<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Http\UploadedFile;

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
        $data['media'] = $this->getStorePathFromFile($data['media']);

        return $this->post->create($data);
    }

    public function update($id, $data)
    {
        $data['media'] = $this->getStorePathFromFile($data['media']);
        return $this->post->where('id', $id)->update($data);
    }

    public function delete($post)
    {
        return $post->delete();
    }

    /**
     * save file in storage/images
     * returns string to save in Database
     *
     * @param UploadedFile $uploadedFile
     * @return string
     */
    private function getStorePathFromFile(UploadedFile $uploadedFile): string {

        $storePath = "";
        $fileName = time() . '.' . $uploadedFile->extension();
        $storePath = $uploadedFile->storeAs('public/images', $fileName);

        return $storePath;
    }
}
