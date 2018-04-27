<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Lambq\Admin\Controllers\ModelForm;

class ContentController extends Controller
{
    use ModelForm;

    public function index()
    {
        echo 1;
    }
}
