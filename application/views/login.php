<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Login Page e-Absen</title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link href="<?= base_url('assets/images/ikon.ico') ?>" rel="icon">
    <link href="<?= base_url('assets/images/ikon.ico') ?>" rel="apple-touch-icon">
    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/font-awesome/4.5.0/css/font-awesome.min.css" />

    <!-- text fonts -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/fonts.googleapis.com.css" />

    <!-- ace styles -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/ace.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/ace-rtl.min.css" />
</head>

<body class="login-layout light-login">
    <div class="main-container">
        <div class="main-content">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="login-container">
                        <div class="center">
                            <img src="<?= base_url() ?>assets/images/logo_falcon.png"
                                style="height: 100px; width: 250px; padding: 10px;" />
                        </div>

                        <div class="space-6"></div>

                        <div class="position-relative">
                            <div id="login-box" class="login-box visible widget-box no-border">
                                <div class="widget-body" style="height: 400px;">
                                    
                                    
                                    <div class="widget-main" style="height: 100%;">
                                        
                                        <h4 class="header blue lighter bigger"
                                            style="font-weight: bold;text-align: center;">
                                            Please Enter Your Admin
                                        </h4>

                                        <div class="space-6"></div>

                                        <form action="<?= base_url('Login/cek_akun/') ?>" method="POST">
                                            <fieldset>
                                                <label class="block clearfix">
                                                    <label>Email</label>
                                                    <span class="block input-icon input-icon-right">
                                                        <input type="text" class="form-control"
                                                            placeholder="email" name="email" required/>
                                                        <i class="ace-icon fa fa-user"></i>
                                                    </span>
                                                </label>

                                                <label class="block clearfix">
                                                    <label>Password</label>
                                                    <span class="block input-icon input-icon-right">
                                                        <input type="password" class="form-control"
                                                            placeholder="Password" name="password" required/>
                                                        <i class="ace-icon fa fa-lock"></i>
                                                    </span>
                                                </label>

                                                <div class="space"></div>

                                                <div class="clearfix">
                                                    <button type="submit"
                                                        class="width-100 pull-right btn btn-sm btn-primary">
                                                        <i class="ace-icon fa fa-key"></i>
                                                        <span class="bigger-110">Login</span>
                                                    </button>
                                                </div>
                                                <br><br>
                                                <div class="clearfix" style="width: 100%;">
                                                    <div class="center">
                                                        <a href="#" onclick="alert('Silakan hubungi Admin/IT')"
                                                            style="color:red;">
                                                            I forgot my password
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="space-4"></div>
                                            </fieldset>
                                        </form>


                                    </div><!-- /.widget-main -->


                                </div><!-- /.widget-body -->
                            </div><!-- /.login-box -->

                            <?= $this->session->flashdata('msg') ?>


                        </div><!-- /.position-relative -->

                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.main-content -->
    </div><!-- /.main-container -->

    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script src="<?= base_url() ?>assets/js/jquery-2.1.4.min.js"></script>

    <!-- <![endif]-->

    <script type="text/javascript">
        if ('ontouchstart' in document.documentElement) document.write("<script src='<?= base_url() ?>assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
    </script>

</body>

</html>