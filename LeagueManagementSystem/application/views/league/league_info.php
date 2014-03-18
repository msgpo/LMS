<table class="table table-hover">
<tr>
	<th>League Details</th>
</tr>
<?php
	foreach($leagueDetails->result() as $ldetails)
	{
		echo '<tr>';
		echo '<td>League Name: </td><td>' . ucwords($ldetails->leaguename) . '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Sport: </td><td>' . $ldetails->sportname . '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Tournament Format: </td><td>' . $ldetails->tournamenttype . '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Registration: </td><td>' . $ldetails->registrationdeadline . '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Status: </td><td>';
		if ($ldetails->isstarted == "f" && $ldetails->isended == "f")
			echo 'Not Started';
		if ($ldetails->isstarted == "t" && $ldetails->isended == "f")
			echo 'Ongoing';
		if ($ldetails->isstarted == "t" && $ldetails->isended == "t")
			echo 'Ended';
		echo '</td>';
		echo '</tr>';
?>
</table>
<button class="btn btn-success btn-lg update-league" id="updateLeague" data-leagueid="<?php echo $ldetails->league_id; ?>" data-leaguename="<?php echo $ldetails->leaguename; ?>" data-sportid="<?php echo $ldetails->sport_id; ?>" data-tournamenttype="<?php echo $ldetails->tournamenttype; ?>" data-registrationdeadline="<?php echo $ldetails->registrationdeadline; ?>">Edit League Details</button>
<button class="btn btn-danger btn-lg remove-league" id="removeLeague" data-leagueid="<?php echo $ldetails->league_id; ?>" data-leaguename="<?php echo ucwords($ldetails->leaguename); ?>">Deactivate League</button>

<!-- The script here depends on the ID of the league, mate. So leave it here. -->
<script>
/*
$(document).ready(function()
{
	
	// Edit League Details
	$("button#submiteditLeague<?php echo $ldetails->league_id; ?>").click(function()
	{
		$.ajax(
		{
			type: "POST",
			url: "<?php echo base_url(); ?>index.php/leagueController/update",
			data:
				{
					league_id: <?php echo $ldetails->league_id; ?>,
					leaguename: $("input#leaguename<?php echo $ldetails->league_id; ?>").val(),
					sport_id: $("input#sport_id<?php echo $ldetails->league_id; ?>").val(),
					tournamenttype: $("input#tournamenttype<?php echo $ldetails->league_id; ?>").val()
				}, 
			success: function(msg){
		$("#deactivateLeague<?php echo $ldetails->league_id; ?>").modal('hide');
					//location.reload();
					window.location = "<?php echo base_url(); ?>index.php/leagueController/index"; 
			},
			error: function(){
				alert("failure");
			}
		//	return false;
		});
	});
	
});
*/
</script>

<!-- Edit League -->
<!--<div class="modal fade" id="editLeague<?php echo $ldetails->league_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Edit League Details</h4>
      </div>
      <div class="modal-body">
		<form class="editLeague<?php echo $ldetails->league_id; ?>">
<p class="nav-header">League Name <input type="text" class="form-control" id="leaguename<?php echo $ldetails->league_id; ?>" name="leaguename" value="<?php echo $ldetails->leaguename; ?>"></p>
<p class="nav-header">Sport
<select class="form-control" id="sport_id<?php echo $ldetails->league_id; ?>" name="sport_id">
<?php

	foreach($sportList->result() as $sport)
	{
		echo '<option';
		if ($ldetails->sport_id == $sport->sport_id) echo ' selected=\"'. $sport->sport_id .'\"';
		echo ' value="';
		echo $sport->sport_id;
		echo '">' . ucwords($sport->sportname);
		echo '</option>';
	}
?>
</select></p>
<p class="nav-header">Tournament Type
<select class="form-control" id="tournamenttype<?php echo $ldetails->league_id; ?>" name="tournamenttype">
	<option <?php if($ldetails->tournamenttype == "Unspecified") echo 'selected="Unspecified"'; ?> value="Unspecified">Unspecified</option>
	<option <?php if($ldetails->tournamenttype == "single elimination") echo 'selected="single elimination"'; ?> value="single elimination">Single Elimination</option>
	<option <?php if($ldetails->tournamenttype == "double elimination") echo 'selected="double elimination"'; ?> value="double elimination">Double Elimination</option>
</select></p>
<p class="nav-header">Date (YYYY-MM-DD) <input class="form-control" type="text" id="datepicker2" name="registrationdeadline" value="<?php echo $ldetails->registrationdeadline; ?>"> </p>

</form>
<div id="tooltip" class="alert alert-info">
	<!--<strong>TIP: </strong>Sport names are case insensitive.-->
<!--</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="submiteditLeague<?php echo $ldetails->league_id; ?>">Save Changes</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	  </div>
    </div>
  </div>
</div>
-->

<?php
	}
?>
<!-- End Modals here -->
<br />
<h2> Team Listing </h2>
<div class="horizontal">
<table class="table table-hover">
<tr>
<th><td align="center">Team name</td><td align="center">Team Coach</td><td align="center">Coach's Contact Number</td><td align="center">Team Description</td></th>
</tr>
<tbody>
<?php
		foreach($tList as $team)
		{
			echo '<tr>';
			echo '<td><a  class="btn btn-info btn-lg" href="' . base_url() . 'index.php/teamController/editTeam/' .$league_id.'/'. $team->team_id . '">Edit</a><a class="btn btn-danger btn-lg" href="' . base_url() . 'index.php/teamController/removeTeam/' .$league_id.'/'. $team->team_id . '" onclick="return confirm(\'Remove this  Team?\')">Remove</a></td><td align="center">' . ucwords($team->teamname) . '</td><td align="center">' . ucwords($team->coachfirstname).' '.ucwords($team->coachlastname). '</td><td align="center">' .ucwords($team->coachphonenumber). '</td><td align="center">' .ucwords($team->teamdesc). '</td>';
			echo '</tr>';
		}
?>
</tbody>
</table>
</div>

<div id="removeleague-dialog">
	<input type="hidden" id="removeleagueid" name="league_id" value="" />
	<div id="tooltipRemoveLeague" class="alert alert-warning">
	</div>
	<button class="btn btn-danger btn-lg" id="submitRemoveLeague">Confirm League Deactivation</button>
</div>

<div id="editleague-dialog" title="Edit League Info">
<table>
<input type="hidden" id="editleagueid" name="league_id" value="" />
<tr><td>League Name</td><td><input type="text" id="editleaguename" name="leaguename" value="" /></td></tr>
<tr><td>Sport</td>
<td><select id="editsportid" name="sport_id">
<?php
if ($sportList)
{
	foreach($sportList->result() as $sport)
	{
		echo '<option value="';
		echo $sport->sport_id;
		echo '">' . ucwords($sport->sportname);
		echo '</option>';
	}
}
?>
</select></td></tr>
<tr><td>Tournament Type</td>
<td><select id="edittournamenttype" name="tournamenttype">
	<option value="Unspecified">Unspecified</option>
	<option value="Single Elimination">Single Elimination</option>
	<option value="Double Elimination">Double Elimination</option>
</select></td></tr>
<tr><td>Date </td>
<td><input type="text" id="datepicker2" name="registrationdeadline" value=""></td></tr>
</table>
<div id="tooltipEditLeague">
	<!--<strong>TIP: </strong>Sport names are case insensitive.-->
</div>
<button type="button" class="btn btn-primary" id="submitUpdateLeague">Edit League Details</button>
</div>
