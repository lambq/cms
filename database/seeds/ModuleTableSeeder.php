<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = date('Y-m-d H:i:s');
        DB::table('modules')->insert([
            ['name' => '简介模块','created_at' => $time, 'updated_at' => $time],
            ['name' => '新闻模块','created_at' => $time, 'updated_at' => $time],
            ['name' => '产品模块','created_at' => $time, 'updated_at' => $time],
            ['name' => '下载模块','created_at' => $time, 'updated_at' => $time],
            ['name' => '图片模块','created_at' => $time, 'updated_at' => $time],
            ['name' => '招聘模块','created_at' => $time, 'updated_at' => $time],
            ['name' => '反馈系统','created_at' => $time, 'updated_at' => $time],
            ['name' => '友情链接','created_at' => $time, 'updated_at' => $time],
            ['name' => '会员中心','created_at' => $time, 'updated_at' => $time],
            ['name' => '全站搜索','created_at' => $time, 'updated_at' => $time],
            ['name' => '网站地图','created_at' => $time, 'updated_at' => $time],
            ['name' => '产品列表','created_at' => $time, 'updated_at' => $time],
            ['name' => '图片列表','created_at' => $time, 'updated_at' => $time],
            ['name' => '外部模块','created_at' => $time, 'updated_at' => $time],
        ]);
    }
}
