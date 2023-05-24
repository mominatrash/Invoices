<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function invoices(){

        $invoices = Invoice::all();

        return view('invoices.invoices',compact('invoices'));

    }

    public function index()
    {
        return view('index');


     //   return view($id);
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_invoice()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function insert(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:255',
        ]);

        $user = new Invoice();
        $user->name = $validate['name'];
        $user->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = Invoice::where('id', $id)->first();
        return view('edit', compact('edit'));
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $update = Invoice::where('id',$request->id)->first();
        $update->name = $request->name;
        $update->save();

        return redirect('/invoices');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Invoice::where('id',$request->id)->delete();
        return back();

    }


}

