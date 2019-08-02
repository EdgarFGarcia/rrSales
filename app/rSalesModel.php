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

        // return $query = DB::connection('raging')
        // ->table('SalesByRep as a')
        // ->select(
        //     DB::raw("IFNULL(Specialty, 'NOT MAPPED') as item_name"),
        //     DB::raw("SUM(a.Qty) as Volume"),
        //     DB::raw("SUM(a.Amount) as Value")
        // )
        // ->join('Doctor as b', 'a.doctor_id', '=', 'b.doctor_id')
        // ->groupBy('b.Specialty')
        // ->limit(3000)
        // ->get();

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

    // public static function dataAnalysisQuery($data){

        // $dataArray = array($data->valvol);

        // if(in_array(array("1", "2"), $dataArray)){
        //     return static::ValVol($data);
        // }else{
        //     if(in_array("1", $data->valvol)){
        //         return static::volume($data);
        //     }else if(in_array("2", $data->valvol)){
        //         return static::value($data);
        //     }
        // }

    // }

    public static function dataAnalysisQuery($data){
        // return $data->row;
        
        $query = DB::connection('raging')
        ->table('doctor')
        ->select(
            $data->row,
            $data->column
        )
        ->limit(1000)
        ->groupBy($data->row)
        ->distinct($data->row)
        ->get();

        $data3[] = [];
        return $toShow = $data->row;
        // return count($data->row); // 4
        foreach($query as $out){
            $data3[] = [
                'row' => $out->Specialty,
                'row2' => $out->Frequency
            ];
        }

        return $data3;

        $collection = collect($query);

        $final = $collection->groupBy($data->row)->map(function($row) use ($data){
            // return $row;
            // return $data->column;
            return [
                // 'key' => $row->unique($data->row)
                'key'   => $row->where($data->row, 'like',  '%' . '$row' . '%')
            ];

        });



    }

    public static function volume($data){

        $query = DB::connection('raging')
        ->table('sales_all')
        ->limit(100)
        ->get();

        $collection = collect($query);

        $final = $collection->groupBy($data->row)->map(function($row) use ($data){
            return [
                'key' => $row->unique($data->column),
                'Volume' => $row->sum('Volume'),
                'Value' => $row->sum('Value'),
                'column' => $row->pluck($data->column),
                'doctor' => $row->pluck('MD Name'),
            ];
        });

        $dataToPassColumn = $data->column;
        $dataToPassRow = $data->row;

        $data2 = [];

        foreach($final as $out){

            $data2[] = [
                'row'       => $out['key'][0]->$dataToPassRow,
                'column'    => $out['key'][0]->$dataToPassColumn,
                'volume'    => $out['Volume'],
                'value'     => $out['Value']
            ];

        }

        return $data2;

    } 

    public static function value($data){

        $query = DB::connection('raging')
        ->table('sales_all')
        ->limit(100)
        ->get();

        $collection = collect($query);

        $final = $collection->groupBy($data->row)->map(function($row) use ($data){
            return [
                'key' => $row->unique($data->column),
                'Volume' => $row->sum('Volume'),
                'Value' => $row->sum('Value'),
                'column' => $row->pluck($data->column),
                'doctor' => $row->pluck('MD Name'),
            ];
        });

        $dataToPassColumn = $data->column;
        $dataToPassRow = $data->row;

        $data2 = [];

        foreach($final as $out){

            $data2[] = [
                'row'       => $out['key'][0]->$dataToPassRow,
                'column'    => $out['key'][0]->$dataToPassColumn,
                'volume'    => $out['Volume'],
                'value'     => $out['Value']
                // 'row'       => $out['key'][0]->$dataToPassRow,
                // 'column'    => $out['column'],
                // 'volume'    => $out['Volume'],
                // 'value'     => $out['Value'],
                // 'doctor'    => $out['doctor']
            ];

        }

        return $data2;

    }

}
