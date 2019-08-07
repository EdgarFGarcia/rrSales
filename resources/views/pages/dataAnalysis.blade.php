@extends('layouts.main')
@section('title', 'Data Analysis')

@section('content')
<style type="text/css">
    td:nth-last-child(-n+3){
        text-align: right
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

                                </select>
                            </div>

                            <div class="col-md-4">

                                <label id="submit">Submit</label><br/>
                                <button type="button" id="submit" class="btn btn-info form-control">Submit</button>

                            </div>

                        </div>

                    </div>
                    
                    <div class="col-lg-12 col-md-12" id="divTable">
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
            drawTable(response.data);
        });
    }

    function drawTable(data){

        $('#labelWarning').addClass("hidden");
        $('#loading').addClass("hidden");
        $('#displayTable').removeClass("hidden");
        $('#contentbody').removeClass("hidden");

        var my_columns = [];

        $.each(data[0], function(key, value){
            var my_items = {};
            my_items.mData = key;
            my_items.sTitle = key;
            my_columns.push(my_items);
        });

        if(table){

            /*
                Destroy previous parent div of the table then build it in DOM
                then feed datatable necessary values then initialize the datatables
            */

            $('#divTable').html("");
            $('#divTable').append($('<table>').attr('id', 'displayTable').css('width', '100%').addClass('display table table-striped table-bordered table-hover'));

            table = $('#displayTable').DataTable({
                dom: 'Bfrtip',
                scrollX: true,
                lengthMenu: [
                    [ 10, 25, 50, -1 ],
                    [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                ],
                buttons: [
                    'pageLength', 'csv'
                ],
                data: data,
                columns: my_columns,
                destroy : true
            });

        }else{
            // not initialized
            table = $('#displayTable').DataTable({
                dom: 'Bfrtip',
                scrollX: true,
                lengthMenu: [
                    [ 10, 25, 50, -1 ],
                    [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                ],
                buttons: [
                    'pageLength', 'csv'
                ],
                data: data,
                columns: my_columns,
                destroy : true
            });

        }

    }

</script>
@endsection