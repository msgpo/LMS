<a href="<?php echo base_url(); ?>index.php/leagueController/index" >View All Leagues</a>
<a href="<?php echo base_url(); ?>index.php/leagueController/generateLeague" >Create New League</a>

<?php
foreach($leagueDetails->result() as $ldetails)
	$id=$ldetails->league_id;
?>
<a href="<?php echo base_url()?>index.php/leagueController/editLeague/<?php echo $id;?>">Edit Details of This League</a>
<a href="<?php echo base_url()?>index.php/leagueController/deactivateLeague/<?php echo $id;?>" onclick="return confirm(\'Are you sure you want to deactivate this league?\')">Deactivate This League</a>
<?php
	foreach($leagueDetails->result() as $ldet)
	{
		if ($ldet->isstarted == "f" && $ldet->isended == "f")
		{
			echo '<a href="'.base_url().'index.php/teamController/addTeam/'.$id.'">Add a new Team</a>';	
			echo '<a href="'. base_url().'index.php/tournamentController/startTournament/'.$id.'">Start League</a>';
		}
	}
?>
<a href="<?php echo base_url();?>index.php/tournamentController/viewTournament/<?php echo $id ?>">View Tournament</a>
<!-- Script for Create League -->

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