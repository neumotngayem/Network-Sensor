<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>RoomManager</title>
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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
  <style type="text/css">
    .indrag:hover{background-color: #ffcc00;}
  </style>
</head>

<body class="fixed-nav bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
     <a class="navbar-brand" style="color: white; cursor: default">Room Manager</a>
    
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
		$conn->close();
		?>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="DeviceManager">
          <a class="nav-link" href="device.php">
            <i class="fa fa-fw fa-tablet"></i>
            <span class="nav-link-text">Device Manager</span>
          </a>
        </li>

         <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="room.php">
            <i style="color: white;" class="fab fa-windows"></i>
            <span style="color: white;" class="nav-link-text"> Room Manager</span>
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
	// Check whether login or not, If not login redirect to login page
	session_start(); 
	if(is_null($_SESSION['user_id'])){
		echo '<script type="text/javascript"> window.location = "./login.php"</script>';
	}
?>

	<div class="content-wrapper">
    <div class="container">
		<div class="card mb-3">
        <div class="card-body">
			<div class="table-responsive">
			<table id="myTable2" class="table tablesorter"  width="100%" cellspacing="1">
	<script>
		// Create object Room
		function Room(rmid, rmname){
			this.rmid = rmid;
			this.rmname = rmname;
		}
		// Initialize the room list
		sessionStorage.setItem("listRoom","");
	</script>
         
	<?php
	$servername = "localhost";
	$username = "root";
	$password = "admin123";
	$dbname = "iot";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "SELECT rm_id, rm_name FROM room ORDER BY posi";
	// Query SQL
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// Output data of each row
		$i = 1;
	    while($row = $result->fetch_assoc()) {
	?>  
            <tr>
              <td>
                <div class="input-group mb-3">
                    <input required style="border-color: #0066FF; cursor:move;" class="indrag form-control rmname" type="text" id="valueid-<?php echo($i) ?>" style="margin-left:20px; margin-top: 20px" type="text" draggable="true" ondragstart="drag(event)" ondrop="drop(event)" ondragover="allowDrop(event)" value="<?php echo($row["rm_name"]) ?>" aria-describedby="basic-addon1">
					<input id ='valuermid-<?php echo($i) ?>' class="rmid" name='rmid' type="text" value="<?php echo($row["rm_id"]) ?>" hidden/>
                    <div class="input-group-prepend">
						<button id='btndelete-<?php echo($i) ?>' style="border-color: black" class="btn bg-warning" data-toggle="modal" data-target="#kbidelete" onclick="setRow(<?php echo($i) ?>)"><i class="fa fa-trash" ></i></button>
					</div>
                </div> 
              </td>
            </tr>
			
			<script>
				// Push acquire data on room list also
				var rm = new Room(<?php echo($row["rm_id"]) ?>,"<?php echo($row["rm_name"]) ?>");
				// If existed in session already have list room, add room on existed room list, push it back to session
				if (sessionStorage.listRoom){
					var list = JSON.parse(sessionStorage.listRoom);
					list.push(rm);
					sessionStorage.setItem("listRoom",JSON.stringify(list));
				}else{ // Else create the new list, add a room on this and push it back to session
					var list = [];
					list.push(rm);
					sessionStorage.setItem("listRoom",JSON.stringify(list));
				}
			</script>

	<?php
			$i+=1;
		}
	}else{ //If no room to show
	?>
		<p><strong>Sorry! </strong>You don't have any room in here <i class="far fa-frown"></i></p>
	<?php
	}
	// Close connection
	$conn->close();	
	?> 
			</table>
			</div>
		</div>
			<div class=" card-footer small text-muted"><button type="button" class="btn btn-success btn-lg btn-block" onclick="saveRm()">Click to Save</button></div>
		</div>
		</br></br>
		<form action="addroom.php" method="post" class="addRoom">
			<div class="input-group mb-3">				
				<input name ='rmadd' style="border-color: #0066FF" type="text" class="form-control" placeholder="Enter room name to add ..." aria-label="" aria-describedby="basic-addon1">
				<div class="input-group-prepend">
					<button type='submit'  style="border-color: black" class="btn bg-warning" type="button"><i class="fa fa-plus " id="" onclick=""></i></button>
				</div>
			</div>
		</form>
    </div>
	</div>
</body>

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

<!-- Delete Modal -->
<div class="modal fade" id="kbidelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">When delete where all of your devices will come ?</h3>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">   
      <div class="form-group">
        <select  class="form-control" id="rmmoveslt" name="rmmoveslt">
                <option value="deleteall" selected>Remove all devices belong to this room</option>
				<script>
						// Print out all room list from session
						var list = JSON.parse(sessionStorage.getItem("listRoom"));
						for(i = 0; i < list.length;i++){
								document.write("<option value='"+list[i].rmid+"'> Move all devices to "+list[i].rmname+"</option>");
						}
				</script>			
        </select>
      </div>   
		<button class="btn btn-primary btn-block" onclick="deleteRm()" >Delete</button>
      </div>      
    </div>
  </div>
</div>

<script>
	// Set row id to session method
	function setRow(rownum){
		var row = rownum-1;
		sessionStorage.setItem("row",row);
		var size = document.getElementById("rmmoveslt").length;
		// Not show current row on display dropbox
		for(i = 1; i < size;i++){
			if(rownum == i){
				document.getElementById("rmmoveslt").options[i].hidden="true";
			}else{
				document.getElementById("rmmoveslt").options[i].hidden="";
			}
		}
	}
	
	// For drag and drop method
	function allowDrop(ev) {
	ev.preventDefault();
	}
	
	// For drag and drop method
	function drag(ev) {
	ev.dataTransfer.setData("text", ev.target.id);
	}
	
	// Drag and drop method
	function drop(ev) {
		// All the source below is to swap value, room id and onclick attribute of drag and drop objects 
		ev.preventDefault();
		var idData = ev.dataTransfer.getData("text");
		var indexBefore = idData.substring(8);
		var idRmid = 'valuermid-'+indexBefore
		var idBtnDelete = '#btndelete-'+indexBefore
		var data = document.getElementById(idData).value;
		var dataRmid = document.getElementById(idRmid).value;
		var attrBtnDelete = $(idBtnDelete).attr("onclick");
		var dataBack = ev.target.value;
		var indexAfter = ev.target.id.substring(8);
		var idRmidBack = 'valuermid-'+indexAfter;
		var dataRmidBack = document.getElementById(idRmidBack).value;
		var idBtnDeleteBack = '#btndelete-'+indexAfter
		var attrBtnDeleteBack = $(idBtnDeleteBack).attr("onclick");
		document.getElementById(idData).value = dataBack;
		document.getElementById(idRmid).value = dataRmidBack;
		$(idBtnDelete).attr("onclick",attrBtnDeleteBack);
		document.getElementById(ev.target.id).value = data;
		document.getElementById(idRmidBack).value = dataRmid;
		$(idBtnDeleteBack).attr("onclick",attrBtnDelete);
	}

	//Save the sort room list method
	function saveRm(){
		//Get all room name and room id
	    var rmnames = document.getElementsByClassName("rmname");
        var rmids = document.getElementsByClassName("rmid");
		var data = [];
		var data2 = [];
		// Check if enter room name is blank
		var i;
		for (i = 0; i < rmnames.length; i++) {
			if(rmnames[i].value.trim() == ''){
				sessionStorage.sysRoomMess = "You need to fill your room name";
				location.reload();
				break;
			}
			// Push data on array
			data.push(rmnames[i].value);
			data2.push(rmids[i].value);
		}
		
		// Using AJAX to request to server
        $.ajax({
            url: 'updateroom.php', 
            dataType: 'text',
            cache: false,
            data: {
				// Join data to 1 string
				data:  data.join('-'),
				data2: data2.join('-')
			},                       
			method: 'post',
			success: function(response){ 
					location.reload();
				}
        });
	}
	
	// Delete room method
	function deleteRm(){
		// Prepare data
		var rownum = sessionStorage.row;
		var rmid = document.getElementsByClassName("rmid")[rownum].defaultValue;
		var	rmidmove = $('[name=rmmoveslt]').val();
		
		// Using AJAX to request to server
		$.ajax({
			url: 'deleteroom.php', 
			dataType: 'text',
			cache: false,
			data: {
				rmid: rmid,
				rmidmove: rmidmove
			},                       
			method: 'post',
			success: function(res){ 
				location.reload();
			}
		});
	}
	
	// Add room method
	$(".addRoom").submit(function(event){
		// Get the URL, request method, form data from add room form 
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
			location.reload();
		});
	});
	
	// Logout method
	function logout(){
		// Using AJAX to request to server
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








































