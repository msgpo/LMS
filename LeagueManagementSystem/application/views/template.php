<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>df_lms_new/ico/favicon.png">
	
	<title><?php echo $title;?></title>
	
	<!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>df_lms_new/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>df_lms_new/css/main.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>df_lms_new/css/font-awesome.min.css">

    <script src="<?php echo base_url(); ?>df_lms_new/js/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>df_lms_new/js/Chart.js"></script>
	<script src="<?php echo base_url(); ?>df_lms_new/js/modernizr.custom.js"></script>
	

	
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo base_url(); ?>df_lms_new/js/html5shiv.js"></script>
      <script src="<?php echo base_url(); ?>df_lms_new/js/respond.min.js"></script>
    <![endif]-->
	
	<!--
	<script src="<?php echo base_url(); ?>scripts/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>scripts/bootstrap.min.js"></script> 
	<link rel="stylesheet" href="<?php echo base_url(); ?>df_lms/stylesheets/screen.css" media="screen" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/bootstrap-combined.min.css" media="screen" />
	<script src="<?php echo base_url(); ?>scripts/jqBootstrapValidation.js"></script>
	<script>
		$(function() 
		{ 
			$("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); 
		});
	</script> -->
</head>
<body data-spy="scroll" data-offset="0" data-target="#theMenu">
<nav class="menu" id="theMenu">
		<div class="menu-wrap">
		<!-- Nav Format
			<h1 class="logo"><a href="index.html#home">Onassis</a></h1>
			<i class="icon-remove menu-close"></i>
			<a href="#home" class="smoothScroll">Home</a>
			<a href="#services" class="smoothScroll">Services</a>
			<a href="#portfolio" class="smoothScroll">Portfolio</a>
			<a href="#about" class="smoothScroll">About</a>
			<a href="#contact" class="smoothScroll">Contact</a>
			<a href="#"><i class="icon-facebook"></i></a>
			<a href="#"><i class="icon-twitter"></i></a>
			<a href="#"><i class="icon-dribbble"></i></a>
			<a href="#"><i class="icon-envelope"></i></a>
			-->
			<?php $this->load->view($nav); ?>
			<br />
			<?php $this->load->view($sidebar); ?>
		</div>
		
		<!-- Menu button -->
		<div id="menuToggle"><i class="icon-reorder"></i></div>
	</nav>
	
	<!-- ========== HEADER SECTION ========== -->
	<!-- <section id="home" name="home"></section> -->
	<?php $this->load->view($masthead); ?>
	
	<div class="container">
		<h1><?php echo $headline;?></h1>
		<?php $this->load->view($include);?>
	</div>
	
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
	
	
<!--
    <div id="header">
        <div id="logo"><img alt="Donut Fortress LMS" src="<?php /* echo base_url(); ?>df_lms/images/df_lms.png" /></div>
    </div>
    <div id="nav">
        <?php $this->load->view($nav); ?>
    </div>
    <div id="container">
		<?php $this->load->view($masthead); ?>
	<div id="content">
        <h1><?php echo $headline;?></h1>
        <?php $this->load->view($include);?>
    </div>
    <div id="sidebar">
		<h1>Options</h1>
		<?php
		$this->load->view($sidebar); */
		?>
			
        </div>
        <div id="footer">
            <p>Copyright &copy; 2014 Donut Fortress Australia, all rights reserved.</p>
        </div>
    </div>
	
-->
<!-- Modals -->
<div class="modal fade" id="addLeague" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Create new League</h4>
      </div>
      <div class="modal-body">
		<form class="addLeague">
<p class="nav-header">League Name <input type="text" class="form-control" name="leaguename" value=""></p>
<p class="nav-header">Sport
<select class="form-control" name="sport_id">
<?php
if ($sportList)
{
	foreach($sportList->result() as $sport)
	{
		echo '<option value="';
		echo $sport->sport_id;
		echo '">' . ucwords($sport->sportname);
		echo '</option>';
	}
}
?>
</select></p>
<p class="nav-header">Tournament Type
<select class="form-control" name="tournamenttype">
	<option value="Unspecified">Unspecified</option>
	<option value="Single Elimination">Single Elimination</option>
	<option value="Double Elimination">Double Elimination</option>
</select></p>
<p class="nav-header">Date (YYYY-MM-DD) <input class="form-control" type="text" name="registrationdeadline" value=""> </p>

</form>
<div id="tooltip" class="alert alert-info">
	<!--<strong>TIP: </strong>Sport names are case insensitive.-->
</div>
<?php
/*
	$errors=$this->session->userdata('err');
	if(is_array($errors))
	{
		foreach($errors as $error)
		{
			echo '<p1>'.$error.'<br></p1>';
		}
	}
	*/
?> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="submitaddLeague">Create League</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	  </div>
    </div>
  </div>
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