<?php
 
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;


class UsersTableSeeder extends Seeder
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
        $super_user = Role::find(1);
 
        $perm = new Permission();
        $perm->permission_slug = 'root';
        
        /*
         * Mass Assignment
         * $fillable 
         */
    
        $user = new User();
        $user->user_email = 'toucan7co@gmail.com';
        $user->user_first_name = 'Toucan';
        $user->user_password = bcrypt('secret');
        $user->user_status = User::$NORMAL_STATUS;


        $super_user->save();
        $user->role()->associate($super_user);
        $user->save();

        
        $super_user->permissions()->save( $perm );
    }
}
