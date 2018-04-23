<?php

namespace App\Admin\Controllers;

use App\menu;
use App\image;
use Lambq\Admin\Layout\Content;
use Lambq\Admin\Grid;
use Lambq\Admin\Facades\Admin;
use Lambq\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    use ModelForm;

    public function index(Request $request)
    {
        if($request->get('module')) {
            return Admin::content(function (Content $content) use ($request) {
                $menu = Menu::where('id',$request->get('mid'))->first();
                print_r($menu);
                $content->header($menu->title.' - 文章管理');
                $content->description('列表');
                if($menu->module == 5){
                    $content->body($this->grid_1());
                }
                if($menu->module == 2){
                    $content->body($this->grid_2());
                }
            });
        }else{
            return Admin::content(function (Content $content) {
                $content->header('文章管理');
                $content->description('列表');
                // 填充页面body部分，这里可以填入任何可被渲染的对象
                $content->body($this->grid());
            });
        }
    }

    public function grid()
    {
        return Admin::grid(menu::class, function(Grid $grid){
            // 第二列显示title字段，由于title字段名和Grid对象的title方法冲突，所以用Grid的column()方法代替
            $grid->column('id','栏目id')->label('success');
            $grid->column('name','栏目路径');
            $grid->column('title','栏目名称');
            $grid->column('hide','显示?')->display(function ($hide) {
                return $hide ? '是' : '否';
            });;
            $grid->column('module','所属模块')->display(function ($module){
                switch ($module)
                {
                    case 1:
                        return '简介模块';
                    break;
                    case 2:
                        return '新闻模块';
                    break;
                    case 3:
                        return '产品模块';
                    break;
                    case 4:
                        return '下载模块';
                    break;
                    case 5:
                        return '图片模块';
                    break;
                    case 6:
                        return '招聘模块';
                    break;
                    case 7:
                        return '留言系统';
                    break;
                    case 8:
                        return '反馈系统';
                    break;
                    case 9:
                        return '友情链接';
                    break;
                    case 10:
                        return '会员中心';
                    break;
                    case 11:
                        return '全站搜索';
                    break;
                    case 12:
                        return '网站地图';
                    break;
                    case 100:
                        return '产品列表';
                    break;
                    case 101:
                        return '图片列表';
                    break;
                    case 0:
                        return '外部模块';
                    break;
                }
            });
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
                $actions->disableEdit();
                if($actions->row['module'] != 1) {
                    $url = '?module='.$actions->row['module'].'&mid='.$actions->row['id'];
                    $actions->prepend("<a class='btn btn-mini btn-success'  href='$url'>模块内容</a>");
                }
                $actions->append('<a href=""><i class="btn btn-mini btn-success fa fa-eye"></i></a>');
            });
        });
    }
    public function grid_1()
    {
        return Admin::grid(image::class, function(Grid $grid){
            // 第二列显示title字段，由于title字段名和Grid对象的title方法冲突，所以用Grid的column()方法代替
            $grid->column('id','id')->label('success');
            $grid->column('title','栏目名称');
            $grid->column('created_at', '创建时间')->sortable();
            $grid->column('updated_at', '更新时间');
            // filter($callback)方法用来设置表格的简单搜索框
            $grid->filter(function ($filter) {
                // 设置created_at字段的范围查询
                $filter->between('created_at', 'Created Time')->datetime();
            });
            //$grid->disableFilter(); //禁用查询过滤器
            $grid->disableExport(); //禁用导出数据按钮
            $grid->disableRowSelector(); //禁用行选择checkbox
            //$grid->disableActions(); //禁用行操作列
            $grid->paginate(100);
            $grid->actions(function ($actions) {
                // 获取当前行主键值
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->append('<a href=""><i class="btn btn-mini btn-success fa fa-eye"></i></a>');
            });
        });
    }
    public function grid_2()
    {
        return Admin::grid(menu::class, function(Grid $grid){
            // 第二列显示title字段，由于title字段名和Grid对象的title方法冲突，所以用Grid的column()方法代替
            $grid->column('id','栏目id')->label('success');
            $grid->column('name','栏目路径');
            $grid->column('title','栏目名称');
            $grid->column('hide','显示?')->display(function ($hide) {
                return $hide ? '是' : '否';
            });;
            $grid->column('module','所属模块')->display(function ($module){
                switch ($module)
                {
                    case 1:
                        return '简介模块';
                    break;
                    case 2:
                        return '新闻模块';
                    break;
                    case 3:
                        return '产品模块';
                    break;
                    case 4:
                        return '下载模块';
                    break;
                    case 5:
                        return '图片模块';
                    break;
                    case 6:
                        return '招聘模块';
                    break;
                    case 7:
                        return '留言系统';
                    break;
                    case 8:
                        return '反馈系统';
                    break;
                    case 9:
                        return '友情链接';
                    break;
                    case 10:
                        return '会员中心';
                    break;
                    case 11:
                        return '全站搜索';
                    break;
                    case 12:
                        return '网站地图';
                    break;
                    case 100:
                        return '产品列表';
                    break;
                    case 101:
                        return '图片列表';
                    break;
                    case 0:
                        return '外部模块';
                    break;
                }
            });
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
                $actions->disableEdit();
                if($actions->row['module'] != 1) {
                    $url = '?module='.$actions->row['module'].'&mid='.$actions->row['id'];
                    $actions->prepend("<a class='btn btn-mini btn-success'  href='$url'>模块内容</a>");
                }
                $actions->append('<a href=""><i class="btn btn-mini btn-success fa fa-eye"></i></a>');
            });
        });
    }
}
