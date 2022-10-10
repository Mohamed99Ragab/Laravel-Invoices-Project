@extends('layouts.master')
@section('title')
    لوحة التحكم
@endsection
@section('css')



    <!--  Owl-carousel css-->
    <link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">اهلا, مرحبا بعودتك!</h2>
            </div>
        </div>

    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">اجمالي الفواتير</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                    {{number_format(\App\Models\Invoice::sum('total'),2)}}
                                </h4>
                                <p class="mb-0 tx-12 text-white op-7">عدد الفواتير:  {{\App\Models\Invoice::count()}}</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-up text-white"></i>
											<span class="text-white op-7"> 100%</span>
										</span>
                        </div>
                    </div>
                </div>
                <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">الفواتير الغير مدفوعة</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                    {{number_format(\App\Models\Invoice::where('value_status',2)->sum('total'),2)}}
                                </h4>
                                <p class="mb-0 tx-12 text-white op-7">عدد الفواتير: {{\App\Models\Invoice::where('value_status',2)->count()}}</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-down text-white"></i>
											<span class="text-white op-7">
                                                 @php
                                                     $count_all= \App\Models\Invoice::count();
                                                     $count_invoices2 = \App\Models\Invoice::where('value_status', 2)->count();
                                                     if($count_invoices2 == 0){
                                                        echo $count_invoices2 = 0;
                                                     }
                                                     else{
                                                         $count_invoices2 = ($count_invoices2 / $count_all) *100 ;
                                                         echo round($count_invoices2)."%";
                                                     }
                                                 @endphp
                                            </span>
										</span>
                        </div>
                    </div>
                </div>
                <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white"> {{number_format(\App\Models\Invoice::where('value_status',1)->sum('total'),2)}} </h4>
                                <p class="mb-0 tx-12 text-white op-7">عد الفواتير: {{\App\Models\Invoice::where('value_status',1)->count()}} </p>
                            </div>
                            <span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-up text-white"></i>
											<span class="text-white op-7">
                                                   @php
                                                       $count_all= \App\Models\Invoice::count();
                                                       $count_invoices1 = \App\Models\Invoice::where('value_status', 1)->count();
                                                       if($count_invoices1 == 0){
                                                          echo $count_invoices1 = 0;
                                                       }
                                                       else{
                                                           $count_invoices1 = ($count_invoices1 / $count_all) *100 ;
                                                           echo round($count_invoices1)."%";
                                                       }
                                                   @endphp

                                            </span>
										</span>
                        </div>
                    </div>
                </div>
                <span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة جزئيا</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white"> {{number_format(\App\Models\Invoice::where('value_status',3)->sum('total'),2)}}  </h4>
                                <p class="mb-0 tx-12 text-white op-7">عدد الفواتير: {{\App\Models\Invoice::where('value_status',3)->count()}}</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-down text-white"></i>
											<span class="text-white op-7">
                                             @php
                                                 $count_all= \App\Models\Invoice::count();
                                                 $count_invoices3 = \App\Models\Invoice::where('value_status', 3)->count();
                                                 if($count_invoices3 == 0){
                                                    echo $count_invoices3 = 0;
                                                 }
                                                 else{
                                                     $count_invoices3 = ($count_invoices3 / $count_all) *100 ;
                                                     echo round($count_invoices3)."%";
                                                 }
                                             @endphp

                                            </span>
										</span>
                        </div>
                    </div>
                </div>
                <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
    </div>
    <!-- row closed -->

    <!-- row opened -->

    <div class="justify-content-center">
        <div class="card">
            <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mb-0">احصائيات عن حالات الفواتير</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
            </div>
            <div class="card-body">
{{--                <div id="donutchart" style="width: 500px; height: 300px;"></div>--}}
                <div class="row">
                    <div class="col">
                        <div id="piechart_div" style="border: 1px solid #ccc"></div>
                    </div>
                    <div class="col">
                        <div id="barchart_div" style="border: 1px solid #ccc"></div>
                    </div>
                </div>


            </div>
        </div>
    </div>





    </div>
    </div>
    <!-- Container closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->


    <script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
    <!-- Moment js -->
    <script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
    <!--Internal  Flot js-->
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js')}}"></script>
    <script src="{{URL::asset('assets/js/dashboard.sampledata.js')}}"></script>
    <script src="{{URL::asset('assets/js/chart.flot.sampledata.js')}}"></script>
    <!--Internal Apexchart js-->
    <script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
    <!-- Internal Map -->
    <script src="{{URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
    <script src="{{URL::asset('assets/js/modal-popup.js')}}"></script>
    <!--Internal  index js -->
    <script src="{{URL::asset('assets/js/index.js')}}"></script>
    <script src="{{URL::asset('assets/js/jquery.vmap.sampledata.js')}}"></script>



{{--    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>--}}
{{--    <script type="text/javascript">--}}
{{--        google.charts.load("current", {packages:["corechart"]});--}}
{{--        google.charts.setOnLoadCallback(drawChart);--}}
{{--        function drawChart() {--}}
{{--            var data = google.visualization.arrayToDataTable([--}}
{{--                ['Task', 'Hours per Day'],--}}
{{--                ['الفواتير الغير مدفوعة',  {{$count_invoices2}}],--}}
{{--                ['الفواتير المدفوعة جزئيا', {{$count_invoices3}}],--}}
{{--                ['الفواتير المدفوعة',    {{$count_invoices1}}]--}}
{{--            ]);--}}

{{--            var options = {--}}
{{--                title: 'نسبة الفواتير',--}}
{{--                pieHole: 0.4,--}}
{{--                colors:['#E74C3C','#F39C12','#229954']--}}
{{--            };--}}

{{--            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));--}}
{{--            chart.draw(data, options);--}}
{{--        }--}}
{{--    </script>--}}





        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            // Load Charts and the corechart and barchart packages.
            google.charts.load('current', {'packages':['corechart']});

            // Draw the pie chart and bar chart when Charts is loaded.
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Topping');
                data.addColumn('number', 'Slices');
                data.addRows([
                    ['الفواتير الغير مدفوعة', {{$count_invoices2}}],
                    ['الفواتير المدفوعة جزئيا', {{$count_invoices3}}],
                    ['الفواتير المدفوعة', {{$count_invoices1}}],

                ]);

                var piechart_options = {title:'نسبة الفواتير',
                    width:400,
                    height:300,
                    colors:['#E74C3C','#F39C12','#229954']
                };
                var piechart = new google.visualization.PieChart(document.getElementById('piechart_div'));
                piechart.draw(data, piechart_options);

                var barchart_options = {title:'نسبة الفواتير',
                    width:400,
                    height:300,
                    legend: 'none',
                    colors:['#3c7ee7']

                };
                var barchart = new google.visualization.BarChart(document.getElementById('barchart_div'));
                barchart.draw(data, barchart_options);
            }
        </script>

@endsection

