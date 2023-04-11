<?php include('inc/header.php') ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    function currentP(id){
        window.location.replace('current.php?id='+id+'#Incoming');
    }
</script>
<div class="dashboard-main-wrapper">
<?php session_start(); 
/**/
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
                        <h2 class="pageheader-title">Current Inventory</h2>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php" class="breadcrumb-link">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Current Inventory</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" >
                    <div class="card">
                        <h5 class="card-header">Product Detail</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatables" class="table table-striped table-bordered first">
                                    <thead>
                                        <tr class="border-0">
                                            <th class="border-0">Name</th>
                                            <th class="border-0">Part Number</th>
                                            <th class="border-0">Label Name</th>
                                            <th class="border-0">Starting Inverntory</th>
                                            <th class="border-0">Inverntory Receivend</th>
                                            <th class="border-0">Inverntory Shipped</th>
                                            <th class="border-0">Inverntory On Hand</th>
                                            <th class="border-0">Minimum Required</th>
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
                                                $InventoryOnhand = $row["StartingInventory"] + $row["InventoryReceived"];
                                                $InventoryOnhand =  $InventoryOnhand - $row["InventoryShipped"];

                                                if($InventoryOnhand < 0 )
                                                { 
                                                    $InventoryOnhand = "<p><font color=red>" . $InventoryOnhand . "</font></p>";
                                                }

                                                echo
                                                    "<tr onClick='currentP(".$row["id"].")'  >" .
                                                    "<td>" . $row["ProductName"] . "</td>" .
                                                    "<td>" . $row["PartNumber"] . "</td>" .
                                                    "<td>" . $row["ProductLabel"] . "</td>" .
                                                    "<td>" . $row["StartingInventory"] . "</td>" .
                                                    "<td>" . $row["InventoryReceived"] . "</td>" .
                                                    "<td>" . $row["InventoryShipped"] . "</td>" .
                                                    "<td>" . $InventoryOnhand . "</td>" .
                                                    "<td>" . $row["MinimumRequired"] . "</td>" .
                                                    "</tr>";
                                            }
                                        } else {
                                            echo "0 results";
                                        }
                                        $conn->close();
                                        ?>
                                        
                                    </tbody>
                                </table>
                             
                            </div>
                        </div>
                        <tr>
                            <td colspan="9"><a href="product-information.php" class="btn btn-outline-light float-right">View Details</a>
                        </tr>
                    </div>
                </div>


                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="Incoming" >
                    <div class="card">
                        <h5 class="card-header">Incoming Purchases</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="" class="table table-striped table-bordered first" >
                                    <thead>
                                        <tr class="border-0">
                                            <th class="border-0">Purchases Date</th>
                                            <th class="border-0">Product ID</th>
                                            <th class="border-0">Number Receivend</th>
                                            <th class="border-0">Supplier ID</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody id="exampleid">
                                    <?php
                                        if($_GET){
                                            $id =$_GET['id'];
                                            if($id){
                                                $connect = mysqli_connect($servername, $username, $password, $dbname);
                                                if ($connect->connect_error) {
                                                    die("Connection failed: " . $conn->connect_error);
                                                }
                                                $sql2 = "SELECT purchases.PurchaseDate,purchases.NumberReceived,suppliers.supplier,products.ProductName,products.PartNumber FROM purchases INNER JOIN suppliers ON suppliers.id =purchases.SupplierId INNER JOIN products
                                                ON products.id = purchases.ProductId WHERE purchases.ProductId =$id";
                                                $result3 = $connect->query($sql2);
                                                $resultArray = array();
                                                while ($row3 = $result3->fetch_assoc()) { 
                                                    echo
                                                    "<tr>" .
                                                    "<td>" . $row3["PurchaseDate"] . "</td>" .
                                                    "<td>" . $row3["ProductName"]." - ". $row3["PartNumber"] . "</td>" .
                                                    "<td>" . $row3["NumberReceived"] . "</td>" .
                                                    "<td>" . $row3["supplier"] . "</td>" .
                                                    "</tr>";

                                                }
                                            }
                                        }
                                        ?>
						            </tbody>
                                     
                                </table>
                            </div>
                        </div>
                    </div>
                </div>  

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">Outgoing Orders</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="" class="table table-striped table-bordered first">
                                    <thead>
                                        <tr class="border-0">
                                            <th class="border-0">Orders Date</th>
                                            <th class="border-0">Product</th>
                                            <th class="border-0">Number Shipped</th>
                                            <th class="border-0">First</th>
                                            <th class="border-0">Last</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if($_GET){
                                            $idOrder =$_GET['id'];
                                            if($_GET['id']){
                                                // $connect = mysqli_connect($servername, $username, $password, $dbname);
                                                // if ($connect->connect_error) {
                                                //     die("Connection failed: " . $conn->connect_error);
                                                // }
                                                $sqls = "SELECT orders.OrderDate,orders.NumberShipped,orders.Last,orders.First,products.ProductName,products.PartNumber FROM orders INNER JOIN products
                                                ON products.id = orders.ProductId WHERE orders.ProductId =$idOrder";
                                                $results = $connect->query($sqls);
                                                while ($rows = $results->fetch_assoc()) {
                                                    echo
                                                    "<tr>" .
                                                    "<td>" . $rows["OrderDate"] . "</td>" .
                                                    "<td>" . $rows["ProductName"]." - ".$rows["PartNumber"] . "</td>" .
                                                    "<td>" . $rows["NumberShipped"] . "</td>" .
                                                    "<td>" . $rows["First"] . "</td>" .
                                                    "<td>" . $rows["Last"] . "</td>" .
                                                    "</tr>";

                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        




<script> 

$(document).ready(function() {
    var table = $('#datatables').DataTable();
 
    $('#datatables tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
        alert( 'You clicked on '+data[0]+'\'s row' );
    } );
    
} );


$(document).ready(function(){
 $('#insert_form').on("submit", function(event){  
  event.preventDefault();  
  if($('#name').val() == "")  
  {  
   alert("Name is required");  
  }  
  else if($('#address').val() == '')  
  {  
   alert("Address is required");  
  }  
  else if($('#designation').val() == '')
  {  
   alert("Designation is required");  
  }
   
  else  
  {  
   $.ajax({  
    url:"module/insert.php",  
    method:"POST",  
    data:$('#insert_form').serialize(),  
    beforeSend:function(){  
     $('#insert').val("Inserting");  
    },  
    success:function(data){  
     $('#insert_form')[0].reset();  
     $('#add_data_Modal').modal('hide');  
     $('#employee_table').html(data);  
    }  
   });  
  }  
 });
});
</script>



<div id="add_data_Modal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h4 class="modal-title">Add Product Information</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
   </div>
   <div class="modal-body">
    <form method="post" id="insert_form">
    <table class="table">
        <tr>
            <td width='35%'><label>Name</label></td>
            <td width='65%'><input type="text" name="name" id="name" class="form-control" /></td>
        </tr>
        <tr>
            <td width='35%'><label>Part Number</label></td>
            <td width='65%'><input type="text" name="name" id="name" class="form-control" /></td>
        </tr>
        <tr>
            <td width='35%'><label>Label</label></td>
            <td width='65%'><input type="text" name="name" id="name" class="form-control" /></td>
        </tr>
        <tr>
            <td width='35%'><label>Starting Inventory</label></td>
            <td width='65%'><input type="text" name="name" id="name" class="form-control" /></td>
        </tr>
        <tr>
            <td width='35%'><label>Inventory Received</label></td>
            <td width='65%'><input type="text" name="name" id="name" class="form-control" /></td>
        </tr>
        <tr>
            <td width='35%'><label>Inventory Shipped</label></td>
            <td width='65%'><input type="text" name="name" id="name" class="form-control" /></td>
        </tr>
        <tr>
            <td width='35%'><label>Inventory On Hand</label></td>
            <td width='65%'><input type="text" name="name" id="name" class="form-control" /></td>
        </tr>
        <tr>
            <td width='35%'><label>Minimum Required</label></td>
            <td width='65%'><input type="text" name="name" id="name" class="form-control" /></td>
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


