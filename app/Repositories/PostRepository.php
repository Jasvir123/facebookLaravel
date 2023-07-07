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
        return $this->post::with('user', 'comment', 'comment.user')->orderByDesc('created_at')->get();
    }

    public function find($id)
    {
        return $this->post->find($id);
    }

    public function create($data)
    {
        $data['user_id'] = auth()->id();

        $media = $data['media'];

        $imageName = time() . '.' . $media->extension();
        $imagePath = $media->storeAs('public/images', $imageName);

        $data['media'] = $imagePath;


        return $this->post->create($data);
    }

    public function update($id, $data)
    {
        return $this->post->where('id', $id)->update($data);
    }

    public function delete($post)
    {
        return $post->delete();
    }
}
