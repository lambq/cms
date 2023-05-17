<?php

namespace App\Admin\Controllers;

use App\Models\Column;
use App\Admin\Repositories\Movie;
use Dcat\Admin\Grid;
use \Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Admin;

class ColumnController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '栏目分类';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Column());

        $grid->column('id', __('ID'));
        $grid->column('parent_id', __('父级菜单'));
        $grid->column('title', __('标题'));
        $grid->column('name', __('名称'));
        $grid->column('order', __('排序'));
        $grid->column('state', '显示状态')->display(function ($state) {
            return $state ? '显示中' : '未显示';
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
        $show = new Show(Column::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('parent_id', __('Parent id'));
        $show->field('title', __('Title'));
        $show->field('name', __('Name'));
        $show->field('order', __('Order'));
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
        $form = new Form(new Column());

        $form->select('parent_id', '父级菜单')->options(Column::selectOptions());
        $form->text('title', '标题')->placeholder('请输入标题')->rules('required',[
            'required' => '请填写标题',
        ]);
        $form->text('name', '名称')->placeholder('请输入名称')->rules('required',[
            'required' => '请填写标题',
        ]);
        $form->tags('keywords', '关键词')->help("每一个关键词之间用<code>,</code>隔开")->rules('required',[
            'required' => '请填写关键词',
        ]);
        $form->textarea('description', '描述')->placeholder('请输入描述')->rules('required',[
            'required' => '请填写描述',
        ]);
        $form->number('order', '排序')->rules('required');
        $form->switch('state', '是否显示')->options([0 => '未显示', 1 => '显示中'])->rules('required');

        $form->tools(function (Form\Tools $tools) {

            // 去掉`列表`按钮
            $tools->disableList();

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
        
        // 在表单提交前调用
        $form->submitted(function (Form $form) {
            $array  = $form->input('keywords');
                    // 删除用户提交的数据
            $form->deleteInput('keywords');
            $form->keywords    = implode(',', $array);
        });
        return $form;
    }
}
