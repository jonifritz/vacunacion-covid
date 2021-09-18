<?php

namespace App\Http\Controllers;

use App\Models\TypeVaccine;
use Illuminate\Http\Request;
use App\Http\Requests\TypeVaccineRequest;
use Illuminate\Support\Facades\Log;

class TypeVaccineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TypeVaccine::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TypeVaccineRequest $request)
    {
        $typeVaccine = TypeVaccine::create([
            'name'=>$request->get('name'),
            'doses_number'=>$request->get('doses_number'),
            'country'=>$request->get('country'),
            'laboratory'=>$request->get('laboratory')
        ]);
        
        return $typeVaccine;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypeVaccine  $typeVaccine
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return TypeVaccine::where('id', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TypeVaccine  $typeVaccine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeVaccine $typeVaccine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeVaccine  $typeVaccine
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeVaccine $typeVaccine)
    {
        //
    }
}
