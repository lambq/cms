<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\menu;
use App\Module;
use Lambq\Admin\Form;
use Lambq\Admin\Facades\Admin;
use Lambq\Admin\Layout\Content;
use Lambq\Admin\Controllers\ModelForm;

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
            $content->body($this->tree());
        });
    }

    public function tree()
    {
        return menu::tree(function ($tree){
            $tree->branch(function ($branch){
                switch ($branch['module'])
                {
                    case 1:
                        $module = '简介模块';
                        break;
                    case 2:
                        $module = '新闻模块';
                        break;
                    case 3:
                        $module = '产品模块';
                        break;
                    case 4:
                        $module = '下载模块';
                        break;
                    case 5:
                        $module = '图片模块';
                        break;
                    case 6:
                        $module = '招聘模块';
                        break;
                    case 7:
                        $module = '留言系统';
                        break;
                    case 8:
                        $module = '反馈系统';
                        break;
                    case 9:
                        $module = '友情链接';
                        break;
                    case 10:
                        $module = '会员中心';
                        break;
                    case 11:
                        $module = '全站搜索';
                        break;
                    case 12:
                        $module = '网站地图';
                        break;
                    case 100:
                        $module = '产品列表';
                        break;
                    case 101:
                        $module = '图片列表';
                        break;
                    case 0:
                        $module = '外部模块';
                        break;
                }
                return "{$branch['id']} - {$branch['title']} - {$branch['name']} - {$module}";
            });
            $tree->disableSave();
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
            $form->select('module', '所属模块')->options(Module::all()->pluck('name', 'id'));
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
