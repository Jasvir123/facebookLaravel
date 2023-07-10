<?php

namespace App\Http\Livewire;

use App\Repositories\CommentRepositoryInterface;
use Livewire\Component;

class ModalComponent extends Component
{
    public $isOpen = false;
    public $comments, $post_id;

    public function mount($post_id)
    {
        $this->post_id = $post_id;
    }

    public function openModal(CommentRepositoryInterface $commentRepository)
    {
        $this->isOpen = true;
        $this->comments = $commentRepository->findCommentsByPostId($this->post_id);
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function submitForm()
    {
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.modal-component', [
            'comments' => $this->comments,
        ]);
    }
}
