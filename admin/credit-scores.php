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
                        <a href="index.php">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Credit Score</li>
                </ol>

                <!-- Page Content -->
                <h1>Credit Score Validation</h1>
                <hr>
                <div class="my-3 p-3 bg-white rounded shadow-sm">
                    <h6 class="border-bottom border-gray pb-2 mb-0">Open Tickets</h6>
                    <?php
                    $sql = "SELECT * FROM `jobs` WHERE `status`='0'";
                    $qry = mysqli_query($myConn, $sql);
                    
                    if (mysqli_num_rows($qry) != 0) {
                        while($rs = mysqli_fetch_assoc($qry)){
                            $tid = $rs['id'];
                            $csql = "SELECT * FROM `creditscoreuploads` WHERE `job`='$tid'";
                            $cqry = mysqli_query($myConn, $csql);

                            ?>
                            
                            <div class="media text-muted pt-3">
                                <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"/><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>
                                <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <strong class="text-gray-dark">Ticket Number: <b><?php echo $rs['id'] ?></b></strong>
                                        <a href="#">Action</a>
                                    </div>
                                    <span class="d-block">Status: <i class="text-success">Open</i></span>
                                    <hr>
                                    <div class="row">
                                        <?php
                                        
                                        if (mysqli_num_rows($cqry) != 0) {
                                            while($rrs = mysqli_fetch_assoc($cqry)){
                                                ?>
                                                
                                                <div class="col-md-4">
                                                    <div class="card" style="width: 18rem;">
                                                        <div class="card-body">
                                                            <h5 class="card-title"><a href="http://localhost/orinon/account/users/files/<?php echo $rrs['file']; ?>"><?php
                                                            if ($rrs['cat'] == 4) {
                                                                echo "National ID";
                                                                $ft = "nd";
                                                            }elseif ($rrs['cat'] == 5) {
                                                                echo "Car Registration Book";
                                                                $ft = "crb";
                                                            }elseif ($rrs['cat'] == 6) {
                                                                echo "Title Deeds";
                                                                $ft = "td";
                                                            }
                                                            
                                                            ?></a></h5>
                                                            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                                                <span>Status: <?php if ($rrs['status'] == 0) {
                                                                    echo '<i class="text-danger">Not Checked</i></span>';
                                                                }elseif ($rrs['status'] == 1) {
                                                                    echo '<i class="text-success">Checked & Validated</i></span>';
                                                                } ?>
                                                            </p>
                                                            <hr>
                                                            <?php if ($rrs['status'] == 0) { ?>
                                                            <form method="get" action="validate.php">
                                                                <input type="hidden" name="fileType" value="<?php echo $rrs['cat']; ?>">
                                                                <input type="hidden" name="ticket" value="<?php echo $rs['id']; ?>">
                                                                <input type="hidden" name="file" value ="<?php echo $rs['file']; ?>">
                                                                <input type="hidden"name="mID" value="<?php echo $rrs['user']; ?>">
                                                                <ul class="list-inline input-group">
                                                                    <li class="list-inline-item">
                                                                        <label for="">Credit Score</label>
                                                                    </li>
                                                                    <li class="list-inline-item">
                                                                        <input type="number" required class="form-control" style="width: 70px;" name="score" value="<?php echo $ft; ?>">
                                                                    </li>
                                                                    <li class="list-inline-item">
                                                                        <button type="submit" class="btn btn-success"><small>Validate</small></button>
                                                                    </li>
                                                                </ul>
                                                            </form><?php }elseif ($rrs['status'] == 1) {
                                                                echo '<button style="border-radious:0; margin-left:70px;" class="btn btn-warning"><small><i class="fas fa-check text-success"> Validated</i></small></button>';
                                                            }?>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <?php
                                            }
                                        }
                                        
                                        ?>
                                        
                                        <div class="col-md-12">
                                             <hr>
                                            <p><i class="text-info"> Download or Open file and Inspect. Click Validate to give Document Score and Save</i></p>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php

                        }
                    }else {
                        ?>
                            <div class="media text-muted pt-3">
                                <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32"><title>Placeholder</title><rect width="100%" height="100%" fill="green"/><text x="50%" y="50%" fill="green" dy=".3em">32x32</text></svg>
                                <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                    <strong class="text-success">No Open Tickets</strong>
                                    <a href="index.php">Back</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        <?php
                    }
                    ?>
                    
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