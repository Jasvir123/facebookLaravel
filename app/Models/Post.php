<?php

namespace App\Models;

use App\Repositories\PostRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory, SoftDeletes;

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
            $post->postLike()->delete();

            // // Delete the post media
            // $mediaPath = $post->media;
            // if ($mediaPath) {
            //     $filename = basename($mediaPath);
            //     Storage::delete(PostRepository::STORE_POST_IMAGE_PATH . $filename);
            // }
        });
    }
    
    public function restore()
    {
        // Restore the Post model
        parent::restore();

        // Restore related Comment models
        $this->comment()->withTrashed()->restore();

        // Restore related PostLike models
        $this->postLike()->withTrashed()->restore();
    }
}
