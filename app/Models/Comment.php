<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'comment',
        'user_id',
        'post_id',
        'nums_like',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'comment_id');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class, 'comment_id');
    }
}
