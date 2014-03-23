<table class="table table-hover">

<tr>
	<th>League Name</th>
	<th></th>
</tr>

<?php

if ($deactLeagues_query->num_rows()==0)
		echo '<td><p>No League Found</p></td>';
foreach ($deactLeagues_query->result() as $league)
{
	echo '<tr>';
		echo '<td>';
		echo ucwords($league->leaguename) . '</td>';
		echo '<td>';
		echo '<button class="btn btn-success btn-lg reactivate-league" id="reactivateLeague" data-reactleagueid="'.$league->league_id .'">Reactivate League</button>';
		echo '</td>';
		echo '</tr>';
}
?>

</table>

