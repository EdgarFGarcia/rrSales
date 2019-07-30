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
                            <div class="col-lg-12 col-md-12">
                                
                                <div class="col-md-4">
                                    <h1 id="header" for="series2" class="text-left"></h1>
                                    <select name="series2" id="series2" class="form-control">
                                        <option value="1">Product SKU</option>
                                        <option value="2">Therapeutic Category</option>
                                        <option value="3">Specialty Sales</option>
                                        <option value="4">Sales Per Doctor Frequency</option>
                                        <option value="5">Sales Per Doctor Class</option>
                                        <option value="6">Sales Per Location</option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div id="graphMain" style="width:100%; height: 600px;"></div>
                                    </div>

                                </div>

                            </div>

                            <hr style="border: 1px solid black; width: 100%;">

                            <div class="col-lg-12 col-md-12">
                                <h1>By District</h1>

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs">
                                  <li class="nav-item active">
                                    <a class="nav-link active" data-toggle="tab" href="#secondGraph">Volume</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#value">Value</a>
                                  </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                  <div class="tab-pane container active" id="secondGraph"></div>
                                  <div class="tab-pane container" id="value"></div>
                                </div>

                                <!-- <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-primary" id="what1" value="1">Value</button>
                                            <button type="button" class="btn btn-primary" id="what2" value="2">Volume</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-12">
                                        <div id="secondGraph" style="width:100%;"></div>
                                    </div>
                                </div> -->

                                <<!-- div class="row">
                                    <div class="col-md-12">

                                        <div class="col-md-6">
                                            <label for="what">Value</label><br/>
                                            <input type="radio" name="what" value="1"> Value
                                            <input type="radio" name="what" value="2" checked="checked"> Volume<br>
                                        </div>

                                    </div>
                                </div> -->

                            </div>
                            
                        </div>
                    </div>


                    <!-- content on click -->

                    <!-- <hr style="border: 1px solid black; width: 100%;"/> -->

                    @include('modals.dm')
                </div>
            </section>
        </div>
    </div>
    <!-- end: page -->
</section>


@endsection

@section('scripts')
<script>

    var client = 'oxford';
    var charts = {};
    var myChart;
    var ctx_live;
    var chart;

    google.load('visualization', '1.0', {
        'packages': ['corechart']
    });

    google.setOnLoadCallback(loadChart);
    google.setOnLoadCallback(loadSecond);
    // google.setOnLoadCallback(loadSecond2);

    $(document).ready(function(){

        $('#series2').select2();

        $(document).on("change", "#series2", function(){
            var series2 = $("#series2").val();
            // var radioValue = $("input[name='what2']:checked").val();
            toChangePieMain(series2);
        });

        $('a[data-toggle="tab"]').on('show.bs.tab', function(){
            loadSecond();
            loadSecond2();
        });

    });

    function loadChart(){

        $('#header').html("Sales Per Product");
        getKPI2Axis("sales_per_product", {
            pieSliceText: 'value-and-percentage',
            chartArea: {
                height: '60%',
                bottom : 200
            },
            hAxis: {
                title: "Products",
                slantedText: true,
                slantedTextAngle: 90,
                textStyle: {
                    fontSize: 10
                }
            },
            vAxes: [{
                    title: 'Volume (Qty)',
                    titleTextStyle: {
                        color: '#0000FF',
                        fontSize: 18
                    },
                    baselineColor: '#000000ff',
                    maxValue: 0
                },
                {
                    title: 'Value (Amount)',
                    titleTextStyle: {
                        color: '#FF0000',
                        fontSize: 18
                    },
                    tickColor: '#ff0000',
                    maxValue: 0
                }
            ],
            series: [{
                    targetAxisIndex: 0
                },
                {
                    targetAxisIndex: 1
                }
            ]
        },
        "ColumnChart");

    }

    function loadSecond(){

        getKPIPivotedloadSecond("Sales_per_DistrictManager_Volume", {
            isStacked: false,
            width: "50%",
            height: 600,
            'title': "District Manager Volume",
            legend: {
                position: 'top',
                maxLines: 5
            },
            chartArea: {
                left: 250,
                top: 20,
                width: '80%',
                height: '100%'
            }
        },
        "BarChart", null, null, null, function(e){

            var sel = charts['Sales_per_DistrictManager_Volume'].chart.getSelection();
            var data = charts['Sales_per_DistrictManager_Volume'].data;
            var column = data.getValue(sel[0].row, 0);
            var volVal = sel[0].column == 1 ? "Volume" : "Value";

            document.getElementById("drillDownContent").innerHTML =
                "<center><h5 style='height:400px'>Loading..." + column + "</h5></center>";

            getKPIPivotedOnClick("Sales_per_MedRep_Volume||[Manager Name]='" + column + "'", {
                isStacked: false,
                width: "100%",
                height: 400,
                'title': column,
                legend: {
                    position: 'top',
                    maxLines: 5
                }
            },
            "Table");

            getKPI2Axis2('sales_per_Medrep', 
                {
                    pieSliceText: 'value-and-percentage', 
                    chartArea: {
                        // left: 10,
                        // top: 20,
                        // width: '75%',
                        height: '40%'
                    }
                },
                "ColumnChart",
                {
                    view : 'sales_all',
                    pivotColumn : 'Frequency',
                    pivotRow : '[Medrep Name]',
                    pivotSourceCol : volVal,
                    filter : "[Manager Name]='" + column + "'"
                }
            
            ) 

            $('#exampleModal').modal("toggle");

        });

    }

    function loadSecond2(){

        getKPIPivotedloadSecond2("Sales_per_DistrictManager_Value", {
            isStacked: false,
            width: "50%",
            height: 600,
            'title': "District Manager Value",
            legend: {
                position: 'top',
                maxLines: 5
            },
            chartArea: {
                left: 250,
                top: 20,
                width: '80%',
                height: '100%'
            }
        },
        "BarChart", null, null, null, function(e){

            var sel = charts['Sales_per_DistrictManager_Value'].chart.getSelection();
            var data = charts['Sales_per_DistrictManager_Value'].data;
            var column = data.getValue(sel[0].row, 0);
            var volVal = sel[0].column == 1 ? "Volume" : "Value";

            document.getElementById("drillDownContent").innerHTML =
                "<center><h5 style='height:400px'>Loading..." + column + "</h5></center>";

            getKPIPivotedOnClick("Sales_per_MedRep_Value||[Manager Name]='" + column + "'", {
                isStacked: false,
                width: "100%",
                height: 400,
                'title': column,
                legend: {
                    position: 'top',
                    maxLines: 5
                }
            },
            "Table");

            getKPI2Axis2('sales_per_Medrep', 
                    {
                        pieSliceText: 'value-and-percentage', 
                        chartArea: {
                            // left: 10,
                            // top: 20,
                            // width: '75%',
                            height: '40%'
                        }
                    },
                    "ColumnChart",
                    {
                        view : 'sales_all',
                        pivotColumn : 'Frequency',
                        pivotRow : '[Medrep Name]',
                        pivotSourceCol : volVal,
                        filter : "[Manager Name]='" + column + "'"
                    }
                
                ) 

            $('#exampleModal').modal("toggle");

        });

    }

    function toChangePie2(radioValue){
        if(radioValue == 1){
            getKPIPivoted2("Sales_per_DistrictManager_Value", {
                isStacked: false,
                width: "50%",
                height: 600,
                'title': "District Manager Value",
                legend: {
                    position: 'top',
                    maxLines: 5
                },
                chartArea: {
                    left: 250,
                    top: 20,
                    width: '80%',
                    height: '100%'
                }
            },
            "BarChart", null, null, null, function(e){

                var sel = charts['Sales_per_DistrictManager_Value'].chart.getSelection();
                var data = charts['Sales_per_DistrictManager_Value'].data;
                var column = data.getValue(sel[0].row, 0); 

                document.getElementById("drillDownContent").innerHTML =
                    "<center><h5 style='height:400px'>Loading..." + column + "</h5></center>";

                getKPIPivotedOnClick("Sales_per_MedRep_Value||[Manager Name]='" + column + "'", {
                    isStacked: false,
                    width: "100%",
                    height: 400,
                    'title': column,
                    legend: {
                        position: 'top',
                        maxLines: 5
                    }
                },
                "Table", null, null, null);

                getKPI2Axis2('sales_per_Medrep', 
                    {
                        pieSliceText: 'value-and-percentage', 
                        chartArea: {
                            // left: 10,
                            // top: 20,
                            // width: '75%',
                            height: '40%'
                        }
                    },
                    "ColumnChart",
                    {
                        view : 'sales_all',
                        pivotColumn : 'Frequency',
                        pivotRow : '[Medrep Name]',
                        pivotSourceCol : volVal,
                        filter : "[Manager Name]='" + column + "'"
                    }
                
                ) 

                $('#exampleModal').modal("toggle");

            });
        }else if(radioValue == 2){
            getKPIPivoted2("Sales_per_DistrictManager_Volume", {
                isStacked: false,
                width: "50%",
                height: 600,
                'title': "District Manager Volume",
                legend: {
                    position: 'top',
                    maxLines: 5
                },
                chartArea: {
                    left: 250,
                    top: 20,
                    width: '80%',
                    height: '100%'
                }
            },
            "BarChart", null, null, null, function(e){

                var sel = charts['Sales_per_DistrictManager_Volume'].chart.getSelection();
                var data = charts['Sales_per_DistrictManager_Volume'].data;
                var column = data.getValue(sel[0].row, 0);

                console.log(sel + " " + data + " " +column);

                document.getElementById("drillDownContent").innerHTML =
                    "<center><h5 style='height:400px'>Loading..." + column + "</h5></center>";

                getKPIPivotedOnClick("Sales_per_MedRep_Volume||[Manager Name]='" + column + "'", {
                    isStacked: false,
                    width: "100%",
                    height: 400,
                    'title': column,
                    legend: {
                        position: 'top',
                        maxLines: 5
                    }
                },
                "Table");

                getKPI2Axis2('sales_per_Medrep', 
                    {
                        pieSliceText: 'value-and-percentage', 
                        chartArea: {
                            // left: 10,
                            // top: 20,
                            // width: '75%',
                            height: '40%'
                        }
                    },
                    "ColumnChart",
                    {
                        view : 'sales_all',
                        pivotColumn : 'Frequency',
                        pivotRow : '[Medrep Name]',
                        pivotSourceCol : volVal,
                        filter : "[Manager Name]='" + column + "'"
                    }
                
                ) 

                $('#exampleModal').modal("toggle");

            });
        }
    }

    function toChangePieMain(series){
        
        if(series == 1){

            $('#header').html("");
            $('#header').html("Sales Per Product");

            getKPI2Axis("sales_per_product", {
                pieSliceText: 'value-and-percentage',
                chartArea: {
                    height: '60%',
                    bottom : 200
                },
                hAxis: {
                    title: "Products",
                    slantedText: true,
                    slantedTextAngle: 90,
                    textStyle: {
                        fontSize: 12
                    }
                },
                vAxes: [{
                        title: 'Volume (Qty)',
                        titleTextStyle: {
                            color: '#0000FF',
                            fontSize: 18
                        },
                        baselineColor: '#000000ff',
                        maxValue: 0
                    },
                    {
                        title: 'Value (Amount)',
                        titleTextStyle: {
                            color: '#FF0000',
                            fontSize: 18
                        },
                        tickColor: '#ff0000',
                        maxValue: 0
                    }
                ],
                series: [{
                        targetAxisIndex: 0
                    },
                    {
                        targetAxisIndex: 1
                    }
                ]
            },
            "ColumnChart");
        }else if(series == 2){

            $('#header').html("");
            $('#header').html("Therapeutic Category");

            getKPI2Axis("sales_per_TC", {
                pieSliceText: 'value-and-percentage',
                chartArea: {
                    height: '60%',
                    bottom : 200
                },
                hAxis: {
                    title: "Products",
                    slantedText: true,
                    slantedTextAngle: 90,
                    textStyle: {
                        fontSize: 12
                    }
                },
                vAxes: [{
                        title: 'Volume (Qty)',
                        titleTextStyle: {
                            color: '#0000FF',
                            fontSize: 18
                        },
                        baselineColor: '#000000ff',
                        maxValue: 0
                    },
                    {
                        title: 'Value (Amount)',
                        titleTextStyle: {
                            color: '#FF0000',
                            fontSize: 18
                        },
                        tickColor: '#ff0000',
                        maxValue: 0
                    }
                ],
                series: [{
                        targetAxisIndex: 0
                    },
                    {
                        targetAxisIndex: 1
                    }
                ]
            },
            "ColumnChart");
        }else if(series == 3){

            $('#header').html("");
            $('#header').html("Specialty Sales");

            getKPI2Axis("sales_per_specialty", {
                pieSliceText: 'value-and-percentage',
                chartArea: {
                    height: '60%',
                    bottom : 200
                },
                hAxis: {
                    title: "Products",
                    slantedText: true,
                    slantedTextAngle: 90,
                    textStyle: {
                        fontSize: 12
                    }
                },
                vAxes: [{
                        title: 'Volume (Qty)',
                        titleTextStyle: {
                            color: '#0000FF',
                            fontSize: 18
                        },
                        baselineColor: '#000000ff',
                        maxValue: 0
                    },
                    {
                        title: 'Value (Amount)',
                        titleTextStyle: {
                            color: '#FF0000',
                            fontSize: 18
                        },
                        tickColor: '#ff0000',
                        maxValue: 0
                    }
                ],
                series: [{
                        targetAxisIndex: 0
                    },
                    {
                        targetAxisIndex: 1
                    }
                ]
            },
            "ColumnChart");
        }else if(series == 4){

            $('#header').html("");
            $('#header').html("Sales Per Frequency");

            getKPI2Axis("sales_per_frequency", {
                pieSliceText: 'value-and-percentage',
                chartArea: {
                    height: '60%',
                    bottom : 200
                },
                hAxis: {
                    title: "Products",
                    slantedText: true,
                    slantedTextAngle: 90,
                    textStyle: {
                        fontSize: 12
                    }
                },
                vAxes: [{
                        title: 'Volume (Qty)',
                        titleTextStyle: {
                            color: '#0000FF',
                            fontSize: 18
                        },
                        baselineColor: '#000000ff',
                        maxValue: 0
                    },
                    {
                        title: 'Value (Amount)',
                        titleTextStyle: {
                            color: '#FF0000',
                            fontSize: 18
                        },
                        tickColor: '#ff0000',
                        maxValue: 0
                    }
                ],
                series: [{
                        targetAxisIndex: 0
                    },
                    {
                        targetAxisIndex: 1
                    }
                ]
            },
            "ColumnChart");
        }else if(series == 5){
            $('#header').html("");
            $('#header').html("Sales Per Doctor Class");

            getKPI2Axis("sales_per_DoctorClass", {
                pieSliceText: 'value-and-percentage',
                chartArea: {
                    height: '60%',
                    bottom : 200
                },
                hAxis: {
                    title: "Products",
                    slantedText: true,
                    slantedTextAngle: 90,
                    textStyle: {
                        fontSize: 12
                    }
                },
                vAxes: [{
                        title: 'Volume (Qty)',
                        titleTextStyle: {
                            color: '#0000FF',
                            fontSize: 18
                        },
                        baselineColor: '#000000ff',
                        maxValue: 0
                    },
                    {
                        title: 'Value (Amount)',
                        titleTextStyle: {
                            color: '#FF0000',
                            fontSize: 18
                        },
                        tickColor: '#ff0000',
                        maxValue: 0
                    }
                ],
                series: [{
                        targetAxisIndex: 0
                    },
                    {
                        targetAxisIndex: 1
                    }
                ]
            },
            "ColumnChart");
        }else if(series == 6){

        }
    }

    function getKPI2Axis2(kpi, options, chartType, params, listener) {

        console.log(`requesting KPIÍ getKPI2Axis2 ${kpi}`)
        var request = $.ajax({
            url: "http://oxford.doccsonline.com/DataViewer/iDoXsInsightGetJSONChartData.php",
            method: "POST",
            data: params || {
                view: kpi,
                key: "pie",
                client: client
            },
            dataType: "json",
            async: true
        });

        request.done(function (jsonData) {

            console.log(jsonData);

            // console.log(`RECEIVED KPI ${kpi}`)
            // console.dir(jsonData);

            if (chartType == 'Pie') {

                var toShowIn = document.getElementById("graph");
                var chart = new google.visualization.LineChart(toShowIn);
                var data = new google.visualization.DataTable(jsonData, 0.6);
                chart.draw(data, options);

            } else {

                var toShowIn = document.getElementById("graph");
                var data = new google.visualization.DataTable(jsonData, 0.6);
                var wrapper = new google.visualization.ChartWrapper({
                    chartType: chartType,
                    dataTable: data,
                    options: options,
                    containerId: toShowIn,

                });

                wrapper.draw();
                if (listener) {
                    google.visualization.events.addListener(wrapper.getChart(), 'select', listener);
                }


            }
            charts[kpi] = {
                    chart: wrapper.getChart(),
                    data: data
                }
            
        })

    }

    // function getKPIPivotedOnClick(kpi, options, chartType, pivotColumn, pivotRow, pivotSourceCol, listener){
    function getKPIPivotedOnClick(kpi, options, chartType, listener){
        console.log(kpi);
        var filter = "";
        if (kpi.split('||').length > 1) {
            var kp = kpi.split('||');
            filter = kp[1];
            kpi = kp[0];
        }

        // console.log(`requesting PIVOTED ${kpi}`)
        var request = $.ajax({
            url: "{{ url('api/getJsonData') }}",
            method: "GET",
            data: {
                view: kpi,
                // pivotColumn: pivotColumn,
                // pivotRow: pivotRow,
                // pivotSourceCol: pivotSourceCol,
                client: client,
                key: "pie",
                filter: filter
            },
            dataType: "json",
            async: true,

            error: function (jqXHR, textStatus, errorThrown) {
                console.dir(textStatus);
                console.dir(errorThrown);
                console.dir(jqXHR);
            },

            success: function (jsonData) {
                var data;
                // console.log(`RECEIVED PIVOTED ${kpi}`)
                // console.log(jsonData);
                data = new google.visualization.DataTable(jsonData, 0.6);
                var toShowIn = document.getElementById("drillDownContent");
                var wrapper = new google.visualization.ChartWrapper({
                    chartType: chartType,
                    dataTable: data,
                    options: options,
                    containerId: toShowIn
                })

                if (listener) {
                    if (chartType == "Table") {
                        var toShowIn = document.getElementById("drillDownContent");
                        google.visualization.events.addOneTimeListener(wrapper, 'ready',
                            function () {

                                console.log(wrapper);
                                charts[toShowIn] = {
                                    chart: wrapper,
                                    data: data
                                };
                                document.getElementById(toShowIn + "_detail").innerHTML =
                                    "<center><h5 style='height:400px'>Ready For Drilldown</h5></center>";
                                google.visualization.events.addListener(wrapper, 'select',
                                    listener);

                            });

                    } else {
                        // alert('with listner');
                        google.visualization.events.addListener(wrapper, 'select',
                            listener);
                    }
                }
                wrapper.draw();
                charts[kpi] = {
                    chart: wrapper.getChart(),
                    data: data
                }
            }
        })

    }

    function getKPIPivotedloadSecond(kpi, options, chartType, pivotColumn, pivotRow, pivotSourceCol, listener){
        var filter = "";
        if (kpi.split('||').length > 1) {
            var kp = kpi.split('||');
            filter = kp[1];
            kpi = kp[0];
        }

        // console.log(`requesting PIVOTED ${kpi}`)
        var request = $.ajax({
            url: "{{ url('api/getJsonData') }}",
            method: "GET",
            data: {
                view: kpi,
                pivotColumn: pivotColumn,
                pivotRow: pivotRow,
                pivotSourceCol: pivotSourceCol,
                client: client,
                key: "pie",
                filter: filter
            },
            dataType: "json",
            async: true,

            error: function (jqXHR, textStatus, errorThrown) {
                console.dir(textStatus);
                console.dir(errorThrown);
                console.dir(jqXHR);
            },

            success: function (jsonData) {
                console.log(jsonData);
                var data;
                // console.log(`RECEIVED PIVOTED ${kpi}`)
                // console.log(jsonData);
                data = new google.visualization.DataTable(jsonData, 0.6);
                var toShowIn = document.getElementById("secondGraph");
                var wrapper = new google.visualization.ChartWrapper({
                    chartType: chartType,
                    dataTable: data,
                    options: options,
                    containerId: toShowIn
                })

                if (listener) {
                    if (chartType == "Table") {
                        var toShowIn = document.getElementById("secondGraph");
                        google.visualization.events.addOneTimeListener(wrapper, 'ready',
                            function () {

                                console.log(wrapper);
                                charts[toShowIn] = {
                                    chart: wrapper,
                                    data: data
                                };
                                document.getElementById(toShowIn + "_detail").innerHTML =
                                    "<center><h5 style='height:400px'>Ready For Drilldown</h5></center>";
                                google.visualization.events.addListener(wrapper, 'select',
                                    listener);

                            });

                    } else {
                        // alert('with listner');
                        google.visualization.events.addListener(wrapper, 'select',
                            listener);
                    }
                }
                wrapper.draw();
                charts[kpi] = {
                    chart: wrapper.getChart(),
                    data: data
                }
            }

        })
    }

    function getKPIPivotedloadSecond2(kpi, options, chartType, pivotColumn, pivotRow, pivotSourceCol, listener){
        var filter = "";
        if (kpi.split('||').length > 1) {
            var kp = kpi.split('||');
            filter = kp[1];
            kpi = kp[0];
        }

        console.log(`requesting PIVOTED ${kpi}`)
        var request = $.ajax({
            url: "{{ url('api/getJsonData') }}",
            method: "GET",
            data: {
                view: kpi,
                pivotColumn: pivotColumn,
                pivotRow: pivotRow,
                pivotSourceCol: pivotSourceCol,
                client: client,
                key: "pie",
                filter: filter
            },
            dataType: "json",
            async: true,

            error: function (jqXHR, textStatus, errorThrown) {
                console.dir(textStatus);
                console.dir(errorThrown);
                console.dir(jqXHR);
            },

            success: function (jsonData) {
                var data;
                // console.log("value");
                console.log(`RECEIVED PIVOTED product value ${kpi}`);
                // console.log(jsonData);
                data = new google.visualization.DataTable(jsonData, 0.6);
                var toShowIn = document.getElementById("value");
                var wrapper = new google.visualization.ChartWrapper({
                    chartType: chartType,
                    dataTable: data,
                    options: options,
                    containerId: toShowIn
                })

                if (listener) {
                    if (chartType == "Table") {
                        var toShowIn = document.getElementById("value");
                        google.visualization.events.addOneTimeListener(wrapper, 'ready',
                            function () {

                                console.log(wrapper);
                                charts[toShowIn] = {
                                    chart: wrapper,
                                    data: data
                                };
                                document.getElementById(toShowIn + "_detail").innerHTML =
                                    "<center><h5 style='height:400px'>Ready For Drilldown</h5></center>";
                                google.visualization.events.addListener(wrapper, 'select',
                                    listener);

                            });

                    } else {
                        // alert('with listner');
                        google.visualization.events.addListener(wrapper, 'select',
                            listener);
                    }
                }
                wrapper.draw();
                charts[kpi] = {
                    chart: wrapper.getChart(),
                    data: data
                }
            }

        })
    }

    function getKPIPivoted2(kpi, options, chartType, pivotColumn, pivotRow, pivotSourceCol, listener) {
        // console.log(listener);
        var filter = "";
        if (kpi.split('||').length > 1) {
            var kp = kpi.split('||');
            filter = kp[1];
            kpi = kp[0];
        }

        // console.log(`requesting PIVOTED ${kpi}`)
        var request = $.ajax({
            // url: "http://oxford.doccsonline.com/DataViewer/iDoXsInsightGetJSONChartData.php",
            url: "{{ url('api/getJsonData') }}",
            method: "GET",
            data: {
                view: kpi,
                pivotColumn: pivotColumn,
                pivotRow: pivotRow,
                pivotSourceCol: pivotSourceCol,
                client: client,
                key: "pie",
                filter: filter
            },
            dataType: "json",
            async: true,

            error: function (jqXHR, textStatus, errorThrown) {
                console.dir(textStatus);
                console.dir(errorThrown);
                console.dir(jqXHR);
            },

            success: function (jsonData) {
                var data;
                // console.log(`RECEIVED PIVOTED ${kpi}`)
                // console.log(jsonData);
                data = new google.visualization.DataTable(jsonData, 0.6);
                var toShowIn = document.getElementById("secondGraph");
                var wrapper = new google.visualization.ChartWrapper({
                    chartType: chartType,
                    dataTable: data,
                    options: options,
                    containerId: toShowIn
                })

                if (listener) {
                    if (chartType == "Table") {
                        var toShowIn = document.getElementById("secondGraph");
                        google.visualization.events.addOneTimeListener(wrapper, 'ready',
                            function () {

                                console.log(wrapper);
                                charts[toShowIn] = {
                                    chart: wrapper,
                                    data: data
                                };
                                document.getElementById(toShowIn + "_detail").innerHTML =
                                    "<center><h5 style='height:400px'>Ready For Drilldown</h5></center>";
                                google.visualization.events.addListener(wrapper, 'select',
                                    listener);

                            });

                    } else {
                        // alert('with listner');
                        google.visualization.events.addListener(wrapper, 'select',
                            listener);
                    }
                }
                wrapper.draw();
                charts[kpi] = {
                    chart: wrapper.getChart(),
                    data: data
                }
            }

        })

    }

    function getKPI2Axis(kpi, options, chartType, beforeDraw, listener) {

        console.log(`requesting KPIÍ ${kpi}`)
        var request = $.ajax({
            url: "http://oxford.doccsonline.com/DataViewer/iDoXsInsightGetJSONChartData.php",
            method: "POST",
            data: {
                view: kpi,
                key: "pie",
                client: client
            },
            dataType: "json",
            async: true
        });

        request.done(function (jsonData) {

            console.log(`RECEIVED KPI ${kpi}`)
            console.dir(jsonData);


            if (chartType == 'Pie') {

                // debugger

                var chart = new google.visualization.LineChart(document.getElementById("graphMain"));
                var data = new google.visualization.DataTable(jsonData, 0.6);
                chart.draw(data, options);


            } else {

                // if (options.vAxes) {
                //     var maxVal = 0;
                //     var maxVol = 0;

                //     jsonData.rows.forEach(row => {
                //         maxVol = row[1] > maxVol ? row[1] : maxVol;
                //         maxVal = row[2] > maxVal ? row[2] : maxVal;
                //     })

                //     options.vAxes[0].maxValue = maxVol
                //     options.vAxes[1].maxValue = maxVal

                // }

                var container = document.getElementById("graphMain");
                var wrapper = new google.visualization.ChartWrapper({
                    chartType: chartType,
                    dataTable: jsonData,
                    options: options,
                    containerId: container,

                });

                if (listener) {
                    google.visualization.events.addListener(wrapper.getChart(), 'select', listener);
                }

                if (beforeDraw != null) {
                    var r = beforeDraw(wrapper.getDataTable());

                    //wrapper.setView(r);
                } else {

                    wrapper.draw();
                }

            }
        })

    }

    // function getKPIPivoted(kpi, options, chartType, pivotColumn, pivotRow, pivotSourceCol, listener) {
    //     // console.log(kpi + " " + options + " " + chartType + " " + pivotColumn + " " + pivotRow + " " + pivotSourceCol + " " + listener);
    //     var filter = "";
    //     if (kpi.split('||').length > 1) {
    //         var kp = kpi.split('||');
    //         filter = kp[1];
    //         kpi = kp[0];
    //     }

    //     // console.log(`requesting PIVOTED ${kpi}`)
    //     var request = $.ajax({
    //         url: "http://oxford.doccsonline.com/DataViewer/iDoXsInsightGetJSONChartData.php",
    //         method: "GET",
    //         data: {
    //             view: kpi,
    //             pivotColumn: pivotColumn,
    //             pivotRow: pivotRow,
    //             pivotSourceCol: pivotSourceCol,
    //             client: client,
    //             key: "pie",
    //             filter: filter
    //         },
    //         dataType: "json",
    //         async: true,

    //         error: function (jqXHR, textStatus, errorThrown) {
    //             console.dir(textStatus);
    //             console.dir(errorThrown);
    //             console.dir(jqXHR);
    //         },

    //         success: function (jsonData) {
    //             var data;
    //             console.log(`RECEIVED PIVOTED ${kpi}`)
    //             // console.log(jsonData);
    //             data = new google.visualization.DataTable(jsonData, 0.6);
    //             var toShowIn = document.getElementById("graphMain");
    //             var wrapper = new google.visualization.ChartWrapper({
    //                 chartType: chartType,
    //                 dataTable: data,
    //                 options: options,
    //                 containerId: toShowIn
    //             })

    //             if (listener) {
    //                 if (chartType == "Table") {
    //                     var toShowIn = document.getElementById("graphMain");
    //                     google.visualization.events.addOneTimeListener(wrapper, 'ready',
    //                         function () {

    //                             console.log(wrapper);
    //                             charts[toShowIn] = {
    //                                 chart: wrapper,
    //                                 data: data
    //                             };
    //                             document.getElementById(toShowIn + "_detail").innerHTML =
    //                                 "<center><h5 style='height:400px'>Ready For Drilldown</h5></center>";
    //                             google.visualization.events.addListener(wrapper, 'select',
    //                                 listener);

    //                         });

    //                 } else {
    //                     //alert('with listner')
    //                     google.visualization.events.addListener(wrapper, 'select',
    //                         listener);
    //                 }
    //             }

    //             wrapper.draw();
    //             charts[kpi] = {
    //                 chart: wrapper.getChart(),
    //                 data: data
    //             }
    //         }

    //     })

    // }

    
    
</script>
@endsection