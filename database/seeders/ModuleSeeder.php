<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('modules')->insert([
            [
                'uuid'           => Str::uuid(),
                'parent_id' => null,
                'name'           => 'Dashboard',
                'url'            => '/dashboard',
                'icon'           => 'Home',
                'seq_no'         => 1,
                'is_sub_module'  => 'N',
                'status'         => 'active',
                'is_permission'  => 'N',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'uuid'           => Str::uuid(),
                'parent_id'      => null,
                'name'           => 'Users',
                'url'            => '/user',
                'icon'           => 'Users',
                'seq_no'         => 2,
                'is_sub_module'  => 'N',
                'status'         => 'active',
                'is_permission'  => 'Y',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
        ]);
    }
}
