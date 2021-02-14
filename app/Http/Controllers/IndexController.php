<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;
use App\Service;
use App\Portfolio;
use App\People;

use DB;
use Mail;

class IndexController extends Controller
{
    /**
     * Вывод главной страницы сайта.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function execute(Request $request) {

        //Проверка какой метод обращения был принят в запросе:
        if($request->isMethod('post')){

            //Массив сообщений ошибок соотв. полям валидации
            $messages = [

                'required' => "Поле :attribute обязательно к заполнению",
                'email' => "Поле (Field) :attribute должно соответствовать email адресу"

            ];

            //Валидация входящих данных из контактной формы
            $this->validate($request, [

                'name'  => 'required|max:255',
                'email' => 'required|email',
                'text'  => 'required'

            ], $messages);

            //dump($request);
            //Сохранение данных запроса в переменную
            $data = $request->all();

            //Отправление емейла:
            $result = Mail::send('site.email', ['data' => $data], function ($message) use ($data){

                $mail_admin = env('MAIL_ADMIN');

                //От кого отправляется письмо:
                $message->from($data['email'], $data['name']);
                //Куда отправляется письмо, -> тема письма:
                $message->to($mail_admin,'Mr. Admin')->subject('Question');

            });

            if($result){
                return redirect()->route('home')->with('status','Email is send');
            }
        }

        //>Сбор данных из БД для вывода на представлении главной страницы:
        $pages = Page::all();
        $portfolios = Portfolio::get(array('name','filter','images'));
        $services = Service::where('id','<',20)->get();
        $peoples = People::take(3)->get();
        $tags = Portfolio::distinct()->pluck('filter');//а это походу идентичное исполнение.
        //<



        //массив для сбора пунктов меню
        $menu = array();

        //Добавление динамических пунктов меню из БД
        foreach($pages as $page){

            $item = array('title' => $page->name, 'alias' => $page->alias);
            array_push($menu,$item);
        }

        //>Добавление статических пунктов меню в переменную $menu
        $item = array('title' => 'Services', 'alias' => 'service');//alias == html id
        array_push($menu,$item);

        $item = array('title' => 'Portfolio', 'alias' => 'Portfolio');
        array_push($menu, $item);

        $item = array('title' => 'Team', 'alias' => 'team');
        array_push($menu,$item);

        $item = array('title' => 'Contact', 'alias' => 'contact');
        array_push($menu, $item);
        //<


        //dd($menu);
        return view('site.index', array(
            'menu'       => $menu,
            'pages'      => $pages,
            'services'   => $services,
            'portfolios' => $portfolios,
            'peoples'    => $peoples,
            'tags'       => $tags,
            'title'      => 'Главная страница'
        ));
    }
}
