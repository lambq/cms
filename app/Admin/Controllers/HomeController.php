<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Lambq\Admin\Controllers\Dashboard;
use Lambq\Admin\Facades\Admin;
use Lambq\Admin\Layout\Column;
use Lambq\Admin\Layout\Content;
use Lambq\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Dashboard');
            $content->description('Description...');

            $content->row(Dashboard::title());

            $content->row(function (Row $row) {

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::environment());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::extensions());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::dependencies());
                });
            });
        });
    }
}
