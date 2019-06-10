<?php
session_start();
if(!isset($_SESSION['AdminNatID'])){
	header("location: http://localhost/orinon/?error=log-in-required");
	exit();
}
include('../dbconnect.php');


?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Orinon Admin - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="index.php">Orinon Loans</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    
  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Loans</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Loans:</h6>
          <a class="dropdown-item" href="loan-apps.php">Applications</a>
          <a class="dropdown-item" href="loans.php">Paid Up</a>
          <a class="dropdown-item" href="bad-debts.php">Bad Debts</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="credit-scores.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Credit Score Applications</span></a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="members.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Clients</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-lock"></i>
          <span>Logout</span>
        </a>
      </li>
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Overview</li>
        </ol>

        <!-- Icon Cards-->
        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-comments"></i>
                </div>
                <div class="mr-5">26 New Messages!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-list"></i>
                </div>
                <div class="mr-5">
                <?php
                
                $asql = "SELECT * FROM `loanapps` WHERE 1";
                $aqry = mysqli_query($myConn, $asql);
                
                echo "(".mysqli_num_rows($aqry).")";
                ?> New Applications!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="loan-apps.php">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-shopping-cart"></i>
                </div>
                <div class="mr-5">
                <?php
                
                $lsql = "SELECT * FROM `loans` WHERE `status`='1'";
                $lqry = mysqli_query($myConn, $lsql);
                
                echo "(".mysqli_num_rows($lqry).")";
                ?> Active Loans!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="loans.php">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-life-ring"></i>
                </div>
                <div class="mr-5">
                <?php
                
                $tsql = "SELECT * FROM `jobs` WHERE `status`='0'";
                $tqry = mysqli_query($myConn, $tsql);
                
                echo "(".mysqli_num_rows($tqry).")";
                ?> Open Tickets!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="credit-scores.php">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
        </div>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Active Loans</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>ID Number</th>
                    <th>Loan Type</th>
                    <th>Amount</th>
                    <th>Interest</th>
                    <th>Due Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  
                  $llsql = "SELECT * FROM `loans` WHERE `status`='1'";
                  $llqry = mysqli_query($myConn, $llsql);
                  if (mysqli_num_rows($llqry) == 0) {
                    ?>
                    
                    <tr>
                      <td>*</td>
                      <td>**</td>
                      <td>*</td>
                      <td>* No active loans found *</td>
                      <td>**</td>
                      <td>*</td>
                    </tr>
                    
                    <?php 
                  }else {
                    while($lrs = mysqli_fetch_assoc($llqry)){

                      $us = $lrs['us_id'];
                      $tp = $lrs['type'];

                      $tpsq = "SELECT * FROM `loancat` WHERE  `id`='$tp'";
                      $tpqry = mysqli_query($myConn, $tpsq);
                      $tprs = mysqli_fetch_assoc($tpqry);

                      $msql = "SELECT * `clients` WHERE `nationalId`='$us'";
                      $mqry = mysqli_query($myConn, $msql);
                      $mrs = mysqli_fetch_assoc($mqry);
                      ?>
                      <tr>
                        <td><?php echo $mrs['firstName']." ".$mrs['surName']; ?></td>
                        <td><?php echo $mrs['nationalId']; ?></td>
                        <td><?php echo $tprs['name']; ?></td>
                        <td>$<?php echo $lrs['amnt']; ?></td>
                        <td><?php echo $lrs['interest'] * 100; ?>%</td>
                        <td><?php echo date("d/m/Y", strtotime($lrs('due_dt'))); ?></td>
                      </tr>
                    <?php
                    }
                  }
                  
                  ?>
                  
                  
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>

      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Orinon <?php echo date("Y"); ?></span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-success" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>

</body>

</html>
