<?php

namespace App\Http\Controllers;

use App\Models\ProvinceVaccination;
use App\Models\TypeVaccine;
use App\Models\VaccineLot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProvinceVaccinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::emergency('Estoy en provinceController');
        Log::emergency(ProvinceVaccination::where('iso_id', 02)->with(['localities', 'type_vaccine'])->get());
        return ProvinceVaccination::with(['localities', 'type_vaccine'])->get();
    }

    public function stats($vaccine_id)
    {
        $provinnceVaccination = ProvinceVaccination::where('vaccine_id', $vaccine_id)
            ->selectRaw('sum(received_lots) as  sum_quantity')
            ->selectRaw("DATE(created_at) as date")
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get();
        $name = TypeVaccine::where('id', $vaccine_id)->first()->name;

        $data['province_stats'] = [
            "name" => $name,
            "results" => $provinnceVaccination
        ];

        return  $data;
    }

    public function statsAll()
    {
        $provinnceVaccination = ProvinceVaccination::with('type_vaccine')->selectRaw('sum(received_lots) as  sum_quantity')
            ->selectRaw("DATE(created_at) as date")
            ->selectRaw("vaccine_id")
            ->groupBy('vaccine_id')
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get();

        $data['province_stats'] = [
            "results" => $provinnceVaccination->groupBy('type_vaccine.name')->all()
        ];

        return $data;
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


    /*public function index2()
    {
        $iso_provincies = ProvinceVaccination::where('iso_id')->array_unique()->get();
        Log::emergency($iso_provincies);
    }*/

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

        if ($sumAll < $envios) {
            return response()->json(['message' => 'No hay suficientes vacunas'], 401);
        }

        foreach ($vaccine_lot as $index => $vc) {
            $lot_total = $vc->quantity - $vc->used;
            $temp = $lot_total -  $envios;

            if ($lot_total > 0) {
                if ($temp < 0) {
                    $vc->used = $vc->used + $lot_total;
                    $envios = abs($envios - $lot_total);
                    array_push($arrayLots, $vc->id);
                    $vc->save();
                } else {
                    $total_x = $vc->used + abs($lot_total - ($lot_total - $envios));
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

        $pv->vaccine_lots()->sync($arrayLots);

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
        return ProvinceVaccination::where('id', $id)->with(['localities', 'type_vaccine'])->first();
    }

    public function showProvinceVaccines()
    {
        Log::emergency('region es '.Auth::user()->region_id);
        $region_id = Auth::user()->region_id;
        Log::emergency('Estoy en region '.Auth::user()->region_id);
        //Log::emergency(ProvinceVaccination::where('iso_id', 02)->with(['localities', 'type_vaccine'])->get());
        //Log::emergency(ProvinceVaccination::where('iso_id', $region_id)->with(['localities', 'type_vaccine'])->get());
        
        return ProvinceVaccination::where('iso_id', $region_id)->with(['localities', 'type_vaccine'])->get();
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
