<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;

class PageController extends Controller
{
    public function execute($alias){

        if(view()->exists('site.page')){

            //Получение данных записи по алиасу:
            $page = Page::where('alias', strip_tags($alias))->first();

            //Переменные для передачи в представление:
            $data = [
                'page' => $page,
                'title' => $page->name
            ];

            return view('site.page', $data);
        } else {
            abort(404);
        }
    }
}
