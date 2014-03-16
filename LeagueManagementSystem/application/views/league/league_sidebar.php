<h1 class="logo">Options</h1>
<a href="<?php echo base_url(); ?>index.php/leagueController/index" >View All Leagues</a>
<!--<a href="<?php echo base_url(); ?>index.php/leagueController/generateLeague" >Create New League</a> -->
<a href="#" data-toggle="modal" data-target="#addLeague" >Create New League</a>
<script>
$(document).ready(function()
{
	function hideModal()
	{
		$("#form-content").modal('hide');
		location.reload();
	}

	//twitter bootstrap script
	$("button#submitaddLeague").click(function()
	{
		$.ajax(
		{
			type: "POST",
			url: "<?php echo base_url(); ?>index.php/leagueController/create/",
			data: $('form.addLeague').serialize(),
			success: function(msg){
				if (msg == 1)
				{
					$("div#tooltip").removeClass().addClass("alert alert-success");
					$("div#tooltip").html('<strong>SUCCESS: </strong>League successfully created.');
					// $("#form-content").setTimeout(5000).modal('hide');
					$("#form-content").setTimeout(hideModal(), 5000);
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
</script> 
