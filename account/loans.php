<?php
session_start();

if(!isset($_SESSION['NatID'])){
	header("location: ../index.php?error=log-in-required");
	exit();
}
include_once('../dbconnect.php');
include_once("../functions.php");

if(isset($_POST['apply'])){

	
	//capture loan type and validate using regex
	if (preg_match ('%^[1-3]{1,1}$%', stripslashes(trim($_POST['loanType'])))) {

		$lt = func::escape_data($myConn, $_POST['loanType']);

	} else {
		$lt = FALSE;

		echo("<script>
			window.alert('Please select valid loan type.')
			window.location.href='loans.php'
			</script>");
			exit();
	}
	//capture loan amount, and validate using regex
	if (preg_match ('%^[0-9]{3,7}$%', stripslashes(trim($_POST['lnAmnt'])))) {

		$lAmnt = func::escape_data($myConn, $_POST['lnAmnt']);

	} else {
		$lAmnt = FALSE;

		echo("<script>
			window.alert('Please enter valid loan amount in numeric values. Please note that valid loan amounts range from $100 to $1 000 000 only')
			window.location.href='loans.php'
			</script>");
			exit();
	}

	if($lAmnt && $lt){
		
		$IDval = $_SESSION['NatID'];
		$id = func::code(3);
		$crsql = "SELECT * FROM `clients` WHERE `nationalId`='$IDval'";
		$crqry = mysqli_query($myConn, $crsql);
		$crs = mysqli_fetch_assoc($crqry);
		$credit = $crs['c_score'];
		$dur = "";
		$lm = "";
		$intre = "";
		if($lt == 1){
			//educational
			if($credit >=100){
				
				if($credit >=100 && $credit < 500){
					$dur = 6;
					$lm = 1000;
					$intre = 0.1;
				}elseif($credit >=100 && $credit < 800){
					$dur = 12;
					$lm = 2000;
					$intre = 0.08;
				}else{
					$dur = 24;
					$due = date('Y-m-d', strtotime($date .'+'.$dur.' month'));
					$lm = 3000;
					$intre = 0.06;
				}
				
				if($lAmnt <= $lm){
					$ssql = "INSERT INTO `loans`(`id`, `us_id`, `type`, `amnt`,`interest`, `dt_applied`,`due_dt`,`ack_recpt`, `status`) VALUES ('$id','$IDval','$lt','$lAmnt','$intre',now(),'$due','0','1')";
					$sqry = mysqli_query($myConn, $ssql);
					if($sqry){
						echo("<script>
									window.alert('Congratulations. Your loan has been approved. Check below the loan terms and confirm receipt')
									window.location.href='loan-terms.php?ln=".mysqli_insert_id($myConn)."&status=approved'
								 </script>");
						exit();
					}else{
						echo("<script>
									window.alert('Loan Application could not finish. Please contact administrator for further help.')
									window.location.href='loans.php?error=application-failed&action=admin'
								 </script>");
						exit();
					}
				}else{
					echo("<script>
									window.alert('Your loan application has been rejected. Your credit score is too litle to qualify for a loan of that magnitude. Check below for more details')
									window.location.href='loan-rejected.php?amnt=".$lAmnt."&credit=".$credit."'
								 </script>");
						exit();
				}
				
			}else{
				echo("<script>
									window.alert('Your loan application has been rejected. Your credit score is too litle to qualify for a loan of that magnitude. Check below for more details')
									window.location.href='loan-rejected.php?amnt=".$lAmnt."&credit=".$credit."'
								 </script>");
						exit();
			}
		}elseif($lt == 2){
			//business
	
			if($credit >=1000){
				
				if($credit >=1000 && $credit < 2000){
					$dur = 6;
					$lm = 2500;
					$intre = 0.09;
				}elseif($credit >=2000 && $credit < 3500){
					$dur = 12;
					$lm = 4000;
					$intre = 0.06;
				}else{
					$dur = 24;
					$lm = 6000;
					$intre = 0.05;
				}
				if($lAmnt <= $lm){
					$ssql = "INSERT INTO `loans`(`id`, `us_id`, `type`, `amnt`,`interest`, `dt_applied`,`due_dt`,`ack_recpt`, `status`) VALUES ('$id','$IDval','$lt','$lAmnt','$intre',now(),'$dur','0','1')";
					$sqry = mysqli_query($myConn, $ssql);
					if($sqry){
						echo("<script>
									window.alert('Congratulations. Your loan has been approved. Check below the loan terms and confirm receipt')
									window.location.href='loan-terms.php?ln=".mysqli_insert_id($myConn)."&status=approved'
								 </script>");
						exit();
					}else{
						echo("<script>
									window.alert('Loan Application could not finish. Please contact administrator for further help.')
									window.location.href='loans.php?error=application-failed&action=admin'
								 </script>");
						exit();
					}
				}else{
					echo("<script>
									window.alert('Your loan application has been rejected. Your credit score is too litle to qualify for a loan of that magnitude. Check below for more details')
									window.location.href='loan-rejected.php?amnt=".$lAmnt."&credit=".$credit."'
								 </script>");
						exit();
				}
				
			}else{
				echo("<script>
									window.alert('Your loan application has been rejected. Your credit score is too litle to qualify for a business loan.')
									window.location.href='loan-rejected.php?amnt=".$lAmnt."&credit=".$credit."'
								 </script>");
						exit();
			}
	
		}elseif($lt == 3){
			//mortgage
			if($credit >=5000){
				
				if($credit >=5000 && $credit < 6000){
					$dur = 6;
					$lm = 20000;
					$intre = 0.095;
				}elseif($credit >=6000 && $credit < 10000){
					$dur = 12;
					$lm = 50000;
					0.075;
				}else{
					$dur = 24;
					$lm = 100000;
					$intre = 0.065;
				}
				if($lAmnt <= $lm){
					$ssql = "INSERT INTO `loans`(`id`, `us_id`, `type`, `amnt`,`interest`, `dt_applied`,`due_dt`,`ack_recpt`, `status`) VALUES ('$id','$IDval','$lt','$lAmnt','$intre',now(),'$dur','0','1')";
					$sqry = mysqli_query($myConn, $ssql);
					if($sqry){
						echo("<script>
									window.alert('Congratulations. Your loan has been approved. Check below the loan terms and confirm receipt')
									window.location.href='loan-terms.php?ln=".mysqli_insert_id($myConn)."&status=approved'
								 </script>");
						exit();
					}else{
						echo("<script>
									window.alert('Loan Application could not finish. Please contact administrator for further help.')
									window.location.href='loans.php?error=application-failed&action=admin'
								 </script>");
						exit();
					}
				}else{
					echo("<script>
									window.alert('Your loan application has been rejected. Your credit score is too litle to qualify for a loan of that magnitude. Check below for more details')
									window.location.href='loan-rejected.php?amnt=".$lAmnt."&credit=".$credit."'
								 </script>");
						exit();
				}
				
			}else{
				echo("<script>
									window.alert('Your loan application has been rejected. Your credit score is too litle to qualify for a Morgage loan. Check below for more details')
									window.location.href='loan-rejected.php?amnt=".$lAmnt."&credit=".$credit."'
								 </script>");
						exit();
			}
		}else{
			echo("<script>
						window.alert('Invalid Access Detected.')
						window.location.href='../index.php?error=flad-invalid-access'
						</script>");
			exit();
		}
	}

	
	
}

?>

<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Orinon - Account</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Google Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Lato:400,700,400italic,300' rel='stylesheet' type='text/css'>

		<!-- all css here -->
		
		<link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
        
		<!-- owl.carousel css -->
        <link rel="stylesheet" href="../css/owl.carousel.css">
        <link rel="stylesheet" href="../css/owl.transitions.css">
		<!-- font-awesome css -->
        <link rel="stylesheet" href="../admin/vendor/fontawesome-free/css/all.min.css">
        <!-- animate css -->
        <link rel="stylesheet" href="../css/animate.css">
		
    </head>
    <body >
	
	<nav class="navbar navbar-dark bg-dark flex-md-nowrap p-0 shadow">
	  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="http://localhost/orinon">Orinon Loans</a>
	  <ul class="list-inline px-3">
		<li class="list-inline-item">
			
		  <a class="nav-link text-white" href="#"><span data-feather="bell"></span>(0)</a>
		</li>
		<li class="list-inline-item">
		  <a class="nav-link text-white" href="logout.php">Sign out</a>
		</li>
	  </ul>
	</nav>

	<div class="container-fluid">
	  <div class="row">
		<nav class="col-md-2 d-none d-md-block bg-light sidebar">
		  <div class="sidebar-sticky">
			<ul class="nav flex-column">
			  <li class="nav-item">
				<a class="nav-link active" href="#">
				  <span data-feather="home"></span>
				  Dashboard <span class="sr-only">(current)</span>
				</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="credit.php">
				  <span data-feather="plus"></span>
				  Credit Rating
				</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="loans.php">
				  <span data-feather="shopping-cart"></span>
				  Loans
				</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="profile.php">
				  <span data-feather="users"></span>
					Profile
				</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="#">
				  <span data-feather="bar-chart-2"></span>
				  Reports
				</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="settings.php">
				  <span data-feather="layers"></span>
				  Settings
				</a>
			  </li>
			</ul>
		  </div>
		</nav>

		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
		  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">Dashboard</h1>
		  </div>
			<div id="loanApplication" class="modal fade">
					<div class="modal-dialog" style="margin-top:30px;">
						<div class="modal-content">
							<div class="modal-header">
								<img src="../images/logos.jpg" style="-moz-border-radius:15px;-webkit-border-radius:15px;height:125px;"/><label style="font-size:20pt;"></label>
							</div>
							<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" autocomplete="off" name="modForm4">
								<div class="modal-body">
									<select type="text" class="form-control" name="loanType" placeholder="Type of Loan">
									<option>Type of Loan</option>
									<?php
										
										$lsql = "SELECT * FROM `loanCat` WHERE 1";
										$lqry = mysqli_query($myConn, $lsql);
										while($rs = mysqli_fetch_assoc($lqry)){
											echo '<option value ="'.$rs['id'].'">'.$rs['name'].'</option>';
										}
									?>
									</select><br><br>
									<input type="number" class="form-control" name="lnAmnt" placeholder="Loan Amount"><br><br>
								</div>
								<div class="modal-footer" style="background-color:green;" >
									<button name="apply" class="btn btn-success" type="submit">Submit</button>
									<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
								</div>
							</form>
						</div>
					</div>
				</div>
		  <div class="container-fluid">
			<div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
				<img class="mr-3" src="http://orinon.co.zw/img/lgl.jpg" alt="" width="200">
				<div class="lh-100">
				  <h6 class="mb-0 text-white lh-100">Dashboard</h6>
				  <small>Since 2018</small>
				</div>
			  </div>
			  
			  <div class="my-3 p-3 bg-white rounded shadow-sm">
				<div class="media text-muted pt-3">
					<div class="row">
						<div class="col-md-4">
							<div class="card" style="width: 18rem;">
							  <div class="card-body">
								<h5 class="card-title"><a href="#loanApplication" data-toggle="modal">Apply Loan</a></h5>
								  <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
									<strong class="d-block text-gray-dark">@<?php echo $_SESSION['Alias']; ?></strong>
									Start Your loan Application
								  </p>
							  </div>
							</div>
							
						</div>
						<div class="col-md-4">
							<div class="card" style="width: 18rem;">
							  <div class="card-body">
								<h5 class="card-title"><a href="credit.php">Credit Score</a></h5>
								  <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
									<strong class="d-block text-gray-dark">@<?php echo $_SESSION['Alias']; ?></strong>
									Colleteral documents
								  </p>
							  </div>
							</div>
							
						</div>
						<div class="col-md-4">
							<div class="card" style="width: 18rem;">
							  <div class="card-body">
								<h5 class="card-title"><a href="">Settings</a></h5>
								  <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
									<strong class="d-block text-gray-dark">@<?php echo $_SESSION['Alias']; ?></strong>
									Change password/ de-activate account
								  </p>
							  </div>
							</div>
							
						</div>
					
					</div>
				  
				</div>
			  </div>

			  <div class="my-3 p-3 bg-white rounded shadow-sm">
				<h6 class="border-bottom border-gray pb-2 mb-0">Active Loans</h6>
				<div class="media text-muted pt-3">
				  <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"/><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>
				  <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
					<div class="d-flex justify-content-between align-items-center w-100">
					  <strong class="text-gray-dark">Full Name</strong>
					  <a href="#">Follow</a>
					</div>
					<span class="d-block">@username</span>
				  </div>
				</div>
				<div class="media text-muted pt-3">
				  <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"/><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>
				  <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
					<div class="d-flex justify-content-between align-items-center w-100">
					  <strong class="text-gray-dark">Full Name</strong>
					  <a href="#">Follow</a>
					</div>
					<span class="d-block">@username</span>
				  </div>
				</div>
				<div class="media text-muted pt-3">
				  <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"/><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>
				  <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
					<div class="d-flex justify-content-between align-items-center w-100">
					  <strong class="text-gray-dark">Full Name</strong>
					  <a href="#">Follow</a>
					</div>
					<span class="d-block">@username</span>
				  </div>
				</div>
			  </div>
		  </div>
		  <hr>
		</main>
	  </div>
	</div>

	<script src="../js/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="../css/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
	
	</body>	
	
</html>			