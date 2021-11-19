<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use DB;
use Carbon\Carbon;
use Log;


class ReportController extends Controller
{
    //

    static function strip_tags_from_line (&$item, $key) {
        $item = strip_tags($item);
    }

    function report (Request $request) {
    	$fname = 'R_'. $request->id;
    	$raw_report = $this->$fname($request);

    	if($request->output == 'csv') {
			$filename = "download.csv";
			$handle = fopen($filename, 'w+');
			$delimiter = ',';
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
			fputcsv($handle, [$raw_report['title']]);
			fputcsv($handle, $raw_report['headers'], $delimiter);
			foreach ($raw_report['lines'] as $line) {
                $line_as_array = get_object_vars($line);
                array_walk($line_as_array, 'App\Http\Controllers\ReportController::strip_tags_from_line');
			    fputcsv($handle, $line_as_array, $delimiter);
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


    function R_movimientoscaja($request)
    {
        
        $sqlString = "SELECT ses.fecha, mov.sesion_id, mov.tipo, mov.descripcion, mov.ticket_tienda, mov.importe, mov.ticket
                        FROM caja_movimientos as mov join caja_sesiones as ses
                        ON mov.sesion_id = ses.id
                        WHERE ses.fecha >= '$request->start_date' and ses.fecha <= '$request->end_date'
                        ORDER BY mov.sesion_id";

                                
        if(!$result = DB::select($sqlString))
        {
            return [
                'title' =>'No hay resultados' ,
                'headers' => [],
                'lines' => $result ];   
        } else {
            return [
                'title' =>'Movimientos caja, ' . $request->start_date . ' a '. $request->end_date ,
                'headers' => ['Fecha', 'Sesión','Tipo', 'Descripción', 'Tkt_tienda', 'Importe', 'Ticket'],
                'lines' => $result ];
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
                            bookings.pay_method as `forma pago`,
                            bookings.invoice as invoice
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
    			'headers' => ['Fecha', 'Fuente','Nombre', 'Clase', 'Pax', 'Pago', 'Sin IVA', 'Forma Pago', 'Factura'],
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


    function R_kpiclientes($request)
	{
    	
    	$sqlString = "SELECT calendarevents.type,
    						sum(bookings.adult+bookings.child) as registered,
    						sum(round(bookings.price/(1+bookings.iva*0.21), 2)) as revenue
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
            $registered = 0;
            $revenue = 0;
            foreach ($result as $i) {
                $registered += $i->registered;
                $revenue += $i->revenue;
            }
            array_push($result, (object) ['type' => 'TOTAL', 'registered' => $registered, 'revenue' => $revenue]);

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
                                stf.name as cook,
                                stf.style as cook_style,
                                scnd.name as second,
                                scnd.style as second_style
                        FROM calendarevents, staff as stf, staff as scnd
                        WHERE calendarevents.date >= '$request->start_date'
                            AND calendarevents.type IN ('PAELLA', 'TAPAS', 'GROUP')
                            AND calendarevents.date <= '$request->end_date'
                            AND calendarevents.staff_id = stf.id
                            AND calendarevents.secondstaff_id = scnd.id
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

                $cook = '<span style="' . $event->cook_style . '">' . $event->cook . '</span>';
                $second_cook = ($event->second == "n.a." ? "" : " , " . '<span style="' . $event->second_style . '">' . $event->second . '</span>');
                if ($event->date == $date->toDateString()) {
                    if ($event->time <= '14:00:00') {
                        $line->morning = $cook . $second_cook;
                    } elseif (isset($line->morning)) {
                        $line->evening = $cook . $second_cook;
                    } else {
                        $line->morning = ' ';
                        $line->evening = $cook . $second_cook;                        
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


    function R_turnos_exportar($request)
    {
        
        $sqlString = "SELECT    calendarevents.date as date,
                                calendarevents.time as time, 
                                calendarevents.type as type,
                                calendarevents.id as ce_id,
                                stf.name as cook,
                                scnd.name as second
                        FROM calendarevents, staff as stf, staff as scnd
                        WHERE calendarevents.date >= '$request->start_date' 
                            AND calendarevents.date <= '$request->end_date'
                            AND calendarevents.staff_id = stf.id
                            AND calendarevents.secondstaff_id = scnd.id
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

            $last_event_in_a_day = 0;
            $line = array_fill(0, 9, '');
            $line[0] = $date->formatLocalized('%d %b %a');

            foreach ($dbresult as $event) {
                if ($event->date == $date->toDateString() && $last_event_in_a_day < 2) {
                    if ($last_event_in_a_day == 0 && $event->time >= '14:00:00') {
                        $last_event_in_a_day++; // there is no morning class, we shift one place 
                    }
                    $line[$last_event_in_a_day + 1] = $event->cook == 'n.a.' ? '' : $event->cook;
                    $line[$last_event_in_a_day + 3] = $event->second == 'n.a.' ? '' : $event->second;
                    $line[$last_event_in_a_day + 5] = $event->type;
                    $line[$last_event_in_a_day + 7] = $event->ce_id;
                    // Log::info($line);
                    $last_event_in_a_day++;
                }
            }
            array_push($result, (object) $line);
        }

        return [
            'title' => '' ,
            'headers' => [],
            'lines' => $result ];        

    }


    function R_ocupacion($request)
    {
        
        $sqlString = "SELECT    ce.date as date,
                                ce.time as time, 
                                ce.type as type,
                                ce.capacity as capacity,
                                sum(bkg.adult + bkg.child) as registered
                        FROM bookings as bkg
                            RIGHT JOIN calendarevents as ce
                            ON ce.id = bkg.calendarevent_id 
                            AND bkg.status_filter = 'REGISTERED'
                        WHERE ce.date BETWEEN '$request->start_date' and '$request->end_date'
                        AND type NOT IN ('LIMPIEZA-MAÑANA', 'LIMPIEZA-MEDIODIA', 'LIMPIEZA-NOCHE', 'PAYREQUEST')
                        GROUP BY date, time, type, capacity
                        ORDER BY date, time";

                                
        if(!$dbresult = DB::select($sqlString))
        {
            return [
                'title' =>'No hay resultados' ,
                'headers' => [],
                'lines' => $dbresult ];   
        } 

        $result = [];

        foreach ($dbresult as $event) {

            setLocale(LC_TIME, 'es');
            $line = new \stdClass();
            if ($event->type == 'GROUP' || $event->registered == $event->capacity) {
                $highlight = 'bg-danger text-white';
            } else if ($event->registered >= $event->capacity - 2) {
                $highlight = 'bg-warning text-white';
            } else {
                $highlight = '';                
            }
            $line->date = '<span class="' . $highlight . '">' . utf8_encode(strftime('%d %B, %A', strtotime($event->date))) . '<span>';
            $line->time = '<span class="' . $highlight . '">' . basename($event->time, ':00') . '<span>';
            $line->type = '<span class="' . $highlight . '">' . $event->type . '<span>';
            $line->registered = '<span class="' . $highlight . '">' . $event->registered . '<span>';
            array_push($result, $line); 
        } 

        return [
            'title' =>'Ocupación, ' . $request->start_date . ' a '. $request->end_date ,
            'headers' => ['Fecha', 'Hora', 'Clase', 'Registrados'],
            'lines' => $result ];  
    }

}
