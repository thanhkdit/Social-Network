<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    use HasFactory;
    protected $table = 'relationships';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_first',
        'user_second',
        'type_id'
    ];

    public function type()
    {
        return $this->belongsTo(TypeRelationship::class, 'type_id');
    }

    public function userFirst()
    {
        return $this->belongsTo(User::class, 'user_first');
    }

    public function userSecond()
    {
        return $this->belongsTo(User::class, 'user_second');
    }
}
