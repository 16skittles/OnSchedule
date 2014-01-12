//Just here to allow easier control over CSS3 animations.

function logBoxIn(){
	document.getElementById("login").className = "loginBoxIn";
	document.getElementById("login").style.visibility = "visible";
}

function headerIn(){
	document.getElementById("header").className = "headerIn";
	document.getElementById("header").style.visibility = "visible";
}

function headerOut(){
	document.getElementById("header").className = "headerOut";
	document.getElementById("header").style.visibility = "visible";
}

function navBarIn(){
	document.getElementById("navBar").className = "navBarIn";
	document.getElementById("navBar").style.visibility = "visible";
}
function navBarOut(){
	document.getElementById("navBar").className = "navBarOut";
	document.getElementById("navBar").style.visibility = "visible";
}
function subNavIn(name){
	document.getElementById(name).className = "subNavIn";
	document.getElementById(name).style.visibility = "visible";
	document.getElementById(name).style.marginLeft = "0%";
}
function subNavOut(name){
	document.getElementById(name).className = "subNavOut";
	document.getElementById(name).style.visibility = "visible";
	document.getElementById(name).style.marginLeft = "200%";
}
function subNavInBeginning(name){
	document.getElementById(name).className = "subNavInBeginning";
	document.getElementById(name).style.visibility = "visible";
	document.getElementById(name).style.marginLeft = "0%";
}
function contentIn(name){
	subNavIn(name+"Nav");
	document.getElementById(name).className = "contentIn";
	document.getElementById(name).style.visibility = "visible";
	document.getElementById(name).style.top = "222px";
}
function contentOut(name){
	subNavOut(name+"Nav");
	document.getElementById(name).className = "contentOut";
	document.getElementById(name).style.visibility = "visible";
	document.getElementById(name).style.top  = "2200px";
}
function contentInBeginning(name){
	subNavInBeginning(name+"Nav");
	document.getElementById(name).className = "contentInBeginning";
	document.getElementById(name).style.visibility = "visible";
	document.getElementById(name).style.top = "222px";
}

function getCourseInfo(){
	return $.ajax({
        url : 'getInfo.php',
        type : 'POST',
        dataType: 'json',
		data: {command: "listCourses"
				},
        success : function (result) {
			console.log(result);
			allcourses = result;
        },
        error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
		alert("Errors in: getCourseInfo()");
      	}
    })
}

var allcourses;
function coursesIn(){
	getCourseInfo().done(function(){
		for(var x = 0; x<allcourses.length; x++){
			var tmp = allcourses[x];
			var exploded = tmp.split('/i/');
			if(exploded[1] == "0"){
				allcourses.splice(x, 1);
			}
		}

		var sorted = 0;
		while(sorted != 1){
			sorted = 1;
			for(var x = 0; x<allcourses.length-1; x++){
				var first = allcourses[x];
				var second = allcourses[x+1];
				if(parseInt(first.split("/i/")[2]) > parseInt(second.split("/i/")[2])){
					allcourses[x] = second;
					allcourses[x+1] = first;
					sorted = 0;
					console.log(first.split("/i/")[2] + ">" + second.split("/i/")[2]);
				}else{
					console.log(first.split("/i/")[2] + "<" + second.split("/i/")[2]);
				}
			}
		}

		var newhtml = "";
		var tmpcourses = new Array();
		for(var x = 1; x<allcourses.length+1; x++){
			var tmp = allcourses[x-1].split("/i/");
			/*name/i/id/i/isshown/i/*/
			var margintop;
			if(x==1){
				margintop = "-20px";
			}else{
				margintop="0px";
			}
			newhtml += "<div class='course"+x+"In' style='margin-top:"+margintop+";'>\
				<div id='courseH"+x+"' style='height:24px;width:90%;margin-left:auto;margin-right:auto;padding-bottom:3px;' onclick='handleCourseClick(" + tmp[2] + ")'>\
					<p style='display:table;margin-left:auto;margin-right:auto;font-size:20px;'onclick='handleCourseClick(" + tmp[2] + ")'>"+tmp[0]+"</p>\
				</div>\
				<div id='courseB"+x+"' style='min-height:40px;width:90%;margin-left:auto;margin-right:auto;'><div id='target" + tmp[2] + "'></div>\
				</div>\
			</div>\
			";
			tmpcourses.push(tmp[2]);
		}
		document.getElementById("courses").innerHTML=newhtml;
		for(var x = 0; x < tmpcourses.length; x++){
			console.log("echoAssignments(" + tmpcourses[x] + ");");
			echoAssignments(tmpcourses[x]);
		}
		var newheight = window.innerHeight - 254;
		document.getElementById("courses").style.height = newheight + "px";
		document.getElementById("calendar").style.height = newheight + "px";
		document.getElementById("assignmenu").style.height = newheight + "px";
	});
}

function mainScreenIn(){
	console.log("Bringing in components");
	document.getElementById("js").style.visibility="visible";
	navBarIn();
	contentInBeginning("calendar");
	headerIn();
	coursesIn();
}