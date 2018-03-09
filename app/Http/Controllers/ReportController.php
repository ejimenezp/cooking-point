<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    //

    function report (Request $request) {
    	$fname = 'R_'. $request->id;
    	$raw_report = $this->$fname($request);

    	if($request->output == 'csv') {
			$filename = "download.csv";
			$handle = fopen($filename, 'w+');
			$delimiter = ';';
			fputcsv($handle, [$raw_report['title']]);
			fputcsv($handle, $raw_report['headers'], $delimiter);
			foreach ($raw_report['lines'] as $line) {
			    fputcsv($handle, get_object_vars($line), $delimiter);
			}
			fclose($handle);
			$response_headers = array(
			    'Content-Type' => 'text/csv',
			    'Content-Encoding' => 'UTF-8'
			);
			return Response::download($filename, 'download.csv', $response_headers);
    	} else {
    		return view('admin.report')->with($raw_report);
    	}

	}

	function R_vclientes($request)
	{
    	
    	$sqlString = "SELECT calendarevents.date as date,
                            sources.name as fuente,   
    						bookings.name as name,
    						calendarevents.type as curso,
    						bookings.adult+bookings.child as pax,
    						bookings.price as pago,
    						round(bookings.price/(1+bookings.iva*0.21), 2) as `sin iva`,
                            bookings.pay_method as `forma pago`
     					FROM calendarevents, bookings, sources
     					WHERE calendarevents.date >= '$request->start_date' AND calendarevents.date <= '$request->end_date' 
                			AND bookings.status_filter = 'REGISTERED'
                        	AND calendarevents.id = bookings.calendarevent_id 
                            AND bookings.source_id = sources.id
                        ORDER BY date, curso, bookings.created_at";

    							
		if(!$result = DB::select($sqlString))
		{
    		return [
    			'title' =>'No hay resultados' ,
    			'headers' => [],
    			'lines' => $result ];	
   		} else {
			return [
    			'title' =>'Detalle Ventas, ' . $request->start_date . ' a '. $request->end_date ,
    			'headers' => ['Fecha', 'Fuente','Nombre', 'Clase', 'Pax', 'Pago', 'Sin IVA', 'Forma Pago'],
    			'lines' => $result ];
		}
    }

    function create_temporary_table($request)
    {

        DB::statement("DROP TEMPORARY TABLE IF EXISTS tienda_report_1");
        DB::statement("CREATE TEMPORARY TABLE tienda_report_1 (ticket_id int, fecha date, producto int, staff_id int, pago varchar(255)) AS (
                SELECT id as ticket_id, fecha, linea0 as producto, staff_id, pago
                    FROM tienda_ventas
                        WHERE fecha >= '$request->start_date' AND fecha <= '$request->end_date' 
                        AND NOT anulado
                        AND NOT (linea0 is null OR linea0 = 3 OR linea0 = 4))");

        for ($i = 1; $i <= 9; $i++) { 
            DB::statement("INSERT INTO tienda_report_1 SELECT id as ticket_id, fecha, linea{$i} as producto, staff_id, pago
                    FROM tienda_ventas
                        WHERE fecha >= '$request->start_date' AND fecha <= '$request->end_date' 
                        AND NOT anulado
                        AND NOT (linea{$i} is null OR linea{$i} = 3 OR linea{$i} = 4)");                     
         }
   
    }

    function R_vtienda($request)
	{
    	
        // first, normalize tiendas_ventas
        self::create_temporary_table($request);

        $sqlString = "SELECT fecha, ticket_id, art.nombre, count(producto), art.pvp, art.iva, round(sum(art.pvp/(1+art.iva/100)), 2), round(sum(art.pvp)-sum(art.pvp/(1+art.iva/100)), 2), sum(art.pvp), pago, staff.name
                        FROM tienda_report_1, staff, tienda_articulos as art
                        WHERE producto = art.id AND
                            staff_id = staff.id
                            AND fecha >= '$request->start_date' AND fecha <= '$request->end_date' 
                        GROUP BY fecha, ticket_id, producto, art.nombre, art.pvp, art.iva, pago, staff.name
                        ORDER BY fecha, ticket_id, pago";
    							
		if(!$result = DB::select($sqlString))
		{
    		return [
    			'title' =>'No hay resultados' ,
    			'headers' => [],
    			'lines' => $result ];	
    	} else {
			return [
    			'title' =>'Ventas Tienda, ' . $request->start_date . ' a '. $request->end_date ,
    			'headers' => ['Fecha', 'Ticket#', 'Artículo', 'Uds', 'P.Unit', '% IVA', 'Base', 'IVA', 'Total', 'Forma Pago', 'Staff'],
    			'lines' => $result ];
		}
    }

    function R_ivatienda($request)
	{
    	
    	$sqlString = "SELECT 
    						sum(base10),
    						sum(base21),
    						sum(base4),
    						sum(iva10),
    						sum(iva21),
    						sum(iva4)
     					FROM tienda_ventas
     					WHERE fecha >= '$request->start_date' AND fecha <= '$request->end_date' 
                			AND NOT anulado
                            AND (linea0 is null OR linea0 <> 3 AND linea0 <> 4)
                            AND (linea1 is null OR linea1 <> 3 AND linea1 <> 4)
                            AND (linea2 is null OR linea2 <> 3 AND linea2 <> 4)
                            AND (linea3 is null OR linea3 <> 3 AND linea3 <> 4)
                            AND (linea4 is null OR linea4 <> 3 AND linea4 <> 4)
                            AND (linea5 is null OR linea5 <> 3 AND linea5 <> 4)
                            AND (linea6 is null OR linea6 <> 3 AND linea6 <> 4)
                            AND (linea7 is null OR linea7 <> 3 AND linea7 <> 4)
                            AND (linea8 is null OR linea8 <> 3 AND linea8 <> 4)
                            AND (linea9 is null OR linea9 <> 3 AND linea9 <> 4)
                        ";


    							
		if(!$result = DB::select($sqlString))
		{
    		return [
    			'title' =>'No hay resultados' ,
    			'headers' => [],
    			'lines' => $result ];	
    	} else {
			return [
    			'title' =>'IVA Tienda, ' . $request->start_date . ' a '. $request->end_date ,
    			'headers' => ['Base 10%', 'Base 21%','Base 4%', 'IVA 10%', 'IVA 21%', 'IVA 4%'],
    			'lines' => $result ];
		}
    }

    function R_kpiclientes($request)
	{
    	
    	$sqlString = "SELECT calendarevents.type,
    						sum(bookings.adult+bookings.child),
    						sum(round(bookings.price/(1+bookings.iva*0.21), 2))
     					FROM calendarevents, bookings
     					WHERE calendarevents.date >= '$request->start_date' AND calendarevents.date <= '$request->end_date' 
                			AND bookings.status_filter = 'REGISTERED'
                        	AND calendarevents.id = bookings.calendarevent_id 
                        GROUP BY type";

    							
		if(!$result = DB::select($sqlString))
		{
    		return [
    			'title' =>'No hay resultados' ,
    			'headers' => [],
    			'lines' => $result ];	
    	} else {
			return [
    			'title' =>'KPI Clientes ' . $request->start_date . ' a '. $request->end_date ,
    			'headers' => ['Clase', 'Registrados','Ingresos'],
    			'lines' => $result ];
		}
    }

    function R_turnos($request)
    {
        
        $sqlString = "SELECT    calendarevents.date as date,
                                calendarevents.time as time, 
                                calendarevents.type as type,
                                staff.name as cook
                        FROM calendarevents, staff
                        WHERE calendarevents.date >= '$request->start_date' 
                            AND calendarevents.date <= '$request->end_date'
                            AND calendarevents.staff_id = staff.id
                        ORDER BY date, time ";

                                
        if(!$dbresult = DB::select($sqlString))
        {
            return [
                'title' =>'No hay resultados' ,
                'headers' => [],
                'lines' => $dbresult ];   
        } 

        $start_date = new Carbon($request->start_date);
        $end_date = new Carbon($request->end_date);
        $end_date->addDay();

        $result = [];

        for ($date = clone $start_date; $date->diffInDays($end_date)>0; $date->addDay()) {

            $line = new \stdClass();
            $line->date = $date->formatLocalized('%d %b, %a');

            foreach ($dbresult as $event) {

                if ($event->date == $date->toDateString()) {
                    if ($event->time <= '14:00:00') {
                        $line->morning = $event->cook;
                    } elseif (isset($line->morning)) {
                        $line->evening = $event->cook;
                    } else {
                        $line->morning = ' ';
                        $line->evening = $event->cook;                        
                    }
                }
            }
            array_push($result, $line);
        }

        return [
            'title' =>'Turnos, ' . $request->start_date . ' a '. $request->end_date ,
            'headers' => ['Fecha', 'Mañana', 'Tarde'],
            'lines' => $result ];

    }

}
