<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>DeviceManager</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <script src="./js/jquery.js"></script>
<script src="./js/jquery-ui.js"></script>
</head>
<body class="fixed-nav bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.html">Device Manager</a>
    
    <!-- button responsive -->
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- end button -->


    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="DeviceManager">
          <a class="nav-link" href="device.php">
            <i class="fa fa-fw fa-user"></i>
            <span class="nav-link-text">Device Manager</span>
          </a>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="roommanager.php">
            <i class="fa fa-refresh fa-windows fa-fw"></i>
            <span class="nav-link-text">Room Manager</span>
          </a>
        </li> 
      </ul>

      <!-- zoom -->
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <!-- end zoom -->

      <ul class="navbar-nav ml-auto">
		<li class="nav-item">
			<a class="nav-link">
            <i class="fa fa-user-circle"></i> Admin</a>
		</li>
		
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </li>
      </ul>
    </div>
  </nav>

<?php
	session_start(); 
	if(is_null($_SESSION['user_id'])){
		echo '<script type="text/javascript"> window.location = "./login.php"</script>';
	}
?>

  <div class="content-wrapper">
    <div class="container">
     
      <!-- Example DataTables Card-->
       <div class="card mb-3">
        <div class="card-header">
          </div>
        <div class="card-body">
          <div class="table-responsive">
            <div id="show"></div>
          </div>
        </div>
         <div class=" card-footer small text-muted"></div>
		<div id="server-results"></div>
    </div>
  </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
   
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>

<script>
  
  if (sessionStorage.sysDeviceMess) {
    document.getElementById("server-results").innerHTML = sessionStorage.sysDeviceMess
  } 
  
  function myFunction(starid){

	var check = document.getElementsByClassName(starid)[1].value;
    if(check == 0){
      document.getElementsByClassName(starid)[0].style.color = "#ffcc00";
	  document.getElementsByClassName(starid)[1].setAttribute('value','1');
	  sessionStorage.setItem(starid,'1');
    } else {
      document.getElementsByClassName(starid)[0].style.color = "black";
	  document.getElementsByClassName(starid)[1].setAttribute('value','0');
	  sessionStorage.setItem(starid,'0');
    }
	
  }

  $(".addDevice").submit(function(event){
	  
    event.preventDefault(); //prevent default action 
    var post_url = $(this).attr("action"); //get form action url
    var request_method = $(this).attr("method"); //get form GET/POST method
    var form_data = $(this).serialize(); //Encode form elements for submission
    
    $.ajax({
        url : post_url,
        type: request_method,
        data : form_data
    }).done(function(response){ //
        sessionStorage.sysDeviceMess = response;
		location.reload();
    });
  });
  
  $('#show').load('acklistdata.php')
  
  $(document).ready(function() {
	setInterval(function () {
		$('#show').load('acklistdata.php')
	}, 5000);
  });

 

</script>

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
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
    <script src="js/sb-admin-charts.min.js"></script>
  </div>
</body>

</html>
