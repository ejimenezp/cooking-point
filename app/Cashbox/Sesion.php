<?php

namespace App\Cashbox;

use Illuminate\Database\Eloquent\Model;
use Log;

class Sesion extends Model
{
    protected $table = 'caja_sesiones';
	public $timestamps = false;
	protected $fillable = ['fecha'];

    public function movimientos()
    {
        return $this->hasMany('App\Cashbox\Movimiento', 'sesion_id');
    }

    public function sesion_anterior()
    {
        return $this->hasMany('App\Cashbox\Sesion', 'sesion_siguiente');
    }

    public function sesion_siguiente()
    {
        return $this->belongsTo('App\Cashbox\Sesion', 'sesion_anterior');
    }


    //
    //
    // función recalcular saldos en función de los movimientos asociados y de los
    // posibles cambios en las sesiones anteriores
    //      
    // 
    //
    public function recalcular()
    {

        if ($this->sesion_anterior <> 0) {
            $anterior = Sesion::find($this->sesion_anterior);
            $this->efectivo_sesion = $this->efectivo_sesion_al_inicio = $anterior->efectivo_sesion;
            $this->saldo_sesion = $anterior->saldo_sesion; 
        }

        // el efectivo inicial lo tomamos de la sesion anterior, salvo que se haya 
        // contado el dinero en la apertura de caja
        if ($this->efectivo_inicial) {
        	$this->efectivo_sesion = $this->efectivo_sesion_al_inicio = $this->efectivo_inicial;
        } 	

        $ventas = $compras = $ajustes = 0;
        foreach ($this->movimientos as $mov) {
        	if ($mov->tipo == 'VENTA') {
        		$ventas += $mov->importe;
        	} else if ($mov->tipo == 'COMPRA') {
        		$compras += $mov->importe;
        	} else if ($mov->tipo == 'AJUSTE') {
        		$ajustes += $mov->importe;
        	}
        }

        $this->ventas = $ventas;
        $this->compras = $compras;
        $this->ajustes = $ajustes;

        $this->saldo_sesion += $ventas + $compras + $ajustes;

        // el efectivo de la sesion los calculamos a partir de los movimientos,
        // salvo que se haya contado el dinero en el cierre de caja
        if ($this->efectivo_final) {
        	$this->efectivo_sesion = $this->efectivo_final;
        } else {
	        $this->efectivo_sesion = $this->efectivo_sesion_al_inicio + $ventas + $compras + $ajustes;
        }

        $this->descuadre = round($this->efectivo_sesion - $this->efectivo_sesion_al_inicio - $ventas - $compras - $ajustes, 6);
        $this->descuadre_acumulado = $this->efectivo_sesion - $this->saldo_sesion;

        $this->save();
    }


	//
	//
	// devuelve una tabla con los detalles de la sesión para mostrar en 
	// pantalla en este orden
	// 		0:1 linea de apertura
	//		0:1 linea de efectivo inicial (si se contó el dinero)
	//		0:n lineas de compras
	//		0:n lineas de ventas
	//		0:1 linea de efectivo final (si se contó el dinero)
	//		0:n linea de ajustes
	//		0:1 linea de cierre (solo si la sesión ya está cerrada)
	// 
	//
	function detalles()
	{
		$tabla = [];

        $anterior = Sesion::find($this->sesion_anterior);

		// si se contó el dinero al inicio, no hace añadir línea de apertura
		if ($this->efectivo_inicial) {
			array_push($tabla, 
				['descripcion' =>'Apertura, efectivo contado',
				'importe' => 0,
				'saldo' => $this->efectivo_inicial,
				'descuadre' => 0,
				'descuadre_acumulado' => $this->efectivo_inicial - $anterior->saldo_sesion
				]);	
		} else {
			// linea de apertura
			array_push($tabla, 
				['descripcion' =>'Apertura',
				'importe' => 0,
				'saldo' => $this->efectivo_sesion_al_inicio,
				'descuadre' => 0,
				'descuadre_acumulado' => $this->efectivo_sesion_al_inicio - $anterior->saldo_sesion
				]);
		}



		// recorremos los movimientos guardándolos en su orden: primero las compras,
		// y luego las ventas

		// inicializamos los acumuladores 
		$efectivo = $this->efectivo_sesion_al_inicio;

		// primero las compras
		foreach ($this->movimientos as $item) {
			if ($item->tipo == 'COMPRA') {
				$efectivo += $item->importe;
				array_push($tabla, 
					['descripcion' => $item->descripcion,
					'importe' => $item->importe,
					'saldo' => $efectivo,
					'id'=> $item->id
					]);				
			}
		}

		// luego las ventas
		foreach ($this->movimientos as $item) {
			if ($item->tipo == 'VENTA') {
				$efectivo += $item->importe;
				array_push($tabla, ['descripcion' => $item->descripcion,
					'importe' => $item->importe,
					'saldo' => $efectivo,
					'id'=> $item->id
					]);				
			}
		}

		// y ahora los ajustes
		foreach ($this->movimientos as $item) {
			if ($item->tipo == 'AJUSTE') {
				$efectivo += $item->importe;
				array_push($tabla, ['descripcion' => $item->descripcion,
					'importe' => $item->importe,
					'saldo' => $efectivo,
					'id'=> $item->id
					]);				
			}
		}

		// Incluimos esta línea si ha habido arqueo de caja
		if ($this->efectivo_final) {
			array_push($tabla, 
				['descripcion' =>'Arqueo caja',
				'importe' => 0,
				'saldo' => $this->efectivo_final,
				'descuadre' => $this->descuadre,
				'descuadre_acumulado' => $this->descuadre_acumulado
				]);
		}

		// indicar si está cerrada
		if ($this->estado == 'CERRADA') {
			array_push($tabla, 
				['descripcion' =>'Cierre',
				'importe' => 0,
				'saldo' => $this->efectivo_sesion,
				'descuadre' => $this->descuadre,
				'descuadre_acumulado' => $this->descuadre_acumulado
				]);
		}

		return $tabla;
	}

}
