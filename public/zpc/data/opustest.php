<?php 
	if($_GET['data']){
		echo '{images:["aaa.jpg","bbb.jpg","ccc.jpg","ddd.jpg", "eee.jpg"],repeat:3,text:{2:"hahaha",4:"heiheihei",10:"Hou !!",40:"12212"},}';
   	}else if($_GET['play_count']){
   		echo '{"play_count":102}';
   	}else if($_GET['sound']){
   		echo '{"sound":"sound/demo.mp3"}';
   	}
	
 ?>