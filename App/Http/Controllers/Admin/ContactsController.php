<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $vars = [];

        $vars['contacts'] = Contact::all();

        return view ('admin.contacts.index', $vars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $vars = [];
        
        return view ('admin.contacts.create', $vars);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->iqama = $request->iqama;
        $contact->rule = $request->rule;
        $contact->created_by = auth()->user()->id;
        $contact->created_at = date ('Y-m-d H:i:s');
        if ( $contact->save()) {
            return redirect ()->back()->with(['success'=> 'تم حفظ بيانات جهة الاتصال بنجاح']);
        }
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
        $vars['contact'] = Contact::find($id);
        return view ('admin.contacts.show', $vars);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $vars['contact'] = Contact::find($id);
        return view ('admin.contacts.edit', $vars);
        
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
        //
        $contact = Contact::find($request->id);
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->iqama = $request->iqama;
        $contact->rule = $request->rule;
        $contact->updated_by = auth()->user()->id;
        $contact->updated_at = date ('Y-m-d H:i:s');
        if ( $contact->update()) {
            return redirect ()->back()->with(['success'=> 'تم تحديث بيانات جهة الاتصال بنجاح']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $contact = Contact::find($id);
        if ( $contact->delete()) {
            return redirect ()->back()->with(['success'=> 'تم حذف بيانات جهة الاتصال بنجاح']);
        }
    }
}
