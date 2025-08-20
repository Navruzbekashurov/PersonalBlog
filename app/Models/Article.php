<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_path',
        'content',
        'published_at',
        'user_id'

    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {

        return $this->hasMany(Comment::class);
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
