<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Illuminate\View\View;

use App\Repositories\PostRepositoryInterface;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Display the createPost view.
     */
    public function createPost(): View
    {
        return view('user.createPost');
    }

    /**
     * Store post in Posts model.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => ['required', 'string', 'max:4000'],
            'media' => ['required', File::types(['jpg', 'png', 'mp4', 'wav'])
                ->min(1)
                ->max(12 * 1024),],
            'visibility' => ['required']
        ]);

        $this->postRepository->create($data);
        
        return Redirect::to('posts')->with('success', 'Post created successfully.');;
    }

    public function storeComment(Request $request): RedirectResponse
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

    public function index(): View
    {
        $posts = $this->postRepository->getAll();
        return view('user.posts', compact('posts'));
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->postRepository->delete($post);
        return Redirect::to('posts')->with('success', 'Post deleted successfully');;
    }
}
