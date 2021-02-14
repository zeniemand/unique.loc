<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;

class PagesController extends Controller
{
    public function execute(){

        if(view()->exists('admin.pages')){

            $title = 'Страницы';

            //Сохранение всех записей из таблички pages:
            $pages = Page::all();

            return view('admin.pages', [
                'title'=> $title,
                'pages'=> $pages
                ]);
        } else {
            abort(404);
        }
    }
}
