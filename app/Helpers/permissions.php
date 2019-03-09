<?php
function check_user_permissions($request, $actionName = null, $id = null)
    {
        //get current user login
        $currentUser = $request->user();
    
        //get current action name
        if ($actionName)
        {
            $currentActionName = $actionName;
        }else{
    
            $currentActionName = ($request->route()->getActionName());
        }
        list($controller, $method) = explode('@',$currentActionName);
        $controller = str_replace(["App\\Http\\Controllers\\Backend\\", "Controller"], "", $controller);
    
        $crudPermissionMap = [
//            'create' => ['create','store'],
//            'update' => ['edit', 'update'],
//            'delete' => ['destroy','restore','forceDestroy'],
//            'red' => ['index','view'],
        
            'crud' => ['create','store','edit','update','destroy','restore','forceDestroy','index','view']
        ];
    
        $classesMap = [
            'Blog' => 'post',
            'Category' => 'category',
            'Users' => 'user'
        ];
    
        foreach ($crudPermissionMap as $permissions => $methods)
        {
            //if the current method exists in method list
            //we will check the permission\
            if (in_array($method, $methods) && isset($classesMap[$controller]))
            {
                $className = $classesMap[$controller];
            
                if ($className == 'post' && in_array($method, ['edit','update','destroy','restore','forceDestroy']))
                {
                    $id = !is_null($id) ? $id : $request->route('blog');
                    //if the current user has not update-others-post/delete-others-post permission
                    //make sure he/she only modify he/she is own post.
                    if ( $id && (! $currentUser->can('update-others-post') || ! $currentUser->can('delete-others-post')))
                    {
                        $post = \App\Post::withTrashed()->find($id);
                        if ($post->author_id !== $currentUser->id)
                        {
                            return false;
                        
                        }
                    }
                }
            
                //if the user has not permission dont allow next request
                elseif (! $currentUser->can("{$permissions}-{$className}"))
                {
                    return false;
                }
                break;
            }
        }
        return true;
    }
?>