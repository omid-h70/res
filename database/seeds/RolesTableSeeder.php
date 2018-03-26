<?php
 
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
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
        /*
         * Guarded Assignment
         * Specifying fiels one by one 
         * $guarded
         */
        $role_array = [
                0 => [
                    'role_title'=>'Super User',
                    'role_slug' =>'super_user',
                    'role_status'=>'active'
                ],
                1 => [
                    'role_title'=>'Guest',
                    'role_slug' =>'guest',
                    'role_status'=>'active'
                ]
                
        ];
        
        foreach( $role_array as $key => $value ){
            
            $new_role = new Role();
            $new_role->role_title = $value['role_title'];
            $new_role->role_slug  = $value['role_slug'];
            $new_role->role_status = $value['role_status'];
            $new_role->save();
            
        }

    }
}
