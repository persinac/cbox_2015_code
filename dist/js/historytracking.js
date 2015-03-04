/*{"location":"","user_id":"","data1":"","data2":""}*/
var history = [];

function pushHistory(loc, user_id, data1, data2) {
    history.push({"location":loc,"user_id":user_id,"data1":data1,"data2":data2})
}

function popHistory() {
    history.pop();
}

function goBack() {
    var loc = "";
    var user_id = "";
    var data1 = "";
    var data2 = "";

    var lastIndex = getMaxIndex();
    var json = getHistoryAtIndex(lastIndex);

    loc = json.location;
    user_id = json.user_id;
    data1 = json.data1;
    data2 = json.data2;

    goToLocation(loc, user_id, data1, data2);

    //last
    popHistory();
}

function goToLocation(loc, user_id, data1, data2) {
    if(loc == "profile") {
        getUserInfo(user_id);
    } else if(loc == "calendar") {
        buildCalendarPage();
        renderCalendar(user_id, false);
        getNotifications(user_id);
    } else if(loc == "challenges") {
        if($("#nav_challenges").hasClass('notification')) {
            listChallenges(user_id, 1);
            $("#nav_challenges").removeClass('notification');
        } else {
            listChallenges(user_id, 0);
        }
    } else if(loc == "leaderboard") {
        //openRegistration();
    } else if(loc == "social") {
        getUsers(user_id);
    } else if(loc == "msgboard") {
        buildMessageboard();
    } else if(loc == "activityfeed") {
        buildActivityFeed();
    }
}

function getMaxIndex() {
    return history.length - 1;
}

function getHistoryAtIndex(index) {
    var json = {"loc":history[index].location,"user_id":history[index].user_id,
        "data1":history[index].data1,"data2":history[index].data2};
    return json;
}