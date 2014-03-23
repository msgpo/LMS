/** Global variables:
 *   baseurl = can be changed to whatever the server's root is located
 *   showDialog = for dialog checkers
 *   prevModule = checking for the previous module accessed before doing something
 *   repeat = checks if the ajax call should repeat all the time. Set this to true before doing any ajax call then set this to false after the operation is complete
 *   loggedin = if the user is logged in or not
 *
 */
var baseurl = "http://127.0.0.1/LMS-fullajax",
	showDialog = true,
	prevModule = "",
	repeat = false,
	repeatSport = false,
	loggedin = false;

window.onload = function() {
	repeat = true;
	checkLoggedIn();
	loadHomePanel();
}

// Argh, duplicated codes! Some functions are made here to avoid it.
function setMasthead(mastheadID, moduleTitle, moduleDesc)
{
	$("div#masthead").html('<div id="' + mastheadID + '"><div class="container"><br /><h1>' + moduleTitle + '</h1><h2>' + moduleDesc +'</h2><div class="row"><br><br><br><div class="col-lg-6 col-lg-offset-3"></div></div></div><!-- /container --></div><!-- /headerwrap -->');
}

function setPagePrimaryTitle(pageTitle)
{
	$("h1#pagetitle").html(pageTitle);
}

function setPageContent(content)
{
	$("div#pagecontent").html(content);
}

function setFirstTableOptions(content)
{
	$("div#tableoneoptions").html(content);
}

// Login Module
function showLoginForm()
{
	if (loggedin == false)
	{
		// The user is not logged in
	$(".notiferror").hide();
	$("#login-dialog").dialog("open");
	$("#username").val(""); 
	$("#password").val("");
	}
	else
	{
		// The user is logged in
		logoutThis();
	}
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
			{
				loggedin = true;
				$("#login-dialog").dialog("close");
				console.log(loggedin);
				//checkLoggedIn()
				loadHomePanel();
				repeat = true;
				checkLoggedIn();
			}	
			else
			{
				$("p.notiferror").show();
			}
        }
    });
    return false;
}

function loadHomePanel()
{
	if (loggedin == true)
	{
		// LM view
		setMasthead("homewrap","League Management System","User Control Panel");
		setPagePrimaryTitle("Welcome to your control panel");
		setPageContent("Lorem ipsum dolor sit amet, consectetur adipiscing elit. In malesuada vel tellus sed commodo. Sed pretium sapien in odio aliquet cursus. Ut eget vestibulum mi. Sed pharetra at nisi non tincidunt. Sed eget facilisis enim. Aliquam erat volutpat. Nulla mollis, justo sed dictum mattis, nisi augue volutpat sapien, quis congue ligula nulla quis urna.");
	}
	else
	{
		// Guest view
		setMasthead("homewrap","League Management System","");
		setPagePrimaryTitle("G'day, Sports Enthusiast!");
		setPageContent("Bacon ipsum dolor sit amet ut landjaeger brisket, tempor bacon adipisicing short ribs cillum. T-bone in eu pariatur frankfurter, brisket in jerky laboris do pork loin. Biltong culpa in, fatback nulla meatball aliqua officia. Nostrud aliquip ham hock flank, cow mollit jerky tenderloin enim velit meatloaf pork loin. Fatback turducken consequat, jowl spare ribs boudin sausage brisket ham incididunt meatball strip steak in. Chuck consectetur chicken aliqua sausage. Occaecat flank pig elit meatball shank shankle chuck ut sed bacon.");
	}
	$("div#tableshere").html("");
	setFirstTableOptions("");
	prevModule = "home";
	repeat = false;
	checkLoggedIn();
	repeat = false;
}

function checkLoggedInHelper()
{
	$.ajax({
                type: 'get',
                dataType: 'text',
                url: baseurl + "/index.php/login/checkSetUsername",
                success: function(response) 
				{
					(response == 1) ? loggedin = true : loggedin = false;
//					console.log(loggedin);
					(loggedin == true) ? $("#login-admin").text("Logout") : $("#login-admin").text("Login");
					
					if (prevModule == "home")
					{
						loadHomePanel();
					}
					if (prevModule == "sport")
					{
						loadSportModule();
					}
					console.log(repeat);
					repeat = false;
					console.log(repeat);
                },
                error: function() 
				{
					alert("failure");
                }
        })
}

function checkLoggedIn()
{
	if (repeat == true)
	{
		setTimeout(function() {
			checkLoggedInHelper();
			}, 1000);
		repeat = false;
	}
}

function logoutThis()
{
	$.ajax({
        url: baseurl + "/index.php/login/logout/",
        type: "post",
        dataType: "text",
        async: true,
        success: function (msg) {
           // alert(msg);
		   repeat = true;
			checkLoggedIn();
			loadHomePanel();
        },
		error: function()
		{
			alert("failure");
		}
    });
}

// Sport Module
function loadSportModule()
{
	setMasthead("sportwrap","Sports","The list of sports to be used in leagues are here.");
	$("h1#pagetitle").html('Sport Listing');
	var searchbox = '<input type="text" id="sportsearch" name="search" value="" />';
	var searchbutton = '<button class="btn btn-primary" id="searchSport">Search</button><br />';
	//$("div#pagecontent").html(searchbox + searchbutton);
	setPageContent(content);
	$("div#tableshere").html("<table class=\"table table-hover\" id=\"table\"><tr><th>Sport Name</th><th></th></tr></table>");
	setFirstTableOptions("<button class=\"btn btn-primary btn-lg\" id=\"addSportDialog\" onclick=\"showAddSportForm();\">Add New Sport</button>");
	repeatSport = true;
	getSports();
	prevModule = "sport";
	checkLoggedIn();
	repeatSport = false;
}

function getSportsHelper()
{
	$.ajax({
                type: 'get',
                dataType: 'json',
				//data: {sportname: sportnametosearch},
                url: baseurl + "/index.php/sportController/getSports",
                success: function(response) 
				{
                    if(response)
					{
						var len = response.length;
						var txt = "";
						if(len > 0)
						{
							for(var i=0;i<len;i++)
							{
								if(response[i].sportname && response[i].sport_id)
								{
									if (loggedin == true)
									{
										// LM is logged in
									//	txt += '<tr><td>'+response[i].sportname+'</td><td><button class="btn btn-info btn-lg update-sport" id="updateSport" data-sportid="'+response[i].sport_id+'" data-sportname="' + response[i].sportname + '">Edit</button></td></tr>';
									txt += '<tr><td>'+response[i].sportname+'</td><td><button class="btn btn-info btn-lg update-sport" id="updateSport" data-sportid="'+response[i].sport_id+'" onclick="showEditSportForm(' + response[i].sport_id + ', \'' + response[i].sportname +'\');" data-sportname="' + response[i].sportname + '">Edit</button><button class="btn btn-danger btn-lg remove-sport" id="removeSport" onclick="showRemoveSportDialog(' + response[i].sport_id + ', \'' + response[i].sportname + '\');" data-sportid="'+response[i].sport_id+'" data-sportname="'+ response[i].sportname +'">Remove</button></td></tr>';
									
									}
									else
									{
										// LM is not logged in
										txt += "<tr><td>"+response[i].sportname+"</td><td></td></tr>";
									}
								}
							}
							if(txt != "")
							{
								$("table#table").append(txt);
							}
						}		
						
					}
					repeatSport = false;
                },
                error: function(xhr, status, error) {
                alert("failure");
                }
            });
}

function getSports()
{
	if (repeatSport == true)
	{
		setTimeout(function() {
			getSportsHelper();
			}, 1000);
		repeatSport = false;
	}
//	return false;
}

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
					loadSportModule();
					$("#addsport-dialog").dialog("close");
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
				loadSportModule();
				$("#editsport-dialog").dialog("close");
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
				loadSportModule();
				$("#removesport-dialog").dialog("close");
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

function showEditSportForm(sportid, sportname)
{
	//var sportid = $(this).attr("data-sportid");
	//var sport_name = $(this).attr("data-sportname");
	var sportid = sportid;
	var sport_name = sportname;
	$("div#tooltip").removeClass().html("");
	$("#editsport-dialog").dialog("open");
	$("#sportid").val(sportid);
	$("#editsportname").val(sport_name);
}

function showRemoveSportDialog(sportid, sportname)
{
	var sportid = sportid;
	var sport_name = sportname;
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