<?php
	$servername = "localhost";
	$username = "root";
	$password = "admin123";
	$dbname = "iot";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	$rm_id = $_GET["id"];
	$sql2 = "SELECT rm_name FROM room where rm_id=".$rm_id;
	$result2 = $conn->query($sql2);
	$row2 = $result2->fetch_assoc();
?>	
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?php echo($row2["rm_name"]) ?></title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>

<body class="fixed-nav bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.html"><?php echo($row2["rm_name"]) ?></a>
    
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
		$sql = "SELECT rm_name, rm_id FROM room";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
		?>
			<li class="nav-item" data-toggle="tooltip" data-placement="right" title="<?php echo($row["rm_name"]) ?>">
				<a class="nav-link" href="roomspec.php?id=<?php echo($row["rm_id"]) ?>">
					<?php
						if($rm_id == $row["rm_id"]){
					?>
					<i style="color: white;" class="fas fa-tag"></i>
					<span style="color: white;" class="nav-link-text"> <?php echo($row["rm_name"]) ?></span>
					<?php
						}else{
					?>
					<i class="fas fa-tag"></i>
					<span class="nav-link-text"> <?php echo($row["rm_name"]) ?></span>
					<?php
						}
					?>
				</a>
			</li>
		<?php
			}
		}
		$conn->close();
		?>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Device Manager">
          <a class="nav-link" href="device.php">
            <i class="fa fa-fw fa-tablet"></i>
            <span class="nav-link-text">Device Manager</span>
          </a>
        </li>

         <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Room Manager">
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
	    <?php
		session_start();
		if(!is_null($_SESSION['user_id'])){
		?>
		<li class="nav-item">
			<a class="nav-link">
            <i class="fa fa-user-circle"></i> Admin</a>
		</li>
		
		<li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out-alt"></i>Logout</a>
        </li>
		<?php
		}else{
		?>
		<li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#kbi">
            <i class="fas fa-sign-in-alt"></i> Login</a>
        </li>
		<?php
		}
		?>
      </ul>
    </div>
  </nav>

	<div class="content-wrapper">
		<div class="container">
				<div id="show"></div>	
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
	
	<!-- Login Modal -->
	<div class="modal fade" id="kbi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div  class="modal-header">
            <h4  class="modal-title" id="exampleModalLabel" style="text-align:center;"><i class="fa fa-lock"></i><strong> Login</strong></h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
         <div class="modal-body">
         <form action="signin.php" method="post" class='signin'>
          <div class="form-group">
            <label for="exampleInputEmail1"><strong>User Name</strong></label>
            <input required name='username' class="form-control"  id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="Username">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1"><strong>Password</strong></label>
            <input required name='password' class="form-control" id="exampleInputPassword1" type="password" placeholder="Password">
          </div>
          <button type='submit' class="btn btn-primary btn-block" >Sign In</button>
        </form>
		<br>
        <div class="text-center">
          <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
        </div>
		<br>
		<div id="login-results"><!-- For server results --></div>
        </div>
          
        </div>
      </div>
    </div>


    <script>
	  
	function editFav(dvid, fav){
		$.ajax({
        url: 'editfav.php', 
        dataType: 'text',
        cache: false,
        data: {
			fav: fav,
			dvid: dvid,
		},                       
        method: 'post',
        success: function(res){ 
			sessionStorage.sysRoomSpecMess = res;
			location.reload();
        }
		});
		  
	}
	
	$('#show').load('roomlistdata.php?id=<?php echo($rm_id) ?>');
	  
	$(document).ready(function() {
		setInterval(function () {
			$('#show').load('roomlistdata.php?id=<?php echo($rm_id) ?>')
		}, 5000);
	});
	
	$(".signin").submit(function(event){
	  
    event.preventDefault(); //prevent default action 
    var post_url = $(this).attr("action"); //get form action url
    var request_method = $(this).attr("method"); //get form GET/POST method
    var form_data = $(this).serialize(); //Encode form elements for submission
    
    $.ajax({
        url : post_url,
        type: request_method,
        data : form_data
    }).done(function(response){ //
	
	if(response === 'login'){
		location.reload();
	}else{
		$("#login-results").html(response);
	}
    });
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
