<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\File;
use Illuminate\View\View;

use App\Repositories\PostRepositoryInterface;
use App\Repositories\CommentRepositoryInterface;
use App\Repositories\PostLikeRepositoryInterface;

use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    protected $postRepository, $postLikeRepository, $commentRepository;

    public function __construct(
        PostRepositoryInterface $postRepository,
        PostLikeRepositoryInterface $postLikeRepository,
        CommentRepositoryInterface $commentRepository
    ) {
        $this->postRepository = $postRepository;
        $this->postLikeRepository = $postLikeRepository;
        $this->commentRepository = $commentRepository;
    }

    public function index(Request $request): View
    {
        $posts = $this->postRepository->getAll($request);
        return view('user.posts', compact('posts'));
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
            'media' => [
                'file' => 'min:1', 'max:4096', 'mimes:jpg,jpeg,png',
            ]
        ], [
            'media.max' => 'The profile image size must not exceed 4 MB.',
            'media.min' => 'The profile image must have a minimum size of 1 KB.',
        ]);


        if (!$this->postRepository->canPostToday()) {
            $message = __('messages.maxPostsCreated');
        } else {
            $this->postRepository->create($data);
            $message = __('messages.postCreated');
        }

        return Redirect::to('posts')->with('success', $message);
    }

    public function storeComment(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'post_id' => ['required', 'integer'],
            'comment' => ['required', 'string', 'max:4000']
        ]);

        $this->commentRepository->create($data);

        return Redirect::to('posts')->with('success', __('messages.commentAdded'));
    }

    public function postLike($post_id): JsonResponse
    {

        if ($this->postLikeRepository->postLikeUnlike($post_id)) {
            $messageJson = ['success' => true];
            $httpStatusCode = 200;
        } else {
            $messageJson = ['message' => __('messages.postNotLiked')];
            $httpStatusCode = 403;
        }

        return response()->json($messageJson, $httpStatusCode);
    }
}
