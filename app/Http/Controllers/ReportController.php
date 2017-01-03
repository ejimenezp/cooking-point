<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use DB;

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
    						replace(bookings.price, '.', ',') as pago,
    						replace(round(bookings.price/(1+bookings.iva*0.21), 2), '.', ',') as `sin iva`,
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


    function R_vtienda($request)
	{
    	
    	$sqlString = "SELECT tienda_ventas.id,
    						fecha,
    						staff.name,    						
    						replace(total, '.', ','),
                            pago
     					FROM tienda_ventas, staff
     					WHERE fecha >= '$request->start_date' AND fecha <= '$request->end_date' 
                			AND NOT anulado
                        	AND tienda_ventas.staff_id = staff.id 
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
                        ORDER BY id";


    							
		if(!$result = DB::select($sqlString))
		{
    		return [
    			'title' =>'No hay resultados' ,
    			'headers' => [],
    			'lines' => $result ];	
    	} else {
			return [
    			'title' =>'Ventas Tienda, ' . $request->start_date . ' a '. $request->end_date ,
    			'headers' => ['Ticket', 'Fecha','Empleado', 'Total', 'Forma Pago'],
    			'lines' => $result ];
		}
    }

    function R_ivatienda($request)
	{
    	
    	$sqlString = "SELECT 
    						replace(sum(base10), '.', ','),
    						replace(sum(base21), '.', ','),
    						replace(sum(base4), '.', ','),
    						replace(sum(iva10), '.', ','),
    						replace(sum(iva21), '.', ','),
    						replace(sum(iva4), '.', ',')
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
    						replace(sum(round(bookings.price/(1+bookings.iva*0.21), 2)), '.', ',')
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

}
