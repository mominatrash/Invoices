<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\Invoice_details;
use App\Notifications\AddInvoice;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice_attachments;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;


class InvoiceController extends Controller
{
    public function create_invoice()
    {

        $sections = Section::all();
        return view('invoices.add_invoices', compact('sections'));
    }

    public function get_products($id)
    {

        $products = DB::table('products')->where('section_id', $id)->pluck('product_name', 'id');
        return json_encode($products);
    }

    public function store_invoice(Request $request)
    {
        $i = new Invoice();
        $i->invoice_number = $request->invoice_number;
        $i->invoice_date = $request->invoice_date;
        $i->due_date = $request->due_date;
        $i->product = $request->product;
        $i->section_id = $request->Section;
        $i->amount_collection = $request->amount_collection;
        $i->amount_commission = $request->amount_commission;
        $i->discount = $request->discount;
        $i->rate_vat = $request->rate_vat;
        $i->value_vat = $request->value_vat;
        $i->user = Auth::user()->name;
        $i->total = $request->total;
        $i->status = "غير مدفوعة";
        $i->value_status = "2";
        $i->note = $request->note;
        $i->save();
    
        $invoice_details = new Invoice_details();
        $invoice_details->invoice_id = $i->id;
        $invoice_details->invoice_number = $i->invoice_number;
        $invoice_details->product = $i->product;
        $invoice_details->section = $i->section_id;
        $invoice_details->status = "غير مدفوعة";
        $invoice_details->value_status = "2";
        $invoice_details->note = $i->note;
        $invoice_details->user = $i->user;
        $invoice_details->save();
    
        if ($request->hasFile('attachment')) {
            $image = $request->file('attachment');
            $file_name = $image->getClientOriginalName();
    
            $attachments = new Invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $i->invoice_number;
            $attachments->created_by = $i->user;
            $attachments->invoice_id = $i->id;
            $attachments->save();
    
            // move pic
            // $extension = $image->getClientOriginalExtension();
            // $imageName = $file_name . '.' . $extension;
            // $image->move(public_path('Attachments/' . $i->invoice_number), $imageName);

            
            
            $imageName = $file_name;
            $image->move(public_path('Attachments/' . $i->invoice_number), $imageName);
    
            $inv_mail_id = $i->id;
            $user = Auth::user();
            Notification::send($user, new AddInvoice($inv_mail_id));
        }
    
        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return redirect('/invoices');
    }

    public function edit_invoice($id)
    {
        $invoices = Invoice::where('id', $id)->first();
        $sections = Section::all();
        return view('invoices.edit_invoice', compact('sections', 'invoices'));
    }

    public function update_invoice(Request $request)
    {
        $invoice = Invoice::where('id', $request->id)->first();

        $invoice->invoice_number = $request->invoice_number;
        $invoice->invoice_date = $request->invoice_date;
        $invoice->due_date = $request->due_date;
        $invoice->product = $request->product;
        $invoice->section_id = $request->Section;
        $invoice->amount_collection = $request->amount_collection;
        ~$invoice->amount_commission = $request->amount_commission;
        $invoice->discount = $request->discount;
        $invoice->rate_vat = $request->rate_vat;
        $invoice->value_vat = $request->value_vat;
        $invoice->user = Auth::user()->name;
        $invoice->total = $request->total;
        $invoice->note = $request->note;
        $invoice->save();

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    }

    public function delete_invoice(Request $request)
    {

        $invoice = Invoice::where('id', $request->invoice_id)->first();
        $Details = invoice_attachments::where('invoice_id', $request->invoice_id)->first();



        if (!empty($Details->invoice_number)) {

            Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
        }

        $invoice->forceDelete();

        session()->flash('delete_invoice');
        return redirect('/invoices');
    }


    public function show_status($id)
    {
        $invoices = Invoice::where('id', $id)->first();
        return view('invoices.status_update', compact('invoices'));
    }

    public function status_update($id, Request $request)
    {

        $invoices = Invoice::findOrFail($id);

        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'value_status' => 1,
                'status' => $request->Status,
                'payment_date' => $request->payment_date,
            ]);

            Invoice_details::create([
                'invoice_id' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->Section,
                'status' => $request->Status,
                'value_status' => 1,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'user' => (Auth::user()->name),
            ]);
        } else {
            $invoices->update([
                'value_status' => 3,
                'status' => $request->Status,
                'payment_date' => $request->payment_date,
            ]);
            Invoice_details::create([
                'invoice_id' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'status' => $request->Status,
                'value_status' => 3,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('status_update');
        return redirect('/invoices');
    }

    public function invoices_paid_status()
    {
        $invoices_paid = Invoice::where('Value_Status', 1)->get();
        $invoices_unpaid = Invoice::where('Value_Status', 2)->get();
        $invoices_paritally_paid = Invoice::where('Value_Status', 3)->get();

        return view('invoices.invoices_paid_status', compact('invoices_paid', 'invoices_unpaid', 'invoices_paritally_paid'));
    }

    public function archive(Request $request)
    {


        $invoice = Invoice::withTrashed('id', $request->invoice_id)->first();

        if ($request->cancel == 1) {
            $invoice->restore();
            return redirect('/archived_invoices');
        } else {

            $invoice->delete();
            session()->flash('archive_invoice');
            return redirect('/invoices');
        }
    }

    public function archived_invoices()
    {
        $invoices = Invoice::onlyTrashed()->get();
        return view('invoices.archived_invoices', compact('invoices'));
    }

    public function print_invoice($id)
    {
        $invoices = Invoice::where('id', $id)->first();

        return view('invoices.print_invoice', compact('invoices'));
    }

    public function export() 
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
    }
}
