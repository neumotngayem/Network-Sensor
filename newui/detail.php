<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Detail</title>
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
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
      <!-- Morris Charts CSS -->
  <link href="vendor/morrisjs/morris.css" rel="stylesheet">
  <style type="text/css">
        .example{
            margin: 20px;
        }
 
    </style>
</head>



<body class="fixed-nav bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.html">Detail</a>
    
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
		session_start();
		$servername = "localhost";
		$username = "root";
		$password = "admin123";
		$dbname = "iot";
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		$sql = "SELECT rm_name, rm_id FROM room ORDER BY posi";
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
		</br>
		<?php
			$dvid = $_GET["dvid"];
			$sql = "SELECT type,sec,loca_id FROM home WHERE device_id='$dvid'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0 && !is_null($_SESSION['user_id']) ) {
			$row = $result->fetch_assoc();
		?>
		<div class="card lg-12">
		<div class="card-header" style="text-align: center;">
			<i class="fas fa-info"></i><b> Configure Info</b>		
		</div>
		<div class="card-body">
          <div class="table-responsive">
            <table class="table" id="dataTables" width="100%" cellspacing="1">
				<tbody>
				

			<tr>
                  <td style="text-align:center; "><strong>Room<input class="form-control-plaintext" style="width:60px; display: inherit;" type="text"  readonly/></strong></td>
                  <td>
                      <select  class="form-control" id="chgrm" >
						<?php
							$sqlRm = "SELECT rm_id, rm_name FROM room ORDER BY posi";
							$resultRm = $conn->query($sqlRm);
							if ($resultRm->num_rows > 0) {
								while($rowRm = $resultRm->fetch_assoc()) {
									if($row["loca_id"] == $rowRm["rm_id"]){
									?>									
										<option selected value="<?php echo($rowRm["rm_id"]) ?>"><?php echo($rowRm["rm_name"]) ?></option>
									<?php
									}else{
									?>
										<option value="<?php echo($rowRm["rm_id"]) ?>"><?php echo($rowRm["rm_name"]) ?></option>
									<?php
									}
								}
							}
						?>	
                      </select>
                  </td>

                    <td >
                       <button class="btn btn-block bg-default" onclick="changeRoom()"><strong>Change </strong></button>
                    </td>
                </tr>
               

		<?php	
		if($row["type"] == "DHT11"){
		?>
				<tr>
                  <td><button class="btn btn-block bg-default " onclick="exportData()" ><strong>Export data in </strong></button></td>  
                  <td>
                      <select  class="form-control" id="dayoption" >
                        <option selected value="1">1 day</option>
                        <option value="2">2 days</option>
                        <option value="3">3 days</option>
						<option value="3">4 days</option>
						<option value="3">5 days</option>
						<option value="3">6 days</option>
						<option value="3">7 days</option>
                      </select>
                  </td>
                  <td></td>
                </tr>
				<tr>
					<td style="text-align:center; "><strong>Update After<input class="form-control-plaintext" style="width:60px; display: inherit;" type="text"  readonly/></strong></td>
					<td>
					<select  class="form-control" id="chgtime" >
                        <option <?php echo ($row["sec"] == 5) ? "selected" : ""; ?> value="5" >5 second</option>
						<option <?php echo ($row["sec"] == 10) ? "selected" : ""; ?> value="10">10 second</option>
						<option <?php echo ($row["sec"] == 15) ? "selected" : ""; ?> value="15">15 second</option>
						<option <?php echo ($row["sec"] == 20) ? "selected" : ""; ?> value="20">20 second</option>
						<option <?php echo ($row["sec"] == 30) ? "selected" : ""; ?> value="30">30 second</option>
                    </select>
					</td>
					<td >
                       <button class="btn btn-block bg-default" onclick="changeTime()" ><strong>Change </strong></button>
                    </td>
				</tr>		
                <tr>
                  <td style="text-align:center; "><strong>Warning<input class="form-control-plaintext" style="width:60px; display: inherit;" type="text"  readonly /></strong></td>
                  <td style="text-align: center;"><input type="checkbox" checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger"></td>
                  <td style="text-align:center; "><strong>When<input class="form-control-plaintext" style="width:60px; display: inherit;" type="text"  readonly /></strong></td>
                </tr>
                <tr>
                  <td style="text-align:center; "><strong>Temparature<input class="form-control-plaintext" style="width:60px; display: inherit;" type="text"  readonly /></strong></td> 
                  <td>
                      <select  class="form-control" id="" >
                        <option selected>></option>
                        <option value="1">=</option>
                        <option value="2"><</option>
                      </select>
                  </td>
                 <td style="text-align:center; "><strong> <input class="form-control" style="width:60px; display: inherit; " type="text" value=" " />  &#8451 </strong></td>
                </tr>
                <tr>

                   <td style="text-align:center; "><strong>Humidity<input class="form-control-plaintext" style="width:60px; display: inherit;" type="text"  readonly/></strong></td>
                  
                  <td>
                      <select  class="form-control" id="" >
                        <option selected>></option>
                        <option value="1">=</option>
                        <option value="2"><</option>
                      </select>
                  </td>
                 <td style="text-align:center; "><strong> <input class="form-control" style="width:60px; display: inherit; " type="text" value=" " /> %</strong></td>
                </tr>

		<?php
			}else if($row["type"] == "MC52" ){
		?>     
                <tr>
                  <td><button class="btn btn-block bg-default " onclick="exportData()" ><strong>Export data in </strong></button></td>  
                  <td>
                      <select class="form-control" id="dayoption" >
                        <option selected value="1">1 day</option>
                      </select>
                  </td>
                  <td>
					<span style="color: red; font-size:larger;">*</span>
				  </td>
                </tr>
				<tr>
					<td style="text-align:center; "><strong>Update After<input class="form-control-plaintext" style="width:60px; display: inherit;" type="text"  readonly/></strong></td>
					<td>
					<select disabled="true" class="form-control" id="chgtime" >
                        <option selected>1 second</option>
                    </select>
					</td>
					<td >
                    </td>
				</tr>
                <tr>
					<td colspan="3" style="text-align:center; ">
						<strong>Warning<input class="form-control-plaintext" style="width:60px; display: inherit;" type="text"  readonly/></strong>
						<input type="checkbox" checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger">
						<strong><input class="form-control-plaintext" style="width:60px; display: inherit;" type="text"  readonly/></strong>
					</td> 	
                </tr>
				<tr>
					<td colspan="3">
						<span style="color: red;">* </span>To avoid sever overload, data of MC52 sensor will store only 24h
					</td>
				</tr>
		<?php		
			}else if($row["type"] == "MQ135" ){
		?>	  
                <tr>
                  <td><button class="btn btn-block bg-default " onclick="exportData()" ><strong>Export data in </strong></button></td>  
                  <td>
                      <select class="form-control" id="dayoption" >
                        <option selected value="1">1 day</option>
                        <option value="2">2 days</option>
                        <option value="3">3 days</option>
						<option value="3">4 days</option>
						<option value="3">5 days</option>
						<option value="3">6 days</option>
						<option value="3">7 days</option>
                      </select>
                  </td>
                  <td></td>
                </tr>
				<tr>
					<td style="text-align:center; "><strong>Update After<input class="form-control-plaintext" style="width:60px; display: inherit;" type="text"  readonly/></strong></td>
					<td>
					<select  class="form-control" id="chgtime" >
                        <option <?php echo ($row["sec"] == 5) ? "selected" : ""; ?> value="5" >5 second</option>
						<option <?php echo ($row["sec"] == 10) ? "selected" : ""; ?> value="10">10 second</option>
						<option <?php echo ($row["sec"] == 15) ? "selected" : ""; ?> value="15">15 second</option>
						<option <?php echo ($row["sec"] == 20) ? "selected" : ""; ?> value="20">20 second</option>
						<option <?php echo ($row["sec"] == 30) ? "selected" : ""; ?> value="30">30 second</option>
                    </select>
					</td>
					<td >
                       <button class="btn btn-block bg-default" onclick="changeTime()" ><strong>Change </strong></button>
                    </td>
				</tr>
                <tr>
                  <td style="text-align:center; "><strong>Warning<input class="form-control-plaintext" style="width:60px; display: inherit;" type="text"  readonly/></strong></td>
                  <td style="text-align: center;">
                    <input type="checkbox" checked data-toggle="toggle" data-onstyle="success" data-offstyle="danger">
                  </td>              
                  <td style="text-align:center; "><strong> When air is under standard <span style="color: red;">*</span><input class="form-control-plaintext" style="width:60px; display: inherit;" type="text"  readonly/></strong></td>
                </tr> 
				<tr>
					<td colspan="3">
						<span style="color: red;">* </span>Base on the air quality standard of United States Department of Labor: <a target="_blank" rel="noopener noreferrer" href="https://www.osha.gov/pls/oshaweb/owadisp.show_document?p_table=STANDARDS&p_id=9992">Link Refer</a>
					</td>
				</tr>
		<?php
			}	
		?>
		        </tbody>
            </table>
			</div>
		</div>	
		<div class=" card-footer small text-muted"><button class="btn btn-block bg-warning " onclick="return confirm('Are you sure?')?deleteDevice():'';"><strong>Delete Device </strong></button></div>
		<?php
		}
		?>
		</div>
		<!--  <p class="btn-danger" style="text-align: center;"><strong>Error !!!</strong></p>

         <p class="btn-success" style="text-align: center;"><strong>Successful !!!</strong></p> -->
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
            <button class="btn btn-primary" onclick="logout()">Logout</button>
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
	
	<!-- Device Name Modal -->
	<div class="modal fade" id="kbi1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div  class="modal-header">
            <h4  class="modal-title" id="exampleModalLabel">Change Device Name</h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
          <div class="form-group">
            <input class="form-control" name="dvname" placeholder="Enter name">
          </div>     
          <button class="btn btn-primary btn-block" onclick="editDvName()">Save</button>
          </div>      
        </div>
      </div>
    </div>
   
    <script>	
	$('#show').load("detaildata.php?dvid='<?php echo($dvid) ?>'");
	
	$(document).ready(function() {
		setInterval(function () {
			if(document.body.scrollTop != 0){
				localStorage.setItem('scroll_top', document.body.scrollTop);
			}else{
				localStorage.setItem('scroll_top', document.documentElement.scrollTop);
			}
			
			$('#show').load("detaildata.php?dvid='<?php echo($dvid) ?>'", function(){
				if (localStorage.getItem('scroll_top') !== null)
					window.scrollTo(0, parseInt(localStorage.getItem('scroll_top')));
			});
		}, 2000);
	});	
	
	function logout(){
		$.ajax({
        url: 'logout.php', 
        dataType: 'text',
        cache: false,
        data: {
		},                       
        method: 'post',
        success: function(res){ 
			location.reload();
        }
		});
	}
	
		
	function editDvName(){
		var dvid = $('[name=dvid]').val();
		var dvname = $('[name=dvname]').val();
		if(dvname == ''){
			alert('You have to enter your Device name');
			return;
		}
		$.ajax({
			url: 'editname.php', 
			dataType: 'text',
			cache: false,
			data: {
			dvid:  dvid,
			dvname: dvname,
			},                       
			method: 'post',
			success: function(res){ 
				location.reload();
			}
		});
	}
		
	function changeRoom(){
		var dvid = $('[name=dvid]').val();
		var chgrmid = $('#chgrm').val();
		$.ajax({
        url: 'changeroom.php', 
        dataType: 'text',
        cache: false,
        data: {
		 dvid: dvid,
		 chgrmid: chgrmid,
		},                       
        method: 'post',
        success: function(res){ 
		 location.reload();
        }
		});
	}
		
	function changeTime(){
		var dvid = $('[name=dvid]').val();
		var chgtime = $('#chgtime').val();
		$.ajax({
        url: 'changetime.php', 
        dataType: 'text',
        cache: false,
        data: {
		 dvid: dvid,
		 chgtime: chgtime,
		},                       
        method: 'post',
        success: function(res){ 
		 location.reload();
        }
		});	
	}
		
	function deleteDevice(){
		var dvid = $('[name=dvid]').val();
		$.ajax({
        url: 'deletedevice.php', 
        dataType: 'text',
        cache: false,
        data: {
		 dvid: dvid
		},                       
        method: 'post',
        success: function(res){ 
		 window.location.href = "index.php";
        }
		});	
	}
		
	function exportData(){
		var dvid = $('[name=dvid]').val();
		var dayopt = $('#dayoption').val();
		window.location.href = 'exportdata.php?dvid='+dvid+"&dayopt="+dayopt;
	}
		
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
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
  </div>
</body>

</html>
