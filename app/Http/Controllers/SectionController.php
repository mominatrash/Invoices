<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;
use Random\Engine\Secure;

class SectionController extends Controller
{

    public function sections ()
    {
        $sections = Section::all();
         return view('sections.sections', compact('sections'));
    }
    public function insert_section(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|unique:sections|max:255',
            'description' => 'required'
        ], [

            'name.required' => 'الرجاء إدخال اسم القسم',
            'name.unique' => 'اسم القسم مسجل مسبقا',
            'description.required' => 'الرجاء إدخال وصف للقسم'


        ]);

        
            $n=new Section();
            $n->name=$request->name;
            $n->description=$request->description;
            $n->created_by=(Auth::user()->name);
            $n->save();
            session()->flash('Add','تم اضافة القسم بنجاح');
            return redirect('/sections');
        
    }

    public function update_section(Request $request)
    {
        $id = $request->id;
        $this->validate($request,[
            'name' => 'required|max:255|unique:sections,name,'.$id, 
            'description' => 'required'
        ], [

            'name.required' => 'الرجاء إدخال اسم القسم',
            'name.unique' => 'اسم القسم مسجل مسبقا',
            'description.required' => 'الرجاء إدخال وصف للقسم'


        ]);

        
            $section = Section::find($id);
            $section->name=$request->name;
            $section->description=$request->description;
            $section->save();
            session()->flash('edit', 'تم التعديل بنجاح');
            return redirect('/sections');
        
    }


    public function section_delete(Request $request)
    {
        Section::where('id',$request->id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('/sections');

    }

}
