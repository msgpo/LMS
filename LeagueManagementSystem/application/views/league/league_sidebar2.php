<a href="<?php echo base_url(); ?>index.php/leagueController/generateLeague" >Create New League</a>
<br><br>
<a href="<?php echo base_url(); ?>index.php/leagueController/index" >View All Leagues</a>
<br><br>

<?php
foreach($leagueDetails->result() as $ldetails)
	$id=$ldetails->league_id;
?>
<a href="<?php echo base_url().'index.php/leagueController/editLeague/'.$id.'">Edit Details of This League</a>'; ?>
<br /><br />
<a href="<?php echo base_url().'index.php/leagueController/deactivateLeague/'.$id.'" onclick="return confirm(\'Are you sure you want to deactivate this league?\')">Deactivate This League</a>'; ?>
<br /><br /><br /><br />
<!-- URI: index.php/teamController/addTeam/<league ID> -->
<a href="<?php echo base_url()?>index.php/teamController/addTeam/<?php echo $id; ?>">Add a new Team</a><br /><br />
<a href="<?php echo base_url().'index.php/leagueController/viewTournament/'.$id.'">View Tournament</a>';?><br />
<a href="<?php echo base_url().'index.php/leagueController/startRanking/'.$id.'">Manage Ranking</a>'; ?>
