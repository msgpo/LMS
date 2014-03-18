var baseurl = "http://127.0.0.1/LeagueManagementSystem";

// Login Module
function showLoginForm()
{
	//$("#login-dialog").dialog("open");
	$(".notiferror").hide();
	$("#login-dialog").dialog("open");
	$("#username").val(""); 
	$("#password").val("");
}

function checkAccount() {
    var usr = $("#username").val(),
        pwd = $("#password").val();
    $.ajax({
        url: baseurl + "/index.php/login/logging_in/",
        type: "POST",
        data: {
            usrnme: usr,
            pwd: pwd
        },
        dataType: "text",
        async: true,
        success: function (msg) {
            if (msg == 1)
				window.location = baseurl + "/index.php/home/index";
			else
			{
				$("p.notiferror").show();
			}
        }
    });
    return false;
}

// Sport Module
function addSport()
{
	var sportname = $("#sportname").val();
	
	$.ajax({
			type: "POST",
			url: baseurl + "/index.php/sportController/create/",
			data: {
				sportname: sportname
			},
			success: function(msg){
				if (msg == 1)
				{
					$("div#tooltip").removeClass().addClass("alert alert-success");
					$("div#tooltip").html('<strong>SUCCESS: </strong>Sport added.');
				//	$("#addSport").modal('hide');
					location.reload();
				}
				else
				{
					// alert(msg);
					if(!($("div#tooltip").hasClass("alert alert-danger")))
					{
						$("div#tooltip").removeClass().addClass("alert alert-danger");
					}
				
					$("div#tooltip").html('<strong>WARNING: </strong>' + msg);
				}
			},
			error: function(){
				alert("failure");
			}
		});
}

function editSport()
{
	var sportID = $("#sportid").val();
	var sportName = $("#editsportname").val();
	
	$.ajax({
		type: "POST",
		url: baseurl + "/index.php/sportController/update/",
		data: {
			id: sportID,
			sname: sportName
		},
		success: function(msg)
		{
			if (msg == 1)
			{
				$("div#tooltipEdit").removeClass().addClass("alert alert-success");
				$("div#tooltipEdit").html('<strong>SUCCESS: </strong>Sport name successfully edited.');
			//	$("#addSport").modal('hide');
				location.reload();
			}
			else
			{
				if(!($("div#tooltipEdit").hasClass("alert alert-danger")))
				{
					$("div#tooltipEdit").removeClass().addClass("alert alert-danger");
				}
				
				$("div#tooltipEdit").html('<strong>WARNING: </strong>' + msg);
			}
		},
		error: function()
		{
			alert("failure");
		}
	});
}

function removeSport()
{
	var sportID = $("#removesportid").val();
//	var sportName = $("#editsportname").val();
	
	$.ajax({
		type: "POST",
		url: baseurl + "/index.php/sportController/remove/",
		data: {
			sport_id: sportID
		},
		success: function(msg)
		{
			if (msg == 1)
			{
				$("div#tooltipRemove").removeClass().addClass("alert alert-success");
				$("div#tooltipRemove").html('<strong>SUCCESS: </strong>Sport successfully removed.');
			//	$("#addSport").modal('hide');
				location.reload();
			}
			else
			{
				if(!($("div#tooltipRemove").hasClass("alert alert-danger")))
				{
					$("div#tooltipRemove").removeClass().addClass("alert alert-danger");
				}
				
				$("div#tooltipRemove").html('<strong>WARNING: </strong>' + msg);
			}
		},
		error: function()
		{
			alert("failure");
		}
	});
}

function showAddSportForm()
{
	$("#sportname").val("");
	$("#addsport-dialog").dialog("open");
}

function showEditSportForm()
{
	var sportid = $(this).attr("data-sportid");
	var sport_name = $(this).attr("data-sportname");
	$("#editsport-dialog").dialog("open");
	$("#sportid").val(sportid);
	$("#editsportname").val(sport_name);
}

function showRemoveSportDialog()
{
	var sportid = $(this).attr("data-sportid");
	var sport_name = $(this).attr("data-sportname");
	$("#removesport-dialog").dialog("open");
	$("#removesportid").val(sportid);
	// The name will be used in the confirmation box.
	// $("#removesportname").val(sport_name);
	$("div#tooltipRemove").html('Remove ' + sport_name + ' from the list of sports? This cannot be undone.');
}

// League Module
function showAddLeagueForm()
{
	$("#leaguename").val("");
	$("#sportid").val("");
	$("#tournamenttype").val("");
	$("#datepicker").val("");
	$("div#tooltipCreateLeague").removeClass();
	$("div#tooltipCreateLeague").html("");
	$("#addleague-dialog").dialog("open");
	
}

function createLeague()
{
	var leaguename = $("#leaguename").val();
	var sportID = $("#sportid").val();
	var tournamenttype = $("#tournamenttype").val();
	var registrationdeadline = $("#datepicker").val();
	
	$.ajax({
			type: "POST",
			url: baseurl + "/index.php/leagueController/create/",
			data: {
				leaguename: leaguename,
				sport_id: sportID,
				tournamenttype: tournamenttype,
				registrationdeadline: registrationdeadline
			},
			success: function(msg){
				if (msg == 1)
				{
					$("div#tooltipCreateLeague").removeClass().addClass("alert alert-success");
					$("div#tooltipCreateLeague").html('<strong>SUCCESS: </strong>A league has been created.');
				//	$("#addSport").modal('hide');
					location.reload();
				}
				else
				{
					// alert(msg);
					if(!($("div#tooltipCreateLeague").hasClass("alert alert-danger")))
					{
						$("div#tooltipCreateLeague").removeClass().addClass("alert alert-danger");
					}
				
					$("div#tooltipCreateLeague").html('<strong>WARNING: </strong>' + msg);
				}
			},
			error: function(){
				alert("failure");
			}
		});
}

function showRemoveLeagueDialog()
{
	var leagueid = $(this).attr("data-leagueid");
	var league_name = $(this).attr("data-leaguename");
	$("#removeleague-dialog").dialog("open");
	$("#removeleagueid").val(leagueid);
	// The name will be used in the confirmation box.
	// $("#removesportname").val(sport_name);
	$("div#tooltipRemoveLeague").html('Deactivate ' + league_name + '? This cannot be undone.');
}

function removeLeague()
{
	 var leagueID = $("#removeleagueid").val();
	//var leagueID = $(this).attr("data-leagueid");
	
	$.ajax({
			type: "POST",
			url: baseurl + "/index.php/leagueController/deactivateLeague/",
			data: {
				league_id: leagueID
			},
			success: function(msg){
				if (msg == 1)
				{
					$("div#tooltipRemoveLeague").removeClass().addClass("alert alert-success");
					$("div#tooltipRemoveLeague").html('<strong>SUCCESS: </strong>A league has been deactivated.');
				//	$("#addSport").modal('hide');
				//	location.reload();
					window.location = baseurl + "/index.php/leagueController/index";
				}
				else
				{
					// alert(msg);
					if(!($("div#tooltipRemoveLeague").hasClass("alert alert-danger")))
					{
						$("div#tooltipRemoveLeague").removeClass().addClass("alert alert-danger");
					}
				
					$("div#tooltipRemoveLeague").html('<strong>WARNING: </strong>' + msg);
				}
			},
			error: function(){
				alert("failure");
			}
		});
}

function showUpdateLeagueForm()
{
	var leagueid = $(this).attr("data-leagueid");
	var leaguename = $(this).attr("data-leaguename");
	var sportID = $(this).attr("data-sportid");
	var tournament = $(this).attr("data-tournamenttype");
	var regdeadline = $(this).attr("data-registrationdeadline");
	$("#editleague-dialog").dialog("open");
	$("#editleagueid").val(leagueid);
	$("#editleaguename").val(leaguename);
	$("#editsportid option:selected").val(sportID);
	$("#edittournament option:selected").val(tournament);
	$("#datepicker2").val(regdeadline);
}

function updateLeague()
{
	 var leagueID = $("#editleagueid").val();
	 var leaguename = $("#editleaguename").val();
	var sportID = $("#editsportid option:selected").val();
	var tournamenttype = $("#edittournament option:selected").val();
	var regDeadline = $("#datepicker2").val();
	
	$.ajax({
			type: "POST",
			url: baseurl + "/index.php/leagueController/update/",
			data: {
				league_id: leagueID,
				leaguename: leaguename,
				sport_id: sportID,
				tournamenttype: tournamenttype,
				registrationdeadline: regDeadline
			},
			success: function(msg){
				if (msg == 1)
				{
					$("div#tooltipEditLeague").removeClass().addClass("alert alert-success");
					$("div#tooltipEditLeague").html('<strong>SUCCESS: </strong>A league has been updated.');
				//	$("#addSport").modal('hide');
				//	location.reload();
					window.location = baseurl + "/index.php/leagueController/index";
				}
				else
				{
					// alert(msg);
					if(!($("div#tooltipEditLeague").hasClass("alert alert-danger")))
					{
						$("div#tooltipEditLeague").removeClass().addClass("alert alert-danger");
					}
				
					$("div#tooltipEditLeague").html('<strong>WARNING: </strong>' + msg);
				}
			},
			error: function(){
				alert("failure");
			}
		});
}

function cancelSport()
{
	$("#removesport-dialog").dialog( "close" );
	//$this.dialog('close');
}