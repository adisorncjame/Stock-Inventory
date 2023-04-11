<?php include('inc/header.php');session_start(); ?>
<div class="dashboard-main-wrapper">

    <?php include('inc/container.php') ?>

    <div class="dashboard-wrapper">
        <div class="container-fluid  dashboard-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title"> WELCOME  <?php echo $_SESSION["username"]." LEVEL: ".$_SESSION["level"]; ?></h2>
                        <div class="page-breadcrumb">
                            <!-- <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php" class="breadcrumb-link">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Incoming Purchases</li>
                                </ol>
                            </nav> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('inc/footer.php'); ?>
