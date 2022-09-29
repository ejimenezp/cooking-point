<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $appends = ['more'];

    public function getMoreAttribute()
    {
        return $this->linea4 ?  '(more)' : '';
    }
}
