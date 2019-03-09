<?php
    
    use App\Category;
    use App\Post;
    use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();
        
        DB::table('categories')->insert([
            [
                'title' => 'Web Design',
                'slug'  => 'Web-design'
            ],

            [
                'title' => 'Web Programme',
                'slug'  => 'Web-programme'
            ],
    
            [
                'title' => 'Internet',
                'slug'  => 'internet'
            ],
    
            [
                'title' => 'Social Marketing',
                'slug'  => 'Social-Marketing'
            ],
    
            [
                'title' => 'Photography',
                'slug'  => 'photography'
            ],
       
        ]);
        
        //update the post data
        foreach (Post::pluck('id') as $postId)
        {
            $categories = Category::pluck('id');
            $categoryId = $categories[rand(0,$categories->count()-1)];
            
            DB::table('posts')
                ->where('id',$postId)
                ->update(['category_id' => $categoryId]);
        }
    }
}
