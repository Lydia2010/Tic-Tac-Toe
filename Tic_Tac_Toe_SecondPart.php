<!doctype html>
<html>
<head>
<title>tic tac toe</title>
<style>
body {
 color:black;
 background-color:white;
 font-family:Tahoma,Verdana,Helvetica,Arial,sans-serif;
}
	.ticTacField {overflow:hidden;}
	
	.ticTacCell { 
		         border: 1px solid #ccc;
		          width: 40px;
		          height:40px;
                  position:relative;
		          text-align:center;}
	.ticTacCell a {position:absolute; left:0;top:0;right:0;bottom:0}
    .ticTacCell a:hover { background: #aaa; }
    
    .ticTacCellWin { 
		         border: 1px solid #ccc;
		          width: 40px;
		          height:40px;
                  position:relative;
		          text-align:center;
		          background:yellow;}
		          
    .ticTacCellFinal { 
		         border: 1px solid #ccc;
		          width: 40px;
		          height:40px;
                  position:relative;
		          text-align:center;
		          background:lightgrey;}
	
	
    
</style>
</head>
<body>
	<h1>Tic-Tac-Toe</h1>	
	<div class="ticTacField">
<form method="post" action="Tic_Tac_Toe_SecondPart.php" >


    To start the game, choose the game mode and press 'New Game' 
    <br>
	<input type="radio" name="gmode" value="3" color="blue" <?php if ( isset($_POST['gmode'])) {if($_POST['gmode']=='3'){echo "checked = '1'";} else {echo "value = '0'";}} else {echo "value = '0'";}?>> 3X3
	<input type="radio" name="gmode" value="5"  <?php if ( isset($_POST['gmode'])) {if($_POST['gmode']=='5'){echo "checked = '1'";} else {echo "value = '0'";}} else {echo "value = '0'";}?>> 5X5
	<br>
<?php
     print "<br>";
    session_start();	
   // echo "user:".$_SESSION["user"];
    function clear()
	{	
	  for($j=1; $j<=9; $j++){
		  $_POST[$j] = "";
		
	  }
		 $_SESSION['moveCount'] = 0;
		 $_SESSION['move0Count'] = 0;
		  $xcount=0;
		  $ocount=0;
		  $_SESSION['needRandom'] =0;
		  $_SESSION['prompt'] ='';
		  $_SESSION['prevMove'] ='z';
		  $_SESSION['moves']= array();
		  $_SESSION['error'] =0;
		  $_SESSION['gameend'] =0;
	}
	function playTicTacToe()
	{
		//session_start();	
		$rand=0;
		global $error;
	$error=false;
	global $player_x;
	$player_x=false; 
	global $player_0;
	$player_0=false;
	global $count;
	$count=0;
	global $countMove;
	$countMove=0;
	global $xcount;
	$xcount=0;
	global $ocount;
	$ocount=0;
	global $new;
	$new = false;
	global $errorchar;
	$errorchar=0;
	global $move;
	$a1=0;
	$b1=0;
	$c1=0;
	
	
		if (isset($_SESSION['gameCount'])) {

		}
		else{

			$_SESSION['gameCount']=0; // counts number of games. presents in table
			$_SESSION['playerXwinCount']=0;// counts wins for playes X in table
			$_SESSION['player0winCount']=0; // counts wins for playes o in table
			$_SESSION['moveCount']=0; // count of prevoous moves of player X.
			$_SESSION['moves']= array();// array of all previous moves
			$_SESSION['machineMove']=0;// not requred
			$_SESSION['needRandom'] =0; // determine mode of game. Two players or player with machine
			$_SESSION['prevMove'] ='z';// keeps recent player move ( what was last move X or o )
			$_SESSION['playerXloose']=0;
			$_SESSION['player0loose']=0;
			$_SESSION['allmoves']=array(array());
			$_SESSION['gameend'] =0;
			
		}
		// determine previous move ended with error and new game must be started.
		if (isset($_SESSION['error'])){
		}
		else{
			$_SESSION['error'] = 0;
		}
		
		// count of prevoous moves of player X.
		if (isset($_SESSION['moveCount'])){
			
		}
		else
		{
			$_SESSION['moveCount']=0;
			
		}
		// count of prevoous moves of player o.
		if (isset($_SESSION['move0Count'])){
			
		}
		else
		{
			$_SESSION['move0Count']=0;
			
		}
		// determine if 2 players or player with machine. Only when game starts.
	    if ($_SESSION['needRandom'] ==0) {
			$rand = rand(1,2);
			if($rand==1)
			{
				$_SESSION['needRandom'] =1;
				$_SESSION['prompt'] = "Player with machine mode: Move 'x' only";
				echo "Player with machine mode: Move 'x' only";
				
			}
			else {
				$_SESSION['needRandom'] =2;
				$_SESSION['prompt'] = "Two players mode: Move 'x', or 'o'";
				echo "Two players mode: Move 'x', or 'o'";
				
			}
		}
		else 
			print_r($_SESSION['prompt']);
			
			
		echo "<br>"	;		
		print "<br>";
		
	
	
	
	    // count moves of x and o in latest session.
		for($j=1; $j<=9; $j++){
			
			if(!empty($_POST[$j]))
			{	
			   if($_POST[$j]=="x")
			      $xcount +=1;
			   elseif($_POST[$j]=="o")
			      $ocount +=1;
		    }
		}
		
		
	if($_SESSION['needRandom']==1 && ($_SESSION['error'] !=1 || empty($_SESSION['error']))) {
		if($xcount-$ocount == 1 && $xcount<5)  // xcount = 5 - the board is full and game is over
		{
			
		
		  // loop populate o with random value for empty cell.
		  while(true){
    		 $rand1 = rand(1,9);
			 if(empty($_POST[$rand1])){
		  		$_POST[$rand1] = "o";
				break;
		  	
			 }
		   }
		  
		}
	}
					
		
	for($i=1; $i<=9; $i++){    

		//if ($i==4 || $i==7) print "<br>";

		//print "<input class=ticTacCell name=$i type=text size=9";//check for ending 


		if(isset($_POST['submit'])and !empty($_POST[$i])){

			$count+=1;
			
			// check current move was not before.  
			if (empty($_SESSION['moves'][$i]) && !empty($_POST[$i])){
				// If it is a new turn and same sign - the error message 
				if ($_SESSION['prevMove']==$_POST[$i]){
					$errorchar = 1;					
					$move = ($_POST[$i] == 'x')?'O':'X';
				}
				else{
				    $_SESSION['prevMove'] =$_POST[$i];
				    $_SESSION['moves'][$i] = $_POST[$i];
				    /*
				    if($i < 4)
				      $_SESSION['allmoves'][0][$i] = $_POST[$i];
				    elseif($i < 7)
				      $_SESSION['allmoves'][1][$i-4] = $_POST[$i];
				    elseif($i < 9)
				      $_SESSION['allmoves'][2][$i-7] = $_POST[$i];  
				      */   
				}
			}
			else
				$_SESSION['moves'][$i] = $_POST[$i];
			
				
			
			if($_POST[$i]=="x" || $_POST[$i]=="o")
			{
				$countMove+=1;

               
			
				//print " value=".$_POST[$i]." readonly>";
				


			   for ($a=1,$b=2,$c=3; $a<=7,$b<=8,$c<=9; $a+=3,$b+=3,$c+=3){

				if($_POST["$a"]==$_POST["$b"]and $_POST["$b"]==$_POST["$c"]){
					if($_POST["$a"]=="x")
					{
						$player_x=true;
						$a1=$a;
						$b1=$b;
						$c1=$c;
						$_SESSION['gameend'] =1;
					} 
					else if ($_POST["$a"]=="o")
					{
						$player_0=true;// $o_wins=true;
						$a1=$a;
						$b1=$b;
						$c1=$c;
						$_SESSION['gameend'] =1;

					}
					
				}
				
				   

			   }
			   for ($a=1,$b=4,$c=7; $a<=3,$b<=6,$c<=9; $a+=1,$b+=1,$c+=1){

				if($_POST["$a"]==$_POST["$b"] && $_POST["$b"]==$_POST["$c"]){
					if ($_POST["$a"]=="x")
					{
						$player_x=true;
						$a1=$a;
						$b1=$b;
						$c1=$c;
                        $_SESSION['gameend'] =1;
					} 
					else if($_POST["$a"]=="o")
					{
						$player_0=true;
						$a1=$a;
						$b1=$b;
						$c1=$c;
						$_SESSION['gameend'] =1;

					}
				}

			}  

			   for ($a=1,$b=5,$c=9; $a<=3,$b<=5,$c>=7; $a+=2,$b+=0,$c-=2){

				if ($_POST["$a"] == $_POST["$b"] && $_POST["$b"]==$_POST["$c"] ){
					if ( ($_POST["$a"]) == "x"){                
						$player_x=true;
						$a1=$a;
						$b1=$b;
						$c1=$c;
						$_SESSION['gameend'] =1;

					} 
					else if($_POST["$a"]=="o") {
						 $player_0=true;
						 $a1=$a;
						$b1=$b;
						$c1=$c;
						$_SESSION['gameend'] =1;

					}
				 }
			   }
	   		}
	   		else{	
				$error=true;
				//print " value=".''.">";		

	   		}

	 	}
		else{
			
				//print ">";
			

			}

	}
	
	
	for($i=1; $i<=9; $i++){
		if ($i==4 || $i==7) print "<br>";
		if(isset($_POST['submit'])and !empty($_POST[$i])){
			if($_POST[$i]=="x" || $_POST[$i]=="o"){
				if($a1==$i || $b1==$i || $c1==$i)
		  			print "<input class=ticTacCellWin name=$i type=text size=9 value=".$_POST[$i]." readonly>";
				elseif($_SESSION['gameend'] ==1)
		  			print "<input class=ticTacCellFinal name=$i type=text size=9 value=".$_POST[$i]." readonly>";
		  		else 
		  		    print "<input class=ticTacCell name=$i type=text size=9 value=".$_POST[$i]." readonly>";	
		    	}		
		 	else 
		   		print "<input class=ticTacCell name=$i type=text size=9 value=".''.">";
		} 
		elseif($_SESSION['gameend'] ==1)
		   print "<input class=ticTacCellFinal name=$i type=text size=9 readonly>";
		else 
		   print "<input class=ticTacCell name=$i type=text size=9 >";  
		      
	}
	
	
}

 

// TicTacToe 5*5 function

function playTicTacToeExt()
	{
		//session_start();	
		$rand=0;
		global $error;
	$error=false;
	global $player_x;
	$player_x=false; 
	global $player_0;
	$player_0=false;
	global $count;
	$count=0;
	global $countMove;
	$countMove=0;
	global $xcount;
	$xcount=0;
	global $ocount;
	$ocount=0;
	global $new;
	$new = false;
	global $errorchar;
	$errorchar=0;
	global $move;
	$a1=0;
	$b1=0;
	$c1=0;
	$d1=0;
	$e1=0;
	
		if (isset($_SESSION['gameCount'])) {

		}
		else{

			$_SESSION['gameCount']=0; // counts number of games. presents in table
			$_SESSION['playerXwinCount']=0;// counts wins for playes X in table
			$_SESSION['player0winCount']=0; // counts wins for playes o in table
			$_SESSION['moveCount']=0; // count of prevoous moves of player X.
			$_SESSION['moves']= array();// array of all previous moves
			$_SESSION['machineMove']=0;// not requred
			$_SESSION['needRandom'] =0; // determine mode of game. Two players or player with machine
			$_SESSION['prevMove'] ='z';// keeps recent player move ( what was last move X or o )
			$_SESSION['playerXloose']=0;
			$_SESSION['player0loose']=0;
			$_SESSION['allmoves']=array(array());
			$_SESSION['gameend'] =0;
			
		}
		// determine previous move ended with error and new game must be started.
		if (isset($_SESSION['error'])){
		}
		else{
			$_SESSION['error'] = 0;
		}
		
		// count of prevoous moves of player X.
		if (isset($_SESSION['moveCount'])){
			
		}
		else
		{
			$_SESSION['moveCount']=0;
			
		}
		// count of prevoous moves of player o.
		if (isset($_SESSION['move0Count'])){
			
		}
		else
		{
			$_SESSION['move0Count']=0;
			
		}
		// determine if 2 players or player with machine. Only when game starts.
	    if ($_SESSION['needRandom'] ==0) {
			$rand = rand(1,2);
			if($rand==1)
			{
				$_SESSION['needRandom'] =1;
				$_SESSION['prompt'] = "Player with machine mode: Move 'x' only";
				echo "Player with machine mode: Move 'x' only";
				
			}
			else {
				$_SESSION['needRandom'] =2;
				$_SESSION['prompt'] = "Two players mode: Move 'x', or 'o'";
				echo "Two players mode: Move 'x', or 'o'";
				
			}
		}
		else 
			print_r($_SESSION['prompt']);
			
			
		echo "<br>"	;		
		print "<br>";
		
	
	
	
	    // count moves of x and o in latest session.
		for($j=1; $j<=25; $j++){
			
			if(!empty($_POST[$j]))
			{	
			   if($_POST[$j]=="x")
			      $xcount +=1;
			   elseif($_POST[$j]=="o")
			      $ocount +=1;
		    }
		}
		
		
	if($_SESSION['needRandom']==1 && ($_SESSION['error'] !=1 || empty($_SESSION['error']))) {
		if($xcount-$ocount == 1 && $xcount<13)  // xcount = 5 - the board is full and game is over
		{
			
		
		  // loop populate o with random value for empty cell.
		  while(true){
    		 $rand1 = rand(1,25);
			 if(empty($_POST[$rand1])){
		  		$_POST[$rand1] = "o";
				break;
		  	
			 }
		   }
		  
		}
	}
					
		
	for($i=1; $i<=25; $i++){    

		//if ($i==6 || $i==11 || $i==16 || $i==21) print "<br>";

		//print "<input class=ticTacCell name=$i type=text size=9";//check for ending 


		if(isset($_POST['submit'])and !empty($_POST[$i])){

			$count+=1;
			
			// check current move was not before.  
			if (empty($_SESSION['moves'][$i]) && !empty($_POST[$i])){
				// If it is a new turn and same sign - the error message 
				if ($_SESSION['prevMove']==$_POST[$i]){
					$errorchar = 1;					
					$move = ($_POST[$i] == 'x')?'O':'X';
				}
				else{
				    $_SESSION['prevMove'] =$_POST[$i];
				    $_SESSION['moves'][$i] = $_POST[$i];
				}
			}
			else
				$_SESSION['moves'][$i] = $_POST[$i];
			
				
			
			if($_POST[$i]=="x" || $_POST[$i]=="o")
			{
				$countMove+=1;

                //$_SESSION['moves'][$i]	= $_POST[$i];
			
				//print " value=".$_POST[$i]." readonly>";


			   for ($a=1,$b=2,$c=3,$d=4,$e=5; $a<=21,$b<=22,$c<=23,$d<=24,$e<=25; $a+=5,$b+=5,$c+=5,$d+=5,$e+=5){

				if($_POST["$a"]==$_POST["$b"]and $_POST["$b"]==$_POST["$c"] and $_POST["$c"]==$_POST["$d"] and $_POST["$d"]==$_POST["$e"] ){
					if($_POST["$a"]=="x")
					{
						$player_x=true;
						$a1=$a;
						$b1=$b;
						$c1=$c;
						$d1=$d;
						$e1=$e;
						$_SESSION['gameend'] =1;
					} 
					else if ($_POST["$a"]=="o")
					{
						$player_0=true;// $o_wins=true;
						$a1=$a;
						$b1=$b;
						$c1=$c;
						$d1=$d;
						$e1=$e;
                        $_SESSION['gameend'] =1;
					}
				}

			   }
			   for ($a=1,$b=6,$c=11,$d=16,$e=21; $a<=5,$b<=10,$c<=15,$d<=20,$e<=25;$a+=1,$b+=1,$c+=1,$d+=1,$e+=1){

				if($_POST["$a"]==$_POST["$b"] && $_POST["$b"]==$_POST["$c"]and $_POST["$c"]==$_POST["$d"] and $_POST["$d"]==$_POST["$e"] ){
					if ($_POST["$a"]=="x")
					{
						$player_x=true;
						$a1=$a;
						$b1=$b;
						$c1=$c;
						$d1=$d;
						$e1=$e;
                        $_SESSION['gameend'] =1;
					} 
					else if($_POST["$a"]=="o")
					{
						$player_0=true;
						$a1=$a;
						$b1=$b;
						$c1=$c;
						$d1=$d;
						$e1=$e;
                        $_SESSION['gameend'] =1;
					}
				}

			}  

			   for ($a=1,$b=7,$c=13,$d=19,$e=25; $a<=5,$b<=9,$c<=13,$d>=17,$e>=21; $a+=4,$b+=2,$c+=0,$d-=2,$e-=4){

				if ($_POST["$a"] == $_POST["$b"] && $_POST["$b"]==$_POST["$c"]and $_POST["$c"]==$_POST["$d"] and $_POST["$d"]==$_POST["$e"] ){
					if ( ($_POST["$a"]) == "x"){                
						$player_x=true;
						$a1=$a;
						$b1=$b;
						$c1=$c;
						$d1=$d;
						$e1=$e;
                        $_SESSION['gameend'] =1;
					} 
					else if($_POST["$a"]=="o") {
						 $player_0=true;
						 $a1=$a;
						 $b1=$b;
						 $c1=$c;
						 $d1=$d;
						 $e1=$e;
                         $_SESSION['gameend'] =1;
					}
				 }
			   }
	   		}
	   		else{	
				$error=true;
				//print " value=".''.">";		

	   		}

	 	}
		else{
				//print ">";

			}

	}
	
	for($i=1; $i<=25; $i++){
		if ($i==6 || $i==11 || $i==16 || $i==21) print "<br>";
		if(isset($_POST['submit'])and !empty($_POST[$i])){
			if($_POST[$i]=="x" || $_POST[$i]=="o"){
				if($a1==$i || $b1==$i || $c1==$i || $d1==$i || $e1==$i )
		  			print "<input class=ticTacCellWin name=$i type=text size=9 value=".$_POST[$i]." readonly>";
				elseif($_SESSION['gameend'] ==1)
		  			print "<input class=ticTacCellFinal name=$i type=text size=9 value=".$_POST[$i]." readonly>";
		  		else 
		  		    print "<input class=ticTacCell name=$i type=text size=9 value=".$_POST[$i]." readonly>";
		    	}		
		 	else 
		   		print "<input class=ticTacCell name=$i type=text size=9 value=".''.">";
		} 
		elseif($_SESSION['gameend'] ==1)
		   print "<input class=ticTacCellFinal name=$i type=text size=9 readonly>";
		else 
		   print "<input class=ticTacCell name=$i type=text size=9 >";
		      
	}

 }

// END OF 5*5 FUNCTION
global $gmode;
$gmode='3';
if ((isset($_POST['submit']) || empty($_POST['submit'] )) && !isset($_POST['newgame']) ) {
   //echo "mode".$_POST['gmode'];
	if (isset($_POST['gmode']))
	{
       $selected_radio = $_POST['gmode'];
      
       if($selected_radio=="3")
       	  playTicTacToe();	 
	   elseif($selected_radio=="5")
	      playTicTacToeExt();
	    
	}
	else {
	      //echo "Choose game mode.";
	      print "<br>";
	      $_POST['gmode']='3';
	      playTicTacToe(); } 
}
if (isset($_POST['newgame'])) {
    
	clear();
	
	if (isset($_POST['gmode']))
	{
		$selected_radio = $_POST['gmode'];
      
       if($selected_radio=="3")
       	  playTicTacToe();	 
	   elseif($selected_radio=="5")
	      playTicTacToeExt();
		
	}
	else {
	      //echo "Choose game mode.";
	      print "<br>";
	      $_POST['gmode']='3';
	      playTicTacToe(); 
	}
}
     
	 ?>
    
        
		<p><input name="submit" type="submit" value="Your turn"></p>	
	    <p><input name="newgame" type="submit" value= "New Game"></p>


		</form>
		<?php
	    
		if ( $_SESSION['error'] !=1 || empty($_SESSION['error'])) {	
		 if($_SESSION['needRandom']==1) {
			if($xcount - $_SESSION['moveCount'] > 1) {
				echo '<i style="color:red;font-size:18px;">Make 1 move only! Please start new game </i> ';
				//echo "make 1 move only! Please start new game";
				$new = true;
				$_SESSION['error'] =1;
				
			
			}
			else if($xcount < $ocount){
				echo '<i style="color:red;font-size:18px;">Player is not allowed to move O! Please start new game </i> ';
		    	//echo "player is not allowed to move O! Please start new game ";
		    	$new = true;
		    	$_SESSION['error'] =1;
		    	
				
			}
		else 	  
			$_SESSION["moveCount"]=$xcount;
		}
		
		
        if( !isset($_POST['newgame']) && ($_SESSION['needRandom']==2 and ($_SESSION['error'] !=1 || empty($_SESSION['error'])))){
			
			if($xcount - ($_SESSION['moveCount']) > 1 || $ocount - ($_SESSION['move0Count'])>1 || 
			   ($xcount - ($_SESSION['moveCount'])==1 && $ocount - ($_SESSION['move0Count']) ==1)) {    
		echo '<i style="color:red;font-size:18px;font-family:bold ;">Make 1 move only! Please start new game </i> ';
			   		
			   		$new = true;
			   		$_SESSION['error'] =1;
			}
			elseif($errorchar == 1){
				echo '<i style="color:red;font-size:18px;">Incorrect move. Player '.$move.' must move. Please start new game. </i> ';
				//echo "Incorrect move. Player ".$move." must move. Please start new game.";
				$_SESSION['error'] =1;
				$new = true;
			}
			else	
				{  
					$_SESSION["move0Count"]=$ocount;
					$_SESSION["moveCount"]=$xcount;
			}
			
			
			
		}
		
		
		if($new==false){ 
			if($player_x){
				print("***Player X wins. Start new game.***");
				$_SESSION["gameCount"]+=1;
				$_SESSION['playerXwinCount']+=1;
				$_SESSION['player0loose']+=1;
			}
			elseif($player_0){
				print("***Player 0 wins. Start new game.***");
				$_SESSION["gameCount"]+=1;
				$_SESSION['player0winCount']+=1;
				$_SESSION['playerXloose']+=1;
		 	}  
			elseif($error){
				if($_SESSION['needRandom']==1) 
					print("Invalid move. Please Enter 'x' only");
				if($_SESSION['needRandom']==2) 
					print("Invalid move. Please Enter 'x' or 'o' only");
			}   

		 		
			if(($count==9 || $count==25) && !$player_x && !$player_0){
				print "***It's a Draw. Start new game.***";
				$_SESSION["gameCount"]+=1;
			}
		}
		
			$player_x=false;
			$player_0=false;

			print "<br>";
			print "<br>";

		}
		else 
		   echo '<i style="color:red;font-size:20px;">Please start new game. </i> ';

	// update scoring set playerxwin, playerowin, playerxloose, playeroloose
?>	


		   
		   
		   
		   
		   
<table border=1 cellpadding=3>
<tr>
<th>User</th>
<th>Player X wins</th>
<th>Player X losses</th>
<th>Player 0 wins</th>
<th>Player 0 losses</th>
<th>Total games</th>

</tr><tr>
<td align=right><input type=button name=user class=winstat value="<?php if(!empty($_SESSION['user'])) echo $_SESSION['user']; else echo ''; ?>"></td>
<td align=right><input type=button name=xWon class=winstat value="<?php echo $_SESSION['playerXwinCount']; ?>"></td>
<td align=right><input type=button name=xLoose class=winstat value="<?php echo $_SESSION['playerXloose']; ?>"></td>
<td align=right><input type=button name=0Won class=winstat value="<?php echo $_SESSION['player0winCount']; ?>"></td>
<td align=right><input type=button name=0Loose class=winstat value="<?php echo $_SESSION['player0loose']; ?>"></td>
<td align=right><input type=button name=total class=winstat value="<?php echo $_SESSION['gameCount']; ?>"></td>
</tr></table>
		
	</div>
  </body>

</html>


	
