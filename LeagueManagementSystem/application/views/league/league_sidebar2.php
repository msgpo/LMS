<a href="<?php echo base_url(); ?>index.php/leagueController/index" >View All Leagues</a>
<a href="#" id="create-league">Create New League</a>

<div id="addleague-dialog" title="Create League">
<table>
<tr><td>League Name</td><td><input type="text" id="leaguename" name="leaguename" value="" /></td></tr>
<tr><td>Sport</td>
<td><select id="sportid" name="sport_id">
<?php
if ($sportList)
{
	foreach($sportList->result() as $sport)
	{
		echo '<option value="';
		echo $sport->sport_id;
		echo '">' . ucwords($sport->sportname);
		echo '</option>';
	}
}
?>
</select></td></tr>
<tr><td>Tournament Type</td>
<td><select id="tournamenttype" name="tournamenttype">
	<option value="Unspecified">Unspecified</option>
	<option value="Single Elimination">Single Elimination</option>
	<option value="Double Elimination">Double Elimination</option>
</select></td></tr>
<tr><td>Date </td>
<td><input type="text" id="datepicker" name="registrationdeadline" value=""></td></tr>
</table>
<div id="tooltipCreateLeague">
	<!--<strong>TIP: </strong>Sport names are case insensitive.-->
</div>
<button type="button" class="btn btn-primary" id="submitCreateLeague">Create League</button>
</div>



<?php
foreach($leagueDetails->result() as $ldetails)
{
	$id=$ldetails->league_id;
	$league_id = $ldetails->league_id;
	$lname = $ldetails->leaguename;
}
?>
<!--
<a href="#" id="updateLeague<?php echo $league_id; ?>" data-toggle="modal" data-target="#editLeague<?php echo $league_id; ?>">Edit League Details</a>
<a href="#" id="removeLeague<?php echo $league_id; ?>" data-toggle="modal" data-target="#deactivateLeague<?php echo $league_id; ?>">Deactivate League</a>-->

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