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
        $details = ['first_name' => 'Super', 'last_name' => 'User', 'email' => 'superadmin@ecwa.com'];
        $updateDetails = $details;
        $updateDetails['password'] = bcrypt('ecwa@nevermind');

        $user = User::firstOrCreate($details, $updateDetails);
        if (!$user->email_verified_at) {
            $user->update(['email_verified_at' => now()]);
        }

        $role = Role::where('name', 'Super Admin')->first();

        if ($role) {
            if (!$user->roles()->where('roles.id', $role->id)->exists()) {
                $user->roles()->attach([$role->id]);
            }
        }
    }
}
