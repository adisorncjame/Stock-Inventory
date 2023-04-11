<?php include('inc/header.php') ?>
<script>
function deleteOrder(id){
    $.ajax({  
            url:"module/delete-order.php?id="+id,  
            method:"GET",  
            data:id,  
            beforeSend:function(){  
            },  
            success:function(data){  
                if(data==true){
                    window.location.reload();
                }else{
                    alert('error');
                }
            }  
        });  
}


function edit(id){
   
    $.ajax({  
            url:"module/get-order.php?id="+id,  
            method:"GET",  
            data:id,  
            beforeSend:function(){  
            },  
            success:function(datas){  
                 $('#edit_data_Modal').modal('show');
                const hotels = JSON.parse(datas);
                    $.each(hotels, function(index, data){  
                        $('#eNumberShipped').val(data.NumberShipped);
                        $('#eProductId').val(data.ProductId);
                        $('#eFirst').val(data.First);
                      
                        $('#eOrderDate').val(data.OrderDate);
                        $('#eid').val(data.id);
                    });

                   
            }  
        });  
}
</script>
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
    $Name = $_SESSION["name"];
    ?>

    <div class="dashboard-wrapper">
        <div class="container-fluid  dashboard-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Outgoing Orders</h2>
                        <p class="pageheader-text"></p>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php" class="breadcrumb-link">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Outgoing Orders</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">
                            <div class="row"> 
                                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10">Order Table</div>
                                
                            </div>
                        </h5>
                        <div class="card-body">
                            <div class="table-responsive">
                               
                                <table id="datatables" class="table table-striped table-bordered first">
                                    <thead>
                                        <tr class="border-0">
                                            <th class="border-0">Orders Date</th>
                                            <th class="border-0">Product</th>
                                            <th class="border-0">Number Shipped</th>
                                            <th class="border-0">First</th>
                                            <th class="border-0">Last</th>
                                            <th class="border-0"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                               
                                            $connect = mysqli_connect($servername, $username, $password, $dbname);
                                            if ($connect->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                            }
                                            $sqls = "SELECT orders.id, orders.OrderDate,orders.NumberShipped,orders.Last,orders.First,products.ProductName,products.PartNumber FROM orders INNER JOIN products
                                            ON products.id = orders.ProductId ";
                                            $results = $connect->query($sqls);
                                            while ($rows = $results->fetch_assoc()) {
                                        
                                                echo
                                                "<tr>" .
                                                "<td>" . $rows["OrderDate"] . "</td>" .
                                                "<td>" . $rows["ProductName"]." - ".$rows["PartNumber"] . "</td>" .
                                                "<td>" . $rows["NumberShipped"] . "</td>" .
                                                "<td>" . $rows["First"] . "</td>" .
                                                "<td>" . $rows["Last"] . "</td>" .
                                                "<td>  <button class='btn btn-warning btn-xs' onclick='edit(".$rows["id"].")'>Edit</button>
                                                <button onclick='deleteOrder(".$rows["id"].")' class='btn btn-danger btn-xs'>Delete</button> </td>" .
                                                "</tr>";

                                            }
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


            <div id="edit_data_Modal" class="modal fade">
            
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Order Information</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" id="edit_formorder">
                    <table class="table">
                        <tr>
                            <td width='35%'><label>Date</label></td>
                            <td width='65%'><input type="hidden" name="id" id="eid" class="form-control" /><input type="date" name="OrderDate" id="eOrderDate" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td width='35%'><label>Product</label></td>
                            <td width='65%'>
                                <select name="ProductId" id="eProductId" class="form-control" >
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
                            <td width='35%'><label>Number Shipped</label></td>
                            <td width='65%'><input type="text" name="NumberShipped" id="eNumberShipped" class="form-control" /></td>
                        </tr>
                        <tr hidden>
                            <td width='35%'><label>First</label></td>
                            <td width='65%'><input type="text" name="First" id="eFirst" class="form-control" ></td>
                        </tr>
                        <tr >
                            <td width='35%'><label>Last</label></td>
                            <td width='65%'><input readonly type="text" name="Last" id="eLast" class="form-control" value = "<?php echo $Name;?>"/></td>
                        </tr>
                    </table>
                    <input type="submit" name="edit" id="edit" value="Confirm" class="btn btn-success" />
                    </form>
                </div>
                <div class="modal-footer"> 
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </div>
                </div>
            </div>









            <div id="add_data_Modal" class="modal fade">
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Order Information</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" id="insert_formorder">
                    <table class="table">
                        <tr>
                            <td width='35%'><label>Date</label></td>
                            <td width='65%'><input type="date" name="OrderDate" id="OrderDate" class="form-control" /></td>
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
                            <td width='35%'><label>Number Shipped</label></td>
                            <td width='65%'><input type="text" name="NumberShipped" id="NumberShipped" class="form-control" /></td>
                        </tr>
                        <tr >
                            <td width='35%'><label>First</label></td>
                            <td width='65%'><input readonly type="text" name="First" id="First" class="form-control"  value="<?php echo $Name;?>" /></td>
                        </tr>
                        <tr hidden>
                            <td width='35%'><label>Last</label></td>
                            <td width='65%'><input type="hidden" name="Last" id="Last" class="form-control" /></td>
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
 $('#insert_formorder').on("submit", function(event){  
   $.ajax({  
    url:"module/insert-order.php",  
    method:"POST",  
    data:$('#insert_formorder').serialize(),  
    beforeSend:function(){  
     $('#insert').val("Inserting");  
    },  
    success:function(data){  
        if(data){
            window.location.replace();
        }else{
            alert('error');
        }
    }  
   });  
  
 });

 $('#edit_formorder').on("submit", function(event){  
   $.ajax({  
    url:"module/update-order.php",  
    method:"POST",  
    data:$('#edit_formorder').serialize(),  
    beforeSend:function(){  
     $('#edit').val("editting");  
    },  
    success:function(data){  
        if(data){
            window.location.replace();
        }else{
            alert('error');
        }
    }  
   });  
  
 });

});
        </script>