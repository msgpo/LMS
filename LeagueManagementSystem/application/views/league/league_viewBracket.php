<table class="table table-hover">
<th>Home</th>
<th>Visitor</th>
<th>Options</th>
<?php
	foreach($matchQuery->result() as $match)
	{
		echo '<tr>';
		echo '<td>';
		$homeTeamInfo = $this->teamList->getTeamName($match->teama);
		$homeTeamName = $homeTeamInfo->row()->teamname;
		// echo $match->teama . '(' . $match->scorea . ')';
		echo ucwords($homeTeamName) . '(' . $match->scorea . ')';
		echo '</td>';
		echo '<td>';
		$visitorTeamInfo = $this->teamList->getTeamName($match->teamb);
		$visitorTeamName = $visitorTeamInfo->row()->teamname;
		// echo $match->teamb . '(' . $match->scoreb . ')';
		echo ucwords($visitorTeamName) . '(' . $match->scoreb . ')';
		echo '</td>';
		echo '<td></td>';
		echo '</tr>';
	}
?>
</table>