<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getAll()
    {
        return $this->post->all();
    }

    public function find($id)
    {
        return $this->post->find($id);
    }

    public function create($data)
    {
        return $this->post->create($data);
    }

    public function update($id, $data)
    {
        return $this->post->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return $this->post->where('id', $id)->delete();
    }
}
