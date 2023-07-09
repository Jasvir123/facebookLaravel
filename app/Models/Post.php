<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'visibility',
        'media'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    
    public function postLike(): HasMany
    {
        return $this->hasMany(PostLike::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($post) {
            $post->comment()->delete();
        });
    }
}
