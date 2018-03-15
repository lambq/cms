<?php

namespace App;

use Lambq\Admin\Traits\AdminBuilder;
use Lambq\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    //
    use ModelTree, AdminBuilder;
    protected $table = 'menus';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setParentColumn('pid');
        $this->setOrderColumn('sort');
        $this->setTitleColumn('name');
    }
}
