<table>
<tr>
	<th></th>
	<th>Sport Name</th>
</tr>
<?php
		if($sports_query->num_rows()==0)
		{
			echo '<tr>';
			echo '<td></td><td><p1>No Sport created yet</p1></td>';
			echo '<tr>';
		}
		else
		{
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
		}?>
</table>
 <style type="text/css">
	p1{
		color:red;
    }
</style>
<?php// echo $data_table; ?>