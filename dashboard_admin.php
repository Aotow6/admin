<?php 
    session_start();

    if (!isset($_SESSION['id'])) {
        // Jika belum login, alihkan ke halaman login atau berikan pesan akses ditolak
        header("Location: login.php");
        exit();
    }
    
    // Cek is_admin dari sesi pengguna
    $is_admin = $_SESSION['is_admin'];
    
    // Jika is_admin bukan 1 (tidak memiliki akses admin)
    if ($is_admin == '0') {
        // Alihkan pengguna ke halaman lain atau berikan pesan akses ditolak
        header("HTTP/1.0 404 Not Found");
        exit();
    }

    // Lanjutkan dengan halaman dashboard admin
    include('config.php');
    include('includes/header.php');
    include('includes/navbar.php');  
?> 
        
        
        
    
       

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

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <!-- </li>


                      

                     

                        <!- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-4 mt-2 d-none d-lg-inline text-gray-600 font-weight-bold"><?php echo $_SESSION['user_name']; ?></span>
                    <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                    </a>
                        <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="userDropdown">
                    <div class="dropdown-divider"></div>
                    <form id="logout-form" action="logout.php" method="POST">
                    <input type="hidden" name="logout" value="true">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                 </a>
                    </form>
                    </div>
                </li>


                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <!-- Page Heading -->
                <div class="container-fluid">
                <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">SELAMAT DATANG DI WEBSITE SIMANTAU</h5>
                                </div>
                                <div class="card-body">
                                <p class="mb-4">WEBSITE INI DIGUNAKAN UNTUK PARA GURU MELIHAT PELATIHAN DAN MENDAFTAR.</p>
                                </div>
                            </div>

                    <!-- Content Row -->
                    <div class="row">

                   
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

    

    <?php 
    include('includes/scripts.php');
    include('includes/footer.php');
    
    ?>
    
    