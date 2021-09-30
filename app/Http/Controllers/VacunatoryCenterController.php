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
        $user = $request->user();
        $locality = $user->locality_id;
        return VacunatoryCenter::where('locality_id',$locality)->get();

        
    }

    public function allVacunatoriesCenters(Request $request)
    {
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

        if ($vacunatoryCenter->save()) {
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
        $vacunatory_center = new VacunatoryCenter();

        $vacunatory_center->name = $request->name;
        $vacunatory_center->locality_id = $request->locality_id;

        if ($vacunatory_center->save()) {
            return response()->json($vacunatory_center, 201);
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
        return VacunatoryCenter::where('id', $id)->with(['localities', 'type_vaccine'])->first();
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
