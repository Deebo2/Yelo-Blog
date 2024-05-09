<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PostList extends Component
{
    use WithPagination;
    #[Url()]
    public $sort = 'desc';
    #[Url()]
    public $search = '';
    #[Url()]
    public $category = '';
    public $popular = true;
    public function setSort($sort){
        $this->sort = ($sort === 'desc') ? 'desc' : 'asc';
    }
    #[On('search')]
    public function dispatchedSearchQuery($search){
        $this->search = $search;
        $this->resetPage();
    }
    public function clearFilters(){
        $this->reset('category','search');
        $this->resetPage();
    }
    #[Computed()]
    public function posts(){
        return Post::published()
        ->with('author','categories')
        ->search($this->search)
        ->when($this->activeCategory,function($query){
            $query->withCategory($this->category);
        })
        ->when($this->popular,function($query){
            $query->popular();
        })
        ->orderBy('published_at',$this->sort)->paginate(3);
    }
    #[Computed()]
    public function activeCategory(){
        if($this->category === '' || $this->category === null){
            return null ;
        }
        return Category::where('slug',$this->category)->first();
    }
    public function render()
    {
        return view('livewire.post-list');
    }
}
