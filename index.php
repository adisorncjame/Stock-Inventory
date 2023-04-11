<?php include('inc/header.php') ?>
<div class="dashboard-main-wrapper">
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

<?php include('inc/container-admin.php'); ?>

    
    <div class="dashboard-wrapper">
        <div class="container-fluid  dashboard-content">

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">

                        <h2 class="pageheader-title">Dashboard Inverntory  </h2>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Stock Inverntory Dashboard
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ecommerce-widget">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-muted">Total Item in Stock</h5>
                                <div class="metric-value d-inline-block">
                                    <h1 class="mb-1">
                                        <?php
                                        $conn = new mysqli($servername, $username, $password, $dbname);
                                        if ($conn->connect_error) {
                                            die("Connection failed: " . $conn->connect_error);
                                        }
                                        $sql = "SELECT SUM(InventoryOnHand) as total FROM products";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo $row["total"];
                                            }
                                        } else {
                                            echo "0";
                                        }
                                        $conn->close();
                                        ?>
                                    </h1>
                                </div>
                                <div class="metric-label d-inline-block float-right text-primary font-weight-bold">
                                    <span>N/A</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-muted">Total Order</h5>
                                <div class="metric-value d-inline-block">
                                    <h1 class="mb-1">
                                        <?php
                                        $conn = new mysqli($servername, $username, $password, $dbname);
                                        if ($conn->connect_error) {
                                            die("Connection failed: " . $conn->connect_error);
                                        }
                                        $sql = "SELECT SUM(orders.id) as total FROM orders";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo $row["total"];
                                            }
                                        } else {
                                            echo "0";
                                        }
                                        $conn->close();
                                        ?>

                                    </h1>
                                </div>
                                <div class="metric-label d-inline-block float-right text-primary font-weight-bold">
                                    <span>N/A</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-muted">Total Product</h5>
                                <div class="metric-value d-inline-block">
                                    <h1 class="mb-1">


                                        <?php
                                        $conn = new mysqli($servername, $username, $password, $dbname);
                                        if ($conn->connect_error) {
                                            die("Connection failed: " . $conn->connect_error);
                                        }
                                        $sql = "SELECT count(products.id) as total FROM products";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo $row["total"];
                                            }
                                        } else {
                                            echo "0";
                                        }
                                        $conn->close();
                                        ?>

                                    </h1>
                                </div>
                                <div class="metric-label d-inline-block float-right text-primary font-weight-bold">
                                    <span>N/A</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-muted">Total Suppliers</h5>
                                <div class="metric-value d-inline-block">
                                    <h1 class="mb-1">
                                        <?php
                                        $conn = new mysqli($servername, $username, $password, $dbname);
                                        if ($conn->connect_error) {
                                            die("Connection failed: " . $conn->connect_error);
                                        }
                                        $sql = "SELECT count(suppliers.id) as total FROM suppliers";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo $row["total"];
                                            }
                                        } else {
                                            echo "0";
                                        }
                                        $conn->close();
                                        ?>
                                    </h1>
                                </div>
                                <div class="metric-label d-inline-block float-right text-primary font-weight-bold">
                                    <span>N/A</span>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- ============================================================== -->

                    <!-- ============================================================== -->

                    <!-- recent orders  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Top 5 Supplier</h5>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-light">
                                            <tr class="border-0">
                                                <th class="border-0">#</th>
                                                <th class="border-0">Supplier ID</th>
                                                <th class="border-0">Name</th>
                                                <th class="border-0">Total Order</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Query Table Top 5 Supplier -->
                                            <?php

                                            $conn = new mysqli($servername, $username, $password, $dbname);
                                            if ($conn->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                            }
                                            $sql = "

SELECT  suppliers.supplier As SuppliersName , SUM(purchases.id) As TotalOrders ,suppliers.id As sId
FROM purchases 
LEFT JOIN suppliers 
ON purchases.SupplierId = suppliers.id GROUP BY suppliers.supplier
ORDER By COUNT(purchases.id) DESC LIMIT 5;";

                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                $r = 1;
                                                while ($row = $result->fetch_assoc()) {
                                                    echo
                                                        "<tr>" .
                                                        "<td>" . $r . "</td>" .
                                                        "<td>" . $row["sId"] . "</td>" .
                                                        "<td>" . $row["SuppliersName"] . "</td>" .
                                                        "<td>" . $row["TotalOrders"] . "</td>" .
                                                        "</tr>";

                                                    $r++;
                                                }
                                            } 
                                            $conn->close();
                                            ?>

                                            <tr>
                                                <td colspan="9"><a href="supplier-information.php"
                                                        class="btn btn-outline-light float-right">View Details</a>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Top 5 Product On Hand </h5>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-light">
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
                                            $sql = "
SELECT * FROM products
Order by InventoryOnHand DESC
LIMIT 5;
";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo
                                                        "<tr>" .
                                                        "<td>" . $row["ProductName"] . "</td>" .
                                                        "<td>" . $row["PartNumber"] . "</td>" .
                                                        "<td>" . $row["ProductLabel"] . "</td>" .
                                                        "<td>" . $row["StartingInventory"] . "</td>" .
                                                        "<td>" . $row["InventoryReceived"] . "</td>" .
                                                        "<td>" . $row["InventoryShipped"] . "</td>" .
                                                        "<td>" . $row["InventoryOnHand"] . "</td>" .
                                                        "<td>" . $row["MinimumRequired"] . "</td>" .
                                                        "</tr>";
                                                }
                                            } 
                                            $conn->close();
                                            ?>

                                            <tr>
                                                <td colspan="9"><a href="product-information.php"
                                                        class="btn btn-outline-light float-right">View Details</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>


                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Top 5 Order Last </h5>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-light">
                                            <tr class="border-0">
                                                <th class="border-0">OrderID</th>
                                                <th class="border-0">Title</Title>
                                                </th>
                                                <th class="border-0">Product Name</th>
                                                <th class="border-0">Frist</th>
                                                <th class="border-0">Last</th>
                                                <th class="border-0">Number Shipped</th>
                                                <th class="border-0">Order Date</th>
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
                                                        "<td>" . $row["OrderDate"] . "</td>" .
                                                        "</tr>";
                                                }
                                            } 
                                            $conn->close();
                                            ?>

                                            <tr>
                                                <td colspan="9"><a href="order-information.php"
                                                        class="btn btn-outline-light float-right">View Details</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php include('inc/footer.php'); ?>