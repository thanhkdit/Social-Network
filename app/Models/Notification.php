<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'content',
        'image',
        'link',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_notifications', 'notification_id', 'user_id')->withTimestamps();
    }
}
