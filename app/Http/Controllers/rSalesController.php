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

    // public function test(){
    // 	return $query = rSalesModel::test();
    // }
}
