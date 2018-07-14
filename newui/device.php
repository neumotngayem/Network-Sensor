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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
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
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Home">
          <a class="nav-link" href="main.php">
            <i class="fa fa-home fa-fw"></i>
            <span class="nav-link-text">Home</span>
          </a>
        </li>
		
		<?php
		$servername = "localhost";
		$username = "root";
		$password = "admin123";
		$dbname = "iot";
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		$sql = "SELECT rm_name, rm_id FROM room";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
		?>
			<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
				<a class="nav-link" href="roomspec.php?id=<?php echo($row["rm_id"]) ?>">
					<i class="fas fa-tag"></i>
					<span class="nav-link-text"> <?php echo($row["rm_name"]) ?></span>
				</a>
			</li>
		<?php
			}
		}
		$conn->close();
		?>
		
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="DeviceManager">
          <a class="nav-link" href="device.php">
			<i style="color: white;" class="fa fa-fw fa-tablet"></i>
            <span style="color: white;" class="nav-link-text">Device Manager</span>
          </a>
        </li>

         <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="room.php">
            <i class="fab fa-windows"></i>
            <span class="nav-link-text"> Room Manager</span>
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
            <i class="fa fa-fw fa-sign-out-alt"></i>Logout</a>
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
	
	
		<div class="form-inline">
		<div class="form-group">
		<select class="form-control" id="">
			<option selected>SSID</option>
			<option value="1">One</option>
			<option value="2">Two</option>
			<option value="3">Three</option>
		</select>
		</div>
		<div class="form-group">
		<input placeholder="Password" type="text" class="form-control"></input>
		</div>
			<div class="btn-group ">
				<button class="btn btn-success" style="color: black" ><i class="fa fa-wifi" > Conect</i></button>
				<button class="btn bg-danger" ><strong>Status: </strong><i> Disconected</i></button>
			</div> 		
		</div>
	

		<p>
			<div class="btn-group" id='devicestatus'></div>
		</p>
		
		<p>
			<div class="btn-group ">
				<button class="btn bg-warning" ><i class="fas fa-mobile-alt" > Change</i></button>
				<span class="btn btn-success" style="cursor: default; color: black" ><strong>Registered : </strong><i> 01248077279</i></span>
			</div>
		</p>	
	
	<button style="margin-bottom: 15px;" class="btn bg-warning" ><i class="fa fa-key"> Change Admin's Password</i></button>
	</br>
	
	<!-- <a class="btn btn-primary" href="turnonoff.php?state=on">Turn on device</a> -->
      <!-- Example DataTables Card-->
    <div class="card mb-3">
        <div class="card-header"><b>WX-Net nodes</b></div>
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
	
  };

  function addRoom(rownum){
	var star = document.getElementsByName("star")[rownum].defaultValue;
	var dvid = document.getElementsByName("dvid")[rownum].defaultValue;
	var dvtype = document.getElementsByName("dvtype")[rownum].defaultValue;
	var room = document.getElementById("dropdown"+dvid).value;
	if(room == ''){
		alert('You have to select a Room first, If not have go to Room Manager and add your room');
		return;
	}
	$.ajax({
        url: 'adddevice.php', 
        dataType: 'text',
        cache: false,
        data: {
		star:  star,
		dvid:  dvid,
		dvtype: dvtype,
		room: room,
		},                       
        method: 'post',
        success: function(res){ 
			sessionStorage.sysDeviceMess = res;
			location.reload();
        }
    });
  };
  
  function turnonoff(state){
	$.ajax({
        url: 'turnonoff.php', 
        dataType: 'text',
        cache: false,
        data: {
		state:  state,
		},                       
        method: 'get',
        success: function(res){
			location.reload();
        }
    });  
  };
  
  $('#show').load('acklistdata.php');
  $('#devicestatus').load('devicestatus.php');
  
  $(document).ready(function() {
	setInterval(function () {
		$('#show').load('acklistdata.php');
		$('#devicestatus').load('devicestatus.php')
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