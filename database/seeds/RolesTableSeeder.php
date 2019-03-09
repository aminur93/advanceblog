<?php
    
    use App\Role;
    use App\User;
    use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('roles')->truncate();
        //create admin role
        $admin = new Role();
        $admin->name = "admin";
        $admin->display_name = "Admin";
        $admin->save();
        
        //create editor role
        $editor = new Role();
        $editor->name = "editor";
        $editor->display_name = "Editor";
        $editor->save();
        
        //create author role
        $author = new Role();
        $author->name = "author";
        $author->display_name = "Author";
        $author->save();
        
        //Attach the role
        //first user is admin
        $user1 = User::find(1);
        $user1->detachRole($admin);
        $user1->attachRole($admin);
        
        //second user is editor
        $user2 = User::find(2);
        $user2->detachRole($editor);
        $user2->attachRole($editor);
        
        //third user id author
        $user3 = User::find(3);
        $user3->detachRole($author);
        $user3->attachRole($author);
    }
}
