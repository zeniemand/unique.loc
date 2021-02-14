<?php

namespace App\Http\Controllers;

use App\Portfolio;

use Validator;

use Illuminate\Http\Request;

class PortfolioEditController extends Controller
{

    public function execute(Portfolio $portfolio, Request $request){

        if($request->isMethod('POST')){

            //Сохранение переданных данных их формы в отдельынй массив:
            $input = $request->except('_token');

            $messages = [
                'required' => 'Поле :attribute обязательно к заполнению',
                'unique' => 'Поле :attribute должно быть уникальным'
            ];

            $validator = Validator::make($input, [
                'name' => 'required|max:255|unique:portfolios,name,'.$input['id'],
                'filter' => 'required|max:255'
            ], $messages);

            if($validator->fails()) return redirect()->route('portfolioEdit', ['portfolio' => $input['id']])->withInput()->withErrors($validator);

            if($request->hasFile('images')){

                //UploadedFile instance:
                $file = $request->file('images');

                //Имя сохраняемого файла:
                $fileName = $file->getClientOriginalName();

                if($file->move(public_path() . "/assets/img/", $fileName)){
                    //Перезапись значения поля images для сохранения в БД:
                    $input['images'] = $fileName;
                } else {
                    throw new \Exception("Не могу записть файл $fileName на сервер");
                }
            } else {
                $input['images'] = $input['old_images'];
            }

            //Удаление лишнего поля:
            unset($input['old_images']);

            $portfolio->fill($input);

            if($portfolio->update()) return redirect()->route('portfolio')->with('status', "Портфолио {$input['name']} успешно обновлено");

        }

        if($request->isMethod('DELETE')){

            $name = $portfolio->name;

            //Удаление связанного файла картинки, если существует с сервера:
            if(\File::exists(public_path() . "/assets/img/{$portfolio->images}")){
                \File::delete(public_path() . "/assets/img/{$portfolio->images}");
            }

            //Удаление записи из БД:
            if($portfolio->delete()){
                return redirect()->route('portfolio')->with('status', "Запсь $name успешно удалена");
            }
        }

        if(view()->exists('admin.portfolio_edit')){
            $title = "Редактирование записи {$portfolio->name}";

            return view('admin.portfolio_edit')->with([
                'title' => $title,
                'data' => $portfolio
                ]);
        } else {
            abort(404);
        }
    }
}
