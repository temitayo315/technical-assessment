<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    //return all invoices summary
    public function invoiceSummary(){

        $data = Invoice::all();
        //return $data;
        foreach($data as $invoice){

            return response()->json([
                'Message' => 'All Invoices Summary',
                'Invoices' => $data,
                'Number of invoices' => $invoice->count(),
                'Total Invoices Amount' => '#'.$invoice->sum('total')
            ]);
        }
    }

    //Create new invoice
    public function create(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'qty' => 'required',
            'price' => 'required'
        ]);
        //calculate 7.5% tax on each products
        $qty = $request->get('qty');
        $price = $request->get('price');
        $amount = $qty * $price;
        $tax = 7.5/100 * $amount;

        $invoice = Invoice::create([
            'name'=> $request->get('name'),
            'qty'=> $request->get('qty'),
            'price'=> $request->get('price'),
            'tax' => $tax,
            'total' => $amount + $tax,
        ]);
        return response()->json([
                    "message"=>"New Invoice generated",
                    "data"=> $invoice
                ]);

    }
}
