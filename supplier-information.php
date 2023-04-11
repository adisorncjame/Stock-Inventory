<?php include('inc/header.php') ?>
<script>
    function deleteItem(id){
        $.ajax({  
            url:"module/delete-supplier.php?id="+id,  
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

    function updateItem(id){
        var sname = document.getElementById("sname").value;
        $.ajax({  
            url:"module/update-supplier.php?id="+ id +"&supplier=" + sname,  
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
</script>

<div class="dashboard-main-wrapper">

<?php 
session_start(); 
/**/
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}

if ($_SESSION["level"] != 'admin') {
    echo '<script>alert("สำหรับผู้ดูแลระบบเท่านั้น");window.location="current.php";</script>';
    exit;
}

    include('inc/container-admin.php');

?>

    <div class="dashboard-wrapper">
        <div class="container-fluid  dashboard-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Supplier Information</h2>
                       
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php" class="breadcrumb-link">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Supplier Information</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">Supplier Table</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatables" class="table table-striped table-bordered first">
                                    <thead>
                                        <tr class="border-0">
                                            <th class="border-0">#</th>
                                            <th class="border-0" >Suppiler ID</th>
                                            <th class="border-0" >Name</th>
                                            <th class="border-0" ></th>
                                            <th class="border-0" ></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $conn = new mysqli($servername, $username, $password, $dbname);
                                        if ($conn->connect_error) {
                                            die("Connection failed: " . $conn->connect_error);
                                        }
                                        $sql = "SELECT * FROM suppliers;";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            $r = 1;
                                            while ($row = $result->fetch_assoc()) {
                                                echo
                                                    "<tr>" .
                                                    "<td width ='5%'>" . $r . "</td>" .
                                                    "<td width ='20%'>" . $row["id"] . "</td>" .
                                                    "<td width ='50%'>" . $row["supplier"] . "</td>"?>
                                                    <td width ='5%'><input type="button" name="view" value="Edit" id="<?php echo $row["id"]; ?>" class="btn btn-info btn-xs view_data" /></td>
                                                    <td width ='5%'><button type="button" onclick="deleteItem(<?php echo $row['id'] ?>)" name="delete" id="delete" class="btn btn-danger btn-xs">Delete</button></td>
                                                </tr><?php
                                                $r++;
                                            }
                                        } else {
                                            echo "0 results";
                                        }
                                        $conn->close();
                                        ?>
                                    </tbody>
                                </table>
                                <button type="button" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning">Add</button>
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
                <h4 class="modal-title">Add Suppiler</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        <div class="modal-body">
            <form method="post" id="insert_form">
                <label>Enter Supplier Name</label>
                <input type="text" name="name" id="name" class="form-control" />
                 <br />
                <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />
            </form>
        </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>
</div>
</div>

<div id="dataModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Supplier Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>    
            </div>
            <div class="modal-body" id="supplier_detail">
            
            </form>
        </div>
    </div>
</div>
</div>

<script>  


$(document).ready(function(){
 $('#insert_form').on("submit", function(event){  
  event.preventDefault();  
  if($('#name').val() == "")  
  {  
   alert("Name is required");  
  }  
  else  
  {  
   $.ajax({  
    url:"module/insert-supplier.php",  
    method:"POST",  
    data:$('#insert_form').serialize(),  
    beforeSend:function(){  
     $('#insert').val("Inserting");  
    },  
    success:function(data){  
        window.location.reload();
    }  
   });  
  }  
 });


 $(document).on('click', '.view_data', function(){
  var supplier_id = $(this).attr("id");
  $.ajax({
   url:"module/view-supplier.php",
   method:"POST",
   data:{supplier_id:supplier_id},
   success:function(data){
    $('#supplier_detail').html(data);
    $('#dataModal').modal('show');
   }
  });
 });
});  

 </script>
