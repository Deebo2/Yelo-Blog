<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'body',
        'image',
        'featured',
        'published_at'
    ];
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function author():BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }
    public function categories(): BelongsToMany{
        return $this->belongsToMany(Category::class);
    }
    public function likes(): BelongsToMany{
        return $this->belongsToMany(User::class,'post_like')->withTimestamps();
    }
    public function comments(): HasMany{
        return $this->hasMany(Comment::class);
    }
    public function scopePublished($query){
        $query->where('published_at','<=',Carbon::now());
    }
    public function scopeFeatured($query){
        $query->where('featured',true);
    }
    public function scopePopular($query){
        $query->withCount('likes')
        ->orderBy('likes_count','desc');
    }
    public function scopeSearch($query,$search = ''){
        $query->where('title','like',"%{$search}%");
    }
    public function scopeWithCategory($query, string $category){
        $query->whereHas('categories',function ($query) use ($category){
            $query->where('slug',$category);
        });
    }
    public function getReadingTime(){
        $mins = round(str_word_count($this->body)) / 250;
        return ($mins < 1) ? 1 : $mins;
    }
    public function getExcerpt(){
        return str()->limit(strip_tags($this->body),150);
    }
    public function getThumbnailUrl(){
        $isUrl = str_contains($this->image,'http');
        return ($isUrl) ? $this->image : Storage::disk('public')->url($this->image);
    }
}
