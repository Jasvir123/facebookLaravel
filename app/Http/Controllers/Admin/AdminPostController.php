<?php

namespace App\Http\Controllers\Admin;

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

    public function index(): View
    {
        $posts = $this->postRepository->getAll();
        return view('admin.posts', compact('posts'));
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->postRepository->delete($post);
        return Redirect::to('admin/posts')->with('success', __('messages.postDeleted'));
    }
}
