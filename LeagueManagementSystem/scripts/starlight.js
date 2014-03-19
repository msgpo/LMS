$(function() {

	$("#loading-box").dialog({
		autoOpen: false,
        resizable: false,
		modal: false
	});

	// Login Module
	$("#login-dialog").dialog({
        autoOpen: false,
        resizable: false
    });
	
	$("#login-admin").click(showLoginForm);
	$("#submitLogin").button();
    $("#submitLogin").button().bind("click",
        checkAccount);
		
	// Sport Module
	$("#addsport-dialog").dialog({
		autoOpen: false,
		width: 450,
        height: 300,
        resizable: false,
		modal: false
	});
	$("#editsport-dialog").dialog({
		autoOpen: false,
		width: 450,
        height: 300,
        resizable: false,
		modal: true
	});
	$("#removesport-dialog").dialog({
		autoOpen: false,
		width: 450,
        height: 300,
		resizable: false,
		modal: true
	});
	
	$("#addSportDialog").button();
	$("#addSportDialog").button().bind("click",
        showAddSportForm);
	$("#submitAddSport").button();
	$("#submitAddSport").button().bind("click",
        addSport);
	
	$(".update-sport").button();
	$(".update-sport").button().bind("click", showEditSportForm);
	$("#submitEditSport").button();
	$("#submitEditSport").button().bind("click",
        editSport);
		
	$(".remove-sport").button();
	$(".remove-sport").button().bind("click", showRemoveSportDialog);
	$("#submitRemoveSport").button();
	$("#submitRemoveSport").button().bind("click",
        removeSport);
		
	// League Module
	$("#addleague-dialog").dialog({
		autoOpen: false,
		width: 706,
        height: 350,
        resizable: false,
		modal: true
	});
	
	$("#removeleague-dialog").dialog({
		autoOpen: false,
		width: 706,
        height: 350,
        resizable: false,
		modal: true
	});
	
	$("#editleague-dialog").dialog({
		autoOpen: false,
		width: 706,
        height: 350,
        resizable: false,
		modal: true
	});
	
	$("#create-league").click(showAddLeagueForm);
	$("#submitCreateLeague").button();
	$("#submitCreateLeague").button().bind("click",
        createLeague);
		
	$(".remove-league").button();
	$(".remove-league").button().bind("click", showRemoveLeagueDialog);
	$("#submitRemoveLeague").button();
	$("#submitRemoveLeague").button().bind("click", removeLeague);
	
	$(".update-league").button();
	$(".update-league").button().bind("click", showUpdateLeagueForm);
	$("#submitUpdateLeague").button();
	$("#submitUpdateLeague").button().bind("click", updateLeague);
	
	// Teams
	$("#addteam-dialog").dialog({
		autoOpen: false,
		width: 706,
        height: 520,
        resizable: true,
		modal: true
	});
	
	$("#editteam-dialog").dialog({
		autoOpen: false,
		width: 706,
        height: 520,
        resizable: true,
		modal: true
	});
	
	$("#add-team").click(showAddTeamForm);
	$("#submitAddTeam").button();
	$("#submitAddTeam").button().bind("click", addTeam);
	$(".edit-team").click(showEditTeamForm);
	$("#submitEditTeam").button();
	$("#submitEditTeam").button().bind("click", editTeam);
	
	// global
	$.ajaxSetup({
        beforeSend: function () {
            showDialog && $("#loading-box").dialog("open");
        },
        complete: function () {
            $("#loading-box").dialog("close");
            showDialog || (showDialog = true);
        }
    });
	
	
	// unused
	$("#submitCancelSport").button();
	$("#submitCancelSport").button().bind("click",
        cancelSport);
});