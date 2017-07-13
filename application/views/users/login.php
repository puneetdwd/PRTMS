<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>PRTMS | Login</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <link rel="shortcut icon" href="favicon.ico"/>
        
        <link href="<?php echo base_url(); ?>assets/layouts/layout5/css/font.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/layouts/layout5/css/new_design.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        
    </head>
    <body>
        <div class="wrapper text-center">
            <header>
                <div class="container">
                    <a class="ir" href="#" id="logo" role="banner" title="Home">LG India</a>
                    
                    <div id="utils">
                        
                        <form class="form navbar-form" role="form" method="post" action="login" accept-charset="UTF-8" id="login-nav">
                            <?php if(isset($error)) { ?>
                                <div class="login-error text-danger text-left" style="margin-top:-28px;">
                                    <i class="fa fa-ban"></i>
                                    <strong> Error ! </strong>
                                    <?php echo $error; ?>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                 <label class="sr-only" for="username">Username</label>
                                 <input type="text" class="form-control input-sm" placeholder="Username" name="username" required>
                            </div>
                            <div class="form-group">
                                 <label class="sr-only" for="password">Password</label>
                                 <input type="password" class="form-control input-sm" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="button normals" style="margin-top: -7px; padding-bottom: 1px; padding-top: 1px;">
                                Sign in
                            </button>
                            
                        </form>
                    </div>
                    
                    <div class="page-logo-text" style="text-align: center; font-size: 20px; margin-top: 34px; color: #C80541;">PRTMS - Part Reliability Test Monitoring System</div>
                </div>
            </header>
            
            <div class="container">
                <section id="hero-area" class="hero-area tab">
                    <img src="assets/images/banner.jpg" >
                </section>
            </div>
            
            <footer>
                <div class="container">
                    <div class="legal">
                        <span class="copy">Copyright &copy; 2016 LG Electronics Powered By Corporate Renaissance Group. All Rights Reserved.</span>
                    </div>
                </div>
            </footer>
        </div>
        
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>