<?php

namespace App\Admin\Controllers;

use App\Module;
use Lambq\Admin\Form;
use Lambq\Admin\Grid;
use Lambq\Admin\Layout\Content;
use Lambq\Admin\Facades\Admin;
use App\Http\Controllers\Controller;
use Lambq\Admin\Controllers\ModelForm;

class ModuleController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Admin::content(function (Content $content) {

            // 选填
            $content->header('模块管理');

            // 选填
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    protected function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('模块管理');
            $content->description('编辑');
            $content->row($this->form()->edit($id));
        });
    }

    public function form()
    {
        return Module::form(function (Form $form) {
            $form->display('id', 'ID');
            $form->text('name', '栏目路径')->rules('required');
            $form->datetime('created_at')->format('YYYY-MM-DD HH:mm:ss');
            $form->datetime('updated_at')->format('YYYY-MM-DD HH:mm:ss');
            $form->disableReset();
        });
    }

    public function grid()
    {
        return Admin::grid(Module::class, function(Grid $grid){
            $grid->column('id','栏目id')->label('success');
            $grid->column('name','栏目路径');
            $grid->column('created_at', '创建时间')->sortable();
            $grid->column('updated_at', '更新时间');
            // filter($callback)方法用来设置表格的简单搜索框
            $grid->filter(function ($filter) {
                // 设置created_at字段的范围查询
                $filter->between('created_at', 'Created Time')->datetime();
            });
            $grid->disableCreateButton(); //禁用创建按钮
            $grid->disablePagination(); //禁用分页条
            //$grid->disableFilter(); //禁用查询过滤器
            $grid->disableExport(); //禁用导出数据按钮
            $grid->disableRowSelector(); //禁用行选择checkbox
            //$grid->disableActions(); //禁用行操作列
            $grid->paginate(100);
            $grid->actions(function ($actions) {
                // 获取当前行主键值
                $actions->disableDelete();
            });
        });
    }
}
