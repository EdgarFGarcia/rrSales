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

        return $query = DB::connection('raging')
        ->table('SalesByRep as a')
        ->select(
            DB::raw("IFNULL(specialty, 'NOT MAPPED') as item_name"),
            DB::raw("SUM(a.Qty) as Volume"),
            DB::raw("SUM(a.Amount) as Value")
        )
        ->join('Doctor as b', 'a.doctor_id', '=', 'b.doctor_id')
        ->groupBy('b.Specialty')
        // ->limit(1000)
        ->get();

    }

    public static function getSalesPerFrequency(){

        return $query = DB::connection('raging')
        ->table('Doctor as a')
        ->select(
            DB::raw("IFNULL(frequency, 'NOT MAPPED') as item_name"),
            DB::raw("SUM(b.Qty) as Volume"),
            DB::raw("SUM(b.Amount) as Value")
        )
        ->join('SalesByRep as b', 'a.doctor_id', '=', 'b.doctor_id')
        ->groupBy('frequency')
        // ->limit(1000)
        ->get();


    }

    public static function getSalesPerDoctorClass(){

        return $query = DB::connection('raging')
        ->table('Doctor as a')
        ->select(
            DB::raw("IFNULL(a.MD_Class, 'NOT MAPPED') as item_name"),
            DB::raw("SUM(b.Qty) as Volume"),
            DB::raw("SUM(b.Amount) as Value")
        )
        ->join('SalesByRep as b', 'a.doctor_id', '=', 'b.doctor_id')
        ->groupBy('a.MD_Class')
        // ->limit(1000)
        ->get();

    }

    public static function getManager(){

        return $query = DB::connection('raging')
        ->table('Doctor as a')
        ->select(
            // DB::raw("ISNULL(a.Manager Name, 'NOT MAPPED') as item_name"),
            'a.Manager_Name as item_name',
            DB::raw("SUM(b.Qty) as Volume")
        )
        ->join('SalesByRep as b', 'a.doctor_id', '=', 'b.doctor_id')
        ->groupBy('a.Manager_Name')
        ->limit(1000)
        ->get();

    }

    public static function getManager2(){

        return $query = DB::connection('raging')
        ->table('Doctor as a')
        ->select(
            // DB::raw("IFNULL(a.Manager Name, 'NOT MAPPED') as item_name"),
            'a.Manager_Name as item_name',
            DB::raw("SUM(b.Amount) as Value")
        )
        ->join('SalesByRep as b', 'a.doctor_id', '=', 'b.doctor_id')
        ->groupBy('a.Manager_Name')
        ->limit(1000)
        ->get();

    }

    public static function getResultOnClick($data){

        return $query = DB::connection('raging')
        ->table('Doctor as a')
        ->select(
            // DB::raw("IFNULL(`Medrep Name`, 'NOT MAPPED') as item_name"),
            'a.Medrep_Name as item_name',
            DB::raw("SUM(b.Qty) as Volume")
        )
        ->join('SalesByRep as b', 'a.doctor_id', '=', 'b.doctor_id')
        ->groupBy('a.Medrep_Name')
        ->limit(1000)
        ->get();

    }

    public static function getResultOnClick2($data){

        return $query = DB::connection('raging')
        ->table('Doctor as a')
        ->select(
            // DB::raw("COUNT(*) as item_name"),
            // DB::raw("IFNULL(`Medrep Name`, 'NOT MAPPED') as item_name"),
            'a.Medrep_Name as item_name',
            DB::raw("SUM(b.Amount) as Value")
        )
        ->join('SalesByRep as b', 'a.doctor_id', '=', 'b.doctor_id')
        ->groupBy('a.Medrep_Name')
        ->limit(1000)
        ->get();

    }

    public static function dataAnalysisQuery($data){
        // return $data->row;
        $toGroup = $data->row;
        $toSelect = $data->row;
        $toColumns = $data->row;

        $count = DB::raw("COUNT('*') as TxCount");
        $sumVolume = DB::raw("SUM(SalesByRep.Qty) as Volume");
        $sumValue = DB::raw("SUM(SalesByRep.Amount) as Value");
        $column = $data->column;

        array_push($toGroup, $column);
        array_push($toSelect, $count, $sumVolume, $sumValue, $column);
        array_push($toColumns, 'Column', 'Count', 'Volume', 'Value');

        $query = DB::connection('raging')
        ->table('Doctor')
        ->select(
            $toSelect
        )
        ->leftJoin('SalesByRep', 'Doctor.doctor_id', '=', 'SalesByRep.doctor_id')
        ->groupBy($toGroup)
        ->limit(100)
        // ->paginate(50);
        ->get()
        ->all();

        $content = "";
        $header = "";
        $keyProduct = "Key Product";
        $MDClass = "MD_Class";
        $MDNAME = "Last_name";
        $ManagerName = "Manager_Name";
        $MedrepName = "Medrep_Name";
        $contents = "";

        for($i = 0; $i < count($toColumns); $i++){
            $header .= "
                <th>".$toColumns[$i]."</th>
            ";
        }

        $data = array();

        foreach($query as $out){

            $obj = new \stdClass;

            if(!empty($out->$keyProduct)){
                $obj->one = $out->$keyProduct;
            }else {
                $obj->one = "Empty";
            }

            if(!empty($out->Specialty)){
                $obj->two = $out->Specialty;
            }else {
                $obj->two = "Empty";
            }

            if(!empty($out->Frequency)){
                $obj->three = $out->Frequency;
            }else {
                $obj->three = "Empty";
            }

            if(!empty($out->MD_Class)){
                $obj->four = $out->MD_Class;
            }else {
                $obj->four = "Empty";
            }

            if(!empty($out->Last_Name)){
                $obj->five = $out->Last_Name;
            }else {
                $obj->five = "Empty";
            }

            if(!empty($out->Manager_Name)){
                $obj->six = $out->Manager_Name;
            }else {
                $obj->six = "Empty";
            }

            if(!empty($out->Medrep_Name)){
                $obj->seven = $out->Medrep_Name;
            }else {
                $obj->seven = "Empty";
            }
            $obj->column = $out->column;
            $obj->TxCount = $out->TxCount;
            $obj->Value = $out->Value;
            $obj->Volume = $out->Volume;

            $data[] = $obj;

        }

        $info = new Collection($data);

        return [
            'header' => $header,
            'data' => $info
        ];

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
