<a href="<?php echo base_url(); ?>index.php/leagueController/index" >View Active Leagues</a>
<a href="<?php echo base_url(); ?>index.php/leagueController/deactivatedLeagueList" >View Deactivated Leagues</a>
<?php
if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
{
?>
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
}
?>

<?php
foreach($leagueDetails->result() as $ldetails)
{
	$id=$ldetails->league_id;
	$league_id = $ldetails->league_id;
	$lname = $ldetails->leaguename;
}


if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
{
	foreach($leagueDetails->result() as $ldet)
	{
		if ($ldet->isstarted == "f" && $ldet->isended == "f")
		{
		//	echo '<a href="'.base_url().'index.php/teamController/addTeam/'.$id.'">Add a new Team</a>';	
		//	echo '<a href="#" id="add-team" data-leagueid="'.$id.'">Add Team</a>';
			echo '<a href="'. base_url().'index.php/leagueController/startLeague/'.$id.'">Start League</a>';
		}
		else
		{
			echo '<a href="' . base_url() . 'index.php/tournamentController/viewTournament/' . $id . '">View Tournament</a>';
			echo '<a href="'.base_url().'index.php/tournamentController/unstartLeague/'.$id.'" onclick="return confirm(\'Are you sure you want to unstart this league?\')"> Unstart League</a>';
		}
	}
}
else
{
	echo '<a href="' . base_url() . 'index.php/tournamentController/viewTournament/' . $id . '">View Tournament</a>';
}
?>

<div id="addteam-dialog" title="Add a New Team">
	<input type="hidden" id="addteam-leagueid" name="league_id" value="" />
	<table>
		<tr><td>Team Name</td><td><input type="text" id="addteam-teamname" name="teamname" value=""></td></tr>
		<tr><td>Team Description</td><td><textarea rows="4" cols="40" id="addteam-teamdesc" name="teamdesc" value=""></textarea></td></tr>
		<tr><td>Coach's Last Name</td><td><input type="text" id="addteam-surname" name="coachlastname" value=""></td></tr>
		<tr><td>Coach's First Name</td><td><input type="text" id="addteam-firstname" name="coachfirstname" value=""></td></tr>
		<tr><td>Coach's Phone Number</td><td><input type="text" id="addteam-coachphone" name="coachphonenumber" value=""></td></tr>
	</table>
	<div id="tooltipAddTeam">
	</div>
	<button type="button" class="btn btn-primary" id="submitAddTeam">Add Team</button>
</div>