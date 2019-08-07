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
        ->table('Doctor as a')
        ->select(
            DB::raw("ISNULL(a.MD Class, 'NOT MAPPED') as item_name"),
            DB::raw("SUM(b.Qty) as Volume"),
            DB::raw("SUM(b.Amount) as Value")
        )
        ->join('SalesByRep as b', 'a.MD ID', '=', 'b.MD ID')
        ->groupBy('a.MD Class')
        ->get();

    }

    public static function getManager(){

        return $query = DB::connection('raging')
        ->table('Doctor as a')
        ->select(
            'a.Manager Name as item_name',
            DB::raw("SUM(b.Qty) as Volume")
        )
        ->join('SalesByRep as b', 'a.MD ID', '=', 'b.MD ID')
        ->groupBy('a.Manager Name')
        // ->limit(1000)
        ->get();

    }

    public static function getManager2(){

        return $query = DB::connection('raging')
        ->table('Doctor as a')
        ->select(
            'a.Manager Name as item_name',
            DB::raw("SUM(b.Amount) as Value")
        )
        ->join('SalesByRep as b', 'a.MD ID', '=', 'b.MD ID')
        ->groupBy('a.Manager Name')
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
        // return $data->row;

        $toGroup = $data->row;
        $toSelect = $data->row;
        $toColumns = $data->row;

        $replacements = array(
            'SalesByRep.item_name' => DB::raw("SalesByRep.item_name as [Item Name]"),
            'class' => DB::raw("class as [TC]"),
            'Name' => DB::raw("Name as [MD Name]")
        );

        foreach($toSelect as $key  => $value){
            if(isset($replacements[$value])){
                $toSelect[$key] = $replacements[$value];
            }
        }

        $count = DB::raw("FORMAT(COUNT('*'), 'N0') as TxCount");
        $sumVolume = DB::raw("ISNULL(FORMAT(SUM(Qty), 'N0'), 0) as Volume");
        $sumValue = DB::raw("ISNULL(FORMAT(SUM(Amount), 'N2'), 0) as Value");

        $column = $data->column;

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

        // $header = "";
        // $product = "Item Name";
        // $class = "TC";
        // $MDClass = "MD Class";
        // $MDNAME = "MD Name";
        // $ManagerName = "Manager Name";
        // $MedrepName = "Medrep Name";

        // $data = array();

        // foreach($query as $out){
        //     $obj = new \stdClass;

        //     if(!empty($out->item_name)){
        //         $obj->$product = $out->item_name;
        //     }

        //     if(!empty($out->class)){
        //         $obj->$class = $out->class;
        //     }

        //     if(!empty($out->Specialty)){
        //         $obj->Specialty = $out->Specialty;
        //     }

        //     if(!empty($out->Frequency)){
        //         $obj->Frequency = $out->Frequency;
        //     }

        //     if(!empty($out->$MDClass)){
        //         $obj->$MDClass = $out->$MDClass;
        //     }

        //     if(!empty($out->Name)){
        //         $obj->$MDNAME = $out->Name;
        //     }

        //     if(!empty($out->$ManagerName)){
        //         $obj->$ManagerName = $out->$ManagerName;
        //     }

        //     if(!empty($out->$MedrepName)){
        //         $obj->$MedrepName = $out->$MedrepName;
        //     }

        //     $obj->TxCount = $out->TxCount;
        //     $obj->Volume = $out->Volume;
        //     $obj->Value = $out->Value;

        //     $data[] = $obj;
        // }

        // $info = new Collection($data);

        // for($i = 0; $i < count($toColumns); $i++){
        //     $header .= "
        //         <th>".$toColumns[$i]."</th>
        //     ";
        // }

        return [
            // 'header' => $header,
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
