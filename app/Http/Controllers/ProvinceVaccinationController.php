<?php

namespace App\Http\Controllers;

use App\Models\ProvinceVaccination;
use App\Models\VaccineLot;
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
        $vaccine_lot = VaccineLot::where('vaccine_id', $request->vaccine_id)->get();
        $envios = $request->received_lots;
        $sumAll = 0;
        $arrayLots = [];
        
        /* Comprobar si hay vacunas suficientes en todos los lotes */
        foreach ($vaccine_lot as $index => $vc) {
            $sumAll = $sumAll + abs($vc->quantity - $vc->used); 
        }
        
        if($sumAll<$envios) {
            return response()->json(['message' => 'No hay suficientes vacunas'], 401);
        }

        foreach ($vaccine_lot as $index => $vc) {
            $lot_total = $vc->quantity - $vc->used; 
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
    
        $pv = new ProvinceVaccination;
        $pv->vaccine_id = $request->vaccine_id;
        $pv->used_lots = json_encode($arrayLots);
        $pv->iso_id = $request->id;
        $pv->complete_name = $request->complete_name;
        $pv->received_lots = $request->received_lots;
        $pv->save();

        return $pv;

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
