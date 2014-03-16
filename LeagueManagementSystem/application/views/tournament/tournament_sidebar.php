<?php
	$id=$league_id;
?>
<a href="<?php echo base_url(); ?>index.php/leagueController/viewLeagueInfo/<?php echo $id; ?>">Back to League Information</a>
<a href="<?php echo base_url();?>index.php/tournamentController/resetTournament/<?php echo $id ?>" onclick="return confirm('Reset this tournament?')">Reset Tournament</a>