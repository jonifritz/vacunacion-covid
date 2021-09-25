<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MunicipalityVaccination;
use App\Models\VacunatoryCenterVaccination;
use Illuminate\Support\Facades\Log;

class VacunatoryCenterVaccinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return VacunatoryCenterVaccination::with(['localities', 'type_vaccine', 'locality'])->get();
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
        $municipality_lot = MunicipalityVaccination::where([['vaccine_id', $request->vaccine_id], 
        ['iso_id', $request->user()->locality_id]])->get();
        Log::emergency($municipality_lot);
        $envios = $request->received_lots;
        $sumAll = 0;
        $arrayLots = [];
        
        /* Comprobar si hay vacunas suficientes en todos los lotes */
        foreach ($municipality_lot as $index => $vc) {
            $sumAll = $sumAll + abs($vc->received_lots - $vc->used); 
        }
        
        if($sumAll<$envios) {
            return response()->json(['message' => 'No hay suficientes vacunas'], 401);
        }

        foreach ($municipality_lot as $index => $vc) {
            $lot_total = $vc->received_lots - $vc->used; 
            $temp = $lot_total -  $envios ; 

            if($lot_total>0) {
                if($temp<0) {
                    $vc->used = $vc->used + $lot_total; 
                    $envios = abs($envios - $lot_total);
                    array_push($arrayLots, $vc->id);
                    $vc->save();
                } else{ 
                    $total_x = $vc->used + abs($lot_total-($lot_total-$envios)); 
                    $vc->used = $total_x;
                    array_push($arrayLots, $vc->id);
                    $vc->save();
                    break;
                }
            }
        }
    
        $vc = new VacunatoryCenterVaccination;
        $vc->vaccine_id = $request->vaccine_id;
        $vc->used_lots = json_encode($arrayLots);
        $vc->name = $request->name;
        $vc->locality_id = $request->locality_id;
        $vc->received_lots = $request->received_lots;
        $vc->save();
        
        $vc->localities()->sync($arrayLots);

        return $vc;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return VacunatoryCenterVaccination::where('id', $id)->with(['localities', 'type_vaccine', 'locality'])->first();
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
