@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Dashboard</h2>
    
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="{{ url('/main') }}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Dashboard</span></li>
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

                    <h2 class="panel-title">Dashboard</h2>
                    <p class="panel-subtitle">Dashboard will show pre-defined charts that can later be customized per client.</p>

                </header>

                <div class="panel-body">

                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <div class="col-md-12 col-md-12">

                                <h1 for="categories" id="categoriesLabel"></h1>
                                <div class="col-md-4">
                                    <select name="categories" id="categories" class="form-control">
                                        <option value="1">Product SKU</option>
                                        <option value="2">Therapeutic Category</option>
                                        <option value="3">Specialty Sales</option>
                                        <option value="4">Sales Per Frequency</option>
                                        <option value="5">Sales Per Doctor Class</option>
                                    </select>
                                </div>
                            </div>
                            
                            <br/><br/>

                            <div class="col-lg-12 col-md-12">

                                <center><h3 id="labelWarning" class="hidden">Loading Please Wait...</h3></center>
                                <center><img src="{{ asset('images/loading2.gif') }}" class="hidden" id="loading"/></center> 
                                <div id="product" style="height: 600px;"></div>

                            </div>

                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12">

                        <h1>By District</h1>
                        <ul class="nav nav-tabs" id="navtab">
                          <li class="nav-item active">
                            <a class="nav-link active" data-toggle="tab" href="#home">Volume</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#menu1">Value</a>
                          </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                          <div class="tab-pane container active" id="home">

                            <center><h3 id="labelWarning2" class="hidden">Loading Please Wait...</h3></center>
                            <center><h3 id="labelWarning4" class="hidden">Loading Please Wait... This can take up to 5 minutes</h3></center>
                            <center><img src="{{ asset('images/loading2.gif') }}" class="hidden" id="loading2"/></center> 

                            <div id="district" style="height: 600px;"></div>

                          </div>
                          <div class="tab-pane container fade" id="menu1">

                            <center><h3 id="labelWarning3" class="hidden">Loading Please Wait...</h3></center>
                            <center><h3 id="labelWarning4" class="hidden">Loading Please Wait... This can take up to 5 minutes</h3></center>
                            <center><img src="{{ asset('images/loading2.gif') }}" class="hidden" id="loading3"/></center> 

                            <div id="district2" style="height: 600px;"></div>

                          </div>
                        </div>

                    </div>

                    <!-- <div class="col-lg-12 col-md-12">
                        
                        <h1>Header</h1>

                        <div class="row" id="hideMeSelection">
                            <div class="col-md-4">
                                <label for="value">Value</label>
                                <select name="value" id="value" class="form-control">
                                    <option value="0">SELECT</option>
                                    <option value="1">Value</option>
                                    <option value="2">Quantity</option>
                                    <option value="3">TX Count</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="row">Row</label>
                                <select name="row" id="row" class="form-control">
                                    <option value="0">SELECT</option>
                                    <option value="1">Product SKU</option>
                                    <option value="2">Therapeutic Category</option>
                                    <option value="3">Institution</option>
                                    <option value="4">MDC Branch</option>
                                    <option value="5">Month</option>
                                    <option value="6">Quarter</option>
                                    <option value="7">Year</option>
                                    <option value="8">Territory</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="column">Column</label>
                                <select name="column" id="column" class="form-control">
                                    <option value="0">SELECT</option>
                                    <option value="1">Product SKU</option>
                                    <option value="2">Therapeutic Category</option>
                                    <option value="3">Institution</option>
                                    <option value="4">MDC Branch</option>
                                    <option value="5">Month</option>
                                    <option value="6">Quarter</option>
                                    <option value="7">Year</option>
                                    <option value="8">Territory</option>
                                </select>
                            </div>
                        </div>
                        <br/><br/>
                        <table id="tableSelection" class="table table-bordered table-striped table-hover hidden" width="100%">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Position</th>
                              <th>Office</th>
                              <th>Extn.</th>
                              <th>Start Date</th>
                              <th>Salary</th>
                            </tr>
                          </thead>
                        </table>

                        <center><h3 id="labelWarningSelection" class="hidden">Loading Please Wait... This can take up to 5 minutes</h3></center>
                        <center><img src="{{ asset('images/loading2.gif') }}" class="hidden" id="loadingSelection"/></center>

                    </div> -->
            
                </div>
            </section>
        </div>
    </div>
    <!-- end: page -->
    @include('modals.dm')
    @include('modals.selectionTable')
</section>

@endsection

@section('scripts')
<script>
    var managerName;
    var value;
    var row;
    var column;
    $(document).ready(function(){
        // onLoad functions
        loadProduct();
        loadDistrict();
        loadDistrict2();
        $('#categories').select2();
        $('#value').select2();
        $('#row').select2();
        $('#column').select2();

        // event listeners 1st chart
        $(document).on('change', '#categories', function(){
            var categories = $('#categories').val();
            if(categories == 1){
                loadProduct();
            }else if(categories == 2){
                loadTherapeutic();
            }else if(categories == 3){
                specialtySales();
            }else if(categories == 4){
                salesPerFrequency();
            }else if(categories == 5){
                salesPerDoctorClass();
            }
        });

        // event listener 3rd chart
        // value = $('#value').val();
        // row = $('#row').val();
        // column = $('#column').val();

        // $(document).on('change', '#value', function(){
        //     value = $('#value').val();
        //     row = $('#row').val();
        //     column = $('#column').val();
        //     if((row != 0) && (column != 0) && (value != 0)){
        //         loadSelection(value, row, column);
        //     }
        // });

        // $(document).on('change', '#row', function(){
        //     value = $('#value').val();
        //     row = $('#row').val();
        //     column = $('#column').val();
        //     if((value != 0) && (column != 0) && (row != 0)){
        //         loadSelection(value, row, column);
        //     }
        // });

        // $(document).on('change', '#column', function(){
        //     value = $('#value').val();
        //     row = $('#row').val();
        //     column = $('#column').val();
        //     if((value != 0) && (row != 0) && (column != 0)){
        //         loadSelection(value, row, column);
        //     }
        // });

    });

    // function loadSelection(value, row, column){
    //     $.ajax({
    //         url : "{{ url('/loadSelection') }}",
    //         method : "GET",
    //         data : {
    //             value : value,
    //             row : row,
    //             column : column
    //         },
    //         beforeSend : function(){
    //             $('#hideMeSelection').addClass("hidden");
    //             $('#labelWarningSelection').removeClass("hidden");
    //             $('#loadingSelection').removeClass("hidden");
    //         }
    //     }).done(function(response){
    //         if(response.response){
    //             // $('#datatableModal').modal("show");
    //             $('#tableSelection').removeClass("hidden");
    //             $('#hideMeSelection').removeClass("hidden");
    //             $('#labelWarningSelection').addClass("hidden");
    //             $('#loadingSelection').addClass("hidden");
    //         }
    //         var dataSet = [
    //             [ "Tiger Nixon", "System Architect", "Edinburgh", "5421", "2011/04/25", "$320,800" ],
    //             [ "Garrett Winters", "Accountant", "Tokyo", "8422", "2011/07/25", "$170,750" ],
    //             [ "Ashton Cox", "Junior Technical Author", "San Francisco", "1562", "2009/01/12", "$86,000" ],
    //             [ "Cedric Kelly", "Senior Javascript Developer", "Edinburgh", "6224", "2012/03/29", "$433,060" ],
    //             [ "Airi Satou", "Accountant", "Tokyo", "5407", "2008/11/28", "$162,700" ],
    //             [ "Brielle Williamson", "Integration Specialist", "New York", "4804", "2012/12/02", "$372,000" ],
    //             [ "Herrod Chandler", "Sales Assistant", "San Francisco", "9608", "2012/08/06", "$137,500" ],
    //             [ "Rhona Davidson", "Integration Specialist", "Tokyo", "6200", "2010/10/14", "$327,900" ],
    //             [ "Colleen Hurst", "Javascript Developer", "San Francisco", "2360", "2009/09/15", "$205,500" ],
    //             [ "Sonya Frost", "Software Engineer", "Edinburgh", "1667", "2008/12/13", "$103,600" ],
    //             [ "Jena Gaines", "Office Manager", "London", "3814", "2008/12/19", "$90,560" ],
    //             [ "Quinn Flynn", "Support Lead", "Edinburgh", "9497", "2013/03/03", "$342,000" ],
    //             [ "Charde Marshall", "Regional Director", "San Francisco", "6741", "2008/10/16", "$470,600" ],
    //             [ "Haley Kennedy", "Senior Marketing Designer", "London", "3597", "2012/12/18", "$313,500" ],
    //             [ "Tatyana Fitzpatrick", "Regional Director", "London", "1965", "2010/03/17", "$385,750" ],
    //             [ "Michael Silva", "Marketing Designer", "London", "1581", "2012/11/27", "$198,500" ],
    //             [ "Paul Byrd", "Chief Financial Officer (CFO)", "New York", "3059", "2010/06/09", "$725,000" ],
    //             [ "Gloria Little", "Systems Administrator", "New York", "1721", "2009/04/10", "$237,500" ],
    //             [ "Bradley Greer", "Software Engineer", "London", "2558", "2012/10/13", "$132,000" ],
    //             [ "Dai Rios", "Personnel Lead", "Edinburgh", "2290", "2012/09/26", "$217,500" ],
    //             [ "Jenette Caldwell", "Development Lead", "New York", "1937", "2011/09/03", "$345,000" ],
    //             [ "Yuri Berry", "Chief Marketing Officer (CMO)", "New York", "6154", "2009/06/25", "$675,000" ],
    //             [ "Caesar Vance", "Pre-Sales Support", "New York", "8330", "2011/12/12", "$106,450" ],
    //             [ "Doris Wilder", "Sales Assistant", "Sydney", "3023", "2010/09/20", "$85,600" ],
    //             [ "Angelica Ramos", "Chief Executive Officer (CEO)", "London", "5797", "2009/10/09", "$1,200,000" ],
    //             [ "Gavin Joyce", "Developer", "Edinburgh", "8822", "2010/12/22", "$92,575" ],
    //             [ "Jennifer Chang", "Regional Director", "Singapore", "9239", "2010/11/14", "$357,650" ],
    //             [ "Brenden Wagner", "Software Engineer", "San Francisco", "1314", "2011/06/07", "$206,850" ],
    //             [ "Fiona Green", "Chief Operating Officer (COO)", "San Francisco", "2947", "2010/03/11", "$850,000" ],
    //             [ "Shou Itou", "Regional Marketing", "Tokyo", "8899", "2011/08/14", "$163,000" ],
    //             [ "Michelle House", "Integration Specialist", "Sydney", "2769", "2011/06/02", "$95,400" ],
    //             [ "Suki Burks", "Developer", "London", "6832", "2009/10/22", "$114,500" ],
    //             [ "Prescott Bartlett", "Technical Author", "London", "3606", "2011/05/07", "$145,000" ],
    //             [ "Gavin Cortez", "Team Leader", "San Francisco", "2860", "2008/10/26", "$235,500" ],
    //             [ "Martena Mccray", "Post-Sales support", "Edinburgh", "8240", "2011/03/09", "$324,050" ],
    //             [ "Unity Butler", "Marketing Designer", "San Francisco", "5384", "2009/12/09", "$85,675" ]
    //         ];
             
    //         // $('#example').DataTable().destroy();
    //             $('#tableSelection').DataTable( {
    //                 destroy: true,
    //                 dom: 'Bfrtip',
    //                 lengthMenu: [
    //                     [ 10, 25, 50, -1 ],
    //                     [ '10 rows', '25 rows', '50 rows', 'Show all' ]
    //                 ],
    //                 buttons: [
    //                     'pageLength', 'csv'
    //                 ],
    //                 data: dataSet,
    //                 columns: [
    //                     { title: "Name" },
    //                     { title: "Position" },
    //                     { title: "Office" },
    //                     { title: "Extn." },
    //                     { title: "Start date" },
    //                     { title: "Salary" }
    //                 ]
    //             } );
    //         } );
    // }

    function loadProduct(){

        $('#categoriesLabel').html('');
        $('#categoriesLabel').html("Sales Per Product");

        $('#loading').removeClass('hidden');
        $('#product').addClass("hidden");

        $.ajax({
            url: "{{ url('/getProducts') }}",
            method : "GET"
        }).done(function(response){
            $('#loading').addClass("hidden");
            $('#product').removeClass("hidden");
            charts(response);
        });

    }

    function loadTherapeutic(){

        $('#categoriesLabel').html('');
        $('#categoriesLabel').html("Therapeutic Category");

        $('#loading').removeClass('hidden');
        $('#product').addClass("hidden");

        $.ajax({
            url: "{{ url('/gettherapeutic') }}",
            method : "GET"
        }).done(function(response){
            $('#loading').addClass("hidden");
            $('#product').removeClass("hidden");
            charts(response);
        });

    }

    function specialtySales(){
        $('#categoriesLabel').html('');
        $('#categoriesLabel').html("Specialty Sales");
        $('#loading').removeClass('hidden');
        $('#product').addClass("hidden");
        $('#labelWarning').removeClass("hidden");
        $.ajax({
            url: "{{ url('/getSpecialtySales') }}",
            method : "GET"
        }).done(function(response){
            // console.log(response);
            $('#loading').addClass("hidden");
            $('#product').removeClass("hidden");
            $('#labelWarning').addClass("hidden");
            charts(response);
        });
    }

    function salesPerFrequency(){

        $('#categoriesLabel').html('');
        $('#categoriesLabel').html("Sales Per Frequency");
        $('#loading').removeClass('hidden');
        $('#product').addClass("hidden");
        $('#labelWarning').removeClass("hidden");

        $.ajax({
            url : "{{ url('/getSalesPerFrequency') }}",
            method : "GET"
        }).done(function(response){
            $('#loading').addClass("hidden");
            $('#product').removeClass("hidden");
            $('#labelWarning').addClass("hidden");
            charts(response);
        });

    }

    function salesPerDoctorClass(){

        $('#categoriesLabel').html('');
        $('#categoriesLabel').html("Sales Per Doctor Class");

        $('#loading').removeClass('hidden');
        $('#product').addClass("hidden");
        $('#labelWarning').removeClass("hidden");

        $.ajax({
            url : "{{ url('/getSalesPerDoctorClass') }}",
            method : "GET"
        }).done(function(response){
            $('#loading').addClass("hidden");
            $('#product').removeClass("hidden");
            $('#labelWarning').addClass("hidden");
            charts(response);
        });
    }

    function charts(result){

        am4core.ready(function() {
        am4core.useTheme(am4themes_material);
        // Themes end

        // Create chart instance
        var chart = am4core.create("product", am4charts.XYChart);

        chart.colors.step = 2;
        chart.maskBullets = false;

        // Add data
        chart.data = result;

        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.dataFields.category = "item_name";
        categoryAxis.renderer.minGridDistance = 40;
        categoryAxis.renderer.labels.template.horizontalCenter = "right";
        categoryAxis.renderer.labels.template.verticalCenter = "middle";
        categoryAxis.renderer.labels.template.rotation = 270;
        categoryAxis.fontSize = 12;

        var volumeAxis = chart.yAxes.push(new am4charts.ValueAxis());
        volumeAxis.title.text = "Volume (Qty)";
        volumeAxis.renderer.grid.template.disabled = true;

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.title.text = "Value (Amount)";
        valueAxis.renderer.grid.template.disabled = true;
        valueAxis.renderer.opposite = true;

        // valueAxis.durationFormatter.durationFormat = "hh'h' mm'min'";

        var latitudeAxis = chart.yAxes.push(new am4charts.ValueAxis());
        latitudeAxis.renderer.grid.template.disabled = true;
        latitudeAxis.renderer.labels.template.disabled = true;

        // Create series
        var volumeSeries = chart.series.push(new am4charts.ColumnSeries());
        volumeSeries.dataFields.valueY = "Volume";
        volumeSeries.dataFields.categoryX = "item_name";
        // volumeSeries.dataFields.valueX = "date";
        volumeSeries.yAxis = volumeAxis;
        volumeSeries.tooltipText = "Volume: {valueY}";
        volumeSeries.name = "Volume";
        volumeSeries.columns.template.fillOpacity = 0.7;
        volumeSeries.columns.template.propertyFields.strokeDasharray = "dashLength";
        volumeSeries.columns.template.propertyFields.fillOpacity = "alpha";

        var volumeState = volumeSeries.columns.template.states.create("hover");
        volumeState.properties.fillOpacity = 0.9;

        var valueSeries = chart.series.push(new am4charts.LineSeries());
        valueSeries.dataFields.valueY = "Value";
        valueSeries.dataFields.categoryX = "item_name";
        // valueSeries.dataFields.valueX = "date";
        valueSeries.yAxis = valueAxis;
        valueSeries.name = "Value";
        valueSeries.strokeWidth = 2;
        valueSeries.propertyFields.strokeDasharray = "dashLength";
        valueSeries.tooltipText = "Value: {valueY}";

        var durationBullet = valueSeries.bullets.push(new am4charts.Bullet());
        var durationRectangle = durationBullet.createChild(am4core.Rectangle);
        durationBullet.horizontalCenter = "middle";
        durationBullet.verticalCenter = "middle";
        durationBullet.width = 7;
        durationBullet.height = 7;
        durationRectangle.width = 7;
        durationRectangle.height = 7;

        var durationState = durationBullet.states.create("hover");
        durationState.properties.scale = 1.2;

        // Add legend
        chart.legend = new am4charts.Legend();

        // Add cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.fullWidthLineX = true;
        chart.cursor.xAxis = categoryAxis;
        chart.cursor.lineX.strokeOpacity = 0;
        chart.cursor.lineX.fill = am4core.color("#000");
        chart.cursor.lineX.fillOpacity = 0.1;

        }); // end am4core.ready()
    }


    function loadDistrict(){
        $('#labelWarning2').removeClass("hidden");
        $('#loading2').removeClass("hidden");
        $('#district').addClass("hidden");
        $.ajax({
            url : "{{ url('/getManager') }}",
            method : "GET"
        }).done(function(response){
            $('#labelWarning2').addClass("hidden");
            $('#loading2').addClass("hidden");
            $('#district').removeClass("hidden");
            district(response);
        });
        
    }

    function loadDistrict2(){
        $('#labelWarning3').removeClass("hidden");
        $('#loading3').removeClass("hidden");
        $('#district2').addClass("hidden");

        // ajax call
        $.ajax({
            url : "{{ url('/getManager2') }}",
            method : "GET"
        }).done(function(response){
            $('#labelWarning3').addClass("hidden");
            $('#loading3').addClass("hidden");
            $('#district2').removeClass("hidden");
            district2(response);
        });

    }

    function district2(response){
        // console.log(response);
        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_material);
            // Themes end

            var chart = am4core.create("district2", am4charts.XYChart);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            chart.data = response;

            var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.dataFields.category = "item_name";
            categoryAxis.renderer.minGridDistance = 40;
            categoryAxis.renderer.labels.template.horizontalCenter = "right";
            categoryAxis.renderer.labels.template.verticalCenter = "middle";
            categoryAxis.renderer.labels.template.rotation = 270;
            categoryAxis.fontSize = 12;

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.renderer.minGridDistance = 30;

            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.categoryX = "item_name";
            series.dataFields.valueY = "Value";
            series.columns.template.tooltipText = "{valueY.value}";
            series.columns.template.tooltipY = 0;
            series.columns.template.strokeOpacity = 0;

            // as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
            series.columns.template.adapter.add("fill", function(fill, target) {
              return chart.colors.getIndex(target.dataItem.index);
            });

            series.columns.template.events.on("hit", function(ev){
                // console.log("clicked on", ev.target.dataItem.dataContext);
                managerName = ev.target.dataItem.dataContext.item_name;
                getResultOnClick2(managerName);
            }, this);

        });
    }

    function district(response){
        // console.log(response);
        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_material);
            // Themes end

            var chart = am4core.create("district", am4charts.XYChart);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            chart.data = response;

            var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.dataFields.category = "item_name";
            categoryAxis.renderer.minGridDistance = 40;
            categoryAxis.renderer.labels.template.horizontalCenter = "right";
            categoryAxis.renderer.labels.template.verticalCenter = "middle";
            categoryAxis.renderer.labels.template.rotation = 270;
            categoryAxis.fontSize = 12;

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.renderer.minGridDistance = 30;

            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.categoryX = "item_name";
            series.dataFields.valueY = "Volume";
            series.columns.template.tooltipText = "{valueY.value}";
            series.columns.template.tooltipY = 0;
            series.columns.template.strokeOpacity = 0;

            // as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
            series.columns.template.adapter.add("fill", function(fill, target) {
              return chart.colors.getIndex(target.dataItem.index);
            });

            series.columns.template.events.on("hit", function(ev){
                // console.log("clicked on", ev.target.dataItem.dataContext);
                managerName = ev.target.dataItem.dataContext.item_name;
                getResultOnClick(managerName);
            }, this);

        });
    }

    function getResultOnClick2(managerName){
        $.ajax({
            url : "{{ url('/getResultOnClick2') }}",
            method : "GET",
            data : {
                name : managerName
            },
            beforeSend : function(){
                $('#labelWarning4').removeClass("hidden");
                $('#loading3').removeClass("hidden");
                $('#district2').addClass("hidden");
                $('#navtab').addClass("hidden");
            }
        }).done(function(response){
            $('#labelWarning4').addClass("hidden");
            $('#loading3').addClass("hidden");
            $('#district2').removeClass("hidden");
            $('#navtab').removeClass("hidden");
            $('#exampleModal').modal('show');
            drawChart(response);
        });
    }

    function getResultOnClick(managerName){
        $.ajax({
            url : "{{ url('/getResultOnClick') }}",
            method : "GET",
            data : {
                name : managerName
            },
            beforeSend: function(){
                $('#labelWarning4').removeClass("hidden");
                $('#loading2').removeClass("hidden");
                $('#district').addClass("hidden");
                $('#navtab').addClass("hidden");
            }
        }).done(function(response){
            $('#labelWarning4').addClass("hidden");
            $('#loading2').addClass("hidden");
            $('#district').removeClass("hidden");
            $('#navtab').removeClass("hidden");
            $('#exampleModal').modal('show');
            drawChart(response);
        });
    }

    function drawChart(result){

        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_material);
            // Themes end

            var chart = am4core.create("modalChart", am4charts.XYChart);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            chart.data = result;

            var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.dataFields.category = "item_name";
            categoryAxis.renderer.minGridDistance = 40;
            categoryAxis.renderer.labels.template.horizontalCenter = "right";
            categoryAxis.renderer.labels.template.verticalCenter = "middle";
            categoryAxis.renderer.labels.template.rotation = 270;
            categoryAxis.fontSize = 12;

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.renderer.minGridDistance = 30;

            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.categoryX = "item_name";
            series.dataFields.valueY = "Volume";
            series.columns.template.tooltipText = "{valueY.value}";
            series.columns.template.tooltipY = 0;
            series.columns.template.strokeOpacity = 0;

            // as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
            series.columns.template.adapter.add("fill", function(fill, target) {
              return chart.colors.getIndex(target.dataItem.index);
            });

            series.columns.template.events.on("hit", function(ev){
                // console.log("clicked on", ev.target.dataItem.dataContext);
                managerName = ev.target.dataItem.dataContext.item_name;
                getResultOnClick(managerName);
            }, this);

        });

    }

</script>
@endsection