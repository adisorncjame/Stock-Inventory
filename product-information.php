<?php include('inc/header.php') ?>
<script>

function deleteItem(id){
    $.ajax({  
            url:"module/delete-product.php?id="+id,  
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
           url:"module/get-product.php?id="+id,  
           method:"GET",  
           data:id,  
           beforeSend:function(){  
           },  
           success:function(datas){  
                $('#edit_data_Modal').modal('show');
               const hotels = JSON.parse(datas);
                   $.each(hotels, function(index, data){  
                       $('#eProductName').val(data.ProductName);
                       $('#ePartNumber').val(data.PartNumber);
                       $('#eProductLabel').val(data.ProductLabel);
                       $('#eStartingInventory').val(data.StartingInventory);
                       $('#eInventoryReceived').val(data.InventoryReceived);
                       $('#eInventoryShipped').val(data.InventoryShipped);
                       $('#eInventoryOnHand').val(data.InventoryOnHand);
                       $('#eMinimumRequired').val(data.MinimumRequired);
                       $('#eid').val(data.id);
                   });

                  
           }  
       });  
}
</script>

<?php session_start(); 
/**/
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}
if ($_SESSION["level"] != 'admin') {
    echo '<script>alert("สำหรับผู้ดูแลระบบเท่านั้น");history.back();</script>';
    exit;
}


?>


<div class="dashboard-main-wrapper">

    <?php include('inc/container-admin.php') ?>

    <div class="dashboard-wrapper">
        <div class="container-fluid  dashboard-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Product Information</h2>
                        <p class="pageheader-text"></p>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php" class="breadcrumb-link">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Product Information</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">Product Information</h5>    
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
                                            <th class="border-0"></th>
                                            <th class="border-0"></th>
                                            
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
                                                    $InventoryOnhand = "<p><font color=red >" . $InventoryOnhand . "</font></p>";
                                                }

                                                echo
                                                    "<tr>" .
                                                    "<td>" . $row["ProductName"] . "</td>" .
                                                    "<td>" . $row["PartNumber"] . "</td>" .
                                                    "<td>" . $row["ProductLabel"] . "</td>" .
                                                    "<td>" . $row["StartingInventory"] . "</td>" .
                                                    "<td>" . $row["InventoryReceived"] . "</td>" .
                                                    "<td>" . $row["InventoryShipped"] . "</td>" .
                                                    "<td>" . $InventoryOnhand . "</td>" .
                                                    "<td>" . $row["MinimumRequired"] . "</td>" ?>
                                                    <td width ='5%'><button type="button" onclick="edit(<?php echo $row['id'] ?>)"  class="btn btn-info btn-xs" >Edit</button></td>
                                                    <td width ='5%'><button type="button" onclick="deleteItem(<?php echo $row['id'] ?>)" name="delete" id="delete" class="btn btn-danger btn-xs">delete</button></td>
                                                    </tr> <?php ;

                                            }
                                        } else {
                                            echo "0 results";
                                        }
                                        $conn->close();
                                        ?>
                                    </tbody>
                                </table>
                                <button type="button" name="" id="d" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

    <?php include('inc/footer.php'); ?>


    <div id="add_data_Modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Product</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        <div class="modal-body">
            <form method="post" id="insert_form">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%"><label>Name</label></td>
                        <td width="60%" ><input type="text" name="ProductName" id="ProductName" class="form-control" /></td>
                    </tr>
                    <tr>
                        <td><label>Part Number</label></td>
                        <td><input type="text" name="PartNumber" id="PartNumber" class="form-control" /></td>
                    </tr>
                    <tr>
                        <td><label>Label</label></td>
                        <td><input type="text" name="ProductLabel" id="ProductLabel" class="form-control" /></td>
                    </tr>
                    <tr>
                        <td><label>Starting Inventory</label></td>
                        <td><input type="text" name="StartingInventory" id="StartingInventory" class="form-control" /></td>
                    </tr>
                    <tr>
                        <td><label>Inventory Received</label></td>
                        <td><input type="text" name="InventoryReceived" id="InventoryReceived" class="form-control" /></td>
                    </tr>
                    <tr>
                        <td><label>Inventory Shipped</label></td>
                        <td><input type="text" name="InventoryShipped" id="InventoryShipped" class="form-control" /></td>
                    </tr>
                    <tr>
                        <td><label>Inventory On Hand</label></td>
                        <td ><input type="text" name="InventoryOnHand" id="InventoryOnHand" class="form-control" /></td>
                    </tr>
                    <tr>
                        <td ><label>Minimum Required</label></td>
                        <td ><input type="text" name="MinimumRequired" id="MinimumRequired" class="form-control" /></td>
                    </tr>
                </table>
              
                <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />
            </form>
        </div>
</div>
</div>
</div>

<div id="edit_data_Modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">edit Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>    
            </div>
            <div class="modal-body" >
                <form method="post" id="edit_form">
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%"><label>Name</label></td>
                            <td width="60%" ><input type="hidden" name="id" id="eid"  /><input type="text" name="ProductName" id="eProductName" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td><label>Part Number</label></td>
                            <td><input type="text" name="PartNumber" id="ePartNumber" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td><label>Label</label></td>
                            <td><input type="text" name="ProductLabel" id="eProductLabel" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td><label>Starting Inventory</label></td>
                            <td><input type="text" name="StartingInventory" id="eStartingInventory" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td><label>Inventory Received</label></td>
                            <td><input type="text" name="InventoryReceived" id="eInventoryReceived" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td><label>Inventory Shipped</label></td>
                            <td><input type="text" name="InventoryShipped" id="eInventoryShipped" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td><label>Inventory On Hand</label></td>
                            <td ><input type="text" name="InventoryOnHand" id="eInventoryOnHand" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td ><label>Minimum Required</label></td>
                            <td ><input type="text" name="MinimumRequired" id="eMinimumRequired" class="form-control" /></td>
                        </tr>
                    </table>
                
                    <input type="submit" name="edit" id="edit" value="edit" class="btn btn-success" />
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<script>  
$(document).ready(function(){
 $('#insert_form').on("submit", function(event){  
   $.ajax({  
    url:"module/insert-product.php",  
    method:"POST",  
    data:$('#insert_form').serialize(),  
    beforeSend:function(){  
     $('#insert').val("Inserting");  
    },  
    success:function(data){  
        if(data){
            window.location.reload();
        }else{
            alert('Error');
        }
       
    }  
   });  
 });


 $('#edit_form').on("submit", function(event){  
   $.ajax({  
    url:"module/update-product.php",  
    method:"POST",  
    data:$('#edit_form').serialize(),  
    beforeSend:function(){  
     $('#edit').val("editting");  
    },  
    success:function(data){  
        if(data){
            window.location.reload();
        }else{
            alert('Error');
        }
       
    }  
   });  
 });


 $(document).on('click', '.view_data', function(){
  var product_id = $(this).attr("id");
  $.ajax({
   url:"module/view-supplier.php",
   method:"POST",
   data:{product_id:product_id},
   success:function(data){
    $('#product_detail').html(data);
    $('#dataModal').modal('show');
   }
  });
 });
});  
 </script>