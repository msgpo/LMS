<br><br>
<?php
	$id=$league_id;
?>
<br><br>
<a href="<?php echo base_url().'index.php/leagueController/viewLeagueInfo/'.$id.'">Back to League Information</a>'?>
<br /><br />
<a href="<?php echo base_url();?>index.php/tournamentController/resetTournament/<?php echo $id ?>">Reset Tournament</a>