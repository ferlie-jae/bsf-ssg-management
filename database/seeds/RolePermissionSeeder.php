<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        ini_set('memory_limit', '2048M');
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Permission::truncate();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
       	
        foreach (Route::getRoutes()->getRoutes() as $i => $route) {
            $action_object = $route->getAction();
            if (!empty($action_object['controller'])) {
                if(is_array($action_object['middleware'])){
                    if(in_array('auth',  $action_object['middleware'])) {
                        $array = explode('.', $action_object['as']);
                        if(
                            $array[1] == 'index' ||
                            $array[1] == 'create' ||
                            // $array[1] == 'store' ||
                            $array[1] == 'show' ||
                            $array[1] == 'edit' ||
                            // $array[1] == 'update' ||
                            $array[1] == 'destroy'
                            // $array[1] == 'restore'
                        ){
                            /* $permissionName = "";
                            switch ($array[1]) {
                                case 'index':
                                    $permissionName = 'index';
                                    break;
                                
                                case 'store':
                                    $permissionName = 'add';
                                    break;
                                    
                                case 'show':
                                    $permissionName = 'view';
                                    break;

                                case 'update':
                                    $permissionName = 'edit';
                                    break;

                                case 'destroy':
                                    $permissionName = 'delete';
                                    break;

                                default:
                                    $permissionName = $array[1];
                                    break;
                            } */
                            Permission::create([
                               'group' => str_replace("_", " ",$array[0]),
                               'name' => $action_object['as'],
                            ]);
                        }
                    }
                }
            }
        }

        $master_admin = Role::create(['name' => 'System Administrator']);
        $admin = Role::create(['name' => 'Administrator']);
        $master_admin->givePermissionTo(Permission::all());
        $faculty = Role::create(['name' => 'Faculty']);
        $student = Role::create(['name' => 'Student']);

        $admin->givePermissionTo(
            Permission::where([
                ['group', '!=', 'roles'],
                ['group', '!=', 'permissions'],
            ])->get()
        );

        $faculty->givePermissionTo(
            Permission::where([
                ['group', '=', 'students'],
                ['name', 'NOT LIKE', '%destroy%'],
            ])->get()
        );

        $student->givePermissionTo(
            Permission::where([
                ['group', '=', 'votes'],
                ['name', 'NOT LIKE', '%edit%'],
                ['name', 'NOT LIKE', '%destroy%'],
            ])->get()
        );
        $student->givePermissionTo(
            Permission::where([
                ['group', '=', 'tasks'],
                ['name', 'NOT LIKE', '%create%'],
                ['name', 'NOT LIKE', '%edit%'],
                ['name', 'NOT LIKE', '%destroy%'],
            ])->get()
        );
        
    }
}
