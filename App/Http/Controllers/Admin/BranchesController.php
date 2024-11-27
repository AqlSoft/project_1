<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BranchesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $branches = Branch::all();
        return view('admin.settings.home', ['branches' => $branches]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {

            $branch = Branch::create([
                'name'          => $request->name,
                'address'       => $request->address,
                'phone'         => $request->phone,
                'email'         => $request->email,
                'ismain'        => 0,
                'branch_code'   => $request->branch_code,
                'created_by'    => auth()->user()->id,
                'updated_by'    => auth()->user()->id
            ]);
            if ($branch) {
                return redirect()->back()->with('success', 'Branch created successfully');
            }
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->with('error', 'Error creating branch because of: ' . $e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $branch = Branch::find($request->id);
        try {

            $branch->update([
                'name'          => $request->name,
                'address'       => $request->address,
                'phone'         => $request->phone,
                'email'         => $request->email,
                'branch_code'   => $request->branch_code,

                'updated_by'    => auth()->user()->id
            ]);

            return redirect()->back()->with('success', 'Branch updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error updating branch because of: ' . $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
