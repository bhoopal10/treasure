<!DOCTYPE html>
<html>
	<head>
	    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	    <meta charset="utf-8" />
	    <title>Treasure</title>
	    <style>
			.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td
			{
				border-top: 1px dotted #DDD !important;
			}
		</style>
	    <meta name="description" content="overview &amp; stats" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	    {{HTML::style('public/css/bootstrap.min.css')}}
	    {{HTML::style('public/css/font-awesome.min.css')}}
	    {{HTML::style('public/css/ace.min.css')}}

	    @yield('css')
	</head>
	<body>
		@include('college/layout.navbar')
		<div class="main-container" id="main-container">
			
				@yield('content')
			
		</div>
    @include('college/layout.footer')
	</body>
	<!--[if !IE]> -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<!-- <![endif]-->
<!--[if IE]>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<![endif]-->
<!--[if !IE]> -->
<script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo URL::to('/'); ?>/public/js/jquery.min.js'>"+"<"+"/script>");
</script>
<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo URL::to('/'); ?>/public/js/jquery1x.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
<script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo URL::to('/'); ?>/public/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
{{HTML::script('public/js/bootstrap.min.js')}}
@yield('script')
<style>

    .menu-min .nav-list > li >form{
        visibility: hidden;
    }
    .menu-min .nav-list > li >input{
        visibility: hidden;
    }

</style>
<script type="text/javascript">
    $(function() {
         $("#usr-det-link").click(function()
       {
          $(".udrop").slideToggle();
          $("#udet-down").toggle();
          $("#udet-up").toggle();
       });
          
            $("#fromdate").datepicker({
                changeMonth: true,
                changeYear: true,

                dateFormat:'dd/mm/yy',
                 onClose: function( selectedDate ) {
            $( "#todate" ).datepicker( "option", "minDate", selectedDate );
        }
        });
              $("#todate").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:'dd/mm/yy',
                 onClose: function( selectedDate ) {
            $( "#fromdate" ).datepicker( "option", "maxDate", selectedDate );
        }
        });


    });
   
</script>
</html>