<?php
    
    use App\Permission;
    use App\Role;
    use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('permissions')->truncate();
        //crud post
        $crudPost = new Permission();
        $crudPost->name = "crud-post";
        $crudPost->save();
        //update other post
        $updateOtherPost = new Permission();
        $updateOtherPost->name = "update-others-post";
        $updateOtherPost->save();
        //delete other post
        $deleteOtherPost = new Permission();
        $deleteOtherPost->name = "delete-others-post";
        $deleteOtherPost->save();
        //crud category
        $crudCategory = new Permission();
        $crudCategory->name = "crud-category";
        $crudCategory->save();
        //crud user
        $crudUser = new Permission();
        $crudUser->name = "crud-user";
        $crudUser->save();
        
        //attach role permission
        $admin = Role::whereName('admin')->first();
        $editor = Role::whereName('editor')->first();
        $author = Role::whereName('author')->first();
    
//        $admin->detachPermissions([$crudPost,$updateOtherPost,$deleteOtherPost,$crudCategory,$crudUser]);
        $admin->attachPermissions([$crudPost,$updateOtherPost,$deleteOtherPost,$crudCategory,$crudUser]);
        
//        $editor->detachPermissions([$crudPost,$updateOtherPost,$deleteOtherPost,$crudCategory]);
        $editor->attachPermissions([$crudPost,$updateOtherPost,$deleteOtherPost,$crudCategory]);
    
//        $author->detachPermissions($crudPost);
        $author->attachPermissions([$crudPost]);
    }
}
