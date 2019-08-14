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
    .dataTables_filter {
		display: none; 
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

                                    <option value="">SELECT</option>
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

                    	<table id="displayTable" class="display table table-bordered table-striped table-hover hidden" cellspacing="0" width="100%">
                    	</table>

                    </div>
            
                </div>
            </section>
        </div>
    </div>
    <!-- end: page -->
    @include('modals.subDataTable')
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
    var dataToSortUnique;
    var sortUniqueValue;

    $(document).ready(function(){

        // on load function
        $('#row').select2();
        $('#column').select2();
        $('#valvol').select2();

        $(document).on('click', '#submit', function(){
            row = $('#row').val();
            column = $('#column').val();
            if(row !== "" && column !== ""){
                toQuery(row, column);
            }else{
                toastr.error("Row And Column should not be empty!");
            }
        });

        $(document).on('click', '#closeModalSort', function(){
        	$('#toDivide').html('');
        });

        $(document).on('click', '#sortData', function(){

        	var itemName = $('.itemName').is(':checked');
        	if(itemName){
        		var itemNames = [];
        		$.each($(".itemName:checked"), function(){            
	                itemNames.push('(?=.*' + $(this).val() + ')');
	            });
	            $('#displayTable').DataTable().search(
	            	itemNames.join('|'), true, false, true
	            ).draw();
	            $('#subDataTable').modal("toggle");
        	}

        	var tc = $('.className').is(':checked');
        	if(tc){
        		var tcArr = [];
        		$.each($(".className:checked"), function(){            
	                tcArr.push('(?=.*' + $(this).val() + ')');
	            });
	            $('#displayTable').DataTable().search(
	            	tcArr.join('|'), true, false, true
	            ).draw();
	            $('#subDataTable').modal("toggle");
        	}

        	var Specialty = $('.Specialty').is(':checked');
        	if(Specialty){
        		var specArr = [];
        		$.each($(".Specialty:checked"), function(){            
	                specArr.push('(?=.*' + $(this).val() + ')');
	            });
	            $('#displayTable').DataTable().search(
	            	specArr.join('|'), true, false, true
	            ).draw();
	            $('#subDataTable').modal("toggle");
        	}

        	var Frequency = $('.Frequency').is(':checked');
        	if(Frequency){
        		var frequencyArr = [];
        		$.each($(".Frequency:checked"), function(){            
	                frequencyArr.push('(?=.*' + $(this).val() + ')');
	            });
	            $('#displayTable').DataTable().search(
	            	frequencyArr.join('|'), true, false, true
	            ).draw();
	            $('#subDataTable').modal("toggle");
        	}

        	var mdClass = $('.mdClass').is(':checked');
        	if(mdClass){
        		var mdClassArr = [];
        		$.each($(".mdClass:checked"), function(){            
	                mdClassArr.push('(?=.*' + $(this).val() + ')');
	            });
	            $('#displayTable').DataTable().search(
	            	mdClassArr.join('|'), true, false, true
	            ).draw();
	            $('#subDataTable').modal("toggle");
        	}

        	var Name = $('.Name').is(':checked');
        	if(Name){
        		var NameArr = [];
        		$.each($(".mdClass:checked"), function(){            
	                NameArr.push('(?=.*' + $(this).val() + ')');
	            });
	            $('#displayTable').DataTable().search(
	            	NameArr.join('|'), true, false, true
	            ).draw();
	            $('#subDataTable').modal("toggle");
        	}

        	var managerName = $('.managerName').is(':checked');
        	if(managerName){
        		var managerNameArr = [];
        		$.each($(".mdClass:checked"), function(){            
	                // itemNames.push($(this).val());
	                managerNameArr.push('(?=.*' + $(this).val() + ')');
	            });
	            $('#displayTable').DataTable().search(
	            	managerNameArr.join('|'), true, false, true
	            ).draw();
	            $('#subDataTable').modal("toggle");
        	}

        	var medrepName = $('.medrepName').is(':checked');
        	if(medrepName){
        		var medrepNameArr = [];
        		$.each($(".mdClass:checked"), function(){            
	                medrepNameArr.push('(?=.*' + $(this).val() + ')');
	            });
	            $('#displayTable').DataTable().search(
	            	medrepNameArr.join('|'), true, false, true
	            ).draw();
	            $('#subDataTable').modal("toggle");
        	}

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
            sortUniqueValue = response.toColumn;
        });
    }

    function drawTable(data, data2, txcounttotal, volumetotal, valuetotal){

        $('#labelWarning').addClass("hidden");
        $('#loading').addClass("hidden");
        $('#displayTable').removeClass("hidden");
        $('#contentbody').removeClass("hidden");

        var my_columns = [];
        var tableFooter;
        dataToSortUnique = data;

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
            totalVolume += parseInt(data2[i].Volume2);
            totalValue += parseInt(data2[i].Value2);
            totalCount += parseInt(data2[i].TxCount2);
        }

        totalFormatVolume = numeral(totalVolume).format('0,0');
        totalFormatValue = numeral(totalValue).format('0,0.0');
        totalFormatTxCount = numeral(totalCount).format('0,0');

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
                lengthMenu: [
                    [ 25, 50, 50, -1 ],
                    [ '25 rows', '50 rows', '100 rows', 'Show all' ]
                ],
                pageLength : 25,
                buttons: [
                    'pageLength',{
                        extend: 'csv',
                        exportOptions: {
                            modifier: {
                              page: 'all'
                            }
                        },
                    }
                ],    
                data: data,
                columns: my_columns,
                destroy : true,
            });

            $('tr th:nth-last-child(1)').attr('id', 'valueHeader');
            $('tr th:nth-last-child(2)').attr('id', 'volumeHeader');
            $('tr th:nth-last-child(3)').attr('id', 'txcounHeader');

            // $('tr th').attr('id', 'sortAll');
            // $('#sortAll').append("<button type='button' class='btn btn-default pull-right' onclick='sortAll();'><i class='fa fa-search-plus' aria-hidden='true'></i></button>'");

            $('tr th').attr('class', 'sortAll');

            $('#valueHeader').removeClass('sortAll');
            $('#volumeHeader').removeClass('sortAll');
            $('#txcounHeader').removeClass('sortAll');
           	
           	var idIndex = 0;
           	
           	$('.sortAll').each(function(index, item){

           		idIndex ++;

           		$(item).append("<button type='button' class='btn btn-link pull-right' onclick='sortAll("+idIndex+");'><i class='fa fa-search-plus' aria-hidden='true'></i></button>");

           	});

            $('#valueHeader').append("<br/>" + "<span class='pull-right'>" + totalFormatValue + "</span>");
            $('#volumeHeader').append("<br/>" + "<span class='pull-right'>" + totalFormatVolume + "</span>");
            $('#txcounHeader').append("<br/>" + "<span class='pull-right'>" + totalFormatTxCount + "</span>");

            table.columns.adjust().draw();

        }else{

            // not initialized
            table = $('#displayTable').DataTable({
                
                dom: 'Bfrtip',
                scrollX: true,
                lengthMenu: [
                    [ 25, 50, 50, -1 ],
                    [ '25 rows', '50 rows', '100 rows', 'Show all' ]
                ],
                pageLength : 25,
                buttons: [
                    'pageLength',{
                        extend: 'csv',
                        exportOptions: {
                            modifier: {
                              page: 'all'
                            }
                        },
                    }
                ],
                data: data,
                columns: my_columns,
                destroy : true,
            });

            $('tr th:nth-last-child(1)').attr('id', 'valueHeader');
            $('tr th:nth-last-child(2)').attr('id', 'volumeHeader');
            $('tr th:nth-last-child(3)').attr('id', 'txcounHeader');

            $('tr th').attr('class', 'sortAll');
 
            $('#valueHeader').removeClass('sortAll');
            $('#volumeHeader').removeClass('sortAll');
            $('#txcounHeader').removeClass('sortAll');

            var idIndex = 0;

           	$('.sortAll').each(function(index, item){

           		idIndex ++;

                $(item).append("<button type='button' class='btn btn-link pull-right' onclick='sortAll("+idIndex+");'><i class='fa fa-search-plus' aria-hidden='true'></i></button>");

           	});

            $('#valueHeader').append("<br/>" + "<span class='pull-right'>" + totalFormatValue + "</span>");
            $('#volumeHeader').append("<br/>" + "<span class='pull-right'>" + totalFormatVolume + "</span>");
            $('#txcounHeader').append("<br/>" + "<span class='pull-right'>" + totalFormatTxCount + "</span>");

            table.columns.adjust().draw();

        }

    }

    function sortAll(id){

    	$('#toDivide').html('');
    	var newId = id - 1;
		var headerText = table.column( newId ).title();

		if(headerText == "Item Name"){
			getItemName();
		}

		if(headerText == "TC"){
			getTc();
		}

		if(headerText == "Specialty"){
			getSpecialty();
		}

		if(headerText == "Frequency"){
			getFrequency();
		}

		if(headerText == "MD Class"){
			getMdClass();
		}

		if(headerText == "MD Name"){
			getMDName();
		}

		if(headerText == "Manager Name"){
			getManagerName();
		}

		if(headerText == "Medrep Name"){
			getMedrepName();
		}

        // if(jQuery.inArray("Item Name", sortUniqueValue) != -1){
        //     getItemName();
        // }

        // if(jQuery.inArray("TC", sortUniqueValue) != -1){
        // 	getTc();
        // }

        // if(jQuery.inArray("Specialty", sortUniqueValue) != -1){
        // 	getSpecialty();
        // }

        // if(jQuery.inArray("Frequency", sortUniqueValue) != -1){
        // 	getFrequency();
        // }

        // if(jQuery.inArray("MD Class", sortUniqueValue) != -1){
        // 	getMdClass();
        // }

        // if(jQuery.inArray("MD Name", sortUniqueValue) != -1){
        // 	getMDName();
        // }

        // if(jQuery.inArray("Manager Name", sortUniqueValue) != -1){
        // 	getManagerName();
        // }

        // if(jQuery.inArray("Medrep Name", sortUniqueValue) != -1){
        // 	getMedrepName();
        // }

        $('#subDataTable').modal("toggle");

    }

    function getItemName(){
        $.ajax({
            url : "{{ url('/getProduct') }}",
            method : "GET",
            beforeSend : function(){
                $('#loadingModal').removeClass('hidden');
            }
        }).done(function(response){
            $('#loadingModal').addClass('hidden');
        	$('#toDivide').append(response);
        	$('.itemName').prop('checked', 'true');
        	$(document).on('click', '#check', function(){
        		$('.itemName').prop('checked', true);
        	});
        	$(document).on('click', '#uncheck', function(){
        		$('.itemName').prop('checked', false);
        	});
        });
    }

    function getTc(){
    	$.ajax({
    		url : "{{ url('/getTc') }}",
    		method : "GET",
            beforeSend : function(){
                $('#loadingModal').removeClass('hidden');
            }
    	}).done(function(response){
            $('#loadingModal').addClass('hidden');
    		$('#toDivide').append(response);
    		$('.className').prop('checked', 'true');
        	$(document).on('click', '#check', function(){
        		$('.className').prop('checked', true);
        	});
        	$(document).on('click', '#uncheck', function(){
        		$('.className').prop('checked', false);
        	});
    	});
    }

    function getSpecialty(){
    	$.ajax({
    		url : "{{ url('/getSpecialty') }}",
    		method : "GET",
            beforeSend : function(){
                $('#loadingModal').removeClass('hidden');
            }
    	}).done(function(response){
            $('#loadingModal').addClass('hidden');
    		$('#toDivide').append(response);
    		$('.Specialty').prop('checked', 'true');
        	$(document).on('click', '#check', function(){
        		$('.Specialty').prop('checked', true);
        	});
        	$(document).on('click', '#uncheck', function(){
        		$('.Specialty').prop('checked', false);
        	});
    	});
    }

    function getFrequency(){
    	$.ajax({
    		url : "{{ url('/getFrequency') }}",
    		method : "GET",
            beforeSend : function(){
                $('#loadingModal').removeClass('hidden');
            }
    	}).done(function(response){
            $('#loadingModal').addClass('hidden');
    		$('#toDivide').append(response);
    		$('.Frequency').prop('checked', 'true');
        	$(document).on('click', '#check', function(){
        		$('.Frequency').prop('checked', true);
        	});
        	$(document).on('click', '#uncheck', function(){
        		$('.Frequency').prop('checked', false);
        	});
    	});
    }

    function getMdClass(){
    	$.ajax({
    		url : "{{ url('/getMdClass') }}",
    		method : "GET",
            beforeSend : function(){
                $('#loadingModal').removeClass('hidden');
            }
    	}).done(function(response){
            $('#loadingModal').addClass('hidden');
    		$('#toDivide').append(response);
    		$('.mdClass').prop('checked', 'true');
        	$(document).on('click', '#check', function(){
        		$('.mdClass').prop('checked', true);
        	});
        	$(document).on('click', '#uncheck', function(){
        		$('.mdClass').prop('checked', false);
        	});
    	});
    }

    function getMDName(){
    	$.ajax({
    		url : "{{ url('/getMDName') }}",
    		method : "GET",
            beforeSend : function(){
                $('#loadingModal').removeClass('hidden');
            }
    	}).done(function(response){
            $('#loadingModal').addClass('hidden');
    		$('#toDivide').append(response);
    		$('.Name').prop('checked', 'true');
        	$(document).on('click', '#check', function(){
        		$('.Name').prop('checked', true);
        	});
        	$(document).on('click', '#uncheck', function(){
        		$('.Name').prop('checked', false);
        	});
    	});
    }

    function getManagerName(){
    	$.ajax({
    		url : "{{ url('/getManagerName') }}",
    		method : "GET",
            beforeSend : function(){
                $('#loadingModal').removeClass('hidden');
            }
    	}).done(function(response){
            $('#loadingModal').addClass('hidden');
    		$('#toDivide').append(response);
    		$('.managerName').prop('checked', 'true');
        	$(document).on('click', '#check', function(){
        		$('.managerName').prop('checked', true);
        	});
        	$(document).on('click', '#uncheck', function(){
        		$('.managerName').prop('checked', false);
        	});
    	});
    }

    function getMedrepName(){
    	$.ajax({
    		url : "{{ url('/getMedrepName') }}",
    		method : "GET",
            beforeSend : function(){
                $('#loadingModal').removeClass('hidden');
            }
    	}).done(function(response){
            $('#loadingModal').addClass('hidden');
    		$('#toDivide').append(response);
    		$('.medrepName').prop('checked', 'true');
        	$(document).on('click', '#check', function(){
        		$('.medrepName').prop('checked', true);
        	});
        	$(document).on('click', '#uncheck', function(){
        		$('.medrepName').prop('checked', false);
        	});
    	});
    }

</script>
@endsection