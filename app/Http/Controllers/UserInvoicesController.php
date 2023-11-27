<?php

namespace App\Http\Controllers;

use App\InvoiceItems;
use App\Invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use PDF;

class UserInvoicesController extends Controller
{

	public function __construct() {
		$this->middleware( 'invoiceAccess' );
	}

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Session::flash('sidebar', 'invoices');

        $invoices = Invoices::where('user', Auth::user()->id)->get();

        return view('user.invoices.index', compact('invoices'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Invoices $invoice)
    {
        return response()->json(['invoice' => $invoice], 200);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        Session::flash('sidebar', 'invoices');

        return view('user.invoices.create');
    }

    /**
     * @param StoreinvoiceRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        Invoices::create([
        	'company' => $request->company,
        	'user' => Auth::user()->id,
        	'from_date' => $request->from_date,
        	'to_date' => $request->to_date,
        ]);

        return redirect()->back()->with(['success' => 'invoice Created Successfully.']);
    }


    /**
     * @param Invoices $invoice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Invoices $invoice)
    {
        Session::flash('sidebar', 'invoices');

        $items = $invoice->items;
        return view('user.invoices.update', compact('invoice', 'items'));
    }

    public function pdf(Invoices $invoice)
    {
        Session::flash('sidebar', 'invoices');

        $items = $invoice->items;
	    $user = Auth::user();
        return view('user.invoices.pdf', compact('invoice', 'items', 'user'));
    }

    public function pdfDownload(Invoices $invoice)
    {
        $items = $invoice->items;
        $user = Auth::user();
	    $pdf = PDF::loadView( 'user.invoices.pdf', compact( 'invoice', 'items', 'user' ) );

	    return $pdf->download( 'Invoice.pdf' );
//	    return $pdf->stream( 'Ticket.pdf' );
    }

    /**
     * @param invoice $invoice
     * @param UpdateinvoiceRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Invoices $invoice, Request $request)
    {
        $invoice->update([
	        'company' => $request->company,
	        'from_date' => $request->from_date,
	        'to_date' => $request->to_date,
        ]);

        return redirect()->back()->with(['success' => 'invoice Updated Successfully.']);
    }

    public function insertItem(Invoices $invoice, Request $request)
    {
    	$lastItem = InvoiceItems::where('invoice_id', $invoice->id)->orderBy('id', 'desc')->first();
    	$credit = $request->credit;

    	switch ($request->item_type) {
		    case 'debitor':
			    $credit_after = $credit + $lastItem->credit_after;
		    	break;
		    case 'creditor':
		    	$credit_after = $lastItem->credit_after - $credit;
		    	break;
		    case 'credit':
		    	$credit_after = $credit;
		    	break;
	    }

	    InvoiceItems::create([
	        'invoice_id' => $invoice->id,
	        'date' => $request->date,
	        'details' => $request->details,
	        'item_type' => $request->item_type,
	        'credit' => $credit,
	        'credit_after' => $credit_after,
        ]);

        return redirect()->back()->with(['success' => 'Item inserted Successfully.']);
    }

    /**
     * @param invoice $invoice
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Invoices $invoice)
    {
        $invoice->delete();

        return redirect()->back()->with(['success' => 'invoice Deleted Successfully.']);
    }

    public function deleteItem(Invoices $invoice, InvoiceItems $item)
    {
	    $item->delete();
        return redirect()->back()->with(['success' => 'Item Deleted Successfully.']);
    }
}
