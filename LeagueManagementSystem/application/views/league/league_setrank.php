<?php
$teaminfo = $this->teamList->getTeamRank($rank, $league_id);
if ($teaminfo->num_rows() > 0)
{
?>
	<form action="<?php echo base_url(); ?>index.php/leagueController/unassignHelper" method="post" accept-charset="utf-8">
	<input type="hidden" name="league_id" value="<?php echo $league_id; ?>" />
<?php
	foreach ($teaminfo->result() as $team)
	{
		echo '<input type="hidden" name="team_id" value="' . $team->team_id . '" />';
		echo '<p>Team: ' . $team->teamname . '</p>';
		echo '<p>Rank: ' . $rank . '</p>';
	}
?>
	<button type="submit" class="btn btn-primary">Unrank this team</button>
<?php
}
else
{
?>
<form action="<?php echo base_url(); ?>index.php/leagueController/setRankHelper" method="post" accept-charset="utf-8">
<input type="hidden" name="rank" value="<?php echo $rank; ?>" />
<input type="hidden" name="league_id" value="<?php echo $league_id; ?>" />
<select name="team_id">
<?php
	$ranklessTeams = $this->teamList->getRanklessTeamsOfLeague($league_id);
	foreach ($ranklessTeams->result() as $team)
	{
		echo '<option value="' . $team->team_id . '">';
		echo $team->teamname;
		echo '</option>';
	}
?>
</select>
<button type="submit" class="btn btn-primary">Set Rank</button>
</form>
<?php
}
?>