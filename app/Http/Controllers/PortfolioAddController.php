<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Portfolio;

use Validator;

class PortfolioAddController extends Controller
{
    public function execute(Request $request){

        if($request->isMethod('GET')) {

            $title = 'Добавить Portfolio';

            //Перенаправление в представление с передачей данных:
            if (view()->exists('admin.portfolio_add')) {
                return view('admin.portfolio_add')->with('title', $title);

            }
        }

        if ($request->isMethod('POST')) {

            $input = $request->except('_token');

            $messages = [
                'required' => 'Поле :attribute обазятельно к заполнению',
                'unique' => 'Поле :attribute должно быть уникальным'
            ];

            //Формирование объекта валидатора с заданными настройками:
            $validator = Validator::make($input, [
                'name' => 'required|unique:portfolios|max:255',
                'filter' => 'required|max:255'
            ], $messages);


            if ($validator->fails()) return redirect(route('portfolioAdd'))->withInput()->withErrors($validator);


            //Если в теле запроса в ячейке images был передан файл, сохранение его на сервер:
            if ($request->hasFile('images')) {

                $file = $request->file('images');

                $input['images'] = $file->getClientOriginalName();

                $file->move(public_path() . '/assets/img/', $input['images']);
            }

            $portfolio = new Portfolio();

            //Передача дефолтного значения изображения, в случае не передачи его в соотвесвующем поле:
            if(!isset($input['images'])) $input['images'] = 'n/a';


            $portfolio->fill($input);

            //Сохранение новой записи в БД с последующим перенаправлением на страницу портфолио:
            if ($portfolio->save())
                return redirect()->route('portfolio')->with('status', "Портфолио {$input['name']} добавлено");

        }

            abort(404);

    }
}
