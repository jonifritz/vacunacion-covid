<?php

namespace App\Http\Controllers;

use App\Models\VaccineStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VaccineStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return VaccineStock::with('type_vaccine')->get();
    }


    // public function index2($nombre)
    // {
    //     $vac =  VaccineStock::with('type_vaccine')->where();
    //     if($nombre == $nombre) {
    //         $vac = $vac->balance + $vac->balance;
    //     }

    //     return $vac;
    // }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
        $vaccineStock = VaccineStock::create([
            'type_vaccine_id' => $request->get('type_vaccine_id'),
            'description' => 'test',
            'quantity' => DB::raw('quantity+'.$request->get('quantity')),
            'balance' => DB::raw('balance+'.$request->get('quantity')),
            'admission_date' => date('Y-m-d', strtotime($request->get('admission_date'))),
            ]);

        return $vaccineStock;
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
