<?php

namespace App\Services;

use Carbon\Carbon;
use Exception;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Calendar;
use Google_Service_Calendar_AclRule;
use Google_Service_Calendar_AclRuleScope;
use Google_Service_Calendar_Event;
use App\Models\Calendar;

class GoogleCalendarService
{
    /**
     * @var Google_Client $client Authorized client object.
     */
    public $client;

    /**
     * @var Google_Service_Calendar $service Service object.
     */
    public $service;

    /**
     * Contructor
     *
     * @return void
     */
    public function __construct()
    {
        // The authorized client object
        try {
            $client = new Google_Client();
            $client->setApplicationName('Google Calendar API PHP Quickstart');
            $client->setScopes(Google_Service_Calendar::CALENDAR);
            $client->setAuthConfig(storage_path() . '/api_key/credentials.json');
            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');
            // Load previously authorized token from a file, if it exists.
            // The file token.json stores the user's access and refresh tokens, and is
            // created automatically when the authorization flow completes for the first
            // time.
            $tokenPath = storage_path() . '/api_key/token.json';
            if (file_exists($tokenPath)) {
                $accessToken = json_decode(file_get_contents($tokenPath), true);
                $client->setAccessToken($accessToken);
            }

            // If there is no previous token or it's expired.
            if ($client->isAccessTokenExpired()) {
                // Refresh the token if possible, else fetch a new one.
                if ($client->getRefreshToken()) {
                    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                } else {
                    // Request authorization from the user.
                    $authUrl = $client->createAuthUrl();
                    printf("Open the following link in your browser:\n%s\n", $authUrl);
                    print 'Enter verification code: ';
                    $authCode = trim(fgets(STDIN));

                    // Exchange authorization code for an access token.
                    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                    $client->setAccessToken($accessToken);

                    // Check to see if there was an error.
                    if (array_key_exists('error', $accessToken)) {
                        throw new Exception(join(', ', $accessToken));
                    }
                }
                // Save the token to a file.
                if (!file_exists(dirname($tokenPath))) {
                    mkdir(dirname($tokenPath), 0700, true);
                }
                file_put_contents($tokenPath, json_encode($client->getAccessToken()));
            }

            $this->client = $client;
            $this->service = new Google_Service_Calendar($client);
        }
        catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Create calendar.
     * @param string $email User email.
     *
     * @return integer
     */
    public function createCalendar(string $email)
    {
        try {
            // Create calendar
            $calendar = new Google_Service_Calendar_Calendar();
            $calendar->setSummary('LaravaBook'); // title calendar
            $calendar->setTimeZone(config('constants.timezone_vietnam'));
            $createdCalendar = $this->service->calendars->insert($calendar);
            $calendarId = $createdCalendar->getId();
            // Share calendar
            $this->shareCalendar($calendarId, $email);

            return $calendarId;
        } catch (Exception $e) {
            return response()->json(['message', $e->getMessage()], 500);
        }
    }

    /**
     * Share calendar to user email
     * @param string $calendarId Calendar id.
     * @param string $email      Email of user.
     * @param string $role       Role with calendar.
     *
     * @return void
     */
    public function shareCalendar(string $calendarId, string $email, $role='reader')
    {
        try {
            $rule = new Google_Service_Calendar_AclRule();
            $scope = new Google_Service_Calendar_AclRuleScope();
            /*
            The type of the scope. Possible values are:
                "default" - The public scope. This is the default value.
                "user" - Limits the scope to a single user.
                "group" - Limits the scope to a group.
                "domain" - Limits the scope to a domain.
            */
            $scope->setType("user");
            $scope->setValue($email);
            $rule->setScope($scope);
            /*
            The role assigned to the scope. Possible values are:
                "none" - Provides no access.
                "freeBusyReader" - Provides read access to free/busy information.
                "reader" - Provides read access to the calendar. Private events will appear to users with reader access, but event details will be hidden.
                "writer" - Provides read and write access to the calendar. Private events will appear to users with writer access, and event details will be visible.
                "owner" - Provides ownership of the calendar. This role has all of the permissions of the writer role with the additional ability to see and manipulate ACLs.
            */
            $rule->setRole($role);
            $this->service->acl->insert($calendarId, $rule);
        } catch (Exception $e) {
            return response()->json(['message', $e->getMessage()], 500);
        }
    }

    /**
     * Create event
     * @param string $calendarId Calendar id.
     * @param array  $data       Data event.
     *
     * @return void
     */
    public function createEvent(string $calendarId, array $data)
    {
        $event = new Google_Service_Calendar_Event(array(
            'summary' => $data['summary'],
            'description' => $data['description'],
            'start' => array(
                'date' => $data['start_date'],
                'timeZone' => config('constants.timezone_japan'),
            ),
            'end' => array(
                'date' => $data['end_date'],
                'timeZone' => config('constants.timezone_japan'),
            )
        ));
        $event = $this->service->events->insert($calendarId, $event);

        return $event;
    }

    /**
     * Delete all event
     * @param string $calendarId Calendar id.
     *
     * @return array
     */
    public function getListEventId(string $calendarId)
    {
        $eventId = [];
        $events = $this->service->events->listEvents($calendarId);

        foreach ($events->getItems() as $event) {
            $eventId[] = $event->getId();
        }

        return $eventId;
    }

    public function syncCalendar($dataCalendar, string $calendarId)
    {
        if (empty($calendarId) === false) {
            // Delete task in google calendar
            $dataEventId = $dataCalendar->pluck('google_event_id')->toArray();
            $eventIds = $this->getListEventId($calendarId);
            foreach ($eventIds as $eventId) {
                if (!in_array($eventId, $dataEventId)) {
                    $this->service->events->delete($calendarId, $eventId);
                }
            }

            // Add task to google calendar
            foreach ($dataCalendar as $calendar) {
                if (!in_array($calendar->google_event_id, $eventIds)) {
                    $event = new Google_Service_Calendar_Event(array(
                        'summary' => $calendar->title,
                        'description' => $calendar->content,
                        'start' => array(
                            'dateTime' => Carbon::parse($calendar->time),
                            'timeZone' => config('constants.timezone_vietnam'),
                        ),
                        'end' => array(
                            'dateTime' => Carbon::parse($calendar->time)->addHour(1),
                            'timeZone' => config('constants.timezone_vietnam'),
                        )
                    ));
                    $event = $this->service->events->insert($calendarId, $event);
                    Calendar::find($calendar->id)->update(['google_event_id' => $event->getId()]);
                }
            }

            return true;
        }

        return false;
    }
}
