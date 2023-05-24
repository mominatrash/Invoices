<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\Invoice_details;
use App\Models\Invoice_attachments;
use Illuminate\Support\Facades\Storage;

class InvoiceDetailsController extends Controller
{
   public function invoice_details($id){

    $invoices = Invoice::where('id', $id)->first();
    $details = Invoice_details::where('invoice_id', $id)->get();
    $attachments = Invoice_attachments::where('invoice_id', $id)->get();
   
    return view('invoices.invoice_details', compact('invoices', 'details', 'attachments'));

   }

   public function View_file($invoice_number ,$file_name)
   {
      $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
      return response()->file($files);
   }


   public function download($invoice_number,$file_name)

   {
       $contents= Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
       return response()->download( $contents);
   }

   public function delete_file(Request $request)
   {
      Invoice_attachments::where('id', $request->id_file)->delete();

      Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
      session()->flash('delete', 'تم حذف المرفق بنجاح');
      return back();
   }
}
