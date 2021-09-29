<?php

namespace App\Http\Controllers;

use App\Models\VacunatoryCenter;
use Illuminate\Http\Request;

class VacunatoryCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$user = $request->user();
       // $locality = $user->locality_id;
       // return VacunatoryCenter::where('locality_id',$locality)->get();

       return VacunatoryCenter::all();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $vacunatoryCenter = VacunatoryCenter::find($id);

        $vacunatoryCenter->name = $request->get('name');
        //$vacunatoryCenter->locality_id = $request->get('locality_id');
        
        if ($vacunatoryCenter->save()){
        return response()->json($vacunatoryCenter, 201);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
    }
}
