<?php
session_start();
if(!isset($_SESSION['AdminNatID'])){
	header("location: http://localhost/orinon/?error=log-in-required");
	exit();
}
include('../dbconnect.php');
include('../functions.php');

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
                        <a href="index.php">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="loans.php">Loans</a></li>
                    <li class="breadcrumb-item active">Applications</li>
                </ol>

                <!-- Page Content -->
                <h1>Loans Applications</h1>
                <hr>
                <div class="my-3 p-3 bg-white rounded shadow-sm">
                    <h6 class="border-bottom border-gray pb-2 mb-0">Open Tickets</h6>
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-table"></i>
                             Pending Applications</div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Loan Type</th>
                                    <th>Credit</th>
                                    <th>Interest</th>
                                    <th>Date Applied</th>
                                    <th>Due Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php 
                                
                                $llsql = "SELECT * FROM `loanapps` WHERE 1";
                                $llqry = mysqli_query($myConn, $llsql);
                                if (mysqli_num_rows($llqry) == 0) {
                                    ?>
                                    
                                    <tr>
                                        <td>*</td>
                                        <td>**</td>
                                        <td>*</td>
                                        <td>(0) Application</td>
                                        <td>*</td>
                                        <td>**</td>
                                        <td>*</td>
                                    </tr>
                                    
                                    <?php 
                                }else {
                                    while($lrs = mysqli_fetch_assoc($llqry)){

                                    $us = $lrs['user'];
                                    $tp = $lrs['ltype'];

                                    $tpsq = "SELECT * FROM `loancat` WHERE  `id`='$tp'";
                                    $tpqry = mysqli_query($myConn, $tpsq);
                                    $tprs = mysqli_fetch_assoc($tpqry);

                                    $msql = "SELECT * `clients` WHERE `nationalId`='$us'";
                                    $mqry = mysqli_query($myConn, $msql);
                                    $mrs = mysqli_fetch_assoc($mqry);
                                    ?>
                                    <tr>
                                        <td><?php echo $lrs['amnt']; ?></td>
                                        <td><?php echo $tprs['name']; ?></td>
                                        <td>$<?php echo $mrs['c_score']; ?></td>
                                        <td><?php echo $lrs['interest'] * 100; ?>%</td>
                                        <td><?php echo date("d/m/Y", strtotime($lrs('dt'))); ?></td>
                                        <td><?php echo date("d/m/Y", strtotime($lrs('due_dt'))); ?></td>
                                        <td>
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <a href="approve.php?action=1&lnID=<?php echo $tprs['id']; ?>" class="btn btn-sm btn-success">Approve</a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="approve.php?action=2&lnID=<?php echo $tprs['id']; ?>" class="btn btn-sm btn-danger">Reject</a>
                                                </li>
                                            </ul>
                                        </td>
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

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>

</body>

</html>