<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\rSalesModel;

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

    public function getProduct(){
        return $query = rSalesModel::getProduct();
    }

    public function getTc(){
        return $query = rSalesModel::getTc();
    }

    public function getSpecialty(){
        return $query = rSalesModel::getSpecialty();
    }

    public function getFrequency(){
        return $query = rSalesModel::getFrequency();
    }

    public function getMdClass(){
        return $query = rSalesModel::getMdClass();
    }

    public function getMDName(){
        return $query = rSalesModel::getMDName();
    }

    public function getManagerName(){
        return $query = rSalesModel::getManagerName();
    }

    public function getMedrepName(){
        return $query = rSalesModel::getMedrepName();
    }

    public function dataAnalysisQuery(Request $request){
        return $query = rSalesModel::dataAnalysisQuery($request);
    }

}
