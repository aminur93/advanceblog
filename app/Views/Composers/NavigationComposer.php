<?php
    /**
     * Created by PhpStorm.
     * User: pavel
     * Date: 1/22/2019
     * Time: 9:58 PM
     */
    
    namespace App\Views\Composers;
    
    use App\Category;
    use App\Post;
    use App\Tag;
    use Illuminate\View\View;
    
    class NavigationComposer
    {
        public function compose(View $view)
        {
            $this->composeCategories($view);
    
            $this->composeTags($view);
            
            $this->composeArchives($view);
            
            $this->composePopularPosts($view);
        }
        
        private function composeCategories(View $view)
        {
            $categories = Category::with(['posts' => function($query){
                $query->published();
            }])->orderBy('title','asc')->get();

             $view->with('categories',$categories);
        }
        
        private function composeTags(View $view)
        {
            $tags = Tag::has('posts')->get();
            $view->with('tags',$tags);
        }
    
        private function composeArchives(View $view)
        {
            $archives = Post::archives();
            $view->with('archives',$archives);
        }
        
        private function composePopularPosts(View $view)
        {
            $popularPost = Post::published()->popular()->take(3)->get();
             $view->with('popularPost',$popularPost);
        }
    }
    
    