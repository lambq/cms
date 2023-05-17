<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use App\Models\Column;
use Illuminate\Support\MessageBag;
use \Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Illuminate\Support\Facades\Auth;
use DB;

class ArticleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '文章管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article());
        $grid->column('id', __('ID'))->sortable();
        $grid->column('column_id', __('所属栏目'));
        $grid->column('title', __('文章标题'))->limit(35);
        $grid->column('copy_from', __('文章来源'));
        $grid->column('state', '审核状态')->display(function ($state) {
            return $state ? '已审核' : '审核中';
        });
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('修改时间'));

        $grid->disableExport();
        $grid->disableColumnSelector();
        $grid->filter(function($filter){

            // 在这里添加字段过滤器
            $filter->like('title', '文章标题');

        });

        $grid->actions(function ($actions) {

            // 去掉查看
            $actions->disableView();
        });
        if(Auth::guard('admin')->user()->id != 1){
            $grid->model()->where('users_id', '=', Auth::guard('admin')->user()->id);
        }
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
        $show = new Show(Article::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('column_id', __('Column id'));
        $show->field('title', __('Title'));
        $show->field('image', __('Image'));
        $show->field('copy_from', __('Copy from'));
        $show->field('keywords', __('Keywords'));
        $show->field('description', __('Description'));
        $show->field('content', __('Content'));
        $show->field('is_best', __('is_best'));
        $show->field('is_top', __('is_top'));
        $show->field('is_pay', __('is_pay'));
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
        $form = new Form(new Article());
        $form->hidden('users_id', '用户ID')->value(Auth::guard('admin')->user()->id);
        $form->select('column_id', '所属栏目')->options(Column::selectOptions());
        $form->text('title','文章标题')->placeholder('请输入文章标题')->rules('required',[
            'required' => '请填写文章标题',
        ]);
        $form->text('copy_from','文章来源')->value('网络');
        $form->tags('keywords','关键词')->help("每一个关键词之间用<code>,</code>隔开")->rules('required',[
            'required' => '请填写关键词',
        ]);
        $form->textarea('description','文章描述')->placeholder('请输入文章描述')->rules('required',[
                'required' => '请填写文章描述',
            ]);
        $form->editor('content','文章内容')->rules('required');
        // $states = [
        //     'on'  => ['value' => 1, 'text' => '打开', 'color' => 'success'],
        //     'off' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],
        // ];
        // $form->switch('is_best', '是否推荐')->states($states);
        // $form->switch('is_top', '是否置顶')->states($states);
        // $form->switch('is_pay', '是否付费')->states($states);
        $form->select('state', '状态')->options([0 => '审核中', 1 => '已审核'])->rules('required');

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
            $form->model()->image = get_img_first_src($form->model()->content);
            $array  = $form->input('keywords');
                    // 删除用户提交的数据
            $form->deleteInput('keywords');
            $form->keywords    = implode(',', $array);
            
            // return $this->authForm(Auth::guard('admin')->user()->id);
        });
        
        //保存后回调
        $form->saved(function (Form $form) {
            if($form->model()->state == 1){
                ziyuan($form->model()->id);
            }
        });

        return $form;
    }
    
    function authForm($id)
    {
        if ($id == 2)
        {
            $count   = DB::table('articles')->where('users_id', 2)->count();
            if ($count >= 200)
            {
                return admin_error('请充值文章条数', '文章数量已经超过200条');
            }
        }
        if ($id == 3)
        {
            $count   = DB::table('articles')->where('users_id', 3)->count();
            if ($count >= 600)
            {
                return admin_error('请充值文章条数', '文章数量已经超过600条');
            }
        }
        if ($id == 4)
        {
            $count   = DB::table('articles')->where('users_id', 4)->count();
            if ($count >= 300)
            {
                return admin_error('请充值文章条数', '文章数量已经超过300条');
            }
        }
        if ($id == 5)
        {
            $count   = DB::table('articles')->where('users_id', 5)->count();
            if ($count >= 300)
            {
                return admin_error('请充值文章条数', '文章数量已经超过300条');
            }
        }
        if ($id == 6)
        {
            $count   = DB::table('articles')->where('users_id', 6)->count();
            if ($count >= 3000)
            {
                return admin_error('请充值文章条数', '文章数量已经超过3000条');
            }
        }
        if ($id == 7)
        {
            $count   = DB::table('articles')->where('users_id', 7)->count();
            if ($count >= 2500)
            {
                return admin_error('请充值文章条数', '文章数量已经超过2500条');
            }
        }
        if ($id == 8)
        {
            $count   = DB::table('articles')->where('users_id', 8)->count();
            if ($count >= 2500)
            {
                return admin_error('请充值文章条数', '文章数量已经超过2500条');
            }
        }
        if ($id == 9)
        {
            $count   = DB::table('articles')->where('users_id', 9)->count();
            if ($count >= 600)
            {
                return admin_error('请充值文章条数', '文章数量已经超过600条');
            }
        }
        if ($id == 14)
        {
            $count   = DB::table('articles')->where('users_id', 14)->count();
            if ($count >= 100)
            {
                return admin_error('请充值文章条数', '文章数量已经超过100条');
            }
        }
        
        return true;
    }
}
