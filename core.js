var date;
var day;
var month;
var year;
var user;
var loggedin;
var needssetup;
var courseList = new Array();
var session = new Array();
var onContent = 0;

function init(){
	var d = new Date();
	date = d.getDate();
	day= d.getDay();
	month = d.getMonth();
	year = d.getFullYear();
	
	
}

init();

function handleResize(){
	var sidebarwidth = window.innerWidth / 100 * 33;
	var newwidth = window.innerWidth;
	if(sidebarwidth < 471){
		newwidth -= 480;
	}else{
		newwidth -= sidebarwidth;
		newwidth -= 10;
	}
	document.getElementById("main").style.width = newwidth+ "px";
	document.getElementById("calendar").style.width = newwidth+ "px";
	document.getElementById("coursemenu").style.width = newwidth+ "px";
	document.getElementById("assignmenu").style.width = newwidth+ "px";
	document.getElementById("settings").style.width = newwidth+ "px";
}

window.onresize = function(event) {
	handleResize();
}

function getSession(){
	return $.ajax({
        url : 'getSession.php',
        type : 'POST',
        dataType : 'json',
        success : function (result) {
			user = result['username'];
			loggedin = result['loggedin'];
			needssetup = result['setup'];
			console.log("Logged in as user " + user);
			console.log(result);
        },
        error : function () {
           alert("Error 1001. Please notify the developer.");
        }
    })
}

var currentFeature;

function setUI(newfeature){
	if(currentFeature == newfeature){
		return 0;
	}
	console.log("currentFeature is " + currentFeature);
	contentOut(currentFeature);

	currentFeature = newfeature;
	console.log("Setting currentFeature to " + currentFeature);
	contentIn(currentFeature);
}

function UISwap(){
	var sidebarwidth = window.innerWidth / 100 * 33;
	var newwidth = window.innerWidth;
	if(sidebarwidth < 471){
		newwidth -= 471;
	}else{
		newwidth -= sidebarwidth;
		newwidth -= 24;
	}
	cancelOnFlyCourse();
	cancelOnFlyWork();
	document.getElementById("main").style.width = newwidth + 24 + "px";
	document.getElementById("calendar").style.width = newwidth+ "px";
	document.getElementById("coursemenu").style.width = newwidth+ "px";
	document.getElementById("assignmenu").style.width = newwidth+ "px";
	document.getElementById("settings").style.width = newwidth+ "px";
	//Directs users who have Javascript disabled
	document.getElementById("nojs").style.height="0px";
	document.getElementById("nojs").innerHTML="";
	document.getElementById("nojs").style.visibility="hidden";
	//Checks if logged in
	handleResize();
	getSession().done(function(){
	if(loggedin == "1" && user != "null" && user != ""){
		
		console.log("Loggedin = " + loggedin);
		if(needssetup == 1){
			console.log("No userdata directory. Showing setup options.");					
			document.body.removeChild(document.getElementById("login"));
			document.getElementById("setup").style.visibility = "visible";
		}else{
			update();
			document.body.removeChild(document.getElementById("login"));
			document.body.removeChild(document.getElementById("setup"));
			currentFeature="calendar";
			console.log("Userdata available. Showing main screen.");
			getCalendar();
			mainScreenIn();
			onContent = 1;
		}
	}else{
		logBoxIn();
	}
	});
}

function changeMonth(amount){
	month += amount;
	if(month == 12){
		year++;
		month = 0;
	}
	if(month == -1){
		year--;
		month = 11;
	}
	getCalendar();
}

function getCourseNames(isNewSystem){

	if(isNewSystem == 1){
		var senddata = "";
	}else{
		var senddata = "useOld";
	}
	
	return $.ajax({
        url : 'getInfo.php',
        type : 'POST',
        dataType : 'json',
		data: {command: "showCourses",
				extradata: senddata
				},
        success : function (result) {
			courseList = courseList.concat(result);
			console.log(courseList);
        },
        error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);		alert("Previous 2 errors in getCourseNames()");
      	}
    })
}

function getCalendar(){
	tmpmonth = month+1;
	return $.ajax({
        url : 'getInfo.php',
        type : 'POST',
		data: {command: "showCal",
				extradata: tmpmonth+":"+(year)
				},
        success : function (result) {
        	document.getElementById("calendar").innerHTML=result;
        	document.getElementById("calMonthLabel").innerHTML = "<p style='font-size:38px;display:table;margin-left:auto;margin-right:auto;margin-top:-10px;'>" + textMonth() + "</p>";

        },
        error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);		alert("Previous 2 errors in getCalendar");
      	}
    })
}

function checkPinnedCourses(x){
	$.ajax({
	        url : 'getInfo.php',
	        type : 'POST',
	        dataType : 'json',
			data: {command: "showPinnedCourses",
					extradata: x
					},
	        success : function (result) {
	        	if(x == 1){
	        	document.getElementById("pinnedCourses").innerHTML = result;
	        	}
	        	if(x == 0){
	        	document.getElementById("unpinnedCourses").innerHTML = result;
	        	}
	        },
	        error: function (xhr, ajaxOptions, thrownError) {
	        alert(xhr.status);
	        alert(thrownError);			alert("Previous 2 errors in checkPinnedCourse()");
	      	}
	    })
}
function showAllAssignments(){
	$.ajax({
	        url : 'getInfo.php',
	        type : 'POST',
	        dataType : 'json',
			data: {command: "showAllAssignments"
					},
	        success : function (result) {
				document.getElementById("worktarget").innerHTML = result;
	        },
	        error: function (xhr, ajaxOptions, thrownError) {
	        alert(xhr.status);
	        alert(thrownError);			alert("Previous 2 errors in showAllAssignments()");
	      	}
	    })
}
function update(){
	document.getElementById("headerday").innerHTML=date;
	document.getElementById("headerdate").innerHTML=textDay() + ", " + textMonth() + " " + date;
	if(loggedin){
		for(var x = 0;x<2;x++){
			checkPinnedCourses(x);
		}
		showAllAssignments();
	}

}

function textDay(){
	switch(day){
		case 0: return "Sunday"; break;
		case 1: return "Monday"; break;
		case 2: return "Tuesday"; break;
		case 3: return "Wednesday"; break;
		case 4: return "Thursday"; break;
		case 5: return "Friday"; break;
		case 6: return "Saturday"; break;
	}
}

function textMonth(){
	switch(month){
		case 0: return "January"; break;
		case 1: return "February"; break;
		case 2: return "March"; break;
		case 3: return "April"; break;
		case 4: return "May"; break;
		case 5: return "June"; break;
		case 6: return "July"; break;
		case 7: return "August"; break;
		case 8: return "September"; break;
		case 9: return "October"; break;
		case 10: return "November"; break;
		case 11: return "December"; break;
	}
}

function isLeapYear(y){
	if(y%400 == 0){
		return true;
	}else if(y%100 == 0){
		return false;
	}else if(y%4 == 0){
		return true;
	}else{
		return false;
	}
}

function DaysInMonth(m, y){
	if(m == 2){
		if(isLeapYear(y)){
			return 29;
		}else{
			return 28;
		}
		
	}else if (m == 11 || m == 4 || m == 6 || m == 9){
		return 30;
	}else{
		return 31;
	}
}

function dayOfYear(y, m, d){
	c=0;
	for(x=1; x<m; x++){
		c += DaysInMonth(x, y);
	}
	c += d;
	
	return c;
}

function dayOfWeek(y, m, d){
	w = 1;	
	y = (y-1)%400 + 1;
	leap = (y-1)/4;
	leap = leap - (y-1)/100;
	leap = leap + (y-1)/400;
	
	reg = y - 1 - leap;
	
	w = w + reg;
	w = w + 2*leap;
	
	w = w + dayOfYear(y, m, d);
	w = (w)%7 + 1;
	return w;
}

/*Login Code*/
function loginscript(event){
	event.preventDefault();

	$.ajax({
        url : 'login.php',
        type : 'POST',
        dataType : 'json',
		data: {username: document.getElementById("loginUname").value,
				password: document.getElementById("loginPass").value
				},
        success : function (result) {
			if(result == "success"){
				UISwap();
			}
			else{
				document.getElementById("logerror").style.visibility="visible";
				document.getElementById("logerror").innerHTML=result;
			}
		},
        error : function () {
           alert("Error 1002. Please notify the developer.");
        }
    })
	
	return 0;
}

function registerscript(event){
	event.preventDefault();
	
	return $.ajax({
        url : 'register.php',
        type : 'POST',
        dataType : 'json',
		data: {username: document.getElementById("regUname").value,
				pass1: document.getElementById("regPass").value,
				pass2: document.getElementById("regPass2").value
				},
        success : function (result) {
			if(result == "success"){
			setTimeout(function (){

             //something you want delayed

				UISwap();
			 }, 500);
			}
			else{
				document.getElementById("logerror").style.visibility="visible";
				document.getElementById("logerror").innerHTML=result;
			}
        },
        error : function () {
           alert("Error 1003. Please notify the developer.");
        }
    })
}

function writeCourseNames(senddata){
	return $.ajax({
        url : 'getInfo.php',
        type : 'POST',
		data: {command: "writeCourses",
				extradata: senddata
				},
        success : function (result) {
			console.log(courseList);
        },
        error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);		alert("Previous 2 errors in writeCourseNames()");
      	}
    })
}

/*Setup Code*/
var setuppage = 1;
var setupimport;

function checkToNum(id){
	if(document.getElementById(id).checked){
		return 1;
	}else{
		return 0;
	}
}

var numCourse = 0;

function setupAdv(){
	if(setuppage == 1){
		setuppage += 1;
		//Not actually sure if ++ works here
		setupimport = document.getElementById("checkboxImport").checked;
		document.getElementById("stpmark1").className = "stpmarku";
		document.getElementById("stpmark2").className = "stpmarks";
		document.getElementById("stpimport").parentNode.removeChild(document.getElementById("stpimport"));
		document.getElementById("stplist").style.display="table";

		if(setupimport){
			console.log("Importing");
			getCourseNames(0).done(function(){
				for(var tmpcourse in courseList){
					numCourse += 1;
					document.getElementById("stpAllNewCourses").innerHTML += "<br /><input type='text' id='stpCourse"+numCourse+"' style='width:300px;margin-right:auto;margin-left:auto;' value='" + courseList[numCourse-1] + "'/>"
				}
			});
		}
	}else if(setuppage == 2){
		setuppage += 1;
		for(var x = 0;x<numCourse;x+=1){
			var tmpname = document.getElementById("stpCourse"+x).value;
			courseList.push(tmpname);
			document.getElementById("stptable").innerHTML += "<tr><td>" + tmpname + "</td><td><input style='display:table;margin-left:auto;margin-right:auto;' type='checkbox' id='"+x+"mon'></input></td><td><input style='display:table;margin-left:auto;margin-right:auto;' type='checkbox' id='"+x+"tue'></input></td><td><input style='display:table;margin-left:auto;margin-right:auto;' type='checkbox' id='"+x+"wed'></input></td><td><input style='display:table;margin-left:auto;margin-right:auto;' type='checkbox' id='"+x+"thu'></input></td><td><input style='display:table;margin-left:auto;margin-right:auto;' type='checkbox' id='"+x+"fri'></input></td></tr>";
		}

		document.getElementById("stpmark2").className = "stpmarku";
		document.getElementById("stpmark3").className = "stpmarks";
		document.getElementById("stplist").parentNode.removeChild(document.getElementById("stplist"));
		document.getElementById("stpplot").style.display="table";
	}else if(setuppage == 3){
		setuppage += 1;

		for(var x = 0;x<numCourse;x+=1){
			var bonus;
			if(numCourse <= 10){
				bonus = "1/i/";
			}else{
				bonus = "0/i/";
			}
			/*
			Name Mon Tue Wed Thur Fri Pin ID
			*/
			writeCourseNames(courseList[x] + "/i/"+ checkToNum(x+"mon") + "/i/" + checkToNum(x+"tue") + "/i/" + checkToNum(x+"wed") + "/i/" + checkToNum(x+"thu") + "/i/" + checkToNum(x+"fri") + "/i/" + bonus);
		}

		document.getElementById("stpmark3").className = "stpmarku";
		document.getElementById("stpmark4").className = "stpmarks";
		document.getElementById("stpplot").parentNode.removeChild(document.getElementById("stpplot"));
		document.getElementById("stpfinal").style.display="table";
	}else if(setuppage == 4){
		document.getElementById("setup").parentNode.removeChild(document.getElementById("setup"));
	}
}

function stpNewCourse(){
	console.log("course added");
	var input = document.createElement('input'); 
	input.type = "text"; 
	input.id = "stpCourse" + numCourse;
	input.style = 'width:300px;margin-right:auto;margin-left:auto;';
	document.getElementById("stpAllNewCourses").appendChild(input);
	numCourse += 1;
}

function submitOnFlyCourse(){
	var writeVal = document.getElementById("name").value + "/i/" + checkToNum("mon") + "/i/" + checkToNum("tue") + "/i/" + checkToNum("wed") + "/i/" + checkToNum("thu") + "/i/" + checkToNum("fri")+"/i/1/i/";
	writeCourseNames(writeVal).done(function(){
		update();
		coursesIn();
		document.getElementById("newcoursetarget").style.height="0px";
		document.getElementById("newcoursetarget").innerHTML="";
	});
}


var addcourseonfly = '<table border="0" style="float:left;width:500px;font-size:16px;height:75px">\
	<tr>\
	<td style="width:20%;padding:0px;height:20px"><p style="display:table;margin-left:auto;margin-right:auto;margin-top: 0px;margin-bottom:0px;">Name</p></td>\
	<td style="width:15%;padding:0px;height:20px"><p style="display:table;margin-left:auto;margin-right:auto;margin-top: 0px;margin-bottom:0px;">Monday</p></td>\
	<td style="width:15%;padding:0px;height:20px"><p style="display:table;margin-left:auto;margin-right:auto;margin-top: 0px;margin-bottom:0px;">Tuesday</p></td>\
	<td style="width:15%;padding:0px;height:20px"><p style="display:table;margin-left:auto;margin-right:auto;margin-top: 0px;margin-bottom:0px;">Wednesday</p></td>\
	<td style="width:15%;padding:0px;height:20px"><p style="display:table;margin-left:auto;margin-right:auto;margin-top: 0px;margin-bottom:0px;">Thursday</p></td>\
	<td style="width:15%;padding:0px;height:20px"><p style="display:table;margin-left:auto;margin-right:auto;margin-top: 0px;margin-bottom:0px;">Friday</p></td>\
	</tr>\
	<tr><td><input style="display:table;margin-left:auto;margin-right:auto;" type="text" id="name"></input></td><td><input style="display:table;margin-left:auto;margin-right:auto;" type="checkbox" id="mon"></input></td><td><input style="display:table;margin-left:auto;margin-right:auto;" type="checkbox" id="tue"></input></td><td><input style="display:table;margin-left:auto;margin-right:auto;" type="checkbox" id="wed"></input></td><td><input style="display:table;margin-left:auto;margin-right:auto;" type="checkbox" id="thu"></input></td><td><input style="display:table;margin-left:auto;margin-right:auto;" type="checkbox" id="fri"></input></td></tr>\
</table>\
<input type="submit" onclick="submitOnFlyCourse()"style="float:left;margin-top:18px;" value="Submit">\
</input>\
<button onclick="cancelOnFlyCourse()"style="float:left;margin-top:18px;">Cancel</button>';

function cancelOnFlyCourse(){
	document.getElementById("newcoursetarget").innerHTML="";
		document.getElementById("newcoursetarget").style.height="0px";
}
function cancelOnFlyWork(){
		document.getElementById("newworktarget").style.height="0px";
		document.getElementById("newworktarget").innerHTML="";
}
function getCourseOptions(){
		return $.ajax({
        url : 'getInfo.php',
        type : 'POST',
		data: {command: "courseOptions"
				},
        success : function (result) {

		document.getElementById("class").innerHTML = result;
		return result;
        },
        error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);		alert("Previous 2 errors in writeCourseNames()");
      	}
    })
}


var addworkonfly = '<table border="0" style="float:left;width:500px;font-size:16px;height:75px">\
	<tr>\
	<td style="width:20%;padding:0px;height:20px"><p style="display:table;margin-left:auto;margin-right:auto;margin-top: 0px;margin-bottom:0px;">Name</p></td>\
	<td style="width:15%;padding:0px;height:20px"><p style="display:table;margin-left:auto;margin-right:auto;margin-top: 0px;margin-bottom:0px;">Month</p></td>\
	<td style="width:15%;padding:0px;height:20px"><p style="display:table;margin-left:auto;margin-right:auto;margin-top: 0px;margin-bottom:0px;">Day</p></td>\
	<td style="width:15%;padding:0px;height:20px"><p style="display:table;margin-left:auto;margin-right:auto;margin-top: 0px;margin-bottom:0px;">Class</p></td>\
	<td style="width:15%;padding:0px;height:20px"><p style="display:table;margin-left:auto;margin-right:auto;margin-top: 0px;margin-bottom:0px;">Length</p></td>\
	</tr>\
	<tr><td><input style="display:table;margin-left:auto;margin-right:auto;" type="text" id="name"></input> </td><td><select style="display:table;margin-left:auto;margin-right:auto;" id="month"><option value="' + month + '">' + textMonth() + '</option><option value="0">January</option><option value="1">February</option><option value="2">March</option><option value="3">April</option><option value="4">May</option><option value="5">June</option><option value="6">July</option><option value="7">August</option><option value="8">September</option><option value="9">October</option><option value="10">November</option><option value="11">December</option></select></td><td><input style="display:table;margin-left:auto;margin-right:auto;width:32px" type="text" id="day" value="' + (date+1) + '"></input></td><td><select style="display:table;margin-left:auto;margin-right:auto;" type="text" id="class"></select></td><td><select style="display:table;margin-left:auto;margin-right:auto;" id="eta"><option value="15">15 Minutes</option><option value="30">30 Minutes</option><option value="60">1 Hour</option><option value="90">1.5 Hours</option><option value="120">2 Hours</option><option value="180">3 Hours</option><option value="240">4 Hours</option><option value="300">5 Hours</option></select></td></tr>\
</table>\
<input type="submit" onclick="submitOnFlyWork()"style="float:left;margin-top:18px;" value="Submit">\
</input>\
<button onclick="cancelOnFlyWork()"style="float:left;margin-top:18px;">Cancel</button>';

/*
Form Analysis:
Fields{
	name
	month
	day
	year
	class
	time
}
toSend{
	name
	class
	createdDate
	dueDate
	time
}
Server-side{
	ID
	Completed Status
}
*/

function writeWork(senddata){
	return $.ajax({
        url : 'getInfo.php',
        type : 'POST',
		data: {command: "writeWork",
				extradata: senddata
				},
        success : function (result) {
        },
        error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);		alert("Previous 2 errors in writeCourseNames()");
      	}
    })
}

function submitOnFlyWork(){
	var trueMonth = month+1;
	var trueMonth2 = parseInt(document.getElementById("month").value) + 1;
	var trueYear;
	if(trueMonth2 > trueMonth){
		trueYear = year;
	}else if(trueMonth2 == trueMonth && parseInt(document.getElementById("day").value) >= date){
		trueYear = year;
	}else{
		trueYear = year+1;
	}
	
	var writeVal = document.getElementById("name").value + "/i/" + document.getElementById("class").value + "/i/" +  trueMonth + "/" + date + "/" + year + "/i/" + trueMonth2 + "/" + document.getElementById("day").value + "/" + trueYear + "/i/" + document.getElementById("eta").value + "/i/";
	writeWork(writeVal).done(function(){
		document.getElementById("newworktarget").style.height="0px";
		document.getElementById("newworktarget").innerHTML="";
		showAllAssignments();
		getCalendar();
		coursesIn();
	});
}

function addCourse(){
	document.getElementById("newcoursetarget").innerHTML = addcourseonfly;
	document.getElementById("newcoursetarget").style.height = "75px";
}
function addWork(){
	document.getElementById("newworktarget").innerHTML = addworkonfly;
	document.getElementById("newworktarget").style.height = "75px";
	getCourseOptions();
}
var expectCourseDelete = false;

function deleteCourse(){
	expectCourseDelete = true;
}
var expectWorkDelete = false;
function deleteWork(){
	expectWorkDelete = true;
}

function deleteCourses(id){
	if(confirm("Do you want to delete this course?")){
		console.log("Deleting Course " + id);
		expectCourseDelete = false;
		return $.ajax({
			url : 'getInfo.php',
			type : 'POST',
			data: {command: "deleteCourses",
					extradata: id
					},
			success : function (result) {
			},
			error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			}
		})
	}
}

function deleteWorks(id){
	if(confirm("Do you want to delete this assignment?")){
		console.log("Deleting Assignment " + id);
		expectWorkDelete = false;
		return $.ajax({
			url : 'getInfo.php',
			type : 'POST',
			data: {command: "deleteAssignment",
					extradata: id
					},
			success : function (result) {
			},
			error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
			}
		})
	}
}

function toggleComplete(id){
	togglecomplete(id).done(function(){
		update();
		showAllCourses();
	});
}

function togglecomplete(id){
	return $.ajax({
		url : 'getInfo.php',
		type : 'POST',
		data: {command: "toggleComplete",
				extradata: id
				},
		success : function (result) {
		},
		error: function (xhr, ajaxOptions, thrownError) {
		alert(xhr.status);
		alert(thrownError);
		}
	})
}

function echoAssignments(id){
	
	var data = (month+1) + "/" + date + "/" + year + "/i/" + id;

	return $.ajax({
		url : 'getInfo.php',
		type : 'POST',
		data: {command: "echoAssignments",
				extradata: data
				},
		success : function (result) {
			document.getElementById("target" + id).innerHTML = result;
		},
		error: function (xhr, ajaxOptions, thrownError) {
		alert(xhr.status);
		alert(thrownError);
		}
	})
}

function handleCourseClick(id){
	if(expectCourseDelete){
		deleteCourses(id).done(function(){
			update();
			coursesIn();
			getCalendar();
			coursesIn();
		});
	}else{
		//Let's see if we can make this go to a specific page for the course
	}
}
function handleWorkClick(id){
	if(expectWorkDelete){
		deleteWorks(id).done(function(){
			update();
			showAllCourses();
			getCalendar();
			coursesIn();
		});
	}else{
		//Let's see if we can make this go to a specific page for the course
	}
}
init();