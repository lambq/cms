<?php

namespace App\Admin\Controllers;

use App\Models\Page;
use App\Admin\Repositories\Movie;
use Dcat\Admin\Grid;
use \Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Admin;

class PageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '单页管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Page());

        $grid->column('id', __('ID'));
        $grid->column('name', __('单页名称'));
        $grid->column('title', __('单页标题'));
        $grid->column('content', __('单页内容'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('修改时间'));

        $grid->disableExport();
        $grid->disableFilter();
        $grid->disableColumnSelector();

        $grid->actions(function ($actions) {

            // 去掉查看
            $actions->disableView();
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Page::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('title', __('Title'));
        $show->field('content', __('Content'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Page());

        $form->text('name', '单页名称')->placeholder('请输入单页名称')->rules('required',[
            'required' => '请填写单页名称',
        ]);
        $form->text('title', '单页标题')->placeholder('请输入单页标题')->rules('required',[
            'required' => '请输入单页标题',
        ]);;
        $form->editor('content', '单页内容')->placeholder('请输入单页内容')->rules('required',[
            'required' => '请填写单页内容',
        ]);

        $form->tools(function (Form\Tools $tools) {


            // 去掉`删除`按钮
            $tools->disableDelete();

            // 去掉`查看`按钮
            $tools->disableView();

        });

        $form->footer(function ($footer) {

            // 去掉`重置`按钮
            $footer->disableReset();

            // 去掉`查看`checkbox
            $footer->disableViewCheck();

            // 去掉`继续编辑`checkbox
            $footer->disableEditingCheck();

            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();

        });

        return $form;
    }
}
