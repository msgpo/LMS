<style type="text/css">
		div.horizontal {
		width: 100%
		height: 100%;
		overflow-x: auto;
		}
		p1{
		color:red;
    }
</style>
<?php
	$notification=$this->session->userdata('notification');
	echo '<p1>'.$notification.'<br></p1>';
	$this->session->unset_userdata('notification');
?>
<table class="table table-hover">
<tr>
	<th>League Details</th>
</tr>
<?php
	foreach($leagueDetails->result() as $ldetails)
	{
		echo '<tr>';
		echo '<td>League Name: </td><td>' . ucwords($ldetails->leaguename) . '</td>';
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
	}
?>	
</table>
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
			echo '<tr>';
			echo '<td><a href="' . base_url() . 'index.php/teamController/editTeam/' .$league_id.'/'. $team->team_id . '">Edit</a>  | <a href="' . base_url() . 'index.php/teamController/removeTeam/' .$league_id.'/'. $team->team_id . '" onclick="return confirm(\'Remove this  Team?\')">Remove</a></td><td align="center">' . ucwords($team->teamname) . '</td><td align="center">' . ucwords($team->coachfirstname).' '.ucwords($team->coachlastname). '</td><td align="center">' .ucwords($team->coachphonenumber). '</td><td align="center">' .ucwords($team->teamdesc). '</td>';
			echo '</tr>';
		}
?>
</tbody>
</table>
</div>
<h2>Team Ranking</h2>
<table class="table table-hover">
<tr>
<th>Rank</th><th>Team</th>
</tr>
<tbody>
<?php
		$rank=1;
		foreach($teamLists->result() as $team)
		{
			// echo $league_id;
			echo '<tr>';
			echo '<td>'.$rank.'</td>';
			echo '<td>';
			// team name

			$rankQuery = $this->teamList->getTeamRank($rank, $league_id);
			if ($rankQuery->num_rows() == 0)
				echo 'Undecided yet';
			else
			{
				foreach($rankQuery->result() as $rankResult)
				{
					echo $rankResult->teamname;
				}
			}
			echo '</td>';
			echo '</tr>';
			$rank=$rank+1;
		}
?>
</tbody>
</table>