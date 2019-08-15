	<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
		<!-- jQuery -->
	 <script src="{{ $base_url }}templates/vendors/jquery/dist/jquery.min.js"></script>
	 <!-- Bootstrap -->
	 <script src="{{ $base_url }}templates/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	 <!-- FastClick -->
	 <script src="{{ $base_url }}templates/vendors/fastclick/lib/fastclick.js"></script>
	 <!-- NProgress -->
	 <script src="{{ $base_url }}templates/vendors/nprogress/nprogress.js"></script>
	 <!-- Chart.js -->
	 <script src="{{ $base_url }}templates/vendors/Chart.js/dist/Chart.min.js"></script>
	 <!-- gauge.js -->
	 <script src="{{ $base_url }}templates/vendors/gauge.js/dist/gauge.min.js"></script>
	 <!-- bootstrap-progressbar -->
	 <script src="{{ $base_url }}templates/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
	 <!-- iCheck -->
	 <script src="{{ $base_url }}templates/vendors/iCheck/icheck.min.js"></script>
	 <!-- Datatables -->
	 <script src="{{ $base_url }}templates/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
	 <script src="{{ $base_url }}templates/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	 <script src="{{ $base_url }}templates/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	 <script src="{{ $base_url }}templates/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
	 <script src="{{ $base_url }}templates/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
	 <script src="{{ $base_url }}templates/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
	 <script src="{{ $base_url }}templates/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
	 <script src="{{ $base_url }}templates/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
	 <script src="{{ $base_url }}templates/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
	 <script src="{{ $base_url }}templates/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	 <script src="{{ $base_url }}templates/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
	 <script src="{{ $base_url }}templates/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
	 <script src="{{ $base_url }}templates/vendors/jszip/dist/jszip.min.js"></script>
	 <script src="{{ $base_url }}templates/vendors/pdfmake/build/pdfmake.min.js"></script>
	 <script src="{{ $base_url }}templates/vendors/pdfmake/build/vfs_fonts.js"></script>
	 <!-- Skycons -->
	 <script src="{{ $base_url }}templates/vendors/skycons/skycons.js"></script>
	 <!-- Flot -->
	 <script src="{{ $base_url }}templates/vendors/Flot/jquery.flot.js"></script>
	 <script src="{{ $base_url }}templates/vendors/Flot/jquery.flot.pie.js"></script>
	 <script src="{{ $base_url }}templates/vendors/Flot/jquery.flot.time.js"></script>
	 <script src="{{ $base_url }}templates/vendors/Flot/jquery.flot.stack.js"></script>
	 <script src="{{ $base_url }}templates/vendors/Flot/jquery.flot.resize.js"></script>
	 <!-- Flot plugins -->
	 <script src="{{ $base_url }}templates/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
	 <script src="{{ $base_url }}templates/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
	 <script src="{{ $base_url }}templates/vendors/flot.curvedlines/curvedLines.js"></script>
	 <!-- DateJS -->
	 <script src="{{ $base_url }}templates/vendors/DateJS/build/date.js"></script>
	 <!-- JQVMap -->
	 <script src="{{ $base_url }}templates/vendors/jqvmap/dist/jquery.vmap.js"></script>
	 <script src="{{ $base_url }}templates/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
	 <script src="{{ $base_url }}templates/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
	 <!-- bootstrap-daterangepicker -->
	 <script src="{{ $base_url }}templates/vendors/moment/min/moment.min.js"></script>
	 <script src="{{ $base_url }}templates/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
	 <!-- Custom Theme Scripts -->
	 <script src="{{ $base_url }}templates/build/js/custom.min.js"></script>
	 <!-- se carga angular -->
	 <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.7/angular.min.js"></script>
	 <script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.3/angular-route.js"></script> -->
	 <!-- Add fancyBox -->
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.5/jquery.fancybox.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
	 <script type="text/javascript">
			 JQuery(".fancybox").fancybox({
					 maxWidth    : 800,
					 maxHeight   : 600,
					 fitToView   : false,
					 width       : '70%',
					 height      : '70%',
					 autoSize    : false,
					 closeClick  : false,
					 openEffect  : 'none',
					 closeEffect : 'none'
			 });

			 jQuery('.selectpicker').selectpicker({
				  style: 'btn-info',
				  size: 4
				});


	</script>

	<script type="text/javascript" src="{{asset('js/axios.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/toastr.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/vue.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/sweetalert.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/global.system.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/tools-manager.js')}}"></script>
	<!-- script master vue -->
  <script type="text/javascript" src="{{asset('js/TitleSystem.js')}}"></script>
  <!-- script desarrollador -->
  @stack('scripts')
