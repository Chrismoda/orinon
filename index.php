<?php
	session_start();
	
	include('dbconnect.php');
	if (isset($_POST['btnLogin'])){
		$usrnm = $_POST["email"];
		$pswd = $_POST["pass"];
		
		$sql="SELECT * FROM `clients` WHERE `emailAddress`='$usrnm' AND `passWord`='$pswd'";
		//Executing the query into the database and store result in result variable
		$result=mysqli_query($myConn,$sql);
		$row=mysqli_fetch_assoc($result);//attach row variable to farmers table rows
		$id=$row["nationalId"];
		$alias=$row["firstName"]." ".$row["surName"];
		
		If (mysqli_num_rows($result)==1){ //Record is found so login is correct.Session is started
						
			$_SESSION['NatID'] = $id;
			$_SESSION['Alias'] = $alias;
			if(isset($_SESSION['NatID'])){
				header("location: account");
				exit();
			}
			
		}else If (mysqli_num_rows($result)==0){
			 echo("<SCRIPT>
			window.alert('Login details are incorrect .Try again')
			window.location.href='index.php'
			</SCRIPT>");
			exit(); 
		}
	}
	
	//login end
		
//administrator profile
if (isset($_POST['btnAdminLogin'])){
		$usrnm = $_POST["email"];
		$pswd = $_POST["pass"];
		
		$sql="SELECT * FROM `admin` WHERE `emailAddress`='$usrnm' AND `passWord`='$pswd'";
		//Executing the query into the database and store result in result variable
		$result=mysqli_query($myConn,$sql);
		$row=mysqli_fetch_assoc($result);//attach row variable to farmers table rows
		$id=$row["nationalId"];
		$alias=$row["firstName"]." ".$row["surName"];
		
		If (mysqli_num_rows($result)==1){ //Record is found so login is correct.Session is started
						
			$_SESSION['AdminNatID'] = $id;
			$_SESSION['AdminAlias'] = $alias;
			if(isset($_SESSION['AdminNatID'])){
				header("location: admin");
				exit();
			}
			
		}else If (mysqli_num_rows($result)==0){
			 echo("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Login details are incorrect .Try again')
			window.location.href='index.php'
			</SCRIPT>");
			exit(); 
		}
	}
	//end to adminportal
if(isset($_POST['btnRegister'])) {
	// Escape user inputs for security
	$NatID = mysqli_real_escape_string($myConn,$_POST['txtNatID1']);
	$Fname = mysqli_real_escape_string($myConn,$_POST['txtFname2']);
	$Lname = mysqli_real_escape_string($myConn,$_POST['txtSurname3']);
	$Email = mysqli_real_escape_string($myConn,$_POST['emailAddress']);
	$passwd = mysqli_real_escape_string($myConn,$_POST['passWord']);

	// Attempt insert query execution
	$sql = "INSERT INTO `clients`(`nationalId`, `firstName`, `surName`, `emailAddress`, `passWord`, `sex`, `address`, `occupation`, `maritalStatus`, `phoneNumber`, `nameOfemployer`, `institution`,`c_score`) VALUES ('$NatID','$Fname','$Lname','$Email','$passwd','','','','','','','','')";

	 if(mysqli_query($myConn, $sql)){
		echo('<SCRIPT>
			window.alert("Record Successfully Saved, Close and Login with your new details");
			window.location.href="index.php";
			</SCRIPT>');
		exit();
	} else{
		echo('<SCRIPT>
			window.alert("Registration Failed. Please try again later");
			window.location.href="index.php";
			</SCRIPT>');
	} 
}
?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Orinon</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Google Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Lato:400,700,400italic,300' rel='stylesheet' type='text/css'>

		<!-- all css here -->
		
		<!-- bootstrap v3.3.6 css -->       
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <!-- Animated text css -->
		<link rel="stylesheet" href="css/animated.css">
		<!-- owl.carousel css -->
        <link rel="stylesheet" href="css/owl.carousel.css">
        <link rel="stylesheet" href="css/owl.transitions.css">
		<!-- font-awesome css -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <!-- animate css -->
        <link rel="stylesheet" href="css/animate.css">
        <link href="css/jquery-ui.css" rel="stylesheet" />
        <link href="css/style.css" rel="stylesheet" />
		<!-- style css -->
		<link rel="stylesheet" href="style.css">
		<!-- responsive css -->
        <link rel="stylesheet" href="css/responsive.css">
		<!-- modernizr css -->
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
		<style>
			body{
			background:url("images/bdy.jpg");
			background-size: cover;
			background-repeat: no-repeat;
	    }

		</style>
    </head>
    <body >
	
	<div id="userReg" class="modal fade">
		<div class="modal-dialog" style="margin-top:30px;">
			<div class="modal-content">
				<div class="modal-header">
					<img src="images\logos.jpg" style="-moz-border-radius:15px;-webkit-border-radius:15px;height:125px;"/><label style="font-size:20pt;">New Applicant Registration</label>
				</div>
				<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" autocomplete="off" name="modForm4">
				<div class="modal-body">
					<input type="text" class="form-control" name="txtNatID1" placeholder="National ID"><br><br>
					<input type="text" class="form-control" name="txtFname2" placeholder="Firstname"><br><br>
					<input type="text" class="form-control" name="txtSurname3" placeholder="Surname"><br><br>
					<input type="email" class="form-control" name="emailAddress" placeholder="Email Address"><br><br>
					<input type="password" class="form-control" name="passWord" placeholder="Password"><br>
				</div>
				<div class="modal-footer" style="background-color:green;" >
					<button name="btnRegister" class="btn btn-success" type="submit">Register</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	
	<div id="userLogin" class="modal fade">
		<div class="modal-dialog" style="margin-top:30px;">
			<div class="modal-content">
				<div class="modal-header">
					<img src="images\logos.jpg" style="-moz-border-radius:15px;-webkit-border-radius:15px;height:125px;"/><label style="font-size:20pt;">Registered User Login</label>
				</div>
				<form method="POST" action="" autocomplete="off" name="modForm">
				<div class="modal-body">
					<input type="text" class="form-control" name="email" placeholder="Email"><br><br>
					<input type="password" class="form-control" name="pass" placeholder="Password"><br>
				</div>
				<div class="modal-footer" style="background-color:green;" >
					<button name="btnLogin" class="btn btn-success" type="submit">Login</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	
	<div id="userAdminLogin" class="modal fade">
		<div class="modal-dialog" style="margin-top:30px;">
			<div class="modal-content">
				<div class="modal-header">
				<img src="images\logos.jpg" style="-moz-border-radius:15px;-webkit-border-radius:15px;height:125px;"/><label style="font-size:20pt;">Administrator Login</label>
				</div>
				<form method="POST" action="" autocomplete="off" name="modForm">
				<div class="modal-body">
					<input type="text" class="form-control" name="email" placeholder="Email"><br><br>
					<input type="password" class="form-control" name="pass" placeholder="Password"><br>
				</div>
				<div class="modal-footer" style="background-color:green;" >
					<button name="btnAdminLogin" class="btn btn-success" type="submit">Login</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	

	
	<div class="Container" style="background-color:green;padding: 10px 90px; margin-top:0px; opacity: 0.6;" >
		
	</div>

	<div class="container" style="background-color:rgba(0,0,0,0.7);margin-top:20px;">
	<hr>
	</div>
	<div class="container" style="background-color:white;padding: 5px 25px; height:400px; ">
	<h2 style="color:green;font-weight:bold;text-align:center;">The Best in the Loan Market</h2>
			<div class="col-lg-6">
				<img src="images\emplo.jpg" style="align:center;-moz-border-radius:15px;-webkit-border-radius:15px;height:370px;background-color:red;"/>
			</div>
			<div class="col-lg-6" >
				<div class="row" >
					<div class="col-lg-6" >
						<a href="#userReg" data-toggle="modal"><img src="images\log.jpg" style="height:150px;width:90%;">New Applicant Registration</img></a>
					</div>	
					<div class="col-lg-6" >
						<a href="#userLogin" data-toggle="modal"><img src="images\login.jpg" style="height:150px;width:90%;">Registered Applicant Login</img></a>
					</div>	
				</div>
				<div class="row" >
					<div class="col-lg-6" >
						<a href="#userAdminLogin" data-toggle="modal"><img src="images\login.jpg" style="height:150px;width:90%;">Administrator Login</img></a>
					</div>	
					<div class="col-lg-6" >
						<a href="#"><img src="images\contact.jpg" style="height:150px;width:90%;">Contact Us</img></a>
					</div>	
				</div>
			</div>
	</div>
<div class="container" style="background-color:rgba(0,0,0,0.7);">
<hr>
</div>

	  
            
		<!-- all js here -->
		<!-- jquery latest version -->
        <script src="js/vendor/jquery-1.12.4.min.js"></script>
		<!-- bootstrap js -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- Google Map js -->
        <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
        <script src="js/jquery-ui.js"></script>		<!-- owl.carousel js -->
        <script src="js/owl.carousel.min.js"></script>
        <!-- easing js -->
        <script src="js/easing.js"></script>
        <!-- jquery.appear js -->
        <script src="js/jquery.appear.js"></script>
        <!-- animated js -->
        <script src="js/animated.js"></script>
        <!-- Mixitup js -->
        <script src="js/jquery.mixitup.min.js"></script>
        <!-- wow js -->
        <script src="js/wow.min.js"></script>
        <!-- counter js -->
        <script src="js/jquery.counterup.min.js"></script>
        <script src="js/waypoints.js"></script>
		<!-- plugins js -->
        <script src="js/plugins.js"></script>
		<!-- main js -->
        <script src="js/main.js"></script>
        <!-- Calendar -->
        <!-- //Calendar -->
    </body>	
	
</html>			