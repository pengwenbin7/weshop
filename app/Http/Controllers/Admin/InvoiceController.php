<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class InvoiceController extends Controller
{
    protected $user;
    
    public function __construct()
    {
        /*
        if ($this->user->can("pay")) {
            return redirect()->route("admin.index");
        }
        */
    }
    
    public function index(Request $request)
    {
        $limit = $request->input("limit", 15);
        $key = $request->input("key", "");
        $invoices = Invoice::orderBy("id", "desc")
                  ->where("order_id", "like", "%$key%")
                  ->with(["order", "address"])
                  ->paginate($limit);
        return view("admin.invoice.index", [
            "key" => $key,
            "limit" => $limit,
            "invoices" => $invoices,
        ]);
    }

    public function create(Request $request)
    {
    }

    public function store(Request $request)
    {
    }

    public function show(Invoice $invoice)
    {
    }

    public function edit(Invoice $invoice)
    {
        return view("admin.invoice.edit", [
            "invoice" => $invoice,
        ]);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $invoice->ship_no = $request->input("ship_no", null);
        $invoice->status = $request->status;
        $invoice->admin_name = auth("admin")->user()->name;
        $invoice->save();
        return redirect()->route("admin.invoice.index");
    }

    public function destroy(Invoice $invoice)
    {
    }
}
