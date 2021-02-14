<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;

use Validator;

use Illuminate\Support\Facades\Storage;

class PagesEditController extends Controller
{
    //
    //public function execute(Request $request, $page){
    public function execute(Page $page, Request $request){

        if($request->isMethod('DELETE')) {

            //Удаление записи:
            if ($page->delete()) {

                //Удаление файла изображения:
                if (\File::exists(public_path() . "/assets/omg/{$page->images}")) {
                    \File::delete(public_path() . "/assets/img/{$page->images}");
                }

                return redirect('admin/pages')->with('status', "Запись успешно удалена");
            }
        }

        if($request->isMethod('POST')) {

            $input = $request->except('_token');

            $messages = [
                'required' => 'Поле :attribute обязательно к заполнению',
                'unique' => 'Поле :attribute должно быть уникальным'
            ];

            $validator = Validator::make($input, [
                'name' => 'required|max:255',
                'alias' => 'required|max:255|unique:pages,alias,'.$input['id'],
                'text' => 'required|max:255'
            ], $messages);

            if($validator->fails()) return redirect()->route('pagesEdit', ['page' => $input['id']])->withErrors($validator)->withInput();

            //Если было добавлено новое изображение:
            if(isset($input['images']) && $request->hasFile('images')){

                //сохранение объекта UpladedFile в переменную:
                $file = $request->file('images');

                //Получение имени файла:
                $fileName = $file->getClientOriginalName();

                if($file->move(public_path()."/assets/img/".$fileName)) {
                    $input['images'] = $fileName;
                } else {
                    throw new \Exception('Не могу записать файл');
                };

            } else {
                $input['images'] = $input['old_images'];
            }

            //Удаление лишнего поля:
            unset($input['old_images']);

            //Заполнение записи новыми данными:
            $page->fill($input);

            //Обновление записи:
            if($page->update()) return redirect()->route('pages')->with(['status' => "Страница {$page->name} успешно отредактирована"]);

        };

        if($request->isMethod('GET')){

            if(view()->exists('admin.pages_edit')){

                //Данные записи приводятся к массиву, для вывода в представлении:
                $data = $page->toArray();

                $title = 'Редактировать страницу';

                return view('admin.pages_edit', ['title' => $title, 'data' => $data]);

            } else {
                abort(404);
            }
        }

    }
}
