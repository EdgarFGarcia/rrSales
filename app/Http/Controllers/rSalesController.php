<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\rSalesModel;
use DB;

class rSalesController extends Controller
{
    //
    public function getProducts(){
    	return $query = rSalesModel::getProducts();
    }

    public function gettherapeutic(){
    	return $query = rSalesModel::therapeutic();
    }

    public function getSpecialtySales(){
    	return $query = rSalesModel::getSpecialtySales();
    }

    public function getSalesPerFrequency(){
    	return $query = rSalesModel::getSalesPerFrequency();
    }

    public function getSalesPerDoctorClass(){
    	return $query = rSalesModel::getSalesPerDoctorClass();
    }

    public function getManager(){
    	return $query = rSalesModel::getManager();
    }

    public function getManager2(){
        return $query = rSalesModel::getManager2();
    }

    public function getResultOnClick(Request $request){
        return $query = rSalesModel::getResultOnClick($request->all());
    }

    public function getResultOnClick2(Request $request){
        return $query = rSalesModel::getResultOnClick2($request->all());
    }

    public function loadSelection(Request $request){
        $query = rSalesModel::loadSelection($request->all());
        if($query == "true"){
            return response()->json([
                'response' => true
            ]);
        }
    }

    public function dataAnalysisQuery(Request $request){
        // return $request->all();
        return $query = rSalesModel::ValVol($request);
        if($query){
            return response()->json([
                'response' => true,
                'data' => $query
            ]);
        }
    }

    public function test(){

        // return $query = DB::connection('raging')
        // ->table("SalesByRep as a")
        // ->select(
        //     'a.Qty as volume',
        //     'a.Amount as value',
        //     // 'a.doctor_id as doctorId',
        //     DB::raw("IFNULL(a.doctor_id, 0) as doctorId"),
        //     'a.item_code as itemCode'
        // )
        // ->get();

        // $query2 = DB::connection('raging')
        // ->table('Doctor as a')
        // ->select(
        //     'a.medrep_id as medrepId',
        //     'a.manager_id as managerId',
        //     // 'a.doctor_id as doctorId'
        //     DB::raw("IFNULL(a.doctor_id, 0) as doctorId")
        // )
        // ->get();

        // $getManagerId = DB::connection('raging')
        // ->table('doctorId')
        // ->select(
        //     // DB::raw("DISTINCT(MD_ID) as mdId")
        //     'id as Id',
        //     'MD_ID as mdId'
        // )
        // ->get();

        // $test = $this->fixData($getManagerId);

        // foreach($getManagerId as $out){
        //     DB::connection('raging')
        //     ->table('Doctor')
        //     ->where('MD_ID', $out->mdId)
        //     ->update([
        //         'doctor_id' => $out->Id
        //     ]);
        // }

        // DB::connection('raging')
        // ->table('doctorId')
        // ->update(
        //     $test
        // );

        $query = DB::connection('raging')
        ->table('Doctor as a')
        ->select(
            'a.MD_ID as mdId',
            'a.Specialty as specialty',
            DB::raw("CONCAT(a.Last_Name, ', ', First_Name, ' ', Middle_Name) as doctorName"),
            'a.Frequency as frequency',
            'a.MD_Class as mdClass'
        )
        ->get();

        $test = $this->fixData($query);

        DB::connection('raging')
        ->table('doctorId')
        ->insert(
            $test
        );        

        return "vape on";
    }

    public function fixData($data){
        // return $data;
        $fix = array();
        foreach($data as $out){
            array_push($fix, array(
                'MD_ID' => $out->mdId,
                // 'doctorName' => $out->doctorName,
                'specialty' => $out->specialty,
                // 'frequency' => $out->frequency,
                // 'md_class' => $out->mdClass
            ));
        }

        return $fix;
    }
}
