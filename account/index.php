<?php
session_start();

if(!isset($_SESSION['NatID'])){
	header("location: ../index.php?error=log-in-required");
	exit();
}
include('../dbconnect.php');
	
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
        <link href="../admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- animate css -->
        <link rel="stylesheet" href="../css/animate.css">
		
    </head>
    <body >
	
	<nav class="navbar navbar-dark bg-dark flex-md-nowrap p-0 shadow">
	  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="http://localhost/orinon">Orinon Loans</a>
	  <ul class="list-inline px-3">
		<li class=" list-inline-item">
		  <a class="nav-link text-white" href="profile.php">Profile</a>
		</li>
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

		  <div class="container-fluid">
			<div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
				<img class="mr-3" src="http://orinon.co.zw/img/lgl.jpg" alt="" width="200">
				<div class="lh-100">
				  <h6 class="mb-0 text-white lh-100">Dashboard</h6>
				  <small>Since 2018</small>
				</div>
			  </div>

			  <div class="my-3 p-3 bg-white rounded shadow-sm">
				<h6 class="border-bottom border-gray pb-2 mb-0">Pending Applications</h6>
				<?php 

				$me = $_SESSION['NatID'];
					$lsq = "SELECT * FROM `loanapps` WHERE  `user`= '$me' AND `status` = '0'";
					$lqry = mysqli_query($myConn, $lsq);

					if (mysqli_num_rows($lqry) != 0) {
						while ($lrs = mysqli_fetch_assoc($lqry)) {
							?>
							
							<div class="media text-muted pt-3">
								<svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"/><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>
								<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
								<strong class="d-block text-gray-dark">Status: <i class="text-warning">Pending</i></strong>
									<ul class="list-inline">
										<li class="list-inline-item">Date: <?php echo date("d/m/Y",strotime($lrs['dt']));?></li>
										<li class="list-inline-item">Amount: <?php echo $lrs['amnt'] ?></li>
										
									</ul>
								</p>
							</div>

							<?php
						}
					}else {
						# code...
					}
				
				
				?>
				
				
				
			  </div>

			  <div class="my-3 p-3 bg-white rounded shadow-sm">
				<h6 class="border-bottom border-gray pb-2 mb-0">Active Loans</h6>
				
				
				<?php 
								$lsql = "SELECT * FROM `loans` WHERE  `us_id`= '$me' AND `status` = '1'";
								$lqryy = mysqli_query($myConn, $lsql);

								if (mysqli_num_rows($lqryy) != 0) {
									while ($lrrs = mysqli_fetch_assoc($lqryy)) {
										?>
										
										<div class="media text-muted pt-3">
												<svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"/><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>
												<div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
												<div class="d-flex justify-content-between align-items-center w-100">
													<strong class="text-gray-dark">Status: <i class="text-success">Active</i></strong>
													<a href="#">More</a>
												</div>
												<ul class="list-inline">
													<li class="list-inline-item">Amount: <?php echo $lrrs['amnt']; ?></li>
													<li class="list-inline-item">Due: <?php echo date("d/m/Y",strotime($lrrs['due_dt']));?></li>
													<li class="list-inline-item">Interest: <?php echo $lrrs['interest'] * 100; ?></li>
												</ul>
												</div>
											</div>

										<?php
									}
								}else {
									echo "No loans found";
								}


							?>

			  </div>
		  </div>
		  <hr>
		</main>
	  </div>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="../css/bootstrap/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
	<script src="https://getbootstrap.com/docs/4.3/examples/dashboard/dashboard.js"></script>
	
	</body>	
	
</html>			