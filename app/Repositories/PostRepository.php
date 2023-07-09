<?php

namespace App\Repositories;

use App\Models\Post;

use App\Traits\FileStorageTrait;

class PostRepository implements PostRepositoryInterface
{
    use FileStorageTrait;

    const STORE_POST_IMAGE_PATH = "public/post/images";

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getAll()
    {
        return $this->post::with('user', 'comment', 'postLike', 'comment.user')->orderByDesc('created_at')->get();
    }

    public function find($id)
    {
        return $this->post->find($id);
    }

    public function create($data)
    {
        $data['user_id'] = auth()->id();
        $data['media'] = $this->getStorePathFromFile($data['media'], self::STORE_POST_IMAGE_PATH);

        return $this->post->create($data);
    }

    public function update($id, $data)
    {
        $data['media'] = $this->getStorePathFromFile($data['media'], self::STORE_POST_IMAGE_PATH);
        return $this->post->where('id', $id)->update($data);
    }

    public function delete($post)
    {
        return $post->delete();
    }

    public function getAllCount()
    {
        return $this->getAll()->count();
    }
}
