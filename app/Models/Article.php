<?php

namespace App\Models;

use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use SearchableTrait;
    
    protected $searchable = [
        'columns' => [
            'articles.title'        => 10,
            'articles.seo_content'  => 1,
            'articles.seo_title'    => 1,
            'articles.seo_keywords' => 5,
            'articles.keywords'     => 5,
        ]
    ];
    //
    protected $fillable = [
        'column_id', 'title', 'seo_title', 'image', 'copy_from', 'keywords', 'seo_keywords', 'description', 'seo_description', 'content', 'seo_content', 'views', 'created_at', 'updated_at'
    ];
}
