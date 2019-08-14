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
            DB::raw("ISNULL([MD Class], 'NOT MAPPED') as item_name"),
            DB::raw("SUM(SalesByRep.Qty) as Volume"),
            DB::raw("SUM(SalesByRep.Amount) as Value")
        )
        ->join('Doctor', 'SalesByRep.MD ID', '=', 'Doctor.MD ID')
        ->groupBy('MD Class')
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
        $toSelect2 = $data->row;

        $toColumns = $data->row;
        $toColumn = $data->row;
        $column = $data->column;

        $replacementsColumn = array(
            'SalesByRep.item_name' => "Item Name",
            'class' => "TC",
            'Name' => "MD Name",
            'item_name' => "Item Name",
            'Date' => "Date",
            'SalesByRep.Date' => "Year",
            'SalesByRep.date' => "Quarter",
            'SalesByRep.dAte' => "Month",
            'SalesByRep.daTe' => "Week"
        );

        $replacements = array(
            'SalesByRep.item_name' => DB::raw("SalesByRep.item_name as [Item Name]"),
            'class' => DB::raw("class as [TC]"),
            'Name' => DB::raw("Name as [MD Name]"),
            'Date' => DB::raw("CONVERT(varchar, [Date], 107) as [Date]"),
            'SalesByRep.Date' => DB::raw("DATEPART(year, [Date]) as [Year]"),
            'SalesByRep.date' => DB::raw("DATEPART(quarter, [Date]) as [Quarter]"),
            'SalesByRep.dAte' => DB::raw("DATEPART(month, [Date]) as [Month]"),
            'SalesByRep.daTe' => DB::raw("DATEPART(week, [Date]) as [Week]")
        );

        foreach($toSelect as $key  => $value){
            if(isset($replacements[$value])){
                $toSelect[$key] = $replacements[$value];
            }
        }

        foreach($toColumn as $key  => $value){
            if(isset($replacements[$value])){
                $toColumn[$key] = $replacementsColumn[$value];
            }
        }

        $count = DB::raw("FORMAT(COUNT('*'), 'N0') as TxCount");
        $count2 = DB::raw("COUNT('*') as TxCount2");
        $sumVolume = DB::raw("FORMAT(SUM(Qty), 'N0') as Volume");
        $sumVolume2 = DB::raw("SUM(Qty) as Volume2");
        $sumValue = DB::raw("FORMAT(SUM(Amount), 'N2') as Value");
        $sumValue2 = DB::raw("SUM(Amount) as Value2");

        array_push($toGroup, $column);
        array_push($toSelect, $column, $count, $sumVolume, $sumValue);
        array_push($toSelect2, $column, $count2, $sumVolume2, $sumValue2);
        array_push($toColumns, 'Column', 'Count', 'Volume', 'Value');

        $query = DB::connection('raging')
        ->table('SalesByRep')
        ->select(
            $toSelect
        )
        ->leftjoin('Doctor', 'SalesByRep.MD ID', '=', 'Doctor.MD ID')
        ->join('PRODUCT_TC', 'SalesByRep.item_code', '=', 'PRODUCT_TC.item_code')
        ->groupBy($toGroup)
        ->get();

        $query2 = DB::connection('raging')
        ->table('SalesByRep')
        ->select(
            $toSelect2
        )
        ->leftjoin('Doctor', 'SalesByRep.MD ID', '=', 'Doctor.MD ID')
        ->join('PRODUCT_TC', 'SalesByRep.item_code', '=', 'PRODUCT_TC.item_code')
        ->groupBy($toGroup)
        ->get();

        return [
            'data' => $query,
            'data2' => $query2,
            'toColumn' => $toColumn
        ];

    }

    public static function getProduct(){
        $query = DB::connection('raging')
        ->table('PRODUCT_TC')
        ->select(
            DB::raw("DISTINCT(item_name)")
        )
        ->orderBy('item_name', 'asc')
        ->get();

        $content = "";

        foreach($query as $out){
            $content .= "

                <div class='form-check'>
                    <label class='form-check-label'>
                        <input type='checkbox' class='form-check-input itemName' value='".$out->item_name."'> ".$out->item_name."
                    </label>
                </div>

            ";
        }

        return $content;

    }

    public static function getTc(){
        $query = DB::connection('raging')
        ->table('PRODUCT_TC')
        ->select(
            DB::raw("DISTINCT(class)")
        )
        ->orderBy('class', 'asc')
        ->get();

        $content = "";

        foreach($query as $out){
            $content .= "
                <div class='form-check'>
                    <label class='form-check-label'>
                        <input type='checkbox' class='form-check-input className' value='".$out->class."'> ".$out->class."
                    </label>
                </div>
            ";
        }

        return $content;

    }

    public static function getSpecialty(){
        $query = DB::connection('raging')
        ->table('Doctor')
        ->select(
            DB::raw("DISTINCT(Specialty)")
        )
        ->orderBy('Specialty', 'asc')
        ->get();

        $content = "";

        foreach($query as $out){
            $content .= "
                <div class='form-check'>
                    <label class='form-check-label'>
                        <input type='checkbox' class='form-check-input Specialty' value='".$out->Specialty."'> ".$out->Specialty."
                    </label>
                </div>
            ";
        }

        return $content;

    }

    public static function getFrequency(){
        $query = DB::connection('raging')
        ->table('Doctor')
        ->select(
            DB::raw("DISTINCT(Frequency)")
        )
        ->orderBy('Frequency', 'asc')
        ->get();

        $content = "";

        foreach($query as $out){
            $content .= "
                <div class='form-check'>
                    <label class='form-check-label'>
                        <input type='checkbox' class='form-check-input Frequency' value='".$out->Frequency."'> ".$out->Frequency."
                    </label>
                </div>
            ";
        }

        return $content;

    }

    public static function getMdClass(){
        $query = DB::connection('raging')
        ->table('Doctor')
        ->select(
            DB::raw("DISTINCT([MD Class]) as mdClass")
        )
        ->orderBy('mdClass', 'asc')
        ->get();

        $content = "";

        foreach($query as $out){
            $content .= "
                <div class='form-check'>
                    <label class='form-check-label'>
                        <input type='checkbox' class='form-check-input mdClass' value='".$out->mdClass."'> ".$out->mdClass."
                    </label>
                </div>
            ";
        }

        return $content;

    }

    public static function getMDName(){
        $query = DB::connection('raging')
        ->table('SalesByRep')
        ->select(
            DB::raw("DISTINCT(Name)")
        )
        ->orderBy('Name', 'asc')
        ->get();

        $content = "";

        foreach($query as $out){
            $content .= "
                <div class='form-check'>
                    <label class='form-check-label'>
                        <input type='checkbox' class='form-check-input Name' value='".$out->Name."'> ".$out->Name."
                    </label>
                </div>
            ";
        }

        return $content;

    }

    public static function getManagerName(){
        $query = DB::connection('raging')
        ->table('Doctor')
        ->select(
            DB::raw("DISTINCT([Manager Name]) as managerName")
        )
        ->orderBy('managerName', 'asc')
        ->get();

        $content = "";

        foreach($query as $out){
            $content .= "
                <div class='form-check'>
                    <label class='form-check-label'>
                        <input type='checkbox' class='form-check-input managerName' value='".$out->managerName."'> ".$out->managerName."
                    </label>
                </div>
            ";
        }

        return $content;

    }

    public static function getMedrepName(){
        $query = DB::connection('raging')
        ->table('Doctor')
        ->select(
            DB::raw("DISTINCT([Medrep Name]) as medrepName")
        )
        ->orderBy('medrepName', 'asc')
        ->get();

        $content = "";

        foreach($query as $out){
            $content .= "
                <div class='form-check'>
                    <label class='form-check-label'>
                        <input type='checkbox' class='form-check-input medrepName' value='".$out->medrepName."'> ".$out->medrepName."
                    </label>
                </div>
            ";
        }

        return $content;

    }

}