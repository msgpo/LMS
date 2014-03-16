<!--<h2>Tournament</h2>-->
<?php
	// $round=1;
	echo '<table class="table table-hover">';
	echo '<tr>';
	echo '<th>Home</th><th>Visitor</th><th>Round</th><th>Options</th>';
	echo '</tr>';
	foreach($matches->result() as $match)
	{
		$teamAName = "";
		$teamBName = "";
		
		if ($match->team_a)
		{
			$teamAQuery = $this->teamList->getTeamById($match->team_a);
			$teamAName = $teamAQuery->row()->teamname;
		}
		if ($match->team_b)
		{
			$teamBQuery = $this->teamList->getTeamById($match->team_b);
			$teamBName = $teamBQuery->row()->teamname;
		}
		if ($teamAName && $teamBName)
		{
			echo '<tr><td>';
			echo ucwords($teamAName);
			if ($match->team_a == $match->winner)
				echo ' (Winner)';
			echo '</td><td>';
			echo ucwords($teamBName);
			if ($match->team_b == $match->winner)
				echo ' (Winner)';
			echo '</td>';
		}
		if (!$teamAName && $teamBName)
			echo '<tr><td>To be determined</td><td>'.ucwords($teamBName).'</td>';
		if ($teamAName && !$teamBName)
			echo '<tr><td>'.ucwords($teamAName).'</td><td>To be determined</td>';
		if (!$teamAName && !$teamBName)
			echo '<tr><td>To be determined</td><td>To be determined</td>';
		echo '<td>'.$match->roundnumber.'</td>';
		if (($teamAName && $teamBName) && !$match->winner)
			echo '<td><a class="btn btn-info btn-lg" href="' . base_url() . 'index.php/tournamentController/setMatch/'.$league_id.'/' . $match->match_id . '">Set Winner</a></td>';
		else
		//echo '<td><a class="btn btn-danger btn-lg" href="#">Cannot set match</a></td>';
			echo '<td></td>';
		echo '</tr>';	
	}
	echo '</table>';
?>