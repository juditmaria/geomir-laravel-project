<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class RoleAndPermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Roles
        $authorRole = Role::create(['name' => Role::AUTHOR]);
        $editorRole = Role::create(['name' => Role::EDITOR]);
        $adminRole  = Role::create(['name' => Role::ADMIN]);

        // Permissions
        Permission::create(['name' => Permission::CONTENT_ADMINISTRATION]);
        Permission::create(['name' => Permission::CONTENT_MODERATION]);

        Permission::create(['name' => Permission::USERS]);
        Permission::create(['name' => Permission::USERS_LIST]);
        Permission::create(['name' => Permission::USERS_CREATE]);
        Permission::create(['name' => Permission::USERS_READ]);
        Permission::create(['name' => Permission::USERS_UPDATE]);
        Permission::create(['name' => Permission::USERS_DELETE]);

        Permission::create(['name' => Permission::FILES]);
        Permission::create(['name' => Permission::FILES_LIST]);
        Permission::create(['name' => Permission::FILES_CREATE]);
        Permission::create(['name' => Permission::FILES_READ]);
        Permission::create(['name' => Permission::FILES_UPDATE]);
        Permission::create(['name' => Permission::FILES_DELETE]);
        
        Permission::create(['name' => Permission::POSTS]);
        Permission::create(['name' => Permission::POSTS_LIST]);
        Permission::create(['name' => Permission::POSTS_CREATE]);
        Permission::create(['name' => Permission::POSTS_READ]);
        Permission::create(['name' => Permission::POSTS_UPDATE]);
        Permission::create(['name' => Permission::POSTS_DELETE]);

        Permission::create(['name' => Permission::PLACES]);
        Permission::create(['name' => Permission::PLACES_LIST]);
        Permission::create(['name' => Permission::PLACES_CREATE]);
        Permission::create(['name' => Permission::PLACES_READ]);
        Permission::create(['name' => Permission::PLACES_UPDATE]);
        Permission::create(['name' => Permission::PLACES_DELETE]);

        // Assign permissions to author role
        $authorRole->givePermissionTo([
            Permission::POSTS_LIST,
            Permission::POSTS_CREATE,
            Permission::POSTS_READ,
            Permission::POSTS_DELETE,
            Permission::PLACES_LIST,
            Permission::PLACES_CREATE,
            Permission::PLACES_READ,
            Permission::PLACES_UPDATE,
            Permission::PLACES_DELETE,
        ]);

        // Assign permissions to editor role
        $editorRole->givePermissionTo([
            Permission::POSTS_LIST,
            Permission::POSTS_READ,
            Permission::PLACES_LIST,
            Permission::PLACES_READ,
            Permission::CONTENT_MODERATION,
        ]);

        // Assign permissions to editor role
        $adminRole->givePermissionTo([
            Permission::USERS,
            Permission::FILES,
            Permission::CONTENT_ADMINISTRATION,
        ]);

        // Update admin user
        $name  = config('admin.name');
        $admin = User::where('name', $name)->first();
        $admin->assignRole(Role::ADMIN);
    }
}
