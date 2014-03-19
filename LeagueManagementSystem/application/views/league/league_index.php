 <form action="<?php echo base_url()?>index.php/leagueController/index" method="post" accept-charset="utf-8">
<p> Search for a League: <input type="text" name="leaguename" value="">
<button type="submit" class="btn btn-primary">Search</button></form></p>
<table class="table table-hover">
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
	/*	echo '<td>';
		echo '<a href="#" class="btn btn-info btn-lg" id="updateLeague' . $league->league_id .'" data-toggle="modal" data-target="#editLeague'.$league->league_id.'">Edit League Details</a>';
		echo '</td>'; */
		echo '</tr>';
?>

<!-- The script here depends on the ID of the league, mate. So leave it here. -->
<script>
/*
$(document).ready(function()
{
	// Edit League Details
	$("button#submiteditLeague<?php echo $league->league_id; ?>").click(function()
	{
		$.ajax(
		{
			type: "POST",
			url: "<?php echo base_url(); ?>index.php/leagueController/update",
			data:
				{
					league_id: <?php echo $league->league_id; ?>,
					leaguename: $("input#leaguename<?php echo $league->league_id; ?>").val(),
					sport_id: $("input#sport_id<?php echo $league->league_id; ?>").val(),
					tournamenttype: $("input#tournamenttype<?php echo $league->league_id; ?>").val()
				}, 
			success: function(msg){
		$("#deactivateLeague<?php echo $league->league_id; ?>").modal('hide');
					//location.reload();
					window.location = "<?php echo base_url(); ?>index.php/leagueController/index"; 
			},
			error: function(){
				alert("failure");
			}
		//	return false;
		});
	});
	
}); */
</script>

<!-- Edit League -->
<div class="modal fade" id="editLeague<?php echo $league->league_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Edit League Details</h4>
      </div>
      <div class="modal-body">
		<form class="editLeague<?php echo $league->league_id; ?>">
<p class="nav-header">League Name <input type="text" class="form-control" id="leaguename<?php echo $league->league_id; ?>" name="leaguename" value="<?php echo $league->leaguename; ?>"></p>
<p class="nav-header">Sport
<select class="form-control" id="sport_id<?php echo $league->league_id; ?>" name="sport_id">
<?php

	foreach($sportList->result() as $sport)
	{
		echo '<option';
		if ($league->sport_id == $sport->sport_id) echo ' selected=\"'. $sport->sport_id .'\"';
		echo ' value="';
		echo $sport->sport_id;
		echo '">' . ucwords($sport->sportname);
		echo '</option>';
	}
?>
</select></p>
<p class="nav-header">Tournament Type
<select class="form-control" id="tournamenttype<?php echo $league->league_id; ?>" name="tournamenttype">
	<option <?php if($league->tournamenttype == "Unspecified") echo 'selected="Unspecified"'; ?> value="Unspecified">Unspecified</option>
	<option <?php if($league->tournamenttype == "single elimination") echo 'selected="single elimination"'; ?> value="single elimination">Single Elimination</option>
	<option <?php if($league->tournamenttype == "double elimination") echo 'selected="double elimination"'; ?> value="double elimination">Double Elimination</option>
</select></p>
<p class="nav-header">Date (YYYY-MM-DD) <input class="form-control" type="text" id="datepicker2" name="registrationdeadline" value="<?php echo $league->registrationdeadline; ?>"> </p>

</form>
<div id="tooltip" class="alert alert-info">
	<!--<strong>TIP: </strong>Sport names are case insensitive.-->
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="submiteditLeague<?php echo $league->league_id; ?>">Save Changes</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	  </div>
    </div>
  </div>
</div>



<?php
}
?>

</table>

