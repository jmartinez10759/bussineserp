@extends('layouts.template.app')
@section('content')
@push('styles')
<!-- Ionicons -->
<!-- <link rel="stylesheet" href="{{ asset('admintle/bower_components/Ionicons/css/ionicons.min.css')}}"> -->
<!-- jvectormap -->
<!-- <link rel="stylesheet" href="{{ asset('admintle/bower_components/jvectormap/jquery-jvectormap.css')}}"> -->
<!-- AdminLTE Skins. Choose a skin from the css/skins
		 folder instead of downloading all of them to reduce the load. -->
<!-- <link rel="stylesheet" href="{{ asset('admintle/dist/css/skins/_all-skins.min.css') }}"> -->
@endpush

<div id="page-wrapper col-sm-12" class="vue-dashboard">
	<!-- page content -->
	<!-- <img src="{{asset('img/dashboard.jpg')}}" width="100%" height="100%"> -->
	<!-- Main content -->
	<section class="content">
		<!-- Info boxes -->
		<div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">CPU Traffic</span>
						<span class="info-box-number">90<small>%</small></span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Likes</span>
						<span class="info-box-number">41,410</span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->

			<!-- fix for small devices only -->
			<div class="clearfix visible-sm-block"></div>

			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Sales</span>
						<span class="info-box-number">760</span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">New Members</span>
						<span class="info-box-number">2,000</span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->

		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Monthly Recap Report</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
							<div class="btn-group">
								<button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-wrench"></i></button>
								<ul class="dropdown-menu" role="menu">
									<li><a href="#">Action</a></li>
									<li><a href="#">Another action</a></li>
									<li><a href="#">Something else here</a></li>
									<li class="divider"></li>
									<li><a href="#">Separated link</a></li>
								</ul>
							</div>
							<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
						</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<!--Div that will hold the pie chart-->
							<div id="chart_div"></div>
							<div id="colums_div"></div>

						</div>
						<!-- /.row -->
					</div>
					<!-- ./box-body -->
					<div class="box-footer">
						<div class="row">

						</div>
						<!-- /.row -->
					</div>
					<!-- /.box-footer -->
				</div>
				<!-- /.box -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->

	</section>
	<!-- /.content -->







	<!-- /page content -->
</div>
 <!-- /. PAGE WRAPPER  -->

@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administrador/build_dashboard.js')}}" ></script>
<!--Load the AJAX API-->
  <script type="text/javascript" src="https://www.google.com/jsapi"><
</script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});
      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);
      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {
				 var datos = [['Lunes',2000],['Martes',1500],['Miercoles',1800],['Jueves',900],['Viernes', 2500],['Sabado', 3000],['Domingo', 900]];
				// Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Dias de la semana');
        data.addColumn('number', 'Ingresos');
				data.addRows(datos);
        // data.addRows([
        //   ['Lunes', 2000],
        //   ['Martes', 1500],
        //   ['Miercoles', 1800],
        //   ['Jueves', 900],
        //   ['Viernes', 2500],
        //   ['Sabado', 3000],
        //   ['Domingo', 900],
        // ]);
        // Set chart options
        var options = {'title':'Titulo de la Grafica',
											 'is3D':true,
                       'width':900,
                       'height':500
										 };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        var grafica = new google.visualization.ColumnChart(document.getElementById('colums_div'));
        chart.draw(data, options);
        grafica.draw(data, options);
      }
    </script>



@endpush
