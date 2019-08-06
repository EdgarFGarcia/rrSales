@extends('layouts.main')
@section('title', 'Data Analysis')

@section('content')
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

                                    <option value="Key Product">Product SKU</option>
                                    <option value="Key Product">Therapeutic Category</option>
                                    <option value="Specialty">Specialty Sales</option>
                                    <option value="Frequency">Sales Per Frequency</option>
                                    <option value="MD Class">Sales Per Doctor Class</option>
                                    <option value="Doctor.Last Name">Doctor Name</option>
                                    <option value="Manager Name">Manager Name</option>
                                    <option value="Medrep Name">Medrep Name</option>

                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="column">Column</label>
                                <select name="column" id="column" class="form-control">

                                    <option value="0">SELECT</option>

                                    <option value="Key Product">Product SKU</option>
                                    <option value="Key Product">Therapeutic Category</option>
                                    <option value="Specialty">Specialty Sales</option>
                                    <option value="Frequency">Sales Per Frequency</option>
                                    <option value="MD Class">Sales Per Doctor Class</option>
                                    <option value="Doctor.Last Name">Doctor Name</option>
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
                    	<table id="displayTable" class="table table-bordered table-striped table-hover hidden" cellspacing="0" width="100%">
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

    // event listeners
    // function toQuery(valvol, row, column){
    function toQuery(row, column){
        $.ajax({
            url : "{{ url('/dataAnalysisQuery') }}",
            method : "GET",
            data : {
                row : row,
                column : column
            },
            beforeSend : function(){
                $('#contentbody').fadeOut(500);
                $('#labelWarning').removeClass("hidden");
                $('#loading').removeClass("hidden");
                $('#displayTable').addClass("hidden");
            },
            success: function(){
                console.log("success entered");
            }
        }).done(function(data){
            // console.log(data);
            if(data.response){

                $('#contentbody').fadeIn(500);
                $('#labelWarning').addClass("hidden");
                $('#loading').addClass("hidden");
                $('#displayTable').removeClass("hidden");

                var my_columns = [];

                $.each(data.data[0], function(key, value){
                    var my_items = {};
                    my_items.data = key;
                    my_items.title = key;
                    my_columns.push(my_items);
                });

                // var jsonData = JSON.parse(data.data);
                // console.log(jsonData);

                // $("#divTable").append('<table id="displayTable" class="display table table-bordered table-striped table-hover" cellspacing="0" width="100%"><thead><tr>' + data.header + '</tr></thead></table>');

                $('#displayTable').DataTable({
                    destroy : true,
                    dom: 'Bfrtip',
                    scrollX: true,
                    lengthMenu: [
                        [ 10, 25, 50, -1 ],
                        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                    ],
                    buttons: [
                        'pageLength', 'csv'
                    ],
                    data: data.data,
                    "columns": my_columns
                });
                
            }
        });

    }

</script>
@endsection