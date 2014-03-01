<form action="<?php echo base_url()?>index.php/leagueController/index" method="post" accept-charset="utf-8">
<p> Search for a League: <input type="text" name="leaguename" value=""></p>
<input type="submit" name="" value="Search"></form>
<?php
	if (isset($_POST['leaguename']))
	{
?>
<table>
<tr>
	<th>League Name</th>
	<th>Sport</th>
</tr>
<?php
foreach ($leagues_query->result() as $league)
{
	echo '<tr>';
	echo '<td><a href="';
	echo base_url();
	echo 'index.php/leagueController/viewLeagueInfo/' . $league->league_id;
	echo '">';
	echo ucwords($league->leaguename) . '</a></td>';
	echo '<td>' . ucwords($league->sportname) . '</td>';
	echo '</tr>';
}
?>
</table>
<?php
}
?>