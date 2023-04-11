<?php  
include('../config/database.php');

if(isset($_POST["supplier_id"]))
{
 $output = '';
 $connect = mysqli_connect($servername, $username, $password, $dbname);
 $query = "SELECT * FROM suppliers WHERE id = '".$_POST["supplier_id"]."'";
 $result = mysqli_query($connect, $query);
 $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';
    while($row = mysqli_fetch_array($result))
    {
     $output .= '
            <label>Supplier ID : '.$row["id"].'</label>
            <input type="text" name="sname" id="sname" value ="'.$row["supplier"].'"class="form-control" />
            <br />
            <button type="button" onclick="updateItem('.$row["id"].')" name="update" id="update" class="btn btn-primary btn-xs">Update</button>
     '; 
    }
    $output .= '</table></div>';
    echo $output;
}

if(isset($_POST["product_id"]))
{
 $output = '';
 $connect = mysqli_connect($servername, $username, $password, $dbname);
 $query = "SELECT * FROM products WHERE id = '".$_POST["product_id"]."'";
 $result = mysqli_query($connect, $query);
 $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';
    while($row = mysqli_fetch_array($result))
    {
     $output .= '
       <label>Product ID : '.$row["id"].'</label>
              <table class="table table-borderless">
                    <tr>
                        <td width="40%"><label>Name</label></td>
                        <td width="60%" ><input type="text" name="name" id="name" class="form-control" value ="'.$row["ProductName"].'"/></td>
                    </tr>
                    <tr>
                        <td><label>Part Number</label></td>
                        <td><input type="text" name="pname" id="pname" class="form-control" value ="'.$row["PartNumber"].'"/></td>
                    </tr>
                    <tr>
                        <td><label>Label</label></td>
                        <td><input type="text" name="lname" id="lname" class="form-control" value ="'.$row["ProductLabel"].'"/></td>
                    </tr>
                    <tr>
                        <td><label>Starting Inventory</label></td>
                        <td><input type="text" name="startInventory" id="startInventory" class="form-control" value ="'.$row["StartingInventory"].'"/></td>
                    </tr>
                    <tr>
                        <td><label>Inventory Received</label></td>
                        <td><input type="text" name="InventoryReceived" id="InventoryReceived" class="form-control" value ="'.$row["InventoryReceived"].'"/></td>
                    </tr>
                    <tr>
                        <td><label>Inventory Shipped</label></td>
                        <td><input type="text" name="InventoryShipped" id="InventoryShipped" class="form-control" value ="'.$row["InventoryShipped"].'"/></td>
                    </tr>
                    <tr>
                        <td><label>Inventory On Hand</label></td>
                        <td ><input type="text" name="InventoryOnHand" id="InventoryOnHand" class="form-control" value ="'.$row["InventoryOnHand"].'"/></td>
                    </tr>
                    <tr>
                        <td ><label>Minimum Required</label></td>
                        <td ><input type="text" name="MinimumRequired" id="MinimumRequired" class="form-control" value ="'.$row["MinimumRequired"].'"/></td>
                    </tr>
                </table>
            <button type="button" onclick="updateItem('.$row["id"].')" name="update" id="update" class="btn btn-primary btn-xs">Update</button>
     '; 
    }
    $output .= '</table></div>';
    echo $output;
}

?>



