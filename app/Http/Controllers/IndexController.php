<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $this->seo()
            ->setTitle('صفحه اصلی لارالرن')
            ->setDescription('به وبسایت لارالرن خوش آمدید');

        return view('index');
    }
}
