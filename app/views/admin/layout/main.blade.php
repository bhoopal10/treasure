<!DOCTYPE html>
<html>
	<head>
	    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	    <meta charset="utf-8" />
	    <title></title>
	    <meta name="description" content="overview &amp; stats" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	    {{HTML::style('public/css/bootstrap.min.css')}}
	    {{HTML::style('public/css/font-awesome.min.css')}}
	</head>
	<body>
		@yield('content')
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
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(600, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 5000);
</script>
</html>