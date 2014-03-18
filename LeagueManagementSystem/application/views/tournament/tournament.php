<!--<h2>Tournament</h2>-->
<div id="w">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
				<h3>
				<?php
					if ($winnerQuery->num_rows() > 0)
					echo 'Congratulations to ' . ucwords($winnerQuery->row()->teamname) . ' for winning this league.';
				?>
				</h3>
				</div>
			</div>
		</div><!-- /container -->
	</div><!-- /w -->
<?php
//	if ($winnerQuery->num_rows() > 0)
//		echo '<p>Winner: ' . ucwords($winnerQuery->row()->teamname) . '</p>';
	

	// $round=1;
	echo '<table class="table table-hover">';
	echo '<tr>';
	echo '<th>Home</th><th> </th><th>Visitor</th><th>Round</th>';
//	$match = $matches->result();
	if ($matches->bracket) echo '<th>Bracket</th>';
	echo '<th>Options</th>';
	echo '</tr>';
	foreach($matches->result() as $match)
	{
		$teamAName = "";
		$teamBName = "";
		
		if ($match->team_a)
		{
			$teamAQuery = $this->teamList->getTeamById($match->team_a);
			$teamAName = $teamAQuery->row()->teamname;
		}
		if ($match->team_b)
		{
			$teamBQuery = $this->teamList->getTeamById($match->team_b);
			$teamBName = $teamBQuery->row()->teamname;
		}
		if ($teamAName && $teamBName)
		{
			echo '<tr><td>';
			echo ucwords($teamAName);
			echo '</td><td>';
			if ($match->team_a == $match->winner)
				echo ' > ';
			else if ($match->team_b == $match->winner)
				echo ' < ';
			else
				echo ' VS ';
			echo '</td><td>';
			echo ucwords($teamBName);
			echo '</td>';
		}
		if (!$teamAName && $teamBName)
			echo '<tr><td>To be determined</td><td> VS </td><td>'.ucwords($teamBName).'</td>';
		if ($teamAName && !$teamBName)
			echo '<tr><td>'.ucwords($teamAName).'</td><td> VS </td><td>To be determined</td>';
		if (!$teamAName && !$teamBName)
			echo '<tr><td>To be determined</td><td> VS </td><td>To be determined</td>';
		echo '<td>'.$match->roundnumber.'</td>';
		if ($match->bracket == "w")
			echo '<td>Winner\'s Bracket</td>';
		if ($match->bracket == "l")
			echo '<td>Loser\'s Bracket</td>';
		if (($teamAName && $teamBName) && !$match->winner)
			echo '<td><button class="btn btn-info btn-lg" id="setWinnerModal" data-toggle="modal" data-target="#setWinner'.$match->league_id.'-'.$match->match_id.'">Set Winner</button></td>';
		else
			echo '<td></td>';
		echo '</tr>';	
?>

<script>
// Edit/Remove goes here
$(document).ready(function()
{	
	//Set Winner
	$("button#submitWinner<?php echo $match->league_id; ?>-<?php echo $match->match_id; ?>").click(function()
	{
		$.ajax(
		{
			type: "POST",
			url: "<?php echo base_url(); ?>index.php/tournamentController/updateMatch/",
		//	data: $('form.setwinner').serialize(),
			data:
				{
					league_id: <?php echo $match->league_id; ?>,
					match_id: <?php echo $match->match_id; ?>,
					winner: $("select#desiredWinner<?php echo $match->league_id; ?>-<?php echo $match->match_id; ?>").val()
				}, 
			success: function(msg){
				$("#form-content").modal('hide');
				location.reload();
				return;
			}, */
			alert(msg);
			},
			error: function(){
				alert("failure");
			}
		//	return false;
		});
	});
});
</script>

<!-- Modals -->
<div class="modal fade" id="setWinner<?php echo $match->league_id; ?>-<?php echo $match->match_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Set The Winner</h4>
      </div>
      <div class="modal-body">
		<form class="setwinner">
			<input type="hidden" id="league" name="league_id" value="<?php echo $match->league_id; ?>" />
			<input type="hidden" id="match" name="match_id" value="<?php echo $match->match_id; ?>" /> 
			<select name="winner" id="desiredWinner<?php echo $match->league_id; ?>-<?php echo $match->match_id; ?>">
				<option value="<?php echo $match->team_a; ?>"><?php echo ucwords($teamAName); ?></option>
				<option value="<?php echo $match->team_b; ?>"><?php echo ucwords($teamBName); ?></option>
			</select>
		</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="submitWinner<?php echo $match->league_id; ?>-<?php echo $match->match_id; ?>">Set Winner</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	  </div>
    </div>
  </div>
</div>


<?php
	}
	echo '</table>';
?>