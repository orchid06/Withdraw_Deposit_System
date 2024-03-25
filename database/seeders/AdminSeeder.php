<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin               = Admin::firstOrNew(['email' => 'admin@gmail.com']);

        $admin->name         = 'Admin';
        $admin->password     = 'admin';
        $admin->save();
    }
}
