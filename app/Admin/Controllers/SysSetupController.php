<?php

namespace App\Admin\Controllers;

use App\Models\SysSetup;
use App\Admin\Repositories\Sys;
use Dcat\Admin\Grid;
use \Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Admin;

class SysSetupController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '系统设置';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SysSetup());

        $grid->column('id', __('ID'));
        $grid->column('webname', __('网站名称'));
        $grid->column('keywords', __('网站关键词'));
        $grid->column('description', __('网站描述'))->limit(35);
        $grid->column('copyright', __('版权信息'))->limit(35);
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
        $show = new Show(SysSetup::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('webname', __('Webname'));
        $show->field('keywords', __('Keywords'));
        $show->field('description', __('Description'));
        $show->field('copyright', __('Copyright'));
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
        $form = new Form(new SysSetup());

        $form->text('webname', '网站名称')->placeholder('请输入网站名称')->rules('required',[
            'required' => '请填写网站名称',
        ]);
        $form->tags('keywords', '网站关键词')->help("每一个关键词之间用<code>,</code>隔开")->rules('required',[
            'required' => '请填写关键词',
        ]);
        $form->textarea('description', '网站描述')->placeholder('请输入网站描述')->rules('required',[
            'required' => '请填写网站描述',
        ]);
        $form->textarea('copyright', '版权信息')->placeholder('请输入版权信息')->rules('required',[
                 'required' => '请填写版权信息',
        ]);
        $form->textarea('welcome', '版权信息')->placeholder('请输入版权信息')->rules('required',[
            'required' => '请填写版权信息',
        ]);
        $form->text('tel', '服务热线')->placeholder('请输入服务热线')->rules('required',[
            'required' => '请填写服务热线',
        ]);
        $form->text('qq', '客户')->placeholder('请输入客户')->rules('required',[
            'required' => '请填写客户',
        ]);
        $form->text('beian', '网站备案号')->placeholder('请输入网站备案号')->rules('required',[
            'required' => '请填写网站备案号',
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
