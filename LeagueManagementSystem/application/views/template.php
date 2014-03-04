<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title><?php echo $title;?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/bootstrap.min.js"></script> 
<!--	<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/dist/css/bootstrap.css" type="text/css" media="screen" /> -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>df_lms/stylesheets/screen.css" type="text/css" media="screen" />
<!--	<script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/dist/js/bootstrap.js"></script> -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>styles/bootstrap-combined.min.css" type="text/css" media="screen" /> 

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

<script>
 $(function() 
 {
	//twitter bootstrap script
	$("button#submit").click(function()
	{
		$.ajax(
		{
    		type: "POST",
			url: "sportController/create/",
			data: $('form.contact').serialize(),
        		success: function(msg){
					var message = "";
					message = "<?php echo $this->session->userdata('err') ?>";
					if(message == "The Sportname field is required")
					{
						// Empty sportname
						if(!($("div#tooltip").hasClass("alert alert-error")))
						{
							$("div#tooltip").removeClass().addClass("alert alert-error");
						}
						$("div#tooltip").html('<strong>WARNING:  </strong>Sport name is required.');
						message = "";
						<?php
						$errors=array('err'=> null);
						$this->session->set_userdata($errors);
						?>
					}
					if (message == "The Sportname already exist")
					{
						if(!($("div#tooltip").hasClass("alert alert-error")))
						{
							$("div#tooltip").removeClass().addClass("alert alert-error");
						}
						$("div#tooltip").html('<strong>WARNING:  </strong>This sport has already existed.');
						message = "";
						<?php
						$errors=array('err'=> null);
						$this->session->set_userdata($errors);
						?>
					}
					if (message != "The Sportname already exist" && message != "The Sportname field is required")
					{
						<?php
						$errors=array('err'=> null);
						$this->session->set_userdata($errors);
						?>
						alert("Validation passed. Modal will now hide.");
						
						$("#form-content").modal('hide');	
					}
 		        },
			error: function(){
				alert("failure");
				}
      		});
	});
});
</script>	

</body>
</html>