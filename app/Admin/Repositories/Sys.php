<?php
namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\Repository;
use Dcat\Admin\Form;

class Sys extends Repository
{
    // 修改操作
    // 返回一个bool类型的数据
    public function update(Form $form)
    {
        // 获取id
        $id = $form->builder()->getResourceId();

        // 获取要修改的数据
        $attributes = $form->updates();

        // TODO
        // 这里写你的修改逻辑

        return true;
    }

}