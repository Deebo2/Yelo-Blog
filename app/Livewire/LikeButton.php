<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\User;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class LikeButton extends Component
{
    // #[Reactive]
    public Post $post;
    public function toggleLike(){
        if(auth()->guest()){
            return $this->redirect(route('login'),true);
        }
        $author = auth()->user();
        if($author->hasLiked($this->post)){
            $author->likes()->detach($this->post);
            return;
        }
        $author->likes()->attach($this->post);
    }
    public function render()
    {
        return view('livewire.like-button');
    }
}
