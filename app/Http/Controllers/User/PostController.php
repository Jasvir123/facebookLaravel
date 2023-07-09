<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\File;
use Illuminate\View\View;

use App\Repositories\PostRepositoryInterface;
use App\Repositories\PostLikeRepositoryInterface;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    protected $postRepository, $postLikeRepository;

    public function __construct(PostRepositoryInterface $postRepository, PostLikeRepositoryInterface $postLikeRepository)
    {
        $this->postRepository = $postRepository;
        $this->postLikeRepository = $postLikeRepository;
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


        if (!$this->postRepository->canPostToday()) {
            $message = 'Could not create post. You have created maximum posts for today.';
        } else {
            $this->postRepository->create($data);
            $message = 'Post created successfully.';
        }

        return Redirect::to('posts')->with('success', $message);
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

    public function postLike($post_id): JsonResponse
    {

        if ($this->postLikeRepository->postLikeUnlike($post_id)) {
            $messageJson = ['success' => true];
            $httpStatusCode = 200;
        } else {
            $messageJson = ['message' => 'Could not like post. You have liked maximum posts for today'];
            $httpStatusCode = 403;
        }

        return response()->json($messageJson, $httpStatusCode);
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->postRepository->delete($post);
        return Redirect::to('posts')->with('success', 'Post deleted successfully');
    }
}
