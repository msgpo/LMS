<table>
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
<table>
<tr>
<th>Teams</th>
</tr>
<tr><td>Edit | Remove</td><td>Shrine Maidens</td></tr>
<tr><td>Edit | Remove</td><td>Scarlet Devil Mansion</td></tr>
<tr><td>Edit | Remove</td><td>Lunar Rabbits</td></tr>
<tr><td>Edit | Remove</td><td>Man-Eating Youkai</td></tr>
<tr><td>Edit | Remove</td><td>Strongest Fairies</td></tr>
</table>