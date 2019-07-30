<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class rSalesModel extends Model
{
    //
    public static function getProducts(){
    	return $query = DB::connection('raging')
    	->table('SalesByRep as a')
    	->select(
    		DB::raw("SUM(a.Amount) as Value"),
    		DB::raw("SUM(a.Qty) as Volume"),
    		'a.item_name'
    	)
    	->groupBy('item_name')
    	->get();
    }

    public static function therapeutic(){
    	return $query = DB::connection('raging')
    	->table('SalesByRep as a')
    	->select(
    		DB::raw("COUNT(*) as item_name"),
    		DB::raw("SUM(a.Qty) as Volume"),
    		DB::raw("SUM(a.Amount) as Value")
    	)
    	->join('PRODUCT_TC as b', 'a.item_code', '=', 'b.item_code')
    	->groupBy('b.class')
    	->get();
    }

    public static function getSpecialtySales(){

    	$query = DB::connection('raging')
    	->table('sales_all')
    	->select(
    		'*'
    	)
    	->limit(3000)
    	->get();

    	$collection = collect($query);

    	$final = $collection->groupBy('specialty')->map(function($row){
    		return [
    			'specialty' => $row->unique('specialty'),
    			'Volume' => $row->sum('Volume'),
    			'Value' => $row->sum('Value')
    		];
    	});

    	$data = [];

    	foreach($final as $out){
    		// return $out;
    		$data[] = [
    			'item_name' => $out['specialty'][0]->specialty,
    			'Volume' => $out['Volume'],
    			'Value' => $out['Value']
    		];
    	}

    	return $data;

    }

    public static function getSalesPerFrequency(){

    	$query = DB::connection('raging')
    	->table('sales_all')
    	->select(
    		'*'
    	)
    	->limit(1000)
    	->get();
    	

    	$collection = collect($query);

    	$final = $collection->groupBy('frequency')->map(function($row){
    		return [
    			'frequency' => $row->unique('frequency'),
    			'Volume' => $row->sum('Volume'),
    			'Value' => $row->sum('Value')
    		];
    	});

    	$data = [];

    	foreach($final as $out){
    		// return $out;
    		$data[] = [
    			'item_name' => $out['frequency'][0]->frequency,
    			'Volume' => $out['Volume'],
    			'Value' => $out['Value']
    		];
    	}

    	return $data;

    }

    public static function getSalesPerDoctorClass(){

    	$query = DB::connection('raging')
    	->table('sales_all')
    	->select(
    		'*'
    	)
    	->limit(1000)
    	->get();

    	$collection = collect($query);

    	$final = $collection->groupBy('MD Class')->map(function($row){
    		return [
    			'MD Class' => $row->unique('MD Class'),
    			'Volume' => $row->sum('Volume'),
    			'Value' => $row->sum('Value')
    		];
    	});

    	$data = [];

    	$test = "MD Class";

    	foreach($final as $out){
    		// return $out;
    		$data[] = [
    			'item_name' => $out['MD Class'][0]->$test,
    			'Volume' => $out['Volume'],
    			'Value' => $out['Value']
    		];
    	}

    	return $data;

    }

    public static function getManager(){

    	$query = DB::connection('raging')
    	->table('sales_all')
    	->select(
    		'*'
    	)
    	->limit(3000)
    	->get();

    	$collection = collect($query);

    	$final = $collection->groupBy('Manager Name')->map(function($row){
    		return [
    			'Manager Name' => $row->unique('Manager Name'),
    			'Volume' => $row->sum('Volume')
    		];
    	});

    	$data = [];

    	$test = "Manager Name";

    	foreach($final as $out){
    		// return $out;
    		$data[] = [
    			'item_name' => $out['Manager Name'][0]->$test,
    			'Volume' => $out['Volume']
    		];
    	}

    	return $data;

    }

    public static function getManager2(){
        $query = DB::connection('raging')
        ->table('sales_all')
        ->select(
            '*'
        )
        ->limit(3000)
        ->get();

        $collection = collect($query);

        $final = $collection->groupBy('Manager Name')->map(function($row){
            return [
                'Manager Name' => $row->unique('Manager Name'),
                'Value' => $row->sum('Value')
            ];
        });

        $data = [];

        $test = "Manager Name";

        foreach($final as $out){
            // return $out;
            $data[] = [
                'item_name' => $out['Manager Name'][0]->$test,
                'Value' => $out['Value']
            ];
        }

        return $data;
    }

    public static function getResultOnClick($data){

        $query = DB::connection('raging')
        ->table('sales_all as a')
        ->where('Manager Name', $data['name'])
        ->limit(1000)
        ->get();

        $collection = collect($query);

        $final = $collection->groupBy('Medrep Name')->map(function($row){
            return [
                'medrepName' => $row->unique('MedRep Name'),
                'Volume' => $row->sum('Volume')
            ];
        });

        $test = "Medrep Name";

        $data = [];

        foreach($final as $out){
            $data[] = [
                'item_name' => $out['medrepName'][0]->$test,
                'Volume'    => $out['Volume']
            ];
        }

        return $data;

    }

    public static function getResultOnClick2($data){

        $query = DB::connection('raging')
        ->table('sales_all as a')
        ->where('Manager Name', $data['name'])
        ->limit(1000)
        ->get();

        $collection = collect($query);

        $final = $collection->groupBy('Medrep Name')->map(function($row){
            return [
                'medrepName' => $row->unique('MedRep Name'),
                'Value' => $row->sum('Value')
            ];
        });

        $test = "Medrep Name";

        $data = [];

        foreach($final as $out){
            $data[] = [
                'item_name' => $out['medrepName'][0]->$test,
                'Volume'    => $out['Value']
            ];
        }

        return $data;

    }

    public static function loadSelection($data){
        return "true";
    }

}
