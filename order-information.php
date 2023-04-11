<?php include('inc/header.php') ?>
<div class="dashboard-main-wrapper">
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

    <?php include('inc/container-admin.php') ?>

    <div class="dashboard-wrapper">
        <div class="container-fluid  dashboard-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Order Information</h2>
                        <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit
                            amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php" class="breadcrumb-link">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Order Information</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">Order Information</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatables" class="table table-striped table-bordered first">
                                    <thead>
                                        <tr class="border-0">
                                        <th class="border-0">OrderID</th>
                                                <th class="border-0">Title</Title>
                                                </th>
                                                <th class="border-0">Product Name</th>
                                                <th class="border-0">Frist</th>
                                                <th class="border-0">Last</th>
                                                <th class="border-0">Number Shipped</th>
                                                <th class="border-0">Order Date</th>
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
                                        $sql = "
SELECT orders.id , orders.ProductId  ,orders.First, orders.Last , orders.Title,products.ProductName, orders.OrderDate,orders.NumberShipped
FROM orders 
INNER JOIN products 
ON orders.ProductId = products.id GROUP by orders.id DESC LIMIT 5;
";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo
                                                    "<tr>" .
                                                    "<td>" . $row["id"] . "</td>" .
                                                    "<td>" . $row["Title"] . "</td>" .
                                                    "<td>" . $row["ProductName"] . "</td>" .
                                                    "<td>" . $row["First"] . "</td>" .
                                                    "<td>" . $row["Last"] . "</td>" .
                                                    "<td>" . $row["NumberShipped"] . "</td>" .
                                                    "<td>" . $row["OrderDate"] . "</td>" ?>
                                                    <td width ='5%'><input type="button" name="view" value="view" id="<?php echo $row["id"]; ?>" class="btn btn-info btn-xs view_data" /></td>
                                                    <td width ='5%'><button type="button" onclick="deleteItem(<?php echo $row['id'] ?>)" name="delete" id="delete" class="btn btn-danger btn-xs">delete</button></td>
                                                </tr><?php ;
                                                    
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
                    </div>
                </div>
            </div>
        </div>
        <?php include('inc/footer.php'); ?>