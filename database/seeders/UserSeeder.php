<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $details = ['first_name' => 'Super', 'last_name' => 'User', 'email' => 'superadmin@ecwa.com', 'email_verified_at' => now()];
        $updateDetails = $details;
        $updateDetails['password'] = bcrypt('mega@itdehappen');

        $role = Role::where('name', 'Super Admin')->first();

        $user = User::whereHas('roles', function($query) use($role) {
            return $query->where('role_id', $role->id);
        })->first();

        if (!$user) {
            $user = User::create($updateDetails);
            $user->roles()->sync($role->id);
        }
    }
}
