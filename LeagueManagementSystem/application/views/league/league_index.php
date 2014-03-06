 <style type="text/css">
	p1{
		color:red;
    }
</style>
<form action="<?php echo base_url()?>index.php/leagueController/index" method="post" accept-charset="utf-8">
<p> Search for a League: <input type="text" name="leaguename" value="">
<input type="submit" name="" value="Search"></form></p>
<table>
<tr>
	<th>League Name</th>
	<th>Sport</th>
</tr>
<?php
if ($leagues_query->num_rows()==0)
		echo '<td><p1>No League Found</p1>';
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