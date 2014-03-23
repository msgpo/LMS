<!--<h2>Tournament</h2>-->
<div id="w">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
				<h3>
				<?php
					echo 'WINNER: ';
					if ($winnerQuery->num_rows() > 0)
						echo ucwords($winnerQuery->row()->teamname) ;
					else
						echo 'Undecided Yet';
				?>
				</h3>
				
				
				</div>
			</div>
		</div><!-- /container -->
	</div><!-- /w -->
<?php
	echo '<table class="table table-hover">';
	echo '<tr>';
	echo '<th>Home</th><th> </th><th>Visitor</th><th>Round</th><th>Bracket</th><th>Options</th>';
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
		//	if ($match->team_a == $match->winner)
		//		echo ' (Winner)';
			echo '</td><td>';
		/*	if ($match->team_a == $match->winner)
				echo ' < ';
			if ($match->team_b == $match->winner)
				echo ' > ';
			if (!$match->winner)
				echo ' VS '; */
			if ($match->team_a == $match->winner)
				echo ' > ';
			else if ($match->team_b == $match->winner)
				echo ' < ';
			else
				echo ' VS ';
			echo '</td><td>';
			echo ucwords($teamBName);
		//	if ($match->team_b == $match->winner)
		//		echo ' (Winner)';
			echo '</td>';
		}
		if (!$teamAName && $teamBName)
			echo '<tr><td>To be determined</td><td> VS </td><td>'.ucwords($teamBName).'</td>';
		if ($teamAName && !$teamBName)
			echo '<tr><td>'.ucwords($teamAName).'</td><td> VS </td><td>To be determined</td>';
		if (!$teamAName && !$teamBName)
			echo '<tr><td>To be determined</td><td> VS </td><td>To be determined</td>';
		echo '<td>'.$match->roundnumber.'</td>';
		echo '<td>';
		if ($match->bracket == "w") echo "Winner's Bracket";
		else if ($match->bracket == "l") echo "Loser's Bracket";
		else if ($match->bracket == "f") echo "Championship";
		else echo "Single Elimination";
		// echo $match->bracket;
		echo '</td>';
		if ((($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))) && (($teamAName && $teamBName) && !$match->winner))
			echo '<td><button type="button" class="btn btn-primary set-winner" data-swleagueid="'.$league_id.'" data-swmatchid="'.$match->match_id .'" data-swhometeamid="'.$match->team_a .'" data-swhometeamname="'.ucwords($teamAName).'" data-swvisitorteamid="'.$match->team_b .'" data-swvisitorteamname="'.ucwords($teamBName).'">Set Winner</button></td>';
		else if ((($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))) && (($teamAName && $teamBName) && $match->winner))
		{
	//		echo '<td><button type="button" class="btn btn-danger change-outcome" data-swleagueid="'.$league_id.'" data-swmatchid="'.$match->match_id .'">Edit Outcome</button></td>';
	echo '<td><a href="'.base_url().'index.php/tournamentController/unsetMatch/'.$league_id.'/'.$match->match_id.'/" class="btn btn-danger change-outcome" data-swleagueid="'.$league_id.'" data-swmatchid="'.$match->match_id .'" onclick="return confirm(\'Are you sure You want to unset the winner in this match?\')">Unset Winner</a></td>';
		} 
		else
			echo '<td></td>';
		echo '</tr>';	
	}
	echo '</table>';
?>
<div id="setWinnerDialog" title="Set The Winner">
	<input type="hidden" id="setwinner-leagueid" name="league_id" value="" />
	<input type="hidden" id="setwinner-matchid" name="match_id" value="" />
	<select id="winner">
	</select>
	<br />
	<br />
	<button type="button" class="btn btn-primary" id="submitSetWinner">Set Winner</button>
</div>
