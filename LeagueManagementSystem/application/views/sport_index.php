<table>
<tr>
	<th></th>
	<th>Sport Name</th>
</tr>
<?php
// generate HTML table from query results
		foreach ($sports_query->result() as $sport)
		{
			echo '<tr>';
			echo '<td><a href="' . base_url() . 'index.php/sportController/edit/' . $sport->sport_id . '">Edit</a>';
			echo ' | ';
			echo '<a href="' . base_url() . 'index.php/sportController/remove/' . $sport->sport_id . '" onclick="return confirm(\'Remove this sport?\')">Remove</a>';
			echo '</td>';
			echo '<td>' . ucwords($sport->sportname) . '</td>';
			echo '</tr>';
		}

	//	$sports_table = $this->table->generate();
		?>
</table>
 <style type="text/css">
	p1{
		color:red;
    }
</style>
<?php// echo $data_table; ?>