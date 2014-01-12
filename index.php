<!--
I see you looking at our code!
Want to see some more?
Check us out on GitHub!
https://github.com/16skittles/
-->

<!doctype html>
<html lang = "en">
<head>
	<meta charset="UTF-8" />
	

	<meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="format-detection" content="telephone=no">

	<link href='http://fonts.googleapis.com/css?family=Oxygen:300,400' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="html5.css" />
	<link rel="stylesheet" href="animate.css" />
	<link rel="stylesheet" href="style.css" />
	<script src="core.js"></script>
	<script src="animations.js"></script>
	
	<script type="text/javascript" language="Javascript" 
        src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
	</script>
	<title>OnSchedule</title>
</head>

<script type="text/javascript">
   function blockMove() {
	   	if(onContent){
	      event.preventDefault() ;
	   	}
	}
</script>

<body style="background:url('grid_noise.png');background:#f9f9ff;margin:0px;height:100%;">
	
	<!--Google Analytics Module -->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-47034961-1', '16skittles.tk');
	  ga('send', 'pageview');

	</script>
	
	<!--JSCheck Module Code-->
	<div id="nojs">
		<p id="nojsp">It appears that Javascript is not enabled in your browser. Please enable Javascript to use the web app. Or, if you prefer, use the non-javascript version available <a href="http://schedule.16skittles.tk/student/">Here</a></p>
	</div>
	<!--Login Module Code-->
	<div id="login">
		<p id="welcome">Welcome to OnSchedule.</p>
		<p id="plslog">Please log in or register to use the web app.</p>
		<p id="logerror"></p>
		<div id="loginforms">
			<div id="formLogin" style="float:left;display:table;">
				<p id="logtext">Log In</p>
				<div style="display:table;margin-left:auto;margin-right:auto;">
					<div id="formLoginText" style="float:left;">
						Username:
						<br />
						Password:
					</div>
					<form name = "login" action = "login.php" method = "post" id="loginform">
						 <input type = "text" name = "username" id="loginUname" style="margin-top:-3px;"/>
						 <br />
						 <input type = "password" name = "password" id="loginPass" style="margin-top:7px;" />
						 <br />
						<input type="submit" onclick="loginscript(event)" style="margin-left:auto;margin-right:auto;margin-top:7px;" value="Login"></input>
					</form>
				</div>
			</div>
			<div id="formLogin">
				<p id="logtext">Register</p>
				<div style="display:table;margin-left:auto;margin-right:auto;">
						<div id="formLoginText" style="float:left;">
							Username:
							<br />
							Password:
							<br />
							Confirm:
						</div>
						<form name = "login" action = "register.php" method = "post" id="loginform">
							 <input type = "text" name = "username" id="regUname" />
							 <br />
							 <input type = "password" name = "password" id="regPass" style="margin-top:7px;" />
							 <br />
							 <input type = "password" name = "repeat" id="regPass2" style="margin-top:7px;" />
							 <br />
							<input type="submit" onclick="registerscript(event)" style="margin-left:auto;margin-right:auto;margin-top:7px;" value="Register"></input>
						</form>
					</div>
			</div>
		</div>
	</div>
	<!--Setup Module Code-->
	<div id="setup">
		<div id="setupprogress">
			<div id="setupani">
				<div id="anibar1"></div>
				<div id="anibar2"></div>
				<div id="anibar3"></div>
				<div id="anibar4"></div>
				<div id="anibar5"></div>
			</div>
			<div id="stp1" class="setupstep"><p id="stptext">Import old data</p></div>
			<div id="stp2" class="setupstep"><p id="stptext">List your courses</p></div>
			<div id="stp3" class="setupstep"><p id="stptext">Plot your schedule</p></div>
			<div id="stp4" class="setupstep"><p id="stptext">Additional info</p></div>
			<div id="stpmark1" class="stpmarks"></div>
			<div id="stpmark2" class="stpmarku"></div>
			<div id="stpmark3" class="stpmarku"></div>
			<div id="stpmark4" class="stpmarku"></div>
		</div>

		
		
		
		
		<div id="stpfinal" style="display:none;" class="stppage">
			<p style="display:table;width:60%;margin-left:auto;margin-right:auto;text-align:center;">Thank you for completing setup! Your information has been saved. You are now ready to use OnSchedule! You can change any of these settings later from within the app.</p>
		</div>
		
		<div id="stpplot" style="display:none;" class="stppage">
			<p style="display:table;width:60%;margin-left:auto;margin-right:auto;text-align:center;">To help us understand when to expect new assignments, show us what days each class takes place.</p>
			<table id="stptable" border="0" style="margin-left:auto;margin-right:auto;">
				<tr>
				<td style="width:20%"><p style="display:table;margin-left:auto;margin-right:auto;">Course</p></td>
				<td style="width:15%"><p style="display:table;margin-left:auto;margin-right:auto;">Monday</p></td>
				<td style="width:15%"><p style="display:table;margin-left:auto;margin-right:auto;">Tuesday</p></td>
				<td style="width:15%"><p style="display:table;margin-left:auto;margin-right:auto;">Wednesday</p></td>
				<td style="width:15%"><p style="display:table;margin-left:auto;margin-right:auto;">Thursday</p></td>
				<td style="width:15%"><p style="display:table;margin-left:auto;margin-right:auto;">Friday</p></td>
				</tr>
			</table>
		</div>
		
		<div id="stplist" style="display:none;" class="stppage">
			<div id="stpAllNewCourses" style="display:table;width:300px;margin-left:auto;margin-right:auto">
			</div>
			<div style="display:table;margin-left:auto;margin-right:auto">
			<button type="button" onclick="stpNewCourse()">Add Course</button>
			</div>
		</div>
		
		<div id="stpimport" class="stppage">
			<p style="display:table;margin-left:auto;margin-right:auto;">If you used OnSchedule during closed beta, you may be able to import your old data.</p>
			<p style="display:table;margin-left:auto;margin-right:auto;">You will be able to choose which courses are imported.</p>
			<br />
			<div style="display:table;margin-left:auto;margin-right:auto;">
				<p style="display:table;float:left;">Import?</p>
				<input type="checkbox" id="checkboxImport" style="float:left;margin-left:5px;margin-top:33px;"/>
			</div>
		</div>
		
		<button style="float:right;width:100px;height:35px;bottom:20px;position:absolute;margin-left:-120px;" type="button" onclick="setupAdv()">Continue</button>
	</div>
	<!--Main Site Code Code-->
	<div id="js" style="visibility:hidden;height:100%;">
		<div id="sidebar" style="height:100%;width:33%;min-width:471px;float:left;">
			<div id="header">
				<div id="headerday" style="display:table;margin-left:auto;margin-right:auto;font-family:'code'">
					
				</div>
				<div id="headerdate">
				</div>
			</div>
			<div id="courses" style="width:106;overflow:auto">

			</div>
		</div>
		<div id="main" style="min-height:100%;float:left;position:relative">
			<div id="navBar" style="width:100%;margin-top:31px;overflow:hidden;position:absolute;">
				<div style="float:left;min-height:32px;width:25%;"><img onclick="setUI('calendar')" style="display:table;margin-left:auto;margin-right:auto;width:48px;"src="calendar.svg" /></div>
				<div style="float:left;min-height:32px;width:25%;"><img onclick="setUI('coursemenu')" style="display:table;margin-left:auto;margin-right:auto;width:48px;"src="course.svg" /></div>
				<div style="float:left;min-height:32px;width:25%;"><img onclick="setUI('assignmenu')" style="display:table;margin-left:auto;margin-right:auto;width:48px;"src="assignment.svg" /></div>
				<div style="float:left;min-height:32px;width:25%;"><img onclick="setUI('settings')" style="display:table;margin-left:auto;margin-right:auto;width:48px;"src="cog.svg" /></div>
			</div>
			<!--SubNav bars-->
			<div id="calendarNav" style="width:100%;overflow:hidden;position:absolute;margin-top:126px">
				<div style="float:left;min-height:32px;width:25%;">
				<img style="display:table;margin-left:auto;margin-right:auto;width:48px;"onclick="changeMonth(-1)"src="leftarrow.svg"/>
				</div>
				<div id="calMonthLabel" style="float:left;min-height:32px;width:50%;">
				</div>
				<div style="float:left;min-height:32px;width:25%;">
				<img onclick="changeMonth(1)"style="display:table;margin-left:auto;margin-right:auto;width:48px;"src="rightarrow.svg"/>
				</div>
			</div>

			<div id="coursemenuNav" style="margin-left:200%;width:100%;overflow:hidden;margin-top:126px;position:absolute;">
				<div id="coursesubNav">
					<div style="float:left;min-height:32px;width:50%;">
						<img style="display:table;margin-left:auto;margin-right:auto;width:48px;"onclick="addCourse()"src="plus.svg" />
					</div>
					<div style="float:left;min-height:32px;width:50%;">
						<img style="display:table;margin-left:auto;margin-right:auto;width:48px;margin-top:20px;"onclick="deleteCourse()"src="minus.svg" />
					</div>
				</div>
			</div>
			
			<div id="assignmenuNav" style="margin-left:200%;width:100%;overflow:hidden;margin-top:126px;;position:absolute;">
				<div style="float:left;min-height:32px;width:25%;">
					<img style="display:table;margin-left:auto;margin-right:auto;width:48px;"onclick="addWork()"src="plus.svg" />
				</div>
				<div style="float: left; min-height:32px;width:50%">
					<p style='font-size:38px;display:table;margin-left:auto;margin-right:auto;margin-top:-10px;'>All Courses</p>
				</div>
				<div style="float:left;min-height:32px;width:25%;">
					<img style="display:table;margin-left:auto;margin-right:auto;width:48px;margin-top:20px;"onclick="deleteWork()"src="minus.svg" />
				</div>
			</div>
			
			<div id="settingsNav" style="margin-left:200%;width:100%;overflow:hidden;margin-top:126px;;position:absolute;">
				<div style="float:left;min-height:32px;width:25%;">
				<img style="display:table;margin-left:auto;margin-right:auto;width:48px;"src="leftarrow.svg"/>
				</div>
				<div id="calMonthLabel" style="float:left;min-height:32px;width:50%;">
				</div>
				<div style="float:left;min-height:32px;width:25%;">
				<img style="display:table;margin-left:auto;margin-right:auto;width:48px;"src="rightarrow.svg"/>
				</div>
			</div>
			
			
			
			<div class="contentmain" id="calendar" style="position:relative"></div>
			<div class="contentmain" id="coursemenu" style="padding-left:5px;padding-right:40px;position:absolute;">
				<div id="newcoursetarget" style="padding:0px">
				</div>
				<p style="font-size:24px;border-bottom-style:solid;border-width:1px;">Pinned Courses</p>
				<div id="pinnedCourses"></div>
				<p style="font-size:24px;border-bottom-style:solid;border-width:1px;">Unpinned Courses</p>
				<div id = "unpinnedCourses"></div>
			</div>
			<div class="contentmain" id="assignmenu" style="position:absolute;overflow:auto">
				<div id="newworktarget" style="padding:0px;"></div>
				<div id="worktarget" style="padding:0px;"></div>
			</div>
			<div class="contentmain" id="settings"></div>
		</div>
	</div>
	
	<script>
		init();
		UISwap();
		update();
		var scrollPosition = [
		self.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft,
		self.pageYOffset || document.documentElement.scrollTop  || document.body.scrollTop
		];
		var html = jQuery('html');
		html.data('scroll-position', scrollPosition);
		html.data('previous-overflow', html.css('overflow'));
		html.css('overflow', 'hidden');
		window.scrollTo(scrollPosition[0], scrollPosition[1]);
		document.getElementById("courses").ontouchmove = function(e) {
			e.stopPropagation();
		};
		document.getElementById("assignmenu").ontouchmove = function(e) {
			e.stopPropagation();
		};
		document.getElementById("dayMinor").ontouchmove = function(e) {
			e.stopPropagation();
		};
		
		document.getElementById("dayMajor").ontouchmove = function(e) {
			e.stopPropagation();
		};
		document.body.ontouchmove = function(e){
			e.preventDefault();
		}
	</script>
</body>
</html>

