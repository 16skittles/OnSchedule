<!doctype html>
<html lang = "en">
<head>
	<meta charset="UTF-8" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="viewport" content="user-scalable=no, width=device-width" />
	<link rel="stylesheet" href="html5.css" />
</head>



<script type="text/javascript" language="Javascript" 
        src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js">
</script>

<body onorientationchange="Rotate(event);" ontouchmove="BlockMove(event);" style="background:#000000;margin:0px;">
<canvas id="testCanvas" style="margin:0px;background:url(http://schedule.16skittles.tk/resources/debut_light.png)">
</canvas>

<script>
	function BlockMove(event){
		event.preventDefault();
	}
	
	function ChangeViewport(){
		alert(window.orientation);
		if(window.orientation == 0 || window.orientation == 180){
			viewport = document.querySelector("meta[name=viewport]");
			viewport.setAttribute('content', 'width=768, user-scalable=0');
			canvas.width = 768;
			canvas.height = 1004;
		}else{
			viewport = document.querySelector("meta[name=viewport]");
			viewport.setAttribute('content', 'width=1024, user-scalable=0');
			canvas.width = 1024;
			canvas.height = 748;
		}
		
		drawDimensions();
	}
	
	function Rotate(event){
		ChangeViewport();
	}

var canvas;
var canvasW;
var canvasH;
var context;

function init()
{
    canvas = document.getElementById("testCanvas");
    canvas.width = $(window).width();//document.body.clientWidth; //document.width is obsolete
    canvas.height = $(window).height();//document.body.clientHeight; //document.height is obsolete
    canvasW = canvas.width;
    canvasH = canvas.height;
		
	if(canvas.getContext) {
	// Initaliase a 2-dimensional drawing context
	context = canvas.getContext('2d');
	}
}



init();


ChangeViewport();
drawDimensions();

//Canvas commands go here

/*Alright, let's go. Classes n stuff.*/

function drawDimensions(){
context.fillStyle="#000000";
context.font = "156px arial";

context.fillText("Width: " + canvas.width, 16, 175);

context.fillText("Height: "+ canvas.height, -72, 350);
}
</script>
</body>
</html>

