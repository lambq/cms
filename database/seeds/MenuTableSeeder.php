<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = date('Y-m-d H:i:s');
        DB::table('admin_menu')->insert([
            ['parent_id' => 0,'order' => 0,'title' => '栏目管理','icon' => 'fa-bars','uri' => 'menu','created_at' => $time, 'updated_at' => $time],
            ['parent_id' => 0,'order' => 0,'title' => '内容管理','icon' => 'fa-bars','uri' => 'content','created_at' => $time, 'updated_at' => $time],
            ['parent_id' => 0,'order' => 0,'title' => '模块管理','icon' => 'fa-bars','uri' => 'module','created_at' => $time, 'updated_at' => $time],
        ]);
    }
}
