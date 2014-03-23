<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>df_lms_new/ico/favicon.png">
	
	<title>Donut Fortress League Management System</title>
	
	<script src="<?php echo base_url(); ?>jquery-ui-1.10.4.custom/js/jquery-1.10.2.js"></script>
	
	<!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>df_lms_new/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>df_lms_new/css/main.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>df_lms_new/css/font-awesome.min.css">
	

<!--	<script src="<?php echo base_url(); ?>df_lms_new/js/jquery-1.9.1.js"></script>-->

	<script src="<?php echo base_url(); ?>df_lms_new/js/Chart.js"></script>
	<!--<script src="<?php echo base_url(); ?>df_lms_new/js/modernizr.custom.js"></script>-->
	

	
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo base_url(); ?>df_lms_new/js/html5shiv.js"></script>
      <script src="<?php echo base_url(); ?>df_lms_new/js/respond.min.js"></script>
    <![endif]-->
	
	<!-- Datepicker and other jQuery stuff -->
	
<!--	<script src="<?php echo base_url(); ?>jquery-ui-1.10.3/ui/jquery-ui.js"></script> -->
	<script src="<?php echo base_url(); ?>jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.js"></script>
	<link href="<?php echo base_url(); ?>jquery-ui-1.10.4.custom/css/australian-colours/jquery-ui-1.10.4.custom.css" rel="stylesheet">
	
	<script>
		$(function() 
		{
			$( "#datepicker" ).datepicker({dateFormat: "yy-mm-dd"});
			// DO NOT CHANGE THIS: in HTML/jQuery ids should be unique.
			$( "#datepicker2" ).datepicker({dateFormat: "yy-mm-dd"});
		});
	</script>

</head>
<body data-spy="scroll" data-offset="0" data-target="#theMenu">
<nav class="menu" id="theMenu">
	<div class="menu-wrap">
		<div id="primarynav">
			<h1 class="logo"><a id="homepage" href="#">Donut Fortress LMS</a></h1>
			<i class="icon-remove menu-close"></i>
			<a id="sport-module" href="#">Sports</a>
			<a title="Not yet revised" href="#">Leagues</a>
			<div id="checklogin">
				<a id="login-admin" href="#">Login</a>
			</div>
		</div>
		<br />
		<!--<p>Secondary navigation here</p>-->
		<div id="sidebar"></div>
		</div>
		
		<!-- Menu button -->
		<div id="menuToggle"><i class="icon-reorder"></i></div>
	</nav>
	
	<!-- ========== HEADER SECTION ========== -->
	<!-- <section id="home" name="home"></section> -->
	<!--<p>Masthead image here.</p>-->
	<?php
	/* DO NOT REMOVE YET: Use the sessions later
	$notification=$this->session->userdata('notification');
	if ($notification)
	{
	echo '<div class="panel panel-default"><div class="panel-body">';
	echo '<div class="alert alert-success"><h3>'.$notification.'</h3></div>';
	echo '</div></div>';
	}
	$this->session->unset_userdata('notification');
*/	?>
	<div id="masthead">
	<div id="homewrap"><div class="container"><br /><h1>League Management System</h1><h2></h2><div class="row"><br><br><br><div class="col-lg-6 col-lg-offset-3"></div></div></div><!-- /container --></div><!-- /headerwrap -->
	</div>
	<br/><br/>
	<div class="container">
		<h1 id="pagetitle">Welcome.</h1>
		<div id="pagecontent">
		</div>
		<div id="tableshere">
			<table id="table" class="table table-hover">
			</table>
		</div>
		<!-- Load necessary buttons here, e.g. Add Sport, Edit League, Deactivate League... -->
		<div id="tableoneoptions"></div>
	</div>
	<br/><br/><br/><br/><br/><br/><br/><br/>
	<!-- ========== FOOTER SECTION ========== -->
	<section id="contact" name="contact"></section>
	<div id="f">
		<div class="container">
			<div class="row">
					<h3><b>CONTACT THE DEVELOPERS</b></h3>
					<br>
					<div class="col-lg-4">
						<h3><b>Send the Developers A Message:</b></h3>
						<h3>donutfortress@gmail.com</h3>
						<br>
					</div>
					
					<div class="col-lg-4">	
						<h3><b>Call Us:</b></h3>
						<h3>+639234281246</h3>
						<br>
					</div>
					
					<div class="col-lg-4">
						<h3><b>We Are Social</b></h3>
						<p>
							<a href="index.html#"><i class="icon-facebook"></i></a>
							<a href="index.html#"><i class="icon-twitter"></i></a>
							<a href="index.html#"><i class="icon-envelope"></i></a>
						</p>
						<br>
					</div>
				</div>
			</div>
		</div><!-- /container -->
	</div><!-- /f -->
	
	<div id="c">
		<div class="container">
			<p>Original theme (Onassis) by <a href="http://www.blacktie.co">BLACKTIE.CO</a></p>
		</div>
	</div>
	
<!-- Start of modals used by all features -->
<div id="loading-box" title="Please wait, mate.">
	<img src="<?php echo base_url(); ?>df_lms_new/img/windows8-loading.gif" alt="Loading..." />
</div>
<!-- Login -->
<div id="login-dialog">
	<p class="notiferror">Invalid username or password.</p>
	<img alt="Donut Fortress LMS logo" src="<?php echo base_url(); ?>df_lms/images/df_lms_backdrop.png" /><br />
	<label for="username">Username</label>
	<input class="form-control" id="username" autocomplete="off" type="text" name="username" />
	<label for="password">Password</label>
	<input class="form-control" id="password" type="password" name="password" />
	<button type="submit" id="submitLogin" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-hover" role="button"><span class="ui-button-text">Login </span></button>
</div>
<!-- Edit Sport -->
<div id="editsport-dialog" title="Edit Sport">
	<input type="hidden" id="sportid" name="sportid" value="" />
	<label for="editsportname">Sport Name</label>
	<input class="form-control" placeholder="Enter a sport name here" value="" type="text" id="editsportname" name="sportname" />
	<div id="tooltipEdit" class="alert alert-info">
		<strong>TIP: </strong>Sport names are case insensitive.
	</div>
	<button type="button" class="btn btn-primary" id="submitEditSport">Edit Sport</button>
</div>
<!-- Remove Sport -->
<div id="removesport-dialog" title="Remove this Sport?">
	<input type="hidden" id="removesportid" name="sportid" value="" />
	<input type="hidden" id="removesportname" name="sportname" value="" />
	<div id="tooltipRemove" class="alert alert-warning">
	</div>
	<button type="button" class="btn btn-danger" id="submitRemoveSport">Remove Sport</button>
	<!--<button type="button" class="btn btn-default" id="submitCancel">Cancel</button>-->
</div>
<!-- Add Sport -->
<div id="addsport-dialog" title="Add Sport">
	<label for="sportname">Sport Name</label>
	<input class="form-control" placeholder="Enter a sport name here" value="" type="text" id="sportname" name="sportname" />
	<div id="tooltip" class="alert alert-info">
		<strong>TIP: </strong>Sport names are case insensitive.
	</div>
	<button type="button" class="btn btn-primary" id="submitAddSport">Add Sport</button>
</div>

<!-- End modals here -->

<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="<?php echo base_url(); ?>scripts/donutfortress.js"></script>
	<script src="<?php echo base_url(); ?>scripts/starlight.js"></script>
	<script src="<?php echo base_url(); ?>df_lms_new/js/classie.js"></script>
    <script src="<?php echo base_url(); ?>df_lms_new/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>df_lms_new/js/smoothscroll.js"></script>
	<script src="<?php echo base_url(); ?>df_lms_new/js/main.js"></script>
</body>
</html>