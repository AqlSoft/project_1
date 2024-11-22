<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Period;
use App\Http\Controllers\Admin\Controller;
use App\Models\InvoiceItem;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{
    //

    public function index () {
        return view('admin.Sales.invoice.index');
    }

    public function create () {
        $basicData = [];
        $lastInvoice = Invoice::all()->sortByDesc('id')->first();
        $invoiceNumber = $lastInvoice == null ? 1 : $lastInvoice->number + 1;
        $basicData['invoiceNumber'] = $invoiceNumber;
        return view('admin.Sales.invoice.create', $basicData);
    }

    public function store () {

    }

    public function createPeriodInvoice ($id) {
        $lastInvoice = Invoice::all()->sortByDesc('id')->first();
        $period = Period::find($id);
        $year = explode('-', date('y-m-d'))[0];
        $month = explode('-', date('y-m-d'))[1];
        $lisn = $lastInvoice === null ? str_pad(1, 10, $year  .$month.'000000', STR_PAD_LEFT) : $lastInvoice->s_number + 1;

        DB::beginTransaction();
        try {
            $invoice = Invoice::create([
                'serial_number'     => $lisn,
                'client_id'         => $period->client_id,
                'contract_id'       => $period->contract_id,
                'period_id'         => $id,
                'account_id'        => 100,
                'claiming_at'       => $period->ends_in_greg,
                'payment_status'    => 0,
                'type'              => 1,
                'created_at'        => date(now()),
                'created_by'        => auth()->user()->id,
                'updated_by'        => auth()->user()->id,
            ]);

            foreach ($period->items as $pItem) {
                # code...
                if ((float)$pItem->price > 0) {
                    InvoiceItem::create([
                        'invoice_id'    => $invoice->id,
                        'item_id'       => $pItem->item_id,
                        'item_price'    => $pItem->price,
                        'item_qty'      => $pItem->qty,
                        'unit_id'       => $pItem->item->unit->id,
                        'item_discount' => 0,
                        'created_at'    => date(now()),
                        'created_by'    => auth()->user()->id,
                        'updated_by'    => auth()->user()->id,
                    ]);
                }
            }
            DB::commit();
            return redirect()->back()->with(['success'=>'تمت انشاء الفاتورة بنجاح ']);
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->back()->with(['error'=>'فشلت عملية انشاء فاتورة للفترة بسبب: '.$err]);
        }
    }
}
