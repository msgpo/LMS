<table class="table table-hover">
<tr>
	<th>League Details</th>
</tr>
<?php
	foreach($leagueDetails->result() as $ldetails)
	{
		echo '<tr>';
		echo '<td>League Name: </td><td>' . ($ldetails->leaguename) . '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Sport: </td><td>' . $ldetails->sportname . '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Tournament Format: </td><td>' . $ldetails->tournamenttype . '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Registration: </td><td>' . $ldetails->registrationdeadline . '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Status: </td><td>';
		if ($ldetails->isstarted == "f" && $ldetails->isended == "f")
			echo 'Not Started';
		if ($ldetails->isstarted == "t" && $ldetails->isended == "f")
			echo 'Ongoing';
		if ($ldetails->isstarted == "t" && $ldetails->isended == "t")
			echo 'Ended';
		echo '</td>';
		echo '</tr>';
?>
</table>
<?php
if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')) && ($ldetails->isstarted == "f" && $ldetails->isended == "f"))
{
?>
<button class="btn btn-success btn-lg update-league" id="updateLeague" data-leagueid="<?php echo $ldetails->league_id; ?>" data-leaguename="<?php echo $ldetails->leaguename; ?>" data-sportid="<?php echo $ldetails->sport_id; ?>" data-tournamenttype="<?php echo $ldetails->tournamenttype; ?>" data-registrationdeadline="<?php echo $ldetails->registrationdeadline; ?>">Edit League Details</button>
<?php
}
?>
<button class="btn btn-danger btn-lg remove-league" id="removeLeague" data-leagueid="<?php echo $ldetails->league_id; ?>" data-leaguename="<?php echo ($ldetails->leaguename); ?>">Deactivate League</button>




<!-- End Modals here -->
<br />
<h2> Team Listing </h2>
<div class="horizontal">
<table class="table table-hover">
<tr>
<th><td align="center">Team name</td><td align="center">Team Coach</td><td align="center">Coach's Contact Number</td><td align="center">Team Description</td></th>
</tr>
<tbody>
<?php
		foreach($tList as $team)
		{
			echo '<tr><td>';
			echo '<button class="btn btn-success btn-lg edit-team" data-leagueid="' . $league_id . '" data-teamid="'. $team->team_id . '" data-teamname="'. $team->teamname .'" data-teamdesc="'.$team->teamdesc .'" data-coachsurname="'. $team->coachlastname .'" data-coachfirstname="' . $team->coachfirstname . '" data-coachphone="'. $team->coachphonenumber .'">Edit Info</button>';
			if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')) && ($ldetails->isstarted == "f" && $ldetails->isended == "f"))
			{
//			echo '<td><a  class="btn btn-info btn-lg" href="' . base_url() . 'index.php/teamController/editTeam/' .$league_id.'/'. $team->team_id . '">Edit</a>';
				
				echo '<button class="btn btn-danger btn-lg remove-team" data-leagueid="' . $league_id . '" data-teamid="'. $team->team_id . '" data-teamname="'. $team->teamname .'">Remove Team</button>';
			}
//			echo '<a class="btn btn-danger btn-lg" href="' . base_url() . 'index.php/teamController/removeTeam/' .$league_id.'/'. $team->team_id . '" onclick="return confirm(\'Remove this  Team?\')">Remove</a></td>';
			echo '<td align="center">' . ($team->teamname) . '</td><td align="center">' . ($team->coachfirstname).' '.($team->coachlastname). '</td><td align="center">' .($team->coachphonenumber). '</td><td align="center">' .($team->teamdesc). '</td>';
			echo '</tr>';

		}
echo '</tbody></table>';
if ($ldetails->isstarted == "f" && ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username'))))
echo '<button class="btn btn-primary" id="add-team" data-leagueid="'.$league_id.'">Add Team</button>';
?>

<?php
	}
?>
</div>

<div id="removeleague-dialog">
	<input type="hidden" id="removeleagueid" name="league_id" value="" />
	<div id="tooltipRemoveLeague" class="alert alert-warning">
	</div>
	<button class="btn btn-danger btn-lg" id="submitRemoveLeague">Confirm League Deactivation</button>
</div>

<div id="editleague-dialog" title="Edit League Info">
<table>
<input type="hidden" id="editleagueid" name="league_id" value="" />
<tr><td>League Name</td><td><input type="text" id="editleaguename" name="leaguename" value="" /></td></tr>
<tr><td>Sport</td>
<td><select id="editsportid" name="sport_id">
<?php
if ($sportList)
{
	foreach($sportList->result() as $sport)
	{
		echo '<option value="';
		echo $sport->sport_id;
		echo '">' . ($sport->sportname);
		echo '</option>';
	}
}
?>
</select></td></tr>
<tr><td>Tournament Type</td>
<td><select id="edittournamenttype" name="tournamenttype">
	<option value="unspecified">Unspecified</option>
	<option value="single elimination">Single Elimination</option>
	<option value="double elimination">Double Elimination</option>
</select></td></tr>
<tr><td>Date </td>
<td><input type="text" id="datepicker2" name="registrationdeadline" value=""></td></tr>
</table>
<div id="tooltipEditLeague">
	<!--<strong>TIP: </strong>Sport names are case insensitive.-->
</div>
<button type="button" class="btn btn-primary" id="submitUpdateLeague">Edit League Details</button>
</div>

<div id="editteam-dialog" title="Edit Team Details">
	<input type="hidden" id="editteam-leagueid" name="league_id" value="" />
	<input type="hidden" id="editteam-teamid" name="league_id" value="" />
	<table>
		<tr><td>Team Name</td><td><input type="text" id="editteam-teamname" name="teamname" value=""></td></tr>
		<tr><td>Team Description</td><td><textarea rows="4" cols="40" id="editteam-teamdesc" name="teamdesc" value=""></textarea></td></tr>
		<tr><td>Coach's Last Name</td><td><input type="text" id="editteam-surname" name="coachlastname" value=""></td></tr>
		<tr><td>Coach's First Name</td><td><input type="text" id="editteam-firstname" name="coachfirstname" value=""></td></tr>
		<tr><td>Coach's Phone Number</td><td><input type="text" id="editteam-coachphone" name="coachphonenumber" value=""></td></tr>
	</table>
	<div id="tooltipEditTeam">
	</div>
	<button type="button" class="btn btn-primary" id="submitEditTeam">Edit Team</button>
</div>

<div id="removeteam-dialog" title="Remove this Team?">
	<input type="hidden" id="removeteam-teamid" name="team_id" value="" />
	<input type="hidden" id="removeteam-leagueid" name="league_id" value="" />
	<input type="hidden" id="removeteam-teamname" name="teamname" value="" />
	<div id="tooltipRemoveTeam" class="alert alert-warning">
	</div>
	<button type="button" class="btn btn-danger" id="submitRemoveTeam">Remove Team</button>
	<!--<button type="button" class="btn btn-default" id="submitCancel">Cancel</button>-->
</div>
