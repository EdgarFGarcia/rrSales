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
                            
                            <!-- <div class="col-md-4">
                                <label>Value</label>
                                <select name="valvol" class="form-control" id="valvol" multiple="multiple">
                                    <option value="0">SELECT</option>
                                    <option value="1">Volume</option>
                                    <option value="2">Value</option>
                                </select>
                            </div> -->
                            
                            <div class="col-md-4">
                                <label for="row">Row</label>
                                <select name="row" id="row" class="form-control" multiple="multiple">
<<<<<<< HEAD
                                    <option value="Product">Product SKU</option>
                                    <option value="TC">Therapeutic Category</option>
                                    <option value="specialty">Specialty Sales</option>
                                    <option value="frequency">Sales Per Frequency</option>
=======
                                    <option value="0">SELECT</option>
                                    <option value="Key Product">Product SKU</option>
                                    <option value="Key Product">Therapeutic Category</option>
                                    <option value="Specialty">Specialty Sales</option>
                                    <option value="Frequency">Sales Per Frequency</option>
>>>>>>> 87da048f1231fe5c3a252ba25de1806e65837f41
                                    <option value="MD Class">Sales Per Doctor Class</option>
                                    <option value="Last Name">Doctor Name</option>
                                    <option value="Manager Name">Manager Name</option>
                                    <option value="Medrep Name">Medrep Name</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="column">Column</label>
                                <select name="column" id="column" class="form-control">
<<<<<<< HEAD
                                    <option value="">SELECT</option>
                                    <option value="Product">Product SKU</option>
                                    <option value="TC">Therapeutic Category</option>
                                    <option value="specialty">Specialty Sales</option>
                                    <option value="frequency">Sales Per Frequency</option>
=======
                                    <option value="0">SELECT</option>
                                    <option value="Key Product">Product SKU</option>
                                    <option value="Key Product">Therapeutic Category</option>
                                    <option value="Specialty">Specialty Sales</option>
                                    <option value="Frequency">Sales Per Frequency</option>
>>>>>>> 87da048f1231fe5c3a252ba25de1806e65837f41
                                    <option value="MD Class">Sales Per Doctor Class</option>
                                    <option value="Last Name">Doctor Name</option>
                                    <option value="Manager Name">Manager Name</option>
                                    <option value="Medrep Name">Medrep Name</option>
                                </select>
                            </div>

                            <div class="col-md-4">
<<<<<<< HEAD
                                <label id="submit">Submit</label><br/>
                                <button type="button" id="submit" class="btn btn-info form-control">Submit</button>
=======
                                <label for="submit">Submit</label><br/>
                                <button type="button" id="submit" class="form-control btn btn-info">Submit</button>
>>>>>>> 87da048f1231fe5c3a252ba25de1806e65837f41
                            </div>

                        </div>

                    </div>
                    
                    <div class="col-lg-12 col-md-12 hidden" id="divTable">
                            
                        <table class="table table-bordered table-striped table-hover" id="tableOut" width="100%">
                            <thead>
                                <tr>
                                    <th>Row</th>
                                    <th>Column</th>
                                    <!-- <th>Doctor Name</th> -->
                                    <th>Volume</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
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
    
    $(document).ready(function(){

        // on load function
        $('#row').select2();
        $('#column').select2();
        $('#valvol').select2();

        // $(document).on('change', '#valvol', function(){

        //     var valvol = $('#valvol').val();
        //     var row = $('#row').val();
        //     var column = $('#column').val();

        //     if((row != 0) && (column != 0)){
        //         // console.log(valvol + " " + row + " " + column);
        //         toQuery(valvol, row, column);
        //     }

        // });

        // $(document).on('change', '#row', function(){
        //     var valvol = $('#valvol').val();
        //     var row = $('#row').val();
        //     var column = $('#column').val();

        //     if((valvol != 0) && (column != 0)){
        //         // console.log(valvol + " " + row + " " + column);
        //         toQuery(valvol, row, column);
        //     }

        // });

        // $(document).on('change', '#column', function(){
        //     var valvol = $('#valvol').val();
        //     var row = $('#row').val();
        //     var column = $('#column').val();

        //     if((valvol != 0) && (row != 0)){
        //         // console.log(valvol + " " + row + " " + column);
        //         toQuery(valvol, row, column);
        //     }
<<<<<<< HEAD

        // });

=======

        // });

>>>>>>> 87da048f1231fe5c3a252ba25de1806e65837f41
        $(document).on('click', '#submit', function(){
            var row = $('#row').val();
            var column = $('#column').val();
            toQuery(row, column);
        });

    });

    // event listeners
    // function toQuery(valvol, row, column){
    function toQuery(row, column){
<<<<<<< HEAD
=======

>>>>>>> 87da048f1231fe5c3a252ba25de1806e65837f41
        $.ajax({
            url : "{{ url('/dataAnalysisQuery') }}",
            method : "GET",
            data : {
                // valvol : valvol,
                row : row,
                column : column
            },
            beforeSend : function(){
                // $('#contentbody').fadeOut(500);
                // $('#labelWarning').removeClass("hidden");
                // $('#loading').removeClass("hidden");
                $('#divTable').addClass("hidden");
            }
        }).done(function(response){
<<<<<<< HEAD
            console.log(response);
            // if(response.response){
            //     $('#contentbody').fadeIn(500);
            //     $('#labelWarning').addClass("hidden");
            //     $('#loading').addClass("hidden");
            //     $('#divTable').removeClass("hidden");
            //     $('#tableOut').DataTable({
            //         destroy : true,
            //         dom: 'Bfrtip',
            //         scrollX: true,
            //         lengthMenu: [
            //             [ 10, 25, 50, -1 ],
            //             [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            //         ],
            //         buttons: [
            //             'pageLength', 'csv'
            //         ],
            //         data : response.data,
            //         aoColumns:[
            //             { "mDataProp": "row" },
            //             { "mDataProp": "column" },
            //             // { "mDataProp": "doctor" },
            //             { "mDataProp": "volume" },
            //             { "mDataProp": "value" }
            //         ]
            //     });
            // }
=======
            if(response.response){
                // $('#contentbody').fadeIn(500);
                // $('#labelWarning').addClass("hidden");
                // $('#loading').addClass("hidden");
                $('#divTable').removeClass("hidden");
                $('#tableOut').DataTable({
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
                    data : response.data,
                    aoColumns:[
                        { "mDataProp": "row" },
                        { "mDataProp": "column" },
                        // { "mDataProp": "doctor" },
                        { "mDataProp": "volume" },
                        { "mDataProp": "value" }
                    ]
                });
            }
>>>>>>> 87da048f1231fe5c3a252ba25de1806e65837f41
        });

    }

</script>
@endsection