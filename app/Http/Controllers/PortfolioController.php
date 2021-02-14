<?php

namespace App\Http\Controllers;

use App\Portfolio;

use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function execute(){

        $portfolios = Portfolio::all();

        $title = 'Раздел Portfolio';

        if(view()->exists('admin.portfolios')){
            return view('admin.portfolios')->with([
                'title' => $title,
                'portfolios' => $portfolios
                ]);
        } else {
            abort(404);
        }
    }
}
