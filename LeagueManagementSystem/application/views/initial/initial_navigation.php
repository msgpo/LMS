<!--<ul>
    <li><a class="active" title="title" href="<?php echo base_url(); ?>index.php/initial/index">Index</a></li>
    <li><a title="title" href="<?php echo base_url(); ?>index.php/sportController/index">Sports</a></li>
    <li><a title="title" href="<?php echo base_url(); ?>index.php/leagueController/index">Leagues</a></li>
    <li><a title="title" href="#">About</a></li>
	<li><a title="title" href="<?php echo base_url(); ?>index.php/login/index">League Manager Login</a></li>
</ul>-->
<h1 class="logo"><a href="<?php echo base_url(); ?>index.php/initial/index">Donut Fortress LMS</a></h1>
<i class="icon-remove menu-close"></i>
<a href="<?php echo base_url(); ?>index.php/sportController/index">Sports</a>
<a title="title" href="<?php echo base_url(); ?>index.php/leagueController/index">Leagues</a>
<a title="title" href="#">About</a>
<a title="title" id="login" href="#">Login</a>
<form class="form-signin" action="<?php echo base_url()?>index.php/login/logging_in" method="post">
<h2 class="form-signin-heading">Please sign in</h2>
<input class="input-block-level" placeholder="Username" autocomplete="off" type="text" name="username" /><br>
<input class="input-block-level" placeholder="Password" type="password" name="password" /><br><br>
<button class="btn btn-large btn-primary" type="submit">Sign in</button></form>
<!-- Modal -->
<!--
<div class="modal hide fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Login</h4>
      </div>
      <div class="modal-body">
	  <form class="contact">
        <ul class="nav nav-list">
		<li class="nav-header">Sport Name</li>
		<li><input class="form-control" placeholder="Enter a sport name here" value="" type="text" id="sportname" name="sportname"></li>
		</ul>
		<br />
			<div id="tooltip" class="alert alert-info">
				<strong>TIP: </strong>Sport names are case insensitive.
			</div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submitadd">Add Sport</button>
      </div>
    </div>
  </div>
</div>
-->
<script>
/*
$(document).ready(function()
{
	/*$("a#login").click(function()
	{
		delay(4000);
	});

	//twitter bootstrap script
	$("button#submitadd").click(function()
	{
		$.ajax(
		{
			type: "POST",
			url: "<?php echo base_url(); ?>index.php/sportController/create/",
			data: $('form.contact').serialize(),
			success: function(msg){
			if (msg == 1)
			{
			//	$("div#tooltip").removeClass().addClass("alert alert-success");
			//	$("div#tooltip").html('<strong>SUCCESS: </strong>Sport added.');
			//	$("#form-content").delay(5000).modal('hide');
			$("#form-content").modal('hide');
				location.reload();
			}
			else
			{
				// alert(msg);
				if(!($("div#tooltip").hasClass("alert alert-danger")))
				{
					$("div#tooltip").removeClass().addClass("alert alert-danger");
				}
				
				$("div#tooltip").html('<strong>WARNING: </strong>' + msg);
			}
			},
			error: function(){
				alert("failure");
			}
		});
	});
});
*/
</script> 