<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    //т.к. само название уже множесвтенное по себе, то тут адаптинуем по нашу бд в ручную:
    protected $table = 'peoples';
}
