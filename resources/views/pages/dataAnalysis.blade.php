@extends('layouts.main')
@section('title', 'Data Analysis')

@section('content')
<style type="text/css">
    td:nth-last-child(-n+3){
        text-align: right
    }
    #displayTable_filter input {
        width: 300px;
        position: relative;
        right: 153px;
    }
</style>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Data Analysis</h2>
    
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="{{ url('/main') }}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Data Analysis</span></li>
            </ol>
    
            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <!-- <a href="#" class="fa fa-caret-down"></a> -->
                        <!-- <a href="#" class="fa fa-times"></a> -->
                    </div>

                    <h2 class="panel-title">Data Analysis</h2>
                    <p class="panel-subtitle">Data Analysis will show pre-defined charts that can later be customized per client.</p>

                </header>

                <div class="panel-body">

                    <center><h3 id="labelWarning" class="hidden">Loading Please Wait...This can take from 5 to 10 minutes (Please be patient)</h3></center>
                    <center><img src="{{ asset('images/loading2.gif') }}" class="hidden" id="loading"/></center>

                    <div class="col-lg-12 col-md-12" id="contentbody">

                        <div class="row">
                            
                            <div class="col-md-4">
                                <label for="row">Row</label>

                                <select name="row" id="row" class="form-control" multiple="multiple">

                                    <option value="SalesByRep.item_name">Product SKU</option>
                                    <option value="class">Therapeutic Category</option>
                                    <option value="Specialty">Specialty</option>
                                    <option value="Frequency">Frequency</option>
                                    <option value="MD Class">Doctor Class</option>
                                    <option value="Name">Doctor Name</option>
                                    <option value="Manager Name">Manager Name</option>
                                    <option value="Medrep Name">Medrep Name</option>
                                    <option value="Date">Date</option>
                                    <option value="SalesByRep.Date">Year</option>
                                    <option value="SalesByRep.date">Quarter</option>
                                    <option value="SalesByRep.dAte">Month</option>
                                    <option value="SalesByRep.daTe">Week</option>

                                </select>

                            </div>

                            <div class="col-md-4">
                                <label for="column">Column</label>

                                <select name="column" id="column" class="form-control">

                                    <option value="0">SELECT</option>
                                    <option value="SalesByRep.item_name">Product SKU</option>
                                    <option value="class">Therapeutic Category</option>
                                    <option value="Specialty">Specialty</option>
                                    <option value="Frequency">Frequency</option>
                                    <option value="MD Class">Doctor Class</option>
                                    <option value="Name">Doctor Name</option>
                                    <option value="Manager Name">Manager Name</option>
                                    <option value="Medrep Name">Medrep Name</option>
                                    <option value="Date">Date</option>
                                    <option value="SalesByRep.Date">Year</option>
                                    <option value="SalesByRep.date">Quarter</option>
                                    <option value="SalesByRep.dAte">Month</option>
                                    <option value="SalesByRep.daTe">Week</option>

                                </select>
                            </div>

                            <div class="col-md-4">

                                <label id="submit">Submit</label><br/>
                                <button type="button" id="submit" class="btn btn-info form-control">Submit</button>

                            </div>

                        </div>

                    </div>
                    
                    <div class="col-lg-12 col-md-12" id="divTable">

                        <!-- <label id="txcount"></label><br/>
                        <label id="volume"></label><br/>
                        <label id="value"></label> -->

                    	<table id="displayTable" class="display table table-bordered table-striped table-hover hidden" cellspacing="0" width="100%">
                    	</table>
                    </div>
            
                </div>
            </section>
        </div>
    </div>
    <!-- end: page -->
</section>

@endsection

@section('scripts')
<script>

    var row;
    var column;
    var table;
    var subTable;
    var totalFormatVolume;
    var totalFormatValue;
    var totalFormatTxCount;

    $(document).ready(function(){

        // on load function
        $('#row').select2();
        $('#column').select2();
        $('#valvol').select2();

        $(document).on('click', '#submit', function(){
            row = $('#row').val();
            column = $('#column').val();
            toQuery(row, column);
        });

    });

    function toQuery(row, column){
        $.ajax({
            url : "{{ url('/dataAnalysisQuery') }}",
            method : "GET",
            data : {
                row : row,
                column : column
            },
            beforeSend : function(){
                $('#labelWarning').removeClass("hidden");
                $('#loading').removeClass("hidden");
                $('#displayTable').addClass("hidden");
                $('#contentbody').addClass("hidden");
            }
        }).done(function(response){
            drawTable(response.data, response.data2, response.totalTxCount, response.totalVolume, response.totalValue);
        });
    }

    function drawTable(data, data2, txcounttotal, volumetotal, valuetotal){

        $('#labelWarning').addClass("hidden");
        $('#loading').addClass("hidden");
        $('#displayTable').removeClass("hidden");
        $('#contentbody').removeClass("hidden");

        var my_columns = [];
        var tableFooter;

        $.each(data[0], function(key, value){
            var my_items = {};
            my_items.mData = key;
            my_items.sTitle = key;
            my_columns.push(my_items);
        });

        var totalVolume = 0;
        var totalValue = 0;
        var totalCount = 0;
        for(var i = 0; i < data2.length; i++){
            // console.log(data[i].Volume);
            totalVolume += parseInt(data2[i].Volume2);
            totalValue += parseInt(data2[i].Value2);
            totalCount += parseInt(data2[i].TxCount2);
        }

        // var totalFormatVolume;
        // var totalFormatValue;
        // var totalFormatTxCount;

        totalFormatVolume = numeral(totalVolume).format('0,0');
        totalFormatValue = numeral(totalValue).format('0,0.0');
        totalFormatTxCount = numeral(totalCount).format('0,0');

        // console.log(totalFormatVolume + " " + totalFormatValue + " " + totalFormatTxCount);

        // $.each(data[0], function(key, value){
        //     tableFooter += "<th>" + key + "</th>";
        // });

        if(table){

            /*
                Destroy previous parent div of the table then build it in DOM
                then feed datatable necessary values then initialize the datatables
            */

            $('#divTable').html("");
            $('#divTable').append($('<table>').attr('id', 'displayTable').css('width', '100%').addClass('display table table-striped table-bordered'));

            table = $('#displayTable').DataTable({
                dom: 'Bfrtip',
                scrollX: true,
                pageLength : 25,
                buttons: [
                    'pageLength', 'csv'
                ],
                data: data,
                columns: my_columns,
                destroy : true,
            });

            $('tr th:nth-last-child(1)').attr('id', 'valueHeader');
            $('tr th:nth-last-child(2)').attr('id', 'volumeHeader');
            $('tr th:nth-last-child(3)').attr('id', 'txcounHeader');

            $('#valueHeader').append("<br/>" + totalFormatValue);
            $('#volumeHeader').append("<br/>" + totalFormatVolume);
            $('#txcounHeader').append("<br/>" + totalFormatTxCount);

        }else{
            // not initialized
            table = $('#displayTable').DataTable({
                
                dom: 'Bfrtip',
                scrollX: true,
                lengthMenu: [
                    [ 25, 50, 50, -1 ],
                    [ '25 rows', '50 rows', '100 rows', 'Show all' ]
                ],
                pageLength : 25
,                buttons: [
                    'pageLength', 'csv'
                ],
                data: data,
                columns: my_columns,
                columnDefs: [
                    {
                        "targets": -1,
                        "createdCell": function(td, cellData, rowData, row, col){
                            $(td).attr('id', 'valueHeader');
                        }
                    }
                ],
                destroy : true,
            });

            $('tr th:nth-last-child(1)').attr('id', 'valueHeader');
            $('tr th:nth-last-child(2)').attr('id', 'volumeHeader');
            $('tr th:nth-last-child(3)').attr('id', 'txcounHeader');

            $('#valueHeader').append("<br/>" + totalFormatValue);
            $('#volumeHeader').append("<br/>" + totalFormatVolume);
            $('#txcounHeader').append("<br/>" + totalFormatTxCount);

        }

    }

    // function toOpenSubModal(data){
    //     // console.log("test");
    //     $('#subDataTable').modal('toggle');
    //     subTable = $('#subDataTableTable').DataTable({
    //         dom: 'Bfrtip',
    //         scrollX: true,
    //         lengthMenu: [
    //             [ 25, 50, 50, -1 ],
    //             [ '25 rows', '50 rows', '100 rows', 'Show all' ]
    //         ],
    //         pageLength : 25,
    //         destroy : true
    //     });
    // }

</script>
@endsection