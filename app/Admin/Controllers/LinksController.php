<?php

namespace App\Admin\Controllers;

use App\Models\Links;
use App\Admin\Repositories\Movie;
use Dcat\Admin\Grid;
use \Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Admin;

class LinksController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '友情链接';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Links());

        $grid->column('id', __('ID'));
        $grid->column('name', __('网站名称'));
        $grid->column('url', '网站链接');
        $grid->column('logo', __('LOGO'));
        $grid->column('type', '友情链接类型')->display(function ($type) {
            return $type ? 'LOGO' : '文字';
        });
        $grid->column('sort', __('排序'));
        $grid->column('state', '审核状态')->display(function ($state) {
            return $state ? '已审核' : '审核中';
        });
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
        $show = new Show(Links::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('url', __('Url'));
        $show->field('logo', __('Logo'));
        $show->field('type', __('Type'));
        $show->field('sort', __('Sort'));
        $show->field('state', __('State'));
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
        $form = new Form(new Links());

        $form->display('id', 'ID');
        $form->text('name', '网站名称')->rules('required');
        $form->url('url', '网站链接')->rules('required')->help("URL类型是完整的URL地址，如： <code>http://www.baidu.com/</code>");
        $form->image('logo', 'LOGO');
        $form->radio('type', '文字或LOGO')->options(['0'=> '文字', '1'=> 'LOGO'])->default('0')->rules('required');
        $form->number('sort', '排序')->min(1)->default('1')->rules('required|numeric|min:1');
        $form->radio('state', '审核状态')->options(['0' => '审核中', '1'=> '已审核'])->default('0')->rules('required');
        $form->display('created_at', '创建时间');
        $form->display('updated_at', '更改时间');

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
