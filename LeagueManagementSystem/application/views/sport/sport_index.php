<table class="table table-hover">
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
			echo '<td>';
			// Button trigger modal
		/*	echo '<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#remove">';
			echo 'Remove';
			echo '</button>'; */
			echo '</td>';
			echo '</tr>';
			
			

			// Modal -->
/* echo '<div class="modal fade" id="remove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <input value="' . $sport->sport_id .  '" type="hidden" name="sport_id">';
		echo $sport->sport_id;
echo '</div>
      <div class="modal-footer">
		<button type="button" class="btn btn-primary">Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>'; */
		}

		?>
</table>
 <style type="text/css">
	p1{
		color:red;
    }
</style>

