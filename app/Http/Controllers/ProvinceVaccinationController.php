<?php

namespace App\Http\Controllers;

use App\Models\ProvinceVaccination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvinceVaccinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProvinceVaccination::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $provinceVaccination = ProvinceVaccination::updateOrCreate(
            [
            'iso_id'=> $request->get('id'),
            'complete_name'=> $request->get('complete_name')
            ],
            [
            'received_vaccines' => DB::raw('received_vaccines+'.$request->get('received_vaccines')) ,
            'assigned_vaccines' => $request->get('assigned_vaccines') ? $request->get('assigned_vaccines') : 0,
            'discarded_vaccines' => $request->get('discarded_vaccines') ? $request->get('discarded_vaccines') : 0,
            ]
        );
        return $provinceVaccination;
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
