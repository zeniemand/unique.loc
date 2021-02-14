<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;

use App\Page;

class PagesAddController extends Controller
{
    //
    public function execute(Request $request){

        if($request->isMethod('POST')){

              //Данные ввода формы, кроме токена:
              $input = $request->except('_token');

              //Сообщения об ошибках валидации:
              $messages = [
                  'required' => 'Поле :attribute обязательно к заполнению',
                  'unique' => 'Поле :attribute должно быть уникальным'
              ];

              //Валидация данных из формы:
              $validator = Validator::make($input, [
                  'name' => 'required|max:255',
                  'alias' => 'required|unique:pages|max:255',
                  'text' => 'required',
              ], $messages);

              //Проверка валидации:
              if($validator->fails()) return redirect()->route('pagesAdd')->withErrors($validator)->withInput();

              //Если в теле запроса передан файл:
              if($request->hasFile('images')){

                  //Сохранение данных файла в форме экземпляра объекта UpladedFiles:
                  $file = $request->file('images');

                  //Замена значения поля загружаемого файла его реальным именем:
                  $input['images'] = $file->getClientOriginalName();

                  //Перемещение файла по предусмотренному пути на сервере:
                  $file->move(public_path().'/assets/img', $input['images']);
              }

              //Пустая модель записи таблички Pages:
              $page = new Page();

              //Если не был загружен файл, передается значение по умолчанию
              if(!isset($input['images'])){
                  $input['images'] = 'n/a';
              }

              //Наполнение модели переданными и обработанными данными из запроса:
              $page->fill($input);

              //Сохранение новой записи в БД:
              if($page->save()) return redirect(route('pages'))->with('status', 'Страница добавлена');

        }

        if(view()->exists('admin.pages_add')){

            $title = 'Добавить новую страницу';

            return view('admin.pages_add', ['title' => $title]);
        } else {
            abort(404);
        }


    }
}
