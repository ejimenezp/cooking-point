<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TiendaVentas extends Model
{
    protected $appends = array('quien', 'articulo0', 'articulo1', 'articulo2','articulo3', 'more');

    //
    public function desc0()
    {
        return $this->hasOne('App\TiendaArticulo', 'id', 'linea0');
    }

    public function desc1()
    {
        return $this->hasOne('App\TiendaArticulo', 'id', 'linea1');
    }

    public function desc2()
    {
        return $this->hasOne('App\TiendaArticulo', 'id', 'linea2');
    }

    public function desc3()
    {
        return $this->hasOne('App\TiendaArticulo', 'id', 'linea3');
    }

    public function staff()
    {
        return $this->belongsTo('App\Staff');
    }

    public function getArticulo0Attribute()
    {
        return $this->desc0->nombre;
    }

    public function getArticulo1Attribute()
    {
        return $this->linea1 ? $this->desc1->nombre : '';
    }

    public function getArticulo2Attribute()
    {
        return $this->linea2 ? $this->desc2->nombre : '';
    }

    public function getArticulo3Attribute()
    {
        return $this->linea3 ? $this->desc3->nombre : '';
    }

    public function getMoreAttribute()
    {
        return $this->linea4 ?  '(more)' : '';
    }

    public function getQuienAttribute()
    {
        return $this->staff->name;
    }
}
