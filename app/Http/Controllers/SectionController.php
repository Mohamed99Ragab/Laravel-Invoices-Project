<?php

namespace App\Http\Controllers;

use App\Http\Requests\Section_StoreRequest;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{

    public function index()
    {
       $sections =  Section::all();

        return view('sections.index',compact('sections'));
    }


    public function create()
    {
        //
    }


    public function store(Section_StoreRequest $request)
    {
        try {
            Section::create([
                'name'=>$request->name,
                'description'=>$request->description,
                'created_by'=>Auth::user()->name
            ]);

            session()->flash('success','تم إضافة القسم بنجاح');
            return redirect()->back();
        }
        catch (\Exception $e){

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }


    public function show(Section $section)
    {
        //
    }


    public function edit(Section $section)
    {
        //
    }


    public function update(Section_StoreRequest $request)
    {
        try {
            $section = Section::findorFail($request->id);
            $section->update([
                'name'=>$request->name,
                'description'=>$request->description
            ]);

            session()->flash('success','تم تعديل القسم بنجاح');
            return redirect()->back();
        }
        catch (\Exception $e){

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function destroy(Request $request)
    {
        try {
            Section::destroy($request->id);
            session()->flash('success','تم حذف القسم بنجاح');
            return redirect()->back();
        }
        catch (\Exception $e){

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
