 <form action="<?php echo base_url()?>index.php/leagueController/index" method="post" accept-charset="utf-8">
<p> Search for a League: <input type="text" name="leaguename" value="">
<button type="submit" class="btn btn-primary">Search</button></form></p>
<table class="table table-hover" id="league_table">
<thead>
<tr>
	<th>League Name</th>
	<th>Sport</th>
</tr>
</thead>
<tbody>
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
		echo ($league->leaguename) . '</a></td>';
		echo '<td>' . ($league->sportname) . '</td>';	
	/*	echo '<td>';
		echo '<a href="#" class="btn btn-info btn-lg" id="updateLeague' . $league->league_id .'" data-toggle="modal" data-target="#editLeague'.$league->league_id.'">Edit League Details</a>';
		echo '</td>'; */
		echo '</tr>';
}
?>
</tbody>
</table>

