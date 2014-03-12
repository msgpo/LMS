<style type="text/css">
	p1{
		color:red;
    }
</style>
<table class="table table-hover">
<tr>
<th>Rank</th><th>Team</th><th>Options</th>
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
				echo 'Unspecified';
			else
			{
				foreach($rankQuery->result() as $rankResult)
				{
					echo $rankResult->teamname;
				}
			}
			echo '</td>';
			echo '<td>';
			echo '<a href="' . base_url() . 'index.php/leagueController/setRank/' . $league_id . '/' . $rank . '/">Assign Team</a>';
			echo '</td>';
			echo '</tr>';
			$rank=$rank+1;
		}
?>
</tbody>
</table>