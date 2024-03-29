<?php

namespace App\Http\Controllers;

use App\Models\VaccineLot;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class VaccineLotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return VaccineLot::with('vaccine_name')->get();
    }

    //Este se usa en PIE CHART
    public function alltypesVaccines()
    {
        Log::emergency('Estoy en lotes');
        $countryLot = VaccineLot::with('vaccine_name')
            ->selectRaw('sum(quantity) as  sum_quantity')
            ->selectRaw("vaccine_id as vaccine_id")
            ->groupBy(("vaccine_id"))
            ->get();
        

        $data['vaccines_by_country'] = [
           // "name" => $name,
            "results" => $countryLot
        ];

        return  $data;
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
        $lot = new VaccineLot;
        $lot->vaccine_id = $request->vaccine_id;
        $lot->description = $request->description;
        $lot->admission_date = Carbon::parse($request->admission_date);
        $lot->quantity = $request->quantity;
        $lot->save();

        return $lot;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VaccineLot  $vaccineLot
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return VaccineLot::with(['vaccine_name', 'regions'])->where('id', $id)->first();
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VaccineLot  $vaccineLot
     * @return \Illuminate\Http\Response
     */
    public function edit(VaccineLot $vaccineLot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VaccineLot  $vaccineLot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VaccineLot $vaccineLot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VaccineLot  $vaccineLot
     * @return \Illuminate\Http\Response
     */
    public function destroy(VaccineLot $vaccineLot)
    {
        //
    }
}
