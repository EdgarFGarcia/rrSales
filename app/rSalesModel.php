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
        ->table('sales_all')
        ->select(
            DB::raw("IFNULL(specialty, 'NOT MAPPED') as item_name"),
            DB::raw("SUM(Volume) as Volume"),
            DB::raw("SUM(Volume) as Value")
        )
        // ->join('Doctor as b', 'a.doctor_id', '=', 'b.doctor_id')
        ->groupBy('specialty')
        ->limit(1000)
        ->get();

    }

    public static function getSalesPerFrequency(){

        return $query = DB::connection('raging')
        ->table('sales_all')
        ->select(
            DB::raw("IFNULL(frequency, 'NOT MAPPED') as item_name"),
            DB::raw("SUM(Volume) as Volume"),
            DB::raw("SUM(Value) as Value")
        )
        // ->join('SalesByRep as b', 'a.doctor_id', '=', 'b.doctor_id')
        ->groupBy('frequency')
        ->limit(1000)
        ->get();


    }

    public static function getSalesPerDoctorClass(){

        return $query = DB::connection('raging')
        ->table('sales_all')
        ->select(
            DB::raw("IFNULL(`MD Class`, 'NOT MAPPED') as item_name"),
            DB::raw("SUM(Volume) as Volume"),
            DB::raw("SUM(Value) as Value")
        )
        // ->join('SalesByRep as b', 'a.doctor_id', '=', 'b.doctor_id')
        ->groupBy('`MD Class`')
        ->limit(1000)
        ->get();

    }

    public static function getManager(){

        return $query = DB::connection('raging')
        ->table('sales_all')
        ->select(
            DB::raw("IFNULL(`Manager Name`, 'NOT MAPPED') as item_name"),
            DB::raw("SUM(Volume) as Volume")
        )
        // ->join('SalesByRep as b', 'a.doctor_id', '=', 'b.doctor_id')
        ->groupBy('Manager Name')
        ->limit(1000)
        ->get();

    }

    public static function getManager2(){

        return $query = DB::connection('raging')
        ->table('sales_all')
        ->select(
            DB::raw("IFNULL(`Manager Name`, 'NOT MAPPED') as item_name"),
            DB::raw("SUM(Value) as Value")
        )
        // ->join('SalesByRep as b', 'a.doctor_id', '=', 'b.doctor_id')
        ->groupBy('Manager Name')
        ->limit(1000)
        ->get();

    }

    public static function getResultOnClick($data){

        return $query = DB::connection('raging')
        ->table('sales_all')
        ->select(
            DB::raw("IFNULL(`Medrep Name`, 'NOT MAPPED') as item_name"),
            DB::raw("SUM(Volume) as Volume")
        )
        // ->join('SalesByRep as b', 'a.doctor_id', '=', 'b.doctor_id')
        ->groupBy('Medrep Name')
        ->limit(1000)
        ->get();

    }

    public static function getResultOnClick2($data){

        return $query = DB::connection('raging')
        ->table('sales_all')
        ->select(
            // DB::raw("COUNT(*) as item_name"),
            DB::raw("IFNULL(`Medrep Name`, 'NOT MAPPED') as item_name"),
            DB::raw("SUM(Value) as Value")
        )
        // ->join('SalesByRep as b', 'a.doctor_id', '=', 'b.doctor_id')
        ->groupBy('Medrep Name')
        ->limit(1000)
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
        $sumVolume = DB::raw("IFNULL(SUM(Volume), 0) as Volume");
        $sumValue = DB::raw("IFNULL(SUM(Value), 0) as Value");
        $column = $data->column;

        array_push($toGroup, $column);
        array_push($toSelect, $count, $sumVolume, $sumValue, $column);
        array_push($toColumns, 'Column', 'Count', 'Volume', 'Value');

        // return count($toColumns);

        $query = DB::connection('raging')
        ->table('sales_all')
        ->select(
            $toSelect
        )
        // ->join('SalesByRep', 'Doctor.doctor_id', '=', 'SalesByRep.doctor_id')
        ->groupBy($toGroup)
        ->limit(100)
        // ->paginate(50);
        ->get();

        $content = "";
        $header = "";
        $keyProduct = "Key Product";
        $MDClass = "MD Class";
        $MDNAME = "MD NAME";
        $ManagerName = "Manager Name";
        $MedrepName = "Medrep Name";
        $contents = "";

        foreach($query as $out){
            
            // nasty code
            if(!empty($out->$keyProduct)){
                $contents .= "
                    <td>".$out->$keyProduct."</td>
                ";
            }
            if(!empty($out->Specialty)){
                $contents .= "
                    <td>".$out->Specialty."</td>
                ";
            }
            if(!empty($out->Frequency)){
                $contents .= "
                    <td>".$out->Frequency."</td>
                ";
            }
            if(!empty($out->MDClass)){
                $contents .= "
                    <td>".$out->MDClass."</td>
                ";
            }
            if(!empty($out->MDNAME)){
                $contents .= "
                    <td>".$out->MDNAME."</td>
                ";
            }
            if(!empty($out->ManagerName)){
                $contents .= "
                    <td>".$out->ManagerName."</td>
                ";
            }
            if(!empty($out->MedrepName)){
                $contents .= "
                    <td>".$out->MedrepName."</td>
                ";
            }
            // // end of nasty code

            $content .= "
                <tr>
                    ".$contents."
                    <td>".$out->TxCount."</td>
                    <td>".$out->Value."</td>
                    <td>".$out->Volume."</td>
                </tr>
            ";
        }

        // for($i = 0; $i < 20; $i++){
        //     $content .= "
        //         <tr>
        //             <td>Test</td>
        //             <td>Test</td>
        //             <td>Test</td>
        //             <td>Test</td>
        //             <td>Test</td>
        //         </tr>
        //     ";
        // }

        for($i = 0; $i < count($toColumns); $i++){
            $header .= "
                <th>".$toColumns[$i]."</th>
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
