<?php

namespace App\Cashbox;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'caja_movimientos';
	protected $fillable = ['importe', 'descripcion', 'tipo', 'ticket_tienda', 'ticket'];
	public $timestamps = false;

    public function sesion()
    {
        return $this->belongsTo('App\Cashbox\Sesion', 'sesion_id');
    }
    
}