var baseurl = "http://127.0.0.1/LeagueManagementSystem",
	showDialog = true;

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
					window.location = baseurl + "/index.php/sportController/index";
				}
				else
				{
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
				window.location = baseurl + "/index.php/sportController/index";
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
				window.location = baseurl + "/index.php/sportController/index";
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
//	$("#sportid").val("");
//	$("#tournamenttype").val("");
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
					window.location = baseurl + "/index.php/leagueController/index";
				}
				else
				{
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
	$("#editsportid").val(sportID);
	$("#edittournamenttype").val(tournament);
	$("#datepicker2").val(regdeadline);
}

function updateLeague()
{
	 var leagueID = $("#editleagueid").val();
	 var leaguename = $("#editleaguename").val();
	var sportID = $("#editsportid option:selected").val();
	var tournamenttype = $("#edittournamenttype option:selected").val();
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
					window.location = baseurl + "/index.php/leagueController/viewLeagueInfo/"+leagueID;
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

function reactivateLeague()
{
	 var leagueID = $(this).attr("data-reactleagueid");
	
	$.ajax({
			type: "POST",
			url: baseurl + "/index.php/leagueController/reactivateLeague/",
			data: {
				league_id: leagueID
			},
			success: function(msg){
					window.location = baseurl + "/index.php/leagueController/index";
			},
			error: function(){
				alert("failure");
			}
		});
}

// Teams

function showAddTeamForm()
{
	var leagueid = $(this).attr("data-leagueid");
	$("#addteam-leagueid").val(leagueid);
	$("#addteam-dialog").dialog("open");
}

function addTeam()
{
	var leagueID = $("#addteam-leagueid").val();
	var teamName = $("#addteam-teamname").val();
	var teamDesc = $("#addteam-teamdesc").val();
	var teamCoachSurname = $("#addteam-surname").val();
	var teamCoachFirstName = $("#addteam-firstname").val();
	var teamCoachPhone = $("#addteam-coachphone").val();

	$.ajax({
			type: "POST",
			url: baseurl + "/index.php/teamController/create/",
			data: {
				league_id: leagueID,
				teamname: teamName,
				coachlastname: teamCoachSurname,
				coachfirstname: teamCoachFirstName,
				coachphonenumber: teamCoachPhone,
				teamdesc: teamDesc
			},
			success: function(msg){
				if (msg == 1)
				{
					window.location = baseurl + "/index.php/leagueController/viewLeagueInfo/" + leagueID;
				}
				else
				{
					// alert(msg);
					if(!($("div#tooltipAddTeam").hasClass("alert alert-danger")))
					{
						$("div#tooltipAddTeam").removeClass().addClass("alert alert-danger");
					}
				
					$("div#tooltipAddTeam").html('<strong>WARNING: </strong>' + msg);
				}
			},
			error: function(){
				alert("failure");
			}
	});
}

function showEditTeamForm()
{
	var leagueid = $(this).attr("data-leagueid");
	var teamid = $(this).attr("data-teamid");
	var teamname = $(this).attr("data-teamname");
	var teamdesc = $(this).attr("data-teamdesc");
	var coachSurname = $(this).attr("data-coachsurname");
	var coachFirstname = $(this).attr("data-coachfirstname");
	var coachPhone = $(this).attr("data-coachphone");
	$("#editteam-leagueid").val(leagueid);
	$("#editteam-teamid").val(teamid);
	$("#editteam-teamname").val(teamname);
	$("#editteam-teamdesc").val(teamdesc);
	$("#editteam-surname").val(coachSurname);
	$("#editteam-firstname").val(coachFirstname);
	$("#editteam-coachphone").val(coachPhone);
	$("#editteam-dialog").dialog("open");
}

function editTeam()
{
	var leagueID = $("#editteam-leagueid").val();
	var teamID = $("#editteam-teamid").val();
	var teamName = $("#editteam-teamname").val();
	var teamDesc = $("#editteam-teamdesc").val();
	var teamCoachSurname = $("#editteam-surname").val();
	var teamCoachFirstName = $("#editteam-firstname").val();
	var teamCoachPhone = $("#editteam-coachphone").val();

	$.ajax({
			type: "POST",
			url: baseurl + "/index.php/teamController/update/",
			data: {
				league_id: leagueID,
				team_id: teamID,
				teamname: teamName,
				coachlastname: teamCoachSurname,
				coachfirstname: teamCoachFirstName,
				coachphonenumber: teamCoachPhone,
				teamdesc: teamDesc
			},
			success: function(msg){
				if (msg == 1)
				{
					window.location = baseurl + "/index.php/leagueController/viewLeagueInfo/" + leagueID;
				}
				else
				{
					// alert(msg);
					if(!($("div#tooltipEditTeam").hasClass("alert alert-danger")))
					{
						$("div#tooltipEditTeam").removeClass().addClass("alert alert-danger");
					}
				
					$("div#tooltipEditTeam").html('<strong>WARNING: </strong>' + msg);
				}
			},
			error: function(){
				alert("failure");
			}
	});
}

function showRemoveTeamDialog()
{
	$("#removeteam-dialog").dialog("open");
	var leagueid = $(this).attr("data-leagueid");
	var teamid = $(this).attr("data-teamid");
	var team_name = $(this).attr("data-teamname");
	$("#removeteam-leagueid").val(leagueid);
	$("#removeteam-teamid").val(teamid);
	$("#removeteam-teamname").val(team_name);
	// The name will be used in the confirmation box.
	// $("#removesportname").val(sport_name);
	$("div#tooltipRemoveTeam").html('Remove ' + team_name + ' from this league\'s participants? This cannot be undone.');
}

function removeTeam()
{
	 var leagueID = $("#removeteam-leagueid").val();
	 var teamID = $("#removeteam-teamid").val();
	
	$.ajax({
			type: "POST",
			url: baseurl + "/index.php/teamController/removeTeam/",
			data: {
				league_id: leagueID,
				team_id: teamID
			},
			success: function(msg){
				if (msg == 1)
				{
					window.location = baseurl + "/index.php/leagueController/viewLeagueInfo/" + leagueID;
				}
				else
				{
					// alert(msg);
					if(!($("div#tooltipRemoveTeam").hasClass("alert alert-danger")))
					{
						$("div#tooltipRemoveTeam").removeClass().addClass("alert alert-danger");
					}
				
					$("div#tooltipRemoveTeam").html('<strong>WARNING: </strong>' + msg);
				}
			},
			error: function(){
				alert("failure");
			}
		});
}

function showSetWinnerDialog()
{
	var leagueID = $(this).attr("data-swleagueid");
	var matchID = $(this).attr("data-swmatchid");
	var homeTeamID = $(this).attr("data-swhometeamid");
	var visitorTeamID = $(this).attr("data-swvisitorteamid");
	var homeTeamName = $(this).attr("data-swhometeamname");
	var visitorTeamName = $(this).attr("data-swvisitorteamname");
	$("#setwinner-leagueid").val(leagueID);
	$("#setwinner-matchid").val(matchID);
	var home = $('<option></option>').attr("value", homeTeamID).text(homeTeamName + " (Home)");
	var visitor = $('<option></option>').attr("value", visitorTeamID).text(visitorTeamName + " (Visitor)");
	$("#winner").empty().append(home).append(visitor); 
	$("#setWinnerDialog").dialog("open");
}

function submitWinner()
{
	var leagueID = $("#setwinner-leagueid").val();
	var matchID = $("#setwinner-matchid").val();
	var winnerID = $("#winner").val();
	
	$.ajax({
			type: "POST",
			url: baseurl + "/index.php/tournamentController/updateMatch/",
			data: {
				league_id: leagueID,
				match_id: matchID,
				winner: winnerID
			},
			success: function(msg){
				//location.reload();
					window.location = baseurl + "/index.php/tournamentController/viewTournament/" + leagueID;
			},
			error: function(){
				alert("failure");
			}
		});
	// alert(winnerID);
}

function cancelSport()
{
	$("#removesport-dialog").dialog( "close" );
	//$this.dialog('close');
}