<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Login</title>
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
    <a class="navbar-brand" style="color: white; cursor: default">Login</a>
    
    <!-- button responsive -->
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- end button -->

    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Home">
          <a class="nav-link" href="index.php">
            <i class="fa fa-home fa-fw"></i>
            <span class="nav-link-text">Home</span>
          </a>
        </li>
		
		<?php
		// Print out Room specification on navigation
		$servername = "localhost";
		$username = "root";
		$password = "admin123";
		$dbname = "iot";
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		$sql = "SELECT rm_name, rm_id FROM room ORDER BY posi";
		// Query SQL
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
		?>
			<li class="nav-item" data-toggle="tooltip" data-placement="right" title="<?php echo($row["rm_name"]) ?>">
				<a class="nav-link" href="roomspec.php?id=<?php echo($row["rm_id"]) ?>">
					<i class="fas fa-tag"></i>
					<span class="nav-link-text"> <?php echo($row["rm_name"]) ?></span>
				</a>
			</li>
		<?php
			}
		}
		// Close connection
		$conn->close();
		?>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="DeviceManager">
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
    </div>
  </nav>

  <div class="content-wrapper">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header" style="text-align:center;"><i class="fa fa-lock"></i><strong> Login</strong></div>
		<div class="card-body">
			<form action="signin.php" method="post" class='signin'>
			  <div class="form-group">
				<label for="exampleInputUsername"><strong>Username</strong></label>
				<input readonly name='username' class="form-control" id="exampleInputUsername" type="text" aria-describedby="emailHelp" value="admin">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword"><strong>Password</strong></label>
				<input required name='password' class="form-control" id="exampleInputPassword" type="password" placeholder="Password">
			  </div>
			  <button type='submit' class="btn btn-primary btn-block" >Sign In</button>
			</form>
		</div>
		<br>
        <div class="text-center">
          <a style="cursor: pointer; color: #007bff;" class="d-block small" onclick="captcha()" data-toggle="modal" data-target="#kbiresetpass">Reset Admin's Password</a>
        </div>
		<br>
		<div style="text-align: center" id="server-results"><!-- For server results --></div>
    </div>
  </div>
  </div>
 
</body>
  
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fa fa-angle-up"></i>
</a>
	
<!--Enter Capcha pop-up-->
<div class="modal fade" id="kbiresetpass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">  
      <div class="modal-body">
		<div class="form-group">
			<h5>Enter a captcha sent to your phone</h5>
			<input class="form-control" type="text" name="incaptcha">
			<br>
			<button id="nextsucss" class="btn btn-primary btn-block" onclick="checkcaptcha()" >Check</button>
			<br>
			<div style="text-align: center" id="check-results"></div>
		</div>          
      </div>          
    </div>
  </div>
</div>


<script>
  // Sign in method
  $(".signin").submit(function(event){
	// Get the URL, request method, form data from sign in form 
    event.preventDefault(); //prevent default action 
    var post_url = $(this).attr("action"); //get form action url
    var request_method = $(this).attr("method"); //get form GET/POST method
    var form_data = $(this).serialize(); //Encode form elements for submission
    // Using AJAX to request to server
    $.ajax({
        url : post_url,
        type: request_method,
        data : form_data
    }).done(function(response){
	if(response == 'login'){
		//If login sucess, go to device.php
		window.location = './device.php';
	}else{ // Else will show fail status, on div server-results	
		$("#server-results").html(response);
	}
    });
  })
  
  // Send captcha method
  function captcha(){
	// Using AJAX to request to server
	$.ajax({
        url: 'sentcaptcha.php', 
        dataType: 'text',
        cache: false,
        data: {
		  phone:'reset'  
		},                       
        method: 'post'
    }); 
  }
  
  // Check enter captcha method
  function checkcaptcha(){
	// Prepare data
	var incaptcha = $('[name=incaptcha]').val();
	// Using AJAX to request to server
	$.ajax({
        url: 'checkcaptcha.php', 
        dataType: 'text',
        cache: false,  
        data: {
			incaptcha: incaptcha,
			phone: 'reset'
		},  		
        method: 'post',
        success: function(res){
			// If reset status is okay
			if(res == 'resetokay'){
				alert("Your admin's password has been reset to default password successfully !!!");
				location.reload();
			}else{ // Else will show fail status, on div check-results	
				$("#check-results").html(res);
			}
        }
    }); 
  }
</script>
<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Page level plugin JavaScript-->
<script src="vendor/datatables/jquery.dataTables.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.js"></script>
<!-- Custom scripts for all pages-->
<script src="js/sb-admin.min.js"></script>
<!-- Custom scripts for this page-->
<script src="js/sb-admin-datatables.min.js"></script>

</html>



