<body onorientationchange="Rotate(event);" ontouchmove="BlockMove(event);" style="background:#000000;margin:0px;">


<script>
	function BlockMove(event){
		event.preventDefault();
	}
	
	function ChangeViewport(){
		alert(window.orientation);
		if(window.orientation == 0 || window.orientation == 180){
			viewport = document.querySelector("meta[name=viewport]");
			viewport.setAttribute('content', 'width=768, user-scalable=0');
		}else{
			viewport = document.querySelector("meta[name=viewport]");
			viewport.setAttribute('content', 'width=1024, user-scalable=0');
		}
	}
	
	function Rotate(event){
		ChangeViewport();
	}

</script>
</body>