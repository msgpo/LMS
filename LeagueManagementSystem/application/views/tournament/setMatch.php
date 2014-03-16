<?php
	if ($matchDetails->row()->team_a)
	{
		$teamA = $matchDetails->row()->team_a;
		$teamAName = $teamAQuery->row()->teamname;
	}
	
	if ($matchDetails->row()->team_b)
	{
		$teamB = $matchDetails->row()->team_b;
		$teamBName = $teamBQuery->row()->teamname;
	}
	
	
?>
<!-- Self-referencing form -->
<form action="<?php echo base_url()?>index.php/tournamentController/updateMatch/<?php echo $league_id.'/'.$match_id;?>/" method="post" accept-charset="utf-8">
	<select name="winner">
		<option value="<?php echo $teamA; ?>"><?php echo ucwords($teamAName); ?></option>
		<option value="<?php echo $teamB; ?>"><?php echo ucwords($teamBName); ?></option>
	</select>
	<button type="submit" class="btn btn-primary">Set Winner</button>
</form>