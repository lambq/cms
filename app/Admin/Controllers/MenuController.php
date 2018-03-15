<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\menu;
use Lambq\Admin\Form;
use Lambq\Admin\Facades\Admin;
use Lambq\Admin\Layout\Content;
use Lambq\Admin\Controllers\ModelForm;
use Lambq\Admin\Tree;

class MenuController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Admin::content(function (Content $content) {

            // 选填
            $content->header('栏目管理');

            // 选填
            $content->description('列表');

            // 填充页面body部分，这里可以填入任何可被渲染的对象
            $content->body(menu::tree());
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content) {
            $content->header('栏目管理');
            $content->description('创建');
            $content->body($this->form());
        });
    }

    public function form()
    {
        return menu::form(function (Form $form) {
            $form->display('id', 'ID');
            $form->select('pid', trans('admin.parent_id'))->options(menu::selectOptions());
            $form->select('module', '所属模块')->options([
                1 => '简介模块',
                2 => '新闻模块',
                3 => '产品模块',
                4 => '下载模块',
                5 => '图片模块',
                6 => '招聘模块',
                7 => '留言系统',
                8 => '反馈系统',
                9 => '友情链接',
                10 => '会员中心',
                11 => '全站搜索',
                12 => '网站地图',
            ]);
            $form->text('name', '栏目路径')->rules('required');
            $form->text('title', '栏目名称')->rules('required');
            $form->text('keywords', '栏目关键词')->rules('required');
            $form->textarea('description', '栏目简短描述')->rows(3);
            $form->switch('hide', '是否显示')->states([
                'on'  => ['value' => 1, 'text' => '打开', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],
            ]);
            $form->divide();
            $form->editor('content', '简介');
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
            $form->disableReset();
        });
    }

    protected function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('栏目管理');
            $content->description('编辑');
            $content->row($this->form()->edit($id));
        });
    }
}
