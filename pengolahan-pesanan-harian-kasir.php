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

    <title>Resto Unikom</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

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
            <li class="nav-item">
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
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKoki" aria-expanded="true" aria-controls="collapseKoki">
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
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePelayan" aria-expanded="true" aria-controls="collapsePelayan">
                        <i class="fas fa-fw fa-wrench"></i>
                        <span>Pelayan</span>
                    </a>
                    <div id="collapsePelayan" class="collapse" aria-labelledby="headingPelayan" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Menu Pelayan</h6>
                            <a class="collapse-item" href="pengolahan-pesanan-pelayan.php">Pencatatan Pesanan</a>
                        </div>
                    </div>
                </li>
            <?php } ?>

            <?php if ($jabatan == 'kasir') { ?>
                <!-- Nav Item - Kasir Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKasir" aria-expanded="true" aria-controls="collapseKasir">
                        <i class="fas fa-fw fa-cash-register"></i>
                        <span>Kasir</span>
                    </a>
                    <div id="collapseKasir" class="collapse show" aria-labelledby="headingKasir" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Menu Kasir</h6>
                            <a class="collapse-item active" href="pengolahan-pesanan-harian-kasir.php">Pengolahan Pesanan</a>
                            <a class="collapse-item " href="pengolahan-pesanan-kasir.php">Histori Pesanan</a>
                            <a class="collapse-item" href="pengolahan-laporan-keuangan-kasir.php">Laporan Keuangan</a>
                        </div>
                    </div>
                </li>
            <?php } ?>

            <?php if ($jabatan == 'admin') { ?>
                <!-- Nav Item - Admin Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdmin" aria-expanded="true" aria-controls="collapseAdmin">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Admin</span>
                    </a>
                    <div id="collapseAdmin" class="collapse" aria-labelledby="headingAdmin" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Menu Admin:</h6>
                            <a class="collapse-item" href="pengolahan-pegawai-admin.php">Pengolahan Pegawai</a>
                            <a class="collapse-item" href="pengolahan-meja-admin.php">Pengolahan Meja</a>
                            <a class="collapse-item" href="pengolahan-menu-admin.php">Persetujuan Menu</a>
                            <a class="collapse-item" href="pengolahan-laporan-admin.php">Laporan Keuangan</a>
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

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Pengolahan Pesanan</h1>
                    <!-- Orders Tab -->
                    <div id="orders" class="tab-content">
                        <p class="mb-4">Daftar Pesanan Dari Semua Pelanggan Hari Ini.</p>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Tabel Pesanan</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <form method="POST" action="">
                                    </form>
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 5%;">No</th>
                                                <th class="text-center" style="width: 12%;">Nomor Pesanan</th>
                                                <th class="text-center" style="width: 20%;">Tanggal</th>
                                                <th class="text-center" style="width: 18%;">Nomor Meja</th>
                                                <th class="text-center" style="width: 20%;">Total</th>
                                                <th class="text-center" style="width: 20%;">Status</th>
                                                <th class="text-center" style="width: 10%;">Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody id="orders-table-body">
                                            <?php
                                            include 'config.php';

                                            // Define statuses to include
                                            $statuses = ["selesai", "belum dibayar", "sudah dibayar"];

                                            // Function to get today date
                                            date_default_timezone_set('Asia/Jakarta');
                                            $today = date('Y-m-d');

                                            // SQL query to fetch orders
                                            $sql = "SELECT o.no_pesanan, o.tanggal, m.no_meja, SUM(ip.jumlah) as total_jumlah, o.total, o.status_pesanan
                                                    FROM pesanan o
                                                    JOIN isi_pesanan ip ON o.no_pesanan = ip.no_pesanan
                                                    JOIN meja m ON o.no_meja = m.no_meja
                                                    WHERE o.status_pesanan IN ('selesai', 'belum dibayar', 'sudah dibayar') AND DATE(o.tanggal) = '$today'
                                                    GROUP BY o.no_pesanan, o.tanggal, m.no_meja, o.total, o.status_pesanan"; 

                                            $result = mysqli_query($db, $sql);

                                            if (mysqli_num_rows($result) > 0) {
                                                $no = 1; // Initialize row number
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    // Determine button class based on status
                                                    $status = $row['status_pesanan'];
                                                    $btnClass = 'btn-warning';

                                                    if ($status == 'selesai') {
                                                        $btnClass = 'btn-primary';
                                                    } else if ($status == 'belum dibayar') {
                                                        $btnClass = 'btn-danger';
                                                    } else if ($status == 'sudah dibayar') {
                                                        $btnClass = 'btn-success';
                                                    }

                                                    echo "<tr>
                                        <td class='text-center'>{$no}</td>
                                        <td>{$row['no_pesanan']}</td>
                                        <td>{$row['tanggal']}</td>
                                        <td>{$row['no_meja']}</td>
                                        <td>{$row['total']}</td>
                                        <td>
                                            <div class='dropdown text-center'>
                                                <button class='btn $btnClass dropdown-toggle' type='button' id='statusDropdown{$row['no_pesanan']}' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                    {$status}
                                                </button>
                                                <div class='dropdown-menu' aria-labelledby='statusDropdown{$row['no_pesanan']}'>
                                                    <a class='dropdown-item' href='#' data-id='{$row['no_pesanan']}' data-status='sudah dibayar' onclick='updateStatus(this)'>sudah dibayar</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class='text-center'>
                                            <button type='button' class='btn btn-info' data-toggle='modal' data-target='#orderDetailModal' data-id='{$row['no_pesanan']}'>
                                                Detail
                                            </button>
                                        </td>
                                    </tr>";
                                                    $no++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='8' class='text-center'>Pesanan tidak ditemukan</td></tr>";
                                            }
                                            mysqli_close($db);
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->

    <!-- Detail Modal -->
    <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Pesanan</h1>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="order-details-content"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; Resto Unikom 2024</span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" di bawah jika Anda siap mengakhiri sesi saat ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
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

    <!-- Updated data in database and fetch order details on modal function -->
    <script>
        $('#orderDetailModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var orderId = button.data('id');

            $.ajax({
                url: 'pengolahan-pesanan-detail-kasir.php',
                type: 'GET',
                data: {
                    no_pesanan: orderId
                },
                success: function(response) {
                    $('#order-details-content').html(response);
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan saat menampilkan detail pesanan');
                }
            });
        });

        function updateStatus(element) {
            var orderId = $(element).data('id');
            var status = $(element).data('status');
            var button = $('#statusDropdown' + orderId);

            $.ajax({
                url: 'pengolahan-pesanan-status-kasir.php',
                type: 'POST',
                data: {
                    no_pesanan: orderId,
                    status: status
                },
                success: function(response) {
                    button.text(status);
                    button.removeClass('btn-warning btn-success btn-danger btn-primary');
                    if (status === 'selesai') {
                        button.addClass('btn-primary');
                    } else if (status === 'belum dibayar') {
                        button.addClass('btn-danger');
                    } else if (status === 'sudah dibayar') {
                        button.addClass('btn-success');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan saat memperbarui status');
                }
            });
        }
    </script>
</body>

</html>