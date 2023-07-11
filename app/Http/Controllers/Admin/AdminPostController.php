<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Sanitizer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

use App\Repositories\PostRepositoryInterface;

class AdminPostController extends Controller
{
    protected $postRepository, $postLikeRepository, $commentRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index(Request $request): View
    {
        $request->merge([
            'searchUser' => Sanitizer::sanitizeInput($request->input('searchUser')),
            'searchDescription' => Sanitizer::sanitizeInput($request->input('searchDescription')),
        ]);

        $posts = $this->postRepository->getAll($request);
        return view('admin.posts', compact('posts','request'));
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->postRepository->delete($post);
        return Redirect::to('admin/posts')->with('success', __('messages.postDeleted'));
    }
}
