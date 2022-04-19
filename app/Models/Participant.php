<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'room_code',
        'user_id',
        'status_seen',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
