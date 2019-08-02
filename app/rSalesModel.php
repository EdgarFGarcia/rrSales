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

        return $query = DB::connection('raging')
        ->table('SalesByRep as a')
        ->select(
            DB::raw("IFNULL(b.Specialty, 'NOT MAPPED') as item_name"),
            DB::raw("SUM(a.Qty) as Volume"),
            DB::raw("SUM(a.Amount) as Value")
        )
        ->join('Doctor as b', 'a.doctor_id', '=', 'b.doctor_id')
        ->groupBy('b.Specialty')
        ->get();

    }

    public static function getSalesPerFrequency(){

        return $query = DB::connection('raging')
        ->table('Doctor as a')
        ->select(
            DB::raw("IFNULL(a.Frequency, 'NOT MAPPED') as item_name"),
            DB::raw("SUM(b.Qty) as Volume"),
            DB::raw("SUM(b.Amount) as Value")
        )
        ->join('SalesByRep as b', 'a.doctor_id', '=', 'b.doctor_id')
        ->groupBy('a.Frequency')
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
        ->get();

    }

    public static function getManager(){

        return $query = DB::connection('raging')
        ->table('Doctor as a')
        ->select(
            DB::raw("IFNULL(a.Manager_Name, 'NOT MAPPED') as item_name"),
            DB::raw("SUM(b.Qty) as Volume")
        )
        ->join('SalesByRep as b', 'a.doctor_id', '=', 'b.doctor_id')
        ->groupBy('a.Manager_Name')
        ->get();

    }

    public static function getManager2(){

        return $query = DB::connection('raging')
        ->table('Doctor as a')
        ->select(
            DB::raw("IFNULL(a.Manager_Name, 'NOT MAPPED') as item_name"),
            DB::raw("SUM(b.Amount) as Value")
        )
        ->join('SalesByRep as b', 'a.doctor_id', '=', 'b.doctor_id')
        ->groupBy('a.Manager_Name')
        ->get();

    }

    public static function getResultOnClick($data){

        return $query = DB::connection('raging')
        ->table('Doctor as a')
        ->select(
            DB::raw("IFNULL(a.Medrep_Name, 'NOT MAPPED') as item_name"),
            DB::raw("SUM(b.Qty) as Volume")
        )
        ->join('SalesByRep as b', 'a.doctor_id', '=', 'b.doctor_id')
        ->groupBy('a.Medrep_Name')
        ->get();

    }

    public static function getResultOnClick2($data){

        return $query = DB::connection('raging')
        ->table('Doctor as a')
        ->select(
            // DB::raw("COUNT(*) as item_name"),
            DB::raw("IFNULL(a.Medrep_Name, 'NOT MAPPED') as item_name"),
            DB::raw("SUM(b.Amount) as Value")
        )
        ->join('SalesByRep as b', 'a.doctor_id', '=', 'b.doctor_id')
        ->groupBy('a.Medrep_Name')
        ->get();

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
        $toGroup = $data->row;
        $toSelect = $data->row;
        $toColumns = $data->row;

        $count = DB::raw("COUNT('*') as TxCount");
        $sumVolume = DB::raw("SUM(Qty) as Volume");
        $sumValue = DB::raw("SUM(Amount) as Value");
        $column = $data->column;

        array_push($toGroup, 'Doctor.doctor_id', $column);
        array_push($toSelect, $count, $sumVolume, $sumValue, $column);
        array_push($toColumns, 'Column', 'Count', 'Volume', 'Value');

        // return count($toColumns);

        $query = DB::connection('raging')
        ->table('Doctor')
        ->select(
            $toSelect
        )
        ->join('SalesByRep', 'Doctor.doctor_id', '=', 'SalesByRep.doctor_id')
        ->groupBy($toGroup)
        ->limit(100)
        // ->paginate(50);
        ->get()
        ->all();

        $content = "";
        $header = "";

        foreach($query as $out){

            $content .= "
                <tr>
                    <td>".$out->MD_Class."</td>
                    <td>".$out->MD_Class."</td>
                    <td>".$out->Specialty."</td>
                    <td>".$out->TxCount."</td>
                    <td>".$out->Value."</td>
                    <td>".$out->Volume."</td>
                </tr>
            ";
        }

        for($i = 0; $i < count($toColumns); $i++){
            $header .= "
                <tr>
                    <th>".$toColumns[$i]."</th>
                </tr>
            ";
        }

        return [
            // $query,
            'header' => $header,
            'data' => $content
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
