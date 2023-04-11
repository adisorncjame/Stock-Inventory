<?php include('inc/header.php') ?>
<div class="dashboard-main-wrapper">
<?php session_start(); 
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}
    if ($_SESSION["level"] == 'admin') {
        include('inc/container-admin.php');
    }
    else 
    {
        include('inc/container.php');
    }
?> 



    <div class="dashboard-wrapper">
        <div class="container-fluid  dashboard-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Incoming Purchases</h2>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php" class="breadcrumb-link">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Incoming Purchases</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">Incoming Purchases</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatables" class="table table-striped table-bordered first">
                                    <thead>
                                        <tr class="border-0" >
                                            <th class="border-0" >Date of Purchases</th>
                                            <th class="border-0" >Product</th>
                                            <th class="border-0" >Number Receivend</th>
                                            <th class="border-0" >Supplier</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $conn = new mysqli($servername, $username, $password, $dbname);
                                        if ($conn->connect_error) {
                                            die("Connection failed: " . $conn->connect_error);
                                        }
                                        $sql = "SELECT * FROM products";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {

                                            while ($row = $result->fetch_assoc()) {
                                                echo
                                                    "<tr>" .
                                                    "<td>" . $row["id"] .' | '. $row["ProductName"] ." - ". $row["PartNumber"] ." ". $row["InventoryOnHand"] . " item</td>" .

                                                    "<td></td>".
                                                    "<td></td>".
                                                    "<td></td>".
                                                    "</tr> ";
                                                    $sql2 = "SELECT purchases.PurchaseDate,purchases.NumberReceived,suppliers.supplier FROM purchases INNER JOIN suppliers ON suppliers.id =purchases.SupplierId WHERE purchases.ProductId ='".$row["id"]."'";
                                                    $result2 = $conn->query($sql2);
                                                while ($row2 = $result2->fetch_assoc()) {
                                                    echo
                                                    "<tr>" .
                                                    "<td> " . $row2["PurchaseDate"] . "</td>" .
                                                    "<td> " . $row["PartNumber"] ."</td>" .
                                                    "<td> " . $row2["NumberReceived"] . "</td>" .
                                                    "<td> " . $row2["supplier"]. "</td>" ?>
                                                    </tr>
                                                <?php ;}
                                            }
                                           
                                        }  
                                        $conn->close();
                                        ?>
                                    </tbody>
                                </table>
                                <button data-toggle="modal" data-target="#add_data_Modal" class="btn btn-success">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end basic table  -->
                <!-- ============================================================== -->
            </div>


            <div id="add_data_Modal" class="modal fade">
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Product Information</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" id="insert_formp">
                    <table class="table">
                        <tr>
                            <td width='35%'><label>Date</label></td>
                            <td width='65%'><input type="date" name="PurchaseDate" id="PurchaseDate" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td width='35%'><label>Product</label></td>
                            <td width='65%'>
                                <select name="ProductId" id="ProductId " class="form-control" >
                                    <?php  
                                      $conn = new mysqli($servername, $username, $password, $dbname);
                                      if ($conn->connect_error) {
                                          die("Connection failed: " . $conn->connect_error);
                                      }
                                      $sql3 = "SELECT * FROM products";
                                      $result3 = $conn->query($sql3);
                                        if ($result3->num_rows > 0) {

                                        while ($row3 = $result3->fetch_assoc()) {
                                                echo "<option value='".$row3["id"]."'>".$row3["ProductName"] ." - ". $row3["PartNumber"] ."</option>";
                                        }
                                            }?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td width='35%'><label>Number Received</label></td>
                            <td width='65%'><input type="text" name="NumberReceived" id="NumberReceived" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td width='35%'><label>Supplier</label></td>
                            <td width='65%'>   
                                <select name="SupplierId" id="SupplierId" class="form-control" >
                                    <?php  
                                      $conn = new mysqli($servername, $username, $password, $dbname);
                                      if ($conn->connect_error) {
                                          die("Connection failed: " . $conn->connect_error);
                                      }
                                      $sql4 = "SELECT * FROM suppliers";
                                      $result4 = $conn->query($sql4);
                                        if ($result4->num_rows > 0) {

                                        while ($row4 = $result4->fetch_assoc()) {
                                                echo "<option value='".$row4["id"]."'>".$row4["supplier"] ."</option>";
                                        }
                                            }?>
                                </select>
                            </td>
                        </tr>
                       
                    </table>
                    <input type="submit" name="insert" id="insert" value="Confirm" class="btn btn-success" />
                    </form>
                </div>
                <div class="modal-footer"> 
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </div>
                </div>
            </div>



        </div>
        <?php include('inc/footer.php'); ?>
        <script>


$(document).ready(function(){
 $('#insert_formp').on("submit", function(event){  
//   if($('#name').val() == "")  
//   {  
//    alert("Name is required");  
//   }  
//   else if($('#address').val() == '')  
//   {  
//    alert("Address is required");  
//   }  
//   else if($('#designation').val() == '')
//   {  
//    alert("Designation is required");  
//   }
   

   $.ajax({  
    url:"module/insert-purchases.php",  
    method:"POST",  
    data:$('#insert_formp').serialize(),  
    beforeSend:function(){  
     $('#insert').val("Inserting");  
    },  
    success:function(data){  
        if(data){
            windows.location.replace();
            
        }else{
            alert('error');
        }
    }  
   });  
  
 });
});

$('#datatables').dataTable( {
  "ordering": false
} );

        </script>