<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title><?php echo $title;?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>df_lms/stylesheets/screen.css" type="text/css" media="screen" />
	<script type="text/javascript">
		function addSport()
		{
		}
	</script>
	
</head>
<body>
    <div id="header">
        <div id="logo"><img alt="Donut Fortress LMS" src="<?php echo base_url(); ?>df_lms/images/df_lms.png" /></div>
    </div>
    <div id="nav">
        <ul>
            <li><a <?php if($curController == "home") echo 'class="active"'; ?> title="title" href="<?php echo base_url(); ?>index.php/home/index">Home</a></li>
            <li><a <?php if($curController == "sportController") echo 'class="active"'; ?> title="title" href="<?php echo base_url(); ?>index.php/sportController/index">Sports</a></li>
            <li><a title="title" href="#">Leagues</a></li>
            <li><a title="title" href="#">About</a></li>
			<li><a title="title" href="<?php echo base_url(); ?>index.php/login/logout">Logout</a></li>
        </ul>
    </div>
    <div id="wrap">
        <!--
            The image below is licensed under Creative Commons by-sa
            http://flickr.com/photos/rickharris/368538048/
        -->
        <?php if($curController == "home") { echo '<img id="masthead" alt="A photo of the Australian Olympic Team at the 2014 Winter Olympics. Photo courtesy of the Australian Broadcasting Corporation." src="';
		echo base_url() . 'df_lms/images/home-masthead.jpg" width="740px" />'; } ?> 
		<?php if($curController == "sportController") { echo '<img id="masthead" alt="A game of Australian Rules Football." src="';
		echo base_url() . 'df_lms/images/gitfiddle.jpg" width="740px" />'; } ?> 
        <div id="content">
            <h1><?php echo $headline;?></h1>
            <?php $this->load->view($include);?>
        </div>
        <div id="sidebar">
			<h1>Options</h1>
		<?php
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
		?>
			
        </div>
        <div id="footer">
            <p>Copyright &copy; 2014 Donut Fortress Australia, all rights reserved.</p>
        </div>
    </div>
</body>
</html>