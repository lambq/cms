<?php

namespace App\Models;

use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    use ModelTree;
    //
    protected $casts = [
        'state' => 'json',
    ];
    
    // 父级ID字段名称，默认值为 parent_id
    protected $parentColumn = 'parent_id';

    // 排序字段名称，默认值为 order
    protected $orderColumn = 'order';

    // 标题字段名称，默认值为 title
    protected $titleColumn = 'title';

    // Since v2.1.6-beta，定义depthColumn属性后，将会在数据表保存当前行的层级
    protected $depthColumn = 'depth';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

    }
}
