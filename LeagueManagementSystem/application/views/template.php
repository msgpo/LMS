<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>df_lms_new/ico/favicon.png">
	
	<title><?php echo $title;?></title>
	
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
	
	<script src="<?php echo base_url(); ?>scripts/donutfortress.js"></script>
	<script src="<?php echo base_url(); ?>scripts/starlight.js"></script>
	
</head>
<body data-spy="scroll" data-offset="0" data-target="#theMenu">
<nav class="menu" id="theMenu">
		<div class="menu-wrap">
			<?php $this->load->view($nav); ?>
			<br />
			<?php $this->load->view($sidebar); ?>
		</div>
		
		<!-- Menu button -->
		<div id="menuToggle"><i class="icon-reorder"></i></div>
	</nav>
	
	<!-- ========== HEADER SECTION ========== -->
	<!-- <section id="home" name="home"></section> -->
	<?php //$this->load->view($masthead);
	
	$notification=$this->session->userdata('notification');
	if($notification)
	{
		echo'<div class= "panel panel-default"> <div class="panel-body">';
		echo '<div class= "alert alert-success"><h3>'.$notification.'</h3></div></div></div>';
		$this->session->unset_userdata('notification'); 
	}?>
	<div class="container">
		<h1><?php echo $headline;?></h1>
		<?php $this->load->view($include);?>
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
	<!--<img src="<?php echo base_url(); ?>df_lms_new/img/australia-flag-waving-emoticon-animated.gif" alt="Loading..." /> -->
	<img src="<?php echo base_url(); ?>df_lms_new/img/windows8-loading.gif" alt="Loading..." />
</div>

<!-- End modals here -->

<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="<?php echo base_url(); ?>df_lms_new/js/classie.js"></script>
    <script src="<?php echo base_url(); ?>df_lms_new/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>df_lms_new/js/smoothscroll.js"></script>
	<script src="<?php echo base_url(); ?>df_lms_new/js/main.js"></script>
</body>
</html>