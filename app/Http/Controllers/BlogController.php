<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Post;
use App\Tag;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    
    protected $limit = 4;
    public function index()
    {
      $posts = Post::with('author','tags','category','comments')
                 ->latestFirst()
                 ->published()
                 ->filter(request()->only(['term','year','month']))
                ->simplePaginate($this->limit);
       return View('blog.index',compact('posts'));
    }

    public function show(Post $post)
    {
//        $viewCount = $post->view_count + 1;
//        $post->update(['view_count' => $viewCount]);
        
        $post->increment('view_count');
        $postComments = $post->comments()->simplePaginate(3);
       return view('blog.show',compact('post','postComments'));
    }
    
    public function category(Category $category)
    {
        $categoryName = $category->title;
        
        $posts = $category
            ->posts()
            ->with('author','tags','comments')
            ->published()
            ->latestFirst()
            ->simplePaginate($this->limit);
        
        return View('blog.index',compact('posts','categoryName'));
    }
    
    public function tag(Tag $tag)
    {
        $tagName = $tag->name;
        
        $posts = $tag
            ->posts()
            ->with('author','category','comments')
            ->published()
            ->latestFirst()
            ->simplePaginate($this->limit);
        
        return View('blog.index',compact('posts','tagName'));
    }
    
    public function author(User $author)
    {
        $authorName = $author->name;
    
        $posts = $author
            ->posts()
            ->with('category','tags','comments')
            ->published()
            ->latestFirst()
            ->simplePaginate($this->limit);
    
        return View('blog.index',compact('posts','authorName'));
    }
    
    
    
}
