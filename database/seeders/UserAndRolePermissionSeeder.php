<?php
namespace Database\Seeders;

use Hash;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserAndRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'minea',
            'password' => Hash::make('password'),
            'email' => 'sominea.ny77@gmail.com'
        ]);

        $permissions = [];
        foreach (permission_modules() as $module) {
            foreach (permission_actions() as $action) {
                $name = $module['key'].' '.$action['key'];
                Permission::firstOrCreate(['name' => $name], ['name' => $name]);
                $permissions[] = $name;
            }
        }

        $role = Role::create(['name' => 'Super Administrator']);
        $role->syncPermissions($permissions);

        $user->syncRoles([$role->name]);
    }
}
