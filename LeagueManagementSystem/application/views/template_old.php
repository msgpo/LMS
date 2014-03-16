<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title><?php echo $title;?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
	</script>
</head>
<body>
    <div id="header">
        <div id="logo"><img alt="Donut Fortress LMS" src="<?php echo base_url(); ?>df_lms/images/df_lms.png" /></div>
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
		$this->load->view($sidebar);
		?>
			
        </div>
        <div id="footer">
            <p>Copyright &copy; 2014 Donut Fortress Australia, all rights reserved.</p>
        </div>
    </div>
	
	
</body>
</html>