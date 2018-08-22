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
</head>
<body class="fixed-nav bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" style="color: white; cursor: default">Device Manager</a>
    
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
			<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
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
	
	    <div class="card mb-3">
        <div class="card-header"><b>WX-Net Host Config</b></div>
        <div class="card-body">
			
		<div id="wifi" class="form-inline">
		</div>
		
		<p>
		<?php
			$conn = new mysqli($servername, $username, $password, $dbname);
			$sql = "SELECT regisphone, ssid,pwssid FROM account";
			$resultacc = $conn->query($sql);
			if ($resultacc->num_rows > 0) {
				$rowacc = $resultacc->fetch_assoc();
				if(!is_null($rowacc["regisphone"])){
					$_SESSION['regisphone'] = $rowacc["regisphone"];
		?>
		<p>
			<div class="btn-group">
				<button class="btn bg-warning" data-toggle="modal" data-target="#kbichangephone1" ><i class="fas fa-mobile-alt"> Change</i></button>
				<span class="btn btn-success" style="cursor: default; color: black" ><strong>Registered: </strong><i> <?php echo($_SESSION['regisphone']) ?></i></span>
			</div>
			</br>
		</p>
			<div class="btn-group table-responsive">
				<button style="color: black; font-weight: bold;" type="button" class="btn btn-primary" onclick="calltest()">Call Test</button>
				<button style="color: black; font-weight: bold;" type="button" class="btn btn-danger" onclick="smstest()">SMS Test</button>
				<button style="color: black; font-weight: bold;" type="button" class="btn btn-warning" onclick="balance()">Balance</button>
				<button style="color: black; font-weight: bold;" type="button" class="btn btn-secondary" onclick="addmoney()">Add Money</button>
				<span id='btngsm' class="btn btn-danger" style="cursor: default; color: black" ><strong>Test status: </strong><i id="gsmtest">Not yet</i></span>
			</div>
		<?php
				}else{
			$_SESSION['regisphone'] = NULL;
		?>
			<div class="btn-group table-responsive">
				<button class="btn bg-warning" data-toggle="modal" data-target="#kbichangephone1" ><i class="fas fa-mobile-alt"> Add</i></button>
				<span class="btn btn-danger" style="cursor: default; color: black" >You haven't had registered phone number yet</span>
			</div>
		<?php
				}
			}
		?>

		</p>	
	
	<button style="margin-bottom: 15px;" class="btn bg-warning" data-toggle="modal" data-target="#kbichangepass" ><i class="fa fa-key"> Change Admin's Password</i></button>
	</br>
	<span style="color: red">* For security reason, it is important that you must register your phone number at your first time login<span>
	
	</div>
	<div class=" card-footer small text-muted"></div>
	</div>

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
            <button class="btn btn-primary" onclick="logout()">Logout</button>
          </div>
        </div>
      </div>
    </div>
	<!-- Add Modal -->
	<div class="modal fade" id="kbiadd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">     
          <div class="modal-body">
          <div class="form-group">
            <h5>What is your device name ?</h5>
            <input class="form-control" type="text" name="dvname">
            <br>
            <h5>What room is belong to ?</h5>
			<select required name="room" class="bg-warning btn">
				<?php
					$sqlRm = "SELECT rm_id, rm_name FROM room ORDER BY posi";
					$resultRm = $conn->query($sqlRm);
					if ($resultRm->num_rows > 0) {
						while($rowRm = $resultRm->fetch_assoc()) {
							?>
							<option value="<?php echo($rowRm["rm_id"]) ?>"><?php echo($rowRm["rm_name"]) ?></option>
							<?php
						}
					}else{
						?>
						<option value="">You have to add a room first</option>
						<?php
					}
					$conn->close();
				?>				
			</select>	
          </div>
          <button class="btn btn-primary btn-block" onclick="addRoom()">Add</button>
          </div>
          
        </div>
      </div>
    </div>
    <!-- end add -->
	
	<!-- Change phone Modal-->
	<div class="modal fade" id="kbichangephone1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">    
          <div class="modal-body">
			<div class="form-group">
				<h5>Enter a phone number that you want to register</h5>
				<input class="form-control" type="text" name="phonechange">
				<br>
				<button type="button" class="btn btn-success btn-block" onclick="calltestregis()">Call Test</button>
				<button type="button" class="btn btn-primary btn-block btn-next" onclick="captcha()" data-toggle="modal" data-target="#kbichangephone2">Next</button>
			</div>    
          </div>    
        </div>
      </div>
    </div>
    <!-- end -->

    <!--Enter Capcha modal-->
	<div class="modal fade" id="kbichangephone2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">  
          <div class="modal-body">
			<div class="form-group">
				<h5>Enter a captcha sent to your phone</h5>
				<input class="form-control" type="text" name="incaptcha">
				<br>
				<button id="nextsucss" class="btn btn-primary btn-block" onclick="checkcaptcha()" >Check</button>
				<br>
				<div id="check-results"></div>
			</div>          
          </div>          
        </div>
      </div>
    </div>
    <!-- end -->
	
	<!--Enter Capcha modal-->
	<div class="modal fade" id="kbichangepass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">  
          <div class="modal-body">
			<div class="form-group">
				<h5>Enter a new password</h5>
				<input class="form-control" type="password" name="passnew">
				<br>
				<h5>Reenter new password</h5>
				<input class="form-control" type="password" name="repassnew">
				<br>
				<button class="btn btn-primary btn-block" onclick="changepass()"><div id='sttcaptcha'>Change Admin's Password</div></button>
				<br>
				<div id="change-results"></div>
			</div>          
          </div>          
        </div>
      </div>
    </div>
    <!-- end -->

<script>
   $("div[id^='kbichangephone']").each(function(){
	var currentModal = $(this);
		//click next
		currentModal.find('.btn-next').click(function(){
		currentModal.modal('hide');
		//hide modal hiện tại    
		currentModal.closest("div[id^='kbichangephone']").nextAll("div[id^='kbichangephone']").first().modal('show');
		// Đây chính là code xử lý phần next modal, click btn-next -> close modal hiện tại --> tìm các modal tiếp theo --> trigger modal đầu tiên tiếp theo với .modal('show')
		//Call back khi close modal hiện tại sẽ next tới tất cả cả modal còn lại và lấy cái tiếp theo đầu tiên cho nó show lên và cứ như vậy.
	});
  });

  function setRow(rownum){
	sessionStorage.setItem("row",rownum);
  }
  
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

  function addRoom(){
	var rownum = sessionStorage.row;
	var star = document.getElementsByName("star")[rownum].defaultValue;
	var dvid = document.getElementsByName("dvid")[rownum].defaultValue;
	var dvtype = document.getElementsByName("dvtype")[rownum].defaultValue;
	var name = $('[name=dvname]').val().trim();
	var room = $('[name=room]').val();
	if(name == ''){
		alert('You have to enter your device name');
		return;
	}
	
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
		dvname: name,
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
  
  function captcha(){
	var phone = $('[name=phonechange]').val().trim();
	if(phone == ''){
		alert("You haven't enter any phone number !!!");
		return;
	}
	$.ajax({
        url: 'sentcaptcha.php', 
        dataType: 'text',
        cache: false,
        data: {
		phone:  phone
		},                       
        method: 'post',
    }); 
  }
  
  function calltestregis(){
	var phone = $('[name=phonechange]').val().trim();
	if(phone == ''){
		alert("You haven't enter any phone number !!!");
		return;
	}
	
	$.ajax({
        url: 'call.php', 
        dataType: 'text',
        cache: false,
        data: {
		phone: phone
		},                       
        method: 'post',
        success: function(res){
			alert(res);
        }
    });  
  };
  
  function checkcaptcha(){
	var incaptcha = $('[name=incaptcha]').val();
	var phone = $('[name=phonechange]').val();
	$.ajax({
        url: 'checkcaptcha.php', 
        dataType: 'text',
        cache: false,  
        data: {
			incaptcha: incaptcha,
			phone: phone
		},  		
        method: 'post',
        success: function(res){
			if(res == 'okay'){
				alert("The phone number "+$('[name=phonechange]').val()+" registerd successfully !!!");
				location.reload();
			}else{
				$("#check-results").html(res);
			}
        }
    }); 
  }
  
  function changepass(){
	var passnew = $('[name=passnew]').val();
	var repassnew = $('[name=repassnew]').val();
	$.ajax({
        url: 'changepass.php', 
        dataType: 'text',
        cache: false,  
        data: {
			passnew: passnew,
			repassnew: repassnew
		},  		
        method: 'post',
        success: function(res){
			if(res == 'okay'){
				alert("The admin's password has changed successfully !!!");
				location.reload();
			}else{
				$("#change-results").html(res);
			}
        }
    }); 
  }
  <?php
	if(!is_null($_SESSION['regisphone'])){
  ?>
 
  function calltest(){
	$("#btngsm").removeClass("btn-success");
	$("#btngsm").removeClass("btn-danger");
	$("#btngsm").addClass("btn-warning");
	$("#gsmtest").html("Waiting");
	$.ajax({
        url: 'call.php', 
        dataType: 'text',
        cache: false,
        data: {
		phone:  '<?php echo($_SESSION['regisphone']) ?>'
		},                       
        method: 'post',
        success: function(res){
			if(res == 'okay'){
				$("#btngsm").removeClass("btn-warning");
				$("#btngsm").addClass("btn-success");
				$("#gsmtest").html("Test success ! Your phone is ringing");				
			}else{
				$("#btngsm").removeClass("btn-warning");
				$("#btngsm").addClass("btn-danger");
				$("#gsmtest").html("Test fail ! Try again");	
			}
        }
    });  
  };
  
  function smstest(){
	$("#btngsm").removeClass("btn-success");
	$("#btngsm").removeClass("btn-danger");
	$("#btngsm").addClass("btn-warning");
	$("#gsmtest").html("Waiting");
	$.ajax({
        url: 'sms.php', 
        dataType: 'text',
        cache: false,
        data: {
		phone:  '<?php echo($_SESSION['regisphone']) ?>',
		mess: 'Test message from WX-Net host'
		},                       
        method: 'post',
        success: function(res){
			if(res == 'okay'){
				$("#btngsm").removeClass("btn-warning");
				$("#btngsm").addClass("btn-success");
				$("#gsmtest").html("Test success ! Your phone is ringing");
			}else{
				$("#btngsm").removeClass("btn-warning");
				$("#btngsm").addClass("btn-danger");
				$("#gsmtest").html("Test fail ! Try again");
			}	
        }
    });  
  };
  
  function balance(){
	$("#btngsm").removeClass("btn-success");
	$("#btngsm").removeClass("btn-danger");
	$("#btngsm").addClass("btn-warning");
	$("#gsmtest").html("Waiting");
	$.ajax({
        url: 'balance.php', 
        dataType: 'text',
        cache: false,
        data: {
		},                       
        method: 'post',
        success: function(res){
			if(res != 'fail'){
				$("#btngsm").removeClass("btn-warning");
				$("#btngsm").addClass("btn-success");
				$("#gsmtest").html("Check balance success !!");
				alert(res);
			}else{
				$("#btngsm").removeClass("btn-warning");
				$("#btngsm").addClass("btn-danger");
				$("#gsmtest").html("Test fail ! Try again");
			}
        }
    });  
  };
  <?php
	}
  ?>
  function connectwifi(){
	var ssid = $('#ssidselect').val();
	var pwssid = $('[name=pwssid]').val();
	$("#btwifi").removeClass("btn-danger");
	$("#btwifi").addClass("btn-warning");
	$("#wifistatus").html("System will reboot later !!! Try refreshing your browser");	
	$.ajax({
       url: 'connectwifi.php', 
       dataType: 'text',
       cache: false,
       data: {
		   ssid: ssid,
		   pwssid: pwssid
	   },                       
       method: 'post',
       success: function(res){
       }
	});	
  }
  
  function disconnectwifi(){
	   $("#ssidselect").removeAttr("disabled");
	   $("#pwssidenter").removeAttr("disabled");
	   $("#btnconnect").removeClass("btn-danger");
	   $("#btnconnect").addClass("btn-success");
	   $("#btnconnect").attr("onclick","connectwifi()");
	   $("#btnconnectstatus").html("Connect");
	   $("#pwssidenter").val('');
	  
  }

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
  
  $('#show').load('acklistdata.php');
  $('#wifi').load('wifidata.php');
  
  
  $(document).ready(function() {
	setInterval(function () {
		if(document.body.scrollTop != 0){
			localStorage.setItem('scroll_top', document.body.scrollTop);
		}else{
			localStorage.setItem('scroll_top', document.documentElement.scrollTop);
		}
		$('#show').load('acklistdata.php', function(){
				if (localStorage.getItem('scroll_top') !== null)
					window.scrollTo(0, parseInt(localStorage.getItem('scroll_top')));
		});
	}, 5000);
  });

</script>


  </div>
</body>

</html>
