@extends('admin.dash')

@section('content')

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="fa fa-bars fa-5x"></i></a>
        <div class="container-fluid" id="Admin_Dashboard_Container">
            <div class="row" id="Admin_Dashboard_Row">

                <div class="col-lg-12" id="Admin_Dashboard-col-md-12">
                    <h4 id="Admin-Heading">Admin Dashboard</h4><br>

                    <div class="col-sm-12 col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading info-color-dark white-text"><i class="fa fa-shopping-cart" aria-hidden="true"></i> &nbsp;Orders</div>
                            <div class="panel-body">
                                <div style="overflow: auto; height: 275px;">
                                @include('admin.pages.partials.orders')
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading default-color white-text"><i class="fa fa-users" aria-hidden="true"></i> &nbsp;Users</div>
                                <div class="panel-body">
                                    <div style="overflow: auto; height: 275px;">
                                        @include('admin.pages.partials.users')
                                    </div>
                                </div>

                        </div>
                    </div>

                </div>  <!-- close col-lg-12 -->

                <div class="col-lg-12" id="Admin_Dashboard-col-md-12">

                    <div class="col-sm-12 col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading primary-color white-text"><i class="fa fa-google-plus" aria-hidden="true"></i> &nbsp;Visitors</div>
                        <div class="panel-body">
                            <div style="overflow: auto; height: 275px;">
                                <div id="embed-api-auth-container"></div>
                                <div id="chart-container"></div>
                                <div id="view-selector-container"></div>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading success-color-dark white-text"><i class="fa fa-bar-chart" aria-hidden="true"></i> &nbsp;Gross Totals</div>
                            <div class="panel-body">
                                <div style="overflow: auto; height: 275px;">
                                    <div class="col-xs-6 col-md-6 text-center" id="Admin_Dashboard_Total-Content-R">
                                        <p><b> Total Revenue<br> ${{ $count_total }}</b></p>
                                    </div>
                                    <div class="col-xs-6 col-md-6 text-center" id="Admin_Dashboard_Total-Content-O">
                                        <p><b>  Total Orders<br>  {{ $orders->count() }}</b></p>
                                    </div>
                                    <div class="col-xs-6 col-md-6 text-center" id="Admin_Dashboard_Total-Content-U">
                                        <p><b>  Total Users<br>  {{ $users->count() }}</b></p>
                                    </div>
                                    <div class="col-xs-6 col-md-6 text-center" id="Admin_Dashboard_Total-Content-P">
                                        <p><b>  Total Products<br>  {{ $products->count() }}</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- close col-lg-12 -->


                <div class="col-lg-12" id="Admin_Dashboard-col-md-12">

                    <div class="col-sm-12 col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading warning-color white-text"><i class="fa fa-cart-plus" aria-hidden="true"></i> &nbsp;Cart Sessions</div>
                            <div class="panel-body">
                                <div style="overflow: auto; height: 275px;">
                                    @include('admin.pages.partials.count_carts')
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading danger-color-dark white-text"><i class="fa fa-archive" aria-hidden="true"></i> &nbsp;Product Stock Alerts</div>
                            <div class="panel-body">
                                <div style="overflow: auto; height: 275px;">
                                    @include('admin.pages.partials.product_quantity_alert')
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- close col-lg-12 -->

                <div class="col-sm-12 col-md-12">

                        <div class="panel panel-default">
                            <div class="panel-heading primary-color-dark white-text"><i class="fa fa-money" aria-hidden="true"></i> &nbsp;Orders & Totals</div>
                                <div class="panel-body">
                                    <canvas id="myChart" style="padding-right: 20px;"></canvas>
                                </div>
                        </div>
                        
                </div>



            </div>  <!-- close row -->
        </div>  <!-- close container-fluid -->
    </div>  <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<script>
    var barChartData = {
        labels : [
            @foreach($orders as $order)
                    "#{{ $order->id }}",
            @endforeach
        ],
        datasets : [
            {
                fillColor : "rgba(220,220,220,0.5)",
                strokeColor : "rgba(220,220,220,0.8)",
                highlightFill: "#33b5e5",
                highlightStroke: "rgba(220,220,220,1)",
                data : [
                    @foreach($orders as $order)
                    {{ $order->total }},
                    @endforeach
                ]
            }
        ]
    };

    window.onload = function(){
        var ctx = document.getElementById("myChart").getContext("2d");
        window.myBar = new Chart(ctx).Bar(barChartData, {
            responsive: true,
            maintainAspectRatio: true,
            scaleOverride: true,
            scaleSteps: 10,
            scaleStepWidth: 500,
            scaleStartValue: 0,
            animationSteps: 60,
            animationEasing: "easeOutBounce",
            barValueSpacing : 0,
        });
    };
</script>


@endsection
