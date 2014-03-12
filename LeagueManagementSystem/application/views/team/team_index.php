<table>
	<tr>
		<th>Team Name</th>
	</tr>
	<?php
		foreach($tList as $team)
		{
			echo '<tr>';
			echo '<td><a href="' . base_url()  . 'index.php/teamController/viewteam/' . $team->team_id . '">' . $team->teamname . '</a></td>';
			echo '</tr>';
		}
	?>
</table>