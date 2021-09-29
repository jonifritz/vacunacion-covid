<?php

namespace App\Http\Controllers;

use App\Models\MunicipalityVaccination;
use App\Models\ProvinceVaccination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\TypeVaccine;
use Illuminate\Support\Facades\DB;

class MunicipalityVaccinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MunicipalityVaccination::with(['vacunatories', 'type_vaccine'])->get();
    }

    public function stats($vaccine_id)
    {
        $municipalityVaccination = MunicipalityVaccination::where('vaccine_id', $vaccine_id)
            ->selectRaw('sum(received_lots) as  sum_quantity')
            ->selectRaw("DATE(created_at) as date")
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get();
        $name = TypeVaccine::where('id', $vaccine_id)->first()->name;

        $data['municipality_stats'] = [
            "name" => $name,
            "results" => $municipalityVaccination
        ];
        return  $data;
    }

    public function statsAll()
    {
        $municipalityVaccination = MunicipalityVaccination::with('type_vaccine')->selectRaw('sum(received_lots) as  sum_quantity')
            ->selectRaw("DATE(created_at) as date")
            ->selectRaw("vaccine_id")
            ->groupBy('vaccine_id')
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get();

        $data['municipality_stats'] = [
            "results" => $municipalityVaccination->groupBy('type_vaccine.name')->all()
        ];

        return $data;
    }

    public function alltypesVaccinesMunicipalities()
    {
        $municipalityVaccination = MunicipalityVaccination::selectRaw('sum(received_lots) as  sum_quantity')
            ->selectRaw("complete_name as complete_name")
            ->groupBy(("complete_name"))
            ->get();
        //$name = ProvinceVaccination::first()->complete_name;

        $data['vaccines_by_municipality'] = [
           // "name" => $name,
            "results" => $municipalityVaccination
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
        $province_lot = ProvinceVaccination::where([['iso_id', $request->user()->region_id], 
        ['vaccine_id', $request->vaccine_id]])->get();
        Log::emergency($province_lot);
        $envios = $request->received_lots;
        $sumAll = 0;
        $arrayLots = [];
        
        /* Comprobar si hay vacunas suficientes en todos los lotes */
        foreach ($province_lot as $index => $vc) {
            $sumAll = $sumAll + abs($vc->received_lots - $vc->used); 
        }
        
        if($sumAll<$envios) {
            return response()->json(['message' => 'No hay suficientes vacunas'], 401);
        }

        foreach ($province_lot as $index => $vc) {
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
    
        $mv = new MunicipalityVaccination;
        $mv->vaccine_id = $request->vaccine_id;
        $mv->used_lots = json_encode($arrayLots);
        $mv->iso_id = $request->id;
        $mv->province_id = $request->province_id;
        $mv->complete_name = $request->complete_name;
        $mv->received_lots = $request->received_lots;
        $mv->save();


        $mv->regions()->sync($arrayLots);

        return $mv;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return MunicipalityVaccination::where('id', $id)->with(['vacunatories', 'type_vaccine'])->first();
    }

    public function showMunicipalitiesVaccines()
    {
        Log::emergency('localidad es '.Auth::user()->locality_id);
        $locality_id = Auth::user()->locality_id;
        Log::emergency('Estoy en localidad '.Auth::user()->locality_id);
        //Log::emergency(ProvinceVaccination::where('iso_id', 02)->with(['localities', 'type_vaccine'])->get());
        //Log::emergency(ProvinceVaccination::where('iso_id', $region_id)->with(['localities', 'type_vaccine'])->get());
        
        return MunicipalityVaccination::where('iso_id', $locality_id)->with(['vacunatories', 'type_vaccine'])->get();
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
