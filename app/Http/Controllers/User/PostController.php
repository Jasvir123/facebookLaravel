<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display the createPost view.
     */
    public function createPost(): View
    {
        // Post::query()->truncate();

        return view('user.createPost');
    }

    /**
     * Store post in Posts model.
     */
    public function storePost(Request $request)
    {
        $request->validate([
            'description' => ['required', 'string', 'max:4000'],
            'media' => ['required', File::types(['jpg', 'png', 'mp4', 'wav'])
                ->min(1)
                ->max(12 * 1024),],
            'visibility' => ['required']
        ]);
        $imageName = time() . '.' . $request->media->extension();
        $imagePath = $request->media->storeAs('public/images', $imageName);


        Post::create([
            'user_id' => $request->user()->id,
            'description' => $request->description,
            'media' => $imagePath,
            'visibility' => $request->visibility
        ]);

        return Redirect::to('posts');
    }

    public function storeComment(Request $request)
    {
        $request->validate([
            'post_id' => ['required', 'integer'],
            'comment' => ['required', 'string', 'max:4000']
        ]);

        Comment::create([
            'user_id' => $request->user()->id,
            'post_id' => $request->post_id,
            'comment' => $request->comment
        ]);

        return Redirect::to('posts');
    }

    public function viewPosts(): View
    {
        $posts = Post::with('user', 'comment', 'comment.user')->orderByDesc('created_at')->get();
        return view('user.posts', compact('posts'));
    }
}
