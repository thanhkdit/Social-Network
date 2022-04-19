<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Relationship;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'introduce',
        'description',
        'avatar',
        'birthday',
        'address',
        'phone',
        'password',
        'calendar_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'author');
    }

    public function userPosts()
    {
        return $this->belongsToMany(Post::class, 'user_posts', 'user_id', 'post_id')->withPivot('option', 'reaction')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function tagPosts()
    {
        return $this->belongsToMany(Post::class, 'tags', 'user_id', 'post_id')->withTimestamps();
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'user_notifications', 'user_id', 'notification_id')
            ->withPivot('user_id', 'status')->withTimestamps();
    }

    public function calendars()
    {
        return $this->hasMany(Calendar::class, 'user_id');
    }

    public function userNotifications()
    {
        return $this->hasMany(UserNotifications::class, 'user_id');
    }

    public function relationsFirst()
    {
        return $this->hasMany(Relationship::class, 'user_first');
    }

    public function relationsSecond()
    {
        return $this->hasMany(Relationship::class, 'user_second');
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'participants', 'user_id', 'room_code')->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class, 'user_id');
    }
}
