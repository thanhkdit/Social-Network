<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'content',
        'nums_like',
        'nums_share',
        'status',
        'location',
        'feeling',
        'type',
        'time',
        'author'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'author');
    }

    public function tagUsers()
    {
        return $this->belongsToMany(User::class, 'tags', 'post_id', 'user_id')->withTimestamps();
    }

    public function postUsers()
    {
        return $this->belongsToMany(User::class, 'user_posts', 'post_id', 'user_id')->withPivot('option', 'reaction')->withTimestamps();
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'post_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }
}
