<?php include('inc/header.php') ?>
<?php session_start(); 
/**/
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}
if ($_SESSION["level"] != 'admin') {
    echo '<script>alert("สำหรับผู้ดูแลระบบเท่านั้น");window.location="current.php";</script>';
    exit;
}
?>

<script>
function deleteUser(id){
    $.ajax({  
            url:"module/delete-user.php?id="+id,  
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
            url:"module/get-user.php?id="+id,  
            method:"GET",  
            data:id,  
            beforeSend:function(){  
            },  
            success:function(datas){  
                 $('#edit_data_Modal').modal('show');
                const hotels = JSON.parse(datas);
                    $.each(hotels, function(index, data){  
                        $('#ename').val(data.name);
                        $('#eusername').val(data.username);
                        $('#epassword').val(data.password);
                        $('#eIsActive').val(data.IsActive);
                        $('#eemail').val(data.email);
                        $('#elevel').val(data.level);
                        $('#eCreateDate').val(data.CreateDate);
                        $('#eid').val(data.id);
                    });

                

                   
            }  
        });  
}
</script>
<div class="dashboard-main-wrapper">

    <?php include('inc/container-admin.php'); ?>
    <div class="dashboard-wrapper">
        <div class="container-fluid  dashboard-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">User Management</h2>
                        <p class="pageheader-text"></p>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php" class="breadcrumb-link">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">User Management</li>
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
                                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10">User Management</div>
                                
                            </div>
                        </h5>
                        <div class="card-body">
                            <div class="table-responsive">
                               
                                <table id="datatables" class="table table-striped table-bordered first">
                                    <thead>
                                        <tr class="border-0">
                                            <th class="border-0">User-ID</th>
                                            <th class="border-0">Username</th>
                                            <th class="border-0">Name</th>
                                            <th class="border-0">E-mail</th>
                                            <th class="border-0">User-Group</th>
                                            <th class="border-0">Status</th>
                                            <th class="border-0">Create-Date</th>
                                            <th class="border-0">Update-Date</th>
                                            <th class="border-0"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                               
                                            $connect = mysqli_connect($servername, $username, $password, $dbname);
                                            if ($connect->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                            }
                                            $sqls = "SELECT * FROM user";
                                            $results = $connect->query($sqls);
                                            $status ="";
                                            while ($rows = $results->fetch_assoc()) {
                                                if ($rows["IsActive"] == "0") { $status =  'Disabled' ; } else { $status = 'Enabled'; } 
                                                echo
                                                "<tr>" .
                                                "<td>" . $rows["id"] . "</td>" .
                                                "<td>" . $rows["username"]. "</td>" .
                                                "<td>" . $rows["name"] . "</td>" .
                                                "<td>" . $rows["email"] . "</td>" .
                                                "<td>" . $rows["level"] . "</td>" .
                                                "<td>" . $status . "</td>" .
                                                "<td>" . $rows["CreateDate"] . "</td>" .
                                                "<td>" . $rows["UpdateDate"] . "</td>" .
                                                "<td>  <button class='btn btn-warning btn-xs' onclick='edit(".$rows["id"].")'>Edit</button>
                                                <button onclick='deleteUser(".$rows["id"].")' class='btn btn-danger btn-xs'>Delete</button> </td>" .
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
                    <h4 class="modal-title">Edit User Information</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" id="edit_form">
                    <table class="table">
                        <tr>
                            <td width='35%'><label>Name</label></td>
                            <td width='65%'><input type="hidden" name="id" id="eid" value = "eid"/><input type="text" name="name" id="ename" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td width='35%'><label>Username</label></td>
                            <td width='65%'><input type="text" name="username" id="eusername" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td width='35%'><label>Password</label></td>
                            <td width='65%'><input type="text" name="password" id="epassword" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td width='35%'><label>Permission</label></td>
                            <td width='65%'>
                                <select name="level" id="elevel" value ="elevel" class="form-control" >
                                    <option value='user'>User</option>
                                    <option value='admin'>Admin</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td width='35%'><label>E-Mail</label></td>
                            <td width='65%'><input type="text" name="email" id="eemail" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td width='35%'><label>Active</label></td>
                            <td width='65%'>
                                <select name="IsActive" id="eIsActive" value="eIsActive" class="form-control" >
                                    <option value='1'>Enabled</option>
                                    <option value='0'>Disabled</option>
                                </select>
                            </td>
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
                    <h4 class="modal-title">Add User Information</h4>
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
                            <td width='35%'><label>Username</label></td>
                            <td width='65%'><input type="text" name="username" id="username" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td width='35%'><label>Password</label></td>
                            <td width='65%'><input type="text" name="password" id="password" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td width='35%'><label>Permission</label></td>
                            <td width='65%'>
                                <select name="level" id="level" value ="level" class="form-control" >
                                    <option value='user'>User</option>
                                    <option value='admin'>Admin</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td width='35%'><label>E-Mail</label></td>
                            <td width='65%'><input type="text" name="email" id="email" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td width='35%'><label>Active</label></td>
                            <td width='65%'>
                                <select name="IsActive" id="IsActive" value="IsActive" class="form-control" >
                                    <option value='1'>Enabled</option>
                                    <option value='0'>Disabled</option>
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
 $('#insert_form').on("submit", function(event){  
   $.ajax({  
    url:"module/insert-user.php",  
    method:"POST",  
    data:$('#insert_form').serialize(),  
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

 $('#edit_form').on("submit", function(event){  
   $.ajax({  
    url:"module/update-user.php",  
    method:"POST",  
    data:$('#edit_form').serialize(),  
    beforeSend:function(){  
     $('#edit').val("editting");  
    },  
    success:function(data){  
        if(data){
            window.location.reload();
        }else{
            alert('error');
        }
    }  
   });  
  
 });

});
</script>