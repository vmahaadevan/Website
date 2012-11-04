<?php

$path_parts = pathinfo(__FILE__);
include("../Setup/preheader.php");
?>
<title>Login</title>
<?php include("../Setup/header.php"); ?>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<table id="maintable" border="0">
    <tr>
	<td id="leftcolumn">
	    <div id="leftmenu">
		<ul style="list-style: none">
		    <li style="padding-top: 15px">
			<a href="#connectfourlabel">Connect Four</a>
			<ul>
			    <li><a href="#backstory">Backstory</a></li>
			    <li><a href="#actualcode">The Actual Code</a></li>
			</ul>
		    </li>
		</ul>
	    </div>
	</td><td width="3%"></td>
	<td id="rightcolumn">
	    <div id="rightcontent">
		<table border="0" style="width: 100%;">
		    <tr>
			<td style="width: 50%;">
			    <h2 style="text-align: center;">Login</h2>
			    <?php 
				if ($_SESSION["message"]!=null) {
				    ?>
			    <div style="text-align: center; padding: 10px;">
				<?php echo $_SESSION["message"]; ?>
			    </div>
			    <?php
				}
			    ?>
			    <form action="../Login/submitlogin.php" method="post" style="padding: 10px;">
				Username:
				<input type="text" name="username"/><br>
				<!--Password:
				<input type="password" name="password"/><br>-->
				<input type="submit" />
			    </form>
			</td>
			<td style="width: 50%;">
			    <h2 style="text-align: center;">Create Account</h2>
			    <?php 
				if ($_SESSION["newmessage"]!=null) {
				    ?>
			    <div style="text-align: center; padding: 10px;">
				<?php echo $_SESSION["newmessage"]; ?>
			    </div>
			    <?php
				}
			    ?>
			    <form action="../Login/submitnewuser.php" method="post" style="padding: 10px;">
				Username:
				<input type="text" name="username"/><br>
				<!--Password:
				<input type="password" name="password"/><br>-->
				<input type="submit" />
			    </form>
			</td>
		    </tr>
		</table>
	    </div>
	</td>
    </tr>
</table>
<?php include("../Setup/footer.php"); ?>