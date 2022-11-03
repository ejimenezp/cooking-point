<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Carbon\Carbon;
use App\Http\Controllers\Controller;


// use App\Http\Requests;

use App\WalletEntry;
use App\WalletMaster;
use App\Sales;

class WalletController extends Controller 
{

    function retrieve($id)
    {
        return WalletEntry::find($id);
    }

    function retrieveLast20()
    {
        return WalletEntry::orderBy('created_at', 'desc')->orderBy('id', 'desc')->take(20)->get();
    }

    function retrieveMaster()
    {
        return WalletMaster::orderBy('order', 'asc')->get();
    }

    function create(Request $request)
    {
        $entry = new WalletEntry();
        $entry->type = $request->type;
        $entry->description = $request->description;
        $entry->amount = $request->amount;
        $entry->receipt = $request->receipt;
        $entry->staff = $request->staff;
        $entry->sale_id = $request->sale_id || 0;
        $entry->save();

        return $entry;
    }

    function createFromSale(Sales $sale, $description)
    {
        Log::info($sale);
        $entry = new WalletEntry();
        $entry->type =  'VENTA';
        $entry->description = $sale->description;
        $entry->amount = $sale->total;
        $entry->receipt = false;
        $entry->staff = $sale->staff;
        $entry->sale_id = $sale->id;
        $entry->description = substr($description, 0, 128);
        $entry->save();
    }

    function update(Request $request)
    {
        $entry = WalletEntry::find($request->id);
        $entry->description = $request->description;
        $entry->amount = $request->amount;
        $entry->receipt = $request->receipt;
        $entry->save();

        return $entry;
    }

    function destroy($id)
    {
        WalletEntry::destroy($id);
    }

    function destroySale($sale_id)
    {
        WalletEntry::where('sale_id', $sale_id)->delete();
    }
}

