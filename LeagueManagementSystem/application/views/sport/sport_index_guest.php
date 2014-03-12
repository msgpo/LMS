<table class="table table-hover">
<tr>
	<th>Sport Name</th>
	<th></th>
</tr>
<?php
// generate HTML table from query results
		foreach ($sports_query->result() as $sport)
		{
			echo '<tr>';
			echo '<td>' . ucwords($sport->sportname) . '</td>';
		/*	echo '<td><a class="btn btn-info btn-lg" href="' . base_url() . 'index.php/sportController/edit/' . $sport->sport_id . '">Edit</a>';
			echo '<a class="btn btn-danger btn-lg" href="' . base_url() . 'index.php/sportController/remove/' . $sport->sport_id . '" onclick="return confirm(\'Remove this sport?\')">Remove</a>';			
			echo '</td>'; */
			echo '</tr>';
		}

		?>
</table>
 <style type="text/css">
	p1{
		color:red;
    }
</style>

