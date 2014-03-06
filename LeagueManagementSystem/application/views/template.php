<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title><?php echo $title;?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>df_lms/stylesheets/screen.css" type="text/css" media="screen" />
	
</head>
<body>
    <div id="header">
        <div id="logo"><img alt="Donut Fortress LMS" src="<?php echo base_url(); ?>df_lms/images/df_lms.png" /></div>
    </div>
    <div id="nav">
        <?php $this->load->view($nav); ?>
    </div>
    <div id="wrap">
		<?php $this->load->view($masthead); ?>
	<div id="content">
        <h1><?php echo $headline;?></h1>
        <?php $this->load->view($include);?>
    </div>
    <div id="sidebar">
		<h1>Options</h1>
		<?php
		/*
			if ($curController == "home")
			{
				echo '<p>Coming soon</p>';
			}
			
			if ($curController == "sportController")
			{
				echo '<a href="';
				echo base_url();
				$message="";
				echo 'index.php/sportController/addSport">Add Sport</a>';
			}
			
			if ($curController == "leagueController")
			{
				echo '<p>Coming soon</p>';
			}
		*/
		$this->load->view($sidebar);
		?>
			
        </div>
        <div id="footer">
            <p>Copyright &copy; 2014 Donut Fortress Australia, all rights reserved.</p>
        </div>
    </div>
</body>
</html>