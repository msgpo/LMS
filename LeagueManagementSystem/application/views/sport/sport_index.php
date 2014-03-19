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
			echo '<td><button class="btn btn-info btn-lg update-sport" id="updateSport" data-sportid="'. $sport->sport_id .'" data-sportname="'. $sport->sportname .'">Edit</button>';
		//	echo '<button class="btn btn-danger btn-lg" id="removeSport'.$sport->sport_id.'" data-toggle="modal" data-target="#removeSport'.$sport->sport_id.'">Remove</button>';
			echo '<button class="btn btn-danger btn-lg remove-sport" id="removeSport" data-sportid="'.$sport->sport_id.'" data-sportname="'. $sport->sportname .'">Remove</button>';
			echo '</td>';
			echo '</tr>';
		}
	
		echo '</table>';
?>

<button class="btn btn-primary btn-lg" id="addSportDialog">Add New Sport</button>

<div id="addsport-dialog" title="Add Sport">
	<label for="sportname">Sport Name</label>
	<input class="form-control" placeholder="Enter a sport name here" value="" type="text" id="sportname" name="sportname" />
	<div id="tooltip" class="alert alert-info">
		<strong>TIP: </strong>Sport names are case insensitive.
	</div>
	<button type="button" class="btn btn-primary" id="submitAddSport">Add Sport</button>
</div>

<div id="editsport-dialog" title="Edit Sport">
	<input type="hidden" id="sportid" name="sportid" value="" />
	<label for="editsportname">Sport Name</label>
	<input class="form-control" placeholder="Enter a sport name here" value="" type="text" id="editsportname" name="sportname" />
	<div id="tooltipEdit" class="alert alert-info">
		<strong>TIP: </strong>Sport names are case insensitive.
	</div>
	<button type="button" class="btn btn-primary" id="submitEditSport">Edit Sport</button>
</div>

<div id="removesport-dialog" title="Remove this Sport?">
	<input type="hidden" id="removesportid" name="sportid" value="" />
	<input type="hidden" id="removesportname" name="sportname" value="" />
	<div id="tooltipRemove" class="alert alert-warning">
	</div>
	<button type="button" class="btn btn-danger" id="submitRemoveSport">Remove Sport</button>
	<!--<button type="button" class="btn btn-default" id="submitCancel">Cancel</button>-->
</div>

<p><?php echo $links; ?></p>
<p>Page rendered in {elapsed_time} seconds.</p>

