<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use DataTables;
use Illuminate\Support\Collection;

class rSalesModel extends Model
{
    //

    public static function getProducts(){

    	return $query = DB::connection('raging')
    	->table('SalesByRep')
    	->select(
    		DB::raw("SUM(Amount) as Value"),
    		DB::raw("SUM(Qty) as Volume"),
    		'item_name'
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

        return $query = DB::connection('raging')
        ->table('SalesByRep as a')
        ->select(
            DB::raw("ISNULL(specialty, 'NOT MAPPED') as item_name"),
            DB::raw("SUM(a.Qty) as Volume"),
            DB::raw("SUM(a.Amount) as Value")
        )
        ->join('Doctor as b', 'a.MD ID', '=', 'b.MD ID')
        ->groupBy('b.Specialty')
        ->get();

    }

    public static function getSalesPerFrequency(){

        return $query = DB::connection('raging')
        ->table('SalesByRep as a')
        ->select(
            DB::raw("ISNULL(b.frequency, 'NOT MAPPED') as item_name"),
            DB::raw("SUM(a.Qty) as Volume"),
            DB::raw("SUM(a.Amount) as Value")
        )
        ->join('Doctor as b', 'a.MD ID', '=', 'b.MD ID')
        ->groupBy('frequency')
        ->get();


    }

    public static function getSalesPerDoctorClass(){
        return $query = DB::connection('raging')
        ->table('SalesByRep')
        ->select(
            DB::raw("ISNULL('Doctor.MD Class', 'NOT MAPPED') as item_name"),
            DB::raw("SUM(SalesByRep.Qty) as Volume"),
            DB::raw("SUM(SalesByRep.Amount) as Value")
        )
        ->join('Doctor', 'SalesByRep.MD ID', '=', 'Doctor.MD ID')
        ->groupBy('Doctor.MD Class')
        ->get();

    }

    public static function getManager(){

        return $query = DB::connection('raging')
        ->table('SalesByRep as a')
        ->select(
            'b.Manager Name as item_name',
            DB::raw("SUM(a.Qty) as Volume")
        )
        ->join('Doctor as b', 'a.MD ID', '=', 'b.MD ID')
        ->groupBy('b.Manager Name')
        // ->limit(1000)
        ->get();

    }

    public static function getManager2(){

        return $query = DB::connection('raging')
        ->table('SalesByRep as a')
        ->select(
            'b.Manager Name as item_name',
            DB::raw("SUM(a.Amount) as Value")
        )
        ->join('Doctor as b', 'a.MD ID', '=', 'b.MD ID')
        ->groupBy('b.Manager Name')
        ->get();

    }

    public static function getResultOnClick($data){

        return $query = DB::connection('raging')
        ->table('SalesByRep as a')
        ->select(
            'b.Medrep Name as item_name',
            DB::raw("SUM(a.Qty) as Volume")
        )
        ->join('Doctor as b', 'a.MD ID', '=', 'b.MD ID')
        ->groupBy('b.Medrep Name')
        ->get();

    }

    public static function getResultOnClick2($data){

        return $query = DB::connection('raging')
        ->table('SalesByRep as a')
        ->select(
            'b.Medrep Name as item_name',
            DB::raw("SUM(a.Amount) as Value")
        )
        ->join('Doctor as b', 'a.MD ID', '=', 'b.MD ID')
        ->groupBy('b.Medrep Name')
        ->get();

    }

    public static function dataAnalysisQuery($data){

        $toGroup = $data->row;
        $toSelect = $data->row;
        // $toColumns = $data->row;
        $column = $data->column;

        $replacements = array(
            'SalesByRep.item_name' => DB::raw("SalesByRep.item_name as [Item Name]"),
            'class' => DB::raw("class as [TC]"),
            'Name' => DB::raw("Name as [MD Name]"),
            'Date' => DB::raw("CONVERT(varchar, Date, 107) as Date")
        );

        foreach($toSelect as $key  => $value){
            if(isset($replacements[$value])){
                $toSelect[$key] = $replacements[$value];
            }
        }

        $count = DB::raw("FORMAT(COUNT('*'), 'N0') as TxCount");
        $sumVolume = DB::raw("ISNULL(FORMAT(SUM(Qty), 'N0'), 0) as Volume");
        $sumValue = DB::raw("ISNULL(FORMAT(SUM(Amount), 'N2'), 0) as Value");

        // $datequarter = DB::raw("DATEPART(quarter,[date]) as [Quarter]");
        // $dateMonth = DB::raw("DATEPART(month, [date]) as [Month]");
        // $dateYear = DB::raw("DATEPART(year, [date]) as [Year]");
        // $dateWeek = DB::raw("DATEPART(week, [date]) as [Week]");

        array_push($toGroup, $column);
        array_push($toSelect, $column, $count, $sumVolume, $sumValue);
        // array_push($toColumns, 'Column', 'Count', 'Volume', 'Value');

        $query = DB::connection('raging')
        ->table('SalesByRep')
        ->select(
            $toSelect
        )
        ->leftjoin('Doctor', 'SalesByRep.MD ID', '=', 'Doctor.MD ID')
        ->join('PRODUCT_TC', 'SalesByRep.item_code', '=', 'PRODUCT_TC.item_code')
        ->groupBy($toGroup)
        ->get();

        $item_name = "Item Name";

        return [
            'data' => $query
        ];

    }

    // public static function volume($data){

    //     $query = DB::connection('raging')
    //     ->table('sales_all')
    //     ->limit(100)
    //     ->get();

    //     $collection = collect($query);

    //     $final = $collection->groupBy($data->row)->map(function($row) use ($data){
    //         return [
    //             'key' => $row->unique($data->column),
    //             'Volume' => $row->sum('Volume'),
    //             'Value' => $row->sum('Value'),
    //             'column' => $row->pluck($data->column),
    //             'doctor' => $row->pluck('MD Name'),
    //         ];
    //     });

    //     $dataToPassColumn = $data->column;
    //     $dataToPassRow = $data->row;

    //     $data2 = [];

    //     foreach($final as $out){

    //         $data2[] = [
    //             'row'       => $out['key'][0]->$dataToPassRow,
    //             'column'    => $out['key'][0]->$dataToPassColumn,
    //             'volume'    => $out['Volume'],
    //             'value'     => $out['Value']
    //         ];

    //     }

    //     return $data2;

    // } 

    // public static function value($data){

    //     $query = DB::connection('raging')
    //     ->table('sales_all')
    //     ->limit(100)
    //     ->get();

    //     $collection = collect($query);

    //     $final = $collection->groupBy($data->row)->map(function($row) use ($data){
    //         return [
    //             'key' => $row->unique($data->column),
    //             'Volume' => $row->sum('Volume'),
    //             'Value' => $row->sum('Value'),
    //             'column' => $row->pluck($data->column),
    //             'doctor' => $row->pluck('MD Name'),
    //         ];
    //     });

    //     $dataToPassColumn = $data->column;
    //     $dataToPassRow = $data->row;

    //     $data2 = [];

    //     foreach($final as $out){

    //         $data2[] = [
    //             'row'       => $out['key'][0]->$dataToPassRow,
    //             'column'    => $out['key'][0]->$dataToPassColumn,
    //             'volume'    => $out['Volume'],
    //             'value'     => $out['Value']
    //             // 'row'       => $out['key'][0]->$dataToPassRow,
    //             // 'column'    => $out['column'],
    //             // 'volume'    => $out['Volume'],
    //             // 'value'     => $out['Value'],
    //             // 'doctor'    => $out['doctor']
    //         ];

    //     }

    //     return $data2;

    // }

}
