<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin e-Absen</title>
    <!-- Bootstrap Styles-->
    <link href="<?= base_url() ?>assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="<?= base_url() ?>assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="<?= base_url() ?>assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="<?= base_url() ?>assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <!-- TABLE STYLES-->
    <link href="<?= base_url() ?>assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link href="<?= base_url('assets/images/ikon.ico') ?>" rel="icon">
    <link href="<?= base_url('assets/images/ikon.ico') ?>" rel="apple-touch-icon">
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= base_url() ?>">Admin</a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?= base_url('Login/keluar/') ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a href="<?= base_url() ?>" <?php if ($page == "Dashboard") {
                                                        echo 'class="active-menu"';
                                                    } ?>><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url("Riwayat") ?>" <?php if ($page == "Riwayat") {
                                                                    echo 'class="active-menu"';
                                                                } ?>><i class="fa fa-folder-open"></i> Riwayat Absen</a>
                    </li>
                    <li>
                        <a href="<?= base_url("User") ?>" <?php if ($page == "User") {
                                                                echo 'class="active-menu"';
                                                            } ?>><i class="fa fa-users"></i> User</a>
                    </li>
                    <?php if ($_SESSION['role_user'] == 3) { ?>
                        <li>
                            <a href="<?= base_url("Jabatan") ?>" <?php if ($page == "Jabatan") {
                                                                        echo 'class="active-menu"';
                                                                    } ?>><i class="fa fa-briefcase"></i> Jabatan</a>
                        </li>
                        <li>
                            <a href="<?= base_url("Tempat") ?>" <?php if ($page == "Tempat") {
                                                                    echo 'class="active-menu"';
                                                                } ?>><i class="fa fa-globe"></i> Tempat Kerja</a>
                        </li>
                    <?php } ?>
                    <!--li>
                        <a href="<? //= base_url("Pengumuman") 
                                    ?>" <?php //if($page == "Pengumuman"){ echo 'class="active-menu"';} 
                                                                    ?>><i class="fa fa-table"></i> Pengumuman</a>
                    </li-->
                    <li>
                        <a href="<?= base_url("Libur") ?>" <?php if ($page == "Libur") {
                                                                echo 'class="active-menu"';
                                                            } ?>><i class="fa fa-table"></i> Hari Libur</a>
                    </li>
                    <li>
                        <a href="<?= base_url("Laporan") ?>" <?php if ($page == "Laporan") {
                                                                    echo 'class="active-menu"';
                                                                } ?>><i class="fa fa-download"></i> Laporan </a>
                    </li>
                    <?php if ($_SESSION['role_user'] == 3 OR $_SESSION['role_user'] == 2) { ?>
                        <li>
                            <a href="<?= base_url("Tools") ?>" <?php if ($page == "Tools") {
                                                                    echo 'class="active-menu"';
                                                                } ?>><i class="fa fa-wrench"></i> Menu Khusus </a>
                        </li>
                    <?php } ?>

                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">