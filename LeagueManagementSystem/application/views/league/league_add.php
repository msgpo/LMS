<form action="<?php echo base_url()?>index.php/leagueController/createLeagueHelper" method="post" accept-charset="utf-8">
<p>League Name: <input type="text" name="leaguename" value=""></p>
<p>Tournament Type:
<select name="tournamenttype">
	<option value="Single Elimination">Single Elimination</option>
	<option value="Double Elimination">Double Elimination</option>
	<option value="Round Robin">Round Robin</option>
</select></p>
<p>Sport:
<select name="sport_id">
<?php
	foreach($sportList->result() as $sport)
	{
		echo '<option value="';
		echo $sport->sport_id;
		echo '">' . ucwords($sport->sportname);
		echo '</option>';
	}
?>
</select>
</p>
<p>Date (YYYY-MM-DD): <input type="text" name="registrationdeadline" value=""> </p>

<input type="submit" name="" value="Create League"></form>