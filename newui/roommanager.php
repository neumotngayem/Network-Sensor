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
  <style type="text/css">
    .indrag:hover{background-color: #ffcc00;}
  </style>
</head>

<body class="fixed-nav bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.html">Room Manager</a>
    
    <!-- button responsive -->
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- end button -->


    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="DeviceManager">
          <a class="nav-link" href="index.html">
            <i class="fa fa-fw fa-user"></i>
            <span class="nav-link-text">Device Manager</span>
          </a>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="RoomManager.html">
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
      <!-- end zoom -->

      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <form class="form-inline my-2 my-lg-0 mr-lg-2">
            <div class="input-group">
              <input class="form-control" type="text" placeholder="Search">
              <span class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </form>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </li>
      </ul>
    </div>
  </nav>



  <div class="content-wrapper">
    <div class="container">
       <div class="card mb-3">
        <div class="card-body">
          <div class="table-responsive">
            <table id="myTable2" class="table tablesorter"  width="100%" cellspacing="1">
         
<?php
	$servername = "localhost";
	$username = "root";
	$password = "admin123";
	$dbname = "iot";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "SELECT rm_id, rm_name FROM room ORDER BY posi";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// output data of each row
		$i = 1;
	    while($row = $result->fetch_assoc()) {
?>
              
            <tr>
              <td>
                <div class="input-group mb-3">
                    <input  style="border-color: #0066FF; cursor:move;" class="indrag form-control rmname" type="text" id="valueid-<?php echo($i) ?>" style="margin-left:20px; margin-top: 20px" type="text" draggable="true" ondragstart="drag(event)" ondrop="drop(event)" ondragover="allowDrop(event)" value="<?php echo($row["rm_name"]) ?>" aria-describedby="basic-addon1">
					<input id ='valuermid-<?php echo($i) ?>' class="rmid" name='rmid' type="text" value="<?php echo($row["rm_id"]) ?>" hidden/>
                     <div class="input-group-prepend">
                   <button  style="border-color: black" class="btn bg-warning"><i class="fa fa-trash" id=""></i></button>
                  </div>
                </div> 
              </td>
            </tr>

<?php
			$i+=1;
		}
	}
?>
                


          
        </table>
      </div>
  </div>
  <div class=" card-footer small text-muted"><button type="button" class="btn btn-success btn-lg btn-block" onclick="saveRm()">Click to Save</button></div>
    </div>
	
	<div id="server-results"><!-- For server results --></div>
   <br></br>
    <div class="input-group mb-3">
                    <input style="border-color: #0066FF" type="text" class="form-control" placeholder="Enter name to add ..." aria-label="" aria-describedby="basic-addon1">
                     <div class="input-group-prepend">
                     <button  style="border-color: black" class="btn bg-warning" type="button"><i class="fa fa-plus " id="" onclick=""></i></button>
                  </div>
                </div>
                 </div> 

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
            <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div>

<script>
function allowDrop(ev) {
  ev.preventDefault();
}
 
function drag(ev) {
  ev.dataTransfer.setData("text", ev.target.id);
}
 
function drop(ev) {
  ev.preventDefault();
  var idData = ev.dataTransfer.getData("text");
  var idRmid = 'valuermid-'+idData.substring(8)
  var data = document.getElementById(idData).value;
  var dataRmid = document.getElementById(idRmid).value;
  var dataBack = ev.target.value;
  var idRmidBack = 'valuermid-'+ev.target.id.substring(8);
  var dataRmidBack = document.getElementById(idRmidBack).value;
  document.getElementById(idData).value = dataBack;
  document.getElementById(idRmid).value = dataRmidBack;
  document.getElementById(ev.target.id).value = data;
  document.getElementById(idRmidBack).value = dataRmid;
}

	//Script for save the sort room list
	function saveRm(){
	    var rmnames = document.getElementsByClassName("rmname");
        var rmids = document.getElementsByClassName("rmid");
		
		var data = [];
		var data2 = [];
		
		var i;
		for (i = 0; i < rmnames.length; i++) {
			data.push(rmnames[i].value);
			data2.push(rmids[i].value);
		}
		
		//Push to update.php
        $.ajax({
                url: 'updateroom.php', 
                dataType: 'text',
                cache: false,
                data: {
		data:  data.join('-'),
		data2: data2.join('-'),
		},                       
                method: 'post',
                success: function(res){ 
                     $("#server-results").html(res);
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








































