<?php
    session_start();
    include('config.php'); // Contains the database connection code

    // Cek apakah pengguna sudah login
    if (!isset($_SESSION['login_user'])) {
        header("location: index.html");
        exit();
        }

    $no_id = $_SESSION['login_user'];
    $jabatan = $_SESSION['jabatan'];
    // Query to get user information
    $sql = "SELECT nama FROM pegawai WHERE no_id = '$no_id'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $user_name = $row['nama']; // Retrieve user's name
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Resto Unikom - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="Dashboard.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Resto Unikom</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="Dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Menu
            </div>

          <!-- Nav Item - Pages Collapse Menu -->
            <?php if ($jabatan == 'koki') { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKoki"
                    aria-expanded="true" aria-controls="collapseKoki">
                    <i class="fas fa-fw fa-utensils"></i>
                    <span>Koki</span>
                </a>
                <div id="collapseKoki" class="collapse" aria-labelledby="headingKoki" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Menu Koki</h6>
                        <a class="collapse-item" href="pengolahan-menu-koki.php">Pengolahan Menu</a>
                        <a class="collapse-item" href="pengolahan-pesanan-koki.php">Pengelohan Pesanan</a>
                    </div>
                </div>
            </li>
            <?php } ?>

            <?php if ($jabatan == 'pelayan') { ?>
            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePelayan"
                    aria-expanded="true" aria-controls="collapsePelayan">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Pelayan</span>
                </a>
                <div id="collapsePelayan" class="collapse show" aria-labelledby="headingPelayan" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Menu Pelayan</h6>
                        <a class="collapse-item active" href="reservasi-pesanan-pelayan.php">Reservasi Pesanan</a>
                        <a class="collapse-item" href="pengolahan-pesanan-pelayan.php">Pencatatan Pesanan</a>
                        <a class="collapse-item" href="status-pesanan-pelayan.php">Status Pesanan</a>
                    </div>
                </div>
            </li>
            <?php } ?>

            <?php if ($jabatan == 'kasir') { ?>
            <!-- Nav Item - Kasir Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKasir"
                    aria-expanded="true" aria-controls="collapseKasir">
                    <i class="fas fa-fw fa-cash-register"></i>
                    <span>Kasir</span>
                </a>
                <div id="collapseKasir" class="collapse" aria-labelledby="headingKasir" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Menu Kasir</h6>
                        <a class="collapse-item" href="pengolahan-pesanan-kasir.php">Total Pesanan</a>
                        <a class="collapse-item" href="pengolahan-laporan-keuangan-kasir.php">Laporan Keuangan</a>
                    </div>
                </div>
            </li>
            <?php } ?>

            <?php if ($jabatan == 'admin') { ?>
            <!-- Nav Item - Admin Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdmin"
                    aria-expanded="true" aria-controls="collapseAdmin">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Admin</span>
                </a>
                <div id="collapseAdmin" class="collapse" aria-labelledby="headingAdmin" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Menu Admin:</h6>
                        <a class="collapse-item" href="pengolahan-pegawai-admin.php">Pengolahan Pegawai</a>
                        <a class="collapse-item" href="pengolahan-meja-admin.php">Cards</a>
                        <a class="collapse-item" href="pengolahan-menu-admin.php">Cards</a>
                        <a class="collapse-item" href="pengolahan-laporan-admin.php">Cards</a>
                    </div>
                </div>
            </li>
            <?php } ?>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
                <p class="text-center mb-2"><strong>Resto Unikom</strong> Versi 1.0</p>
                <a class="btn btn-success btn-sm" href="https://github.com/xturus138/adminWebsite">Laporkan Bug !</a>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($user_name); ?></span>
                    <img class="img-profile rounded-circle"
                        src="img/undraw_profile.svg">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>

            </ul>

            </nav>
            <!-- End of Topbar -->
            <title>Menu Pencatatan Pesanan</title>
            <style>
                    body {
                        font-family: 'Nunito', sans-serif;
                        margin: 0;
                        padding: 0;
                        background-color: #f8f9fc;
                    }
                    .container {
                        width: 100%;
                        padding: 20px;
                        background-color: #fff;
                        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
                        border-radius: 5px;
                        margin-top: 30px;
                    }
                    h1 {
                        text-align: center;
                        color: #4e73df;
                        font-size: 1.75rem;
                        margin-bottom: 20px;
                    }
                    .submit-btn {
                        display: block;
                        width: 25%;
                        padding: 15px;
                        background-color: #4e73df;
                        color: white;
                        border: none;
                        border-radius: 5px;
                        cursor: pointer;
                        font-size: 18px;
                        font-weight: bold;
                        margin: 0 auto; 
                        text-align: center;
                    }
                    .submit-btn:hover {
                        background-color: #2e59d9;
                    }
                    .table-number {
                        margin-bottom: 20px;
                    }
                    .table-number label {
                        font-weight: bold;
                    }
                    .table-number select {
                        width: 100%;
                        padding: 10px;
                        border: 1px solid #d1d3e2;
                        border-radius: 5px;
                    }
                    .order-status {
                        margin-bottom: 20px;
                    }
                    .order-status label {
                        font-weight: bold;
                    }
                    .order-status select {
                        width: 100%;
                        padding: 10px;
                        border: 1px solid #d1d3e2;
                        border-radius: 5px;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h1>Menu Reservasi</h1>
                    <form action="reservasi-pesanan-insert-pelayan.php" method="POST">
                        <div class="table-number">
                            <label for="table-number">Nomor Meja:</label>
                            <select id="table-number" name="table_number" required>
                                <option value="" disabled selected>Pilih Nomor Meja</option>
                                <?php
                                include('config.php');
                                $query = "SELECT no_meja, kapasitas, status_meja FROM meja WHERE status_meja = 'kosong'";
                                $result = mysqli_query($db, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $no_meja = $row['no_meja'];
                                    $kapasitas = $row['kapasitas'];
                                    $status_meja = $row['status_meja'];
                                    echo "<option value=\"$no_meja\">Meja $no_meja - Kapasitas: $kapasitas - Status: $status_meja</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary btn-block">Catat Reservasi</button>
                    </form>
                </div>
            </body>
    
            <!-- End of Page Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="index.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>