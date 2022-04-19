<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\GoogleCalendarService;

class CalendarController extends Controller
{
    public function __construct(GoogleCalendarService $gCalendarService)
    {
        $this->gCalendarService = $gCalendarService;
    }

    public function index()
    {
        $data = Calendar::all()->toArray();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $data = Calendar::create($request->only('user_id', 'title', 'content', 'time'));
        return response()->json(['data' => $data]);
    }

    public function destroy(Request $request) {
        $id = $request->calendar_id;
        $data = Calendar::destroy($id);
        return response()->json(['data' => $data]);
    }

    public function deleteAll(Request $request) {
        $id = $request->user_id;
        $data = Calendar::where('user_id', $id)->delete();
        return response()->json(['data' => $data]);
    }

    public function syncCalendar()
    {
        try {
            $user = auth()->user();
            $calendarId = $user->calendar_id;
            if (empty($calendarId)) {
                //Create calendar api
                $calendarId = $this->gCalendarService->createCalendar($user->email);
                User::find($user->id)->update(['calendar_id' => $calendarId]);
            }
            $dataCalendar = Calendar::where('user_id', $user->id)->get();
            $isSync = $this->gCalendarService->syncCalendar($dataCalendar, $calendarId);
            if ($isSync === true) {
                return response()->json(['message' => 'Sync calendar successfully']);
            }
            return response()->json(['message' => 'Sync calendar failed'], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Sync calendar failed', 'error' => $e->getMessage()], 500);
        }
    }
}
