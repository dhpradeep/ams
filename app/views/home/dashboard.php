<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?= WEBSITE_TITLE ?> | Dashboard</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?= BOWER_DIR ?>/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="<?= BOWER_DIR ?>/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= CSS_DIR ?>/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?= BOWER_DIR ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>


    <div id="wrapper">
        <!-- Navigation -->
        <?php include(INCLUDES_DIR.DS.'nav-bar.php'); ?>

        <div id="page-wrapper">
            <!-- /.row -->
            <div class="row">
                    <div class="col-lg-12">
                                              
                        <h1 class="page-header">
                            Welcome to <small class="text-primary"><?= WEBSITE_TITLE ?></small>
                           
                        </h1>                
                    </div>
                </div>
                <!-- /.row -->

    <!-- on admin session -->
                <div class="row">
                    <div class="col-lg-12">
                        <h4>About the system here</h4>
                        
                        <blockquote>
                            This is <?= WEBSITE_TITLE." Version : ".VERSION ?><br><br>
                          <p>Developed by <strong><a target="blank" href = "<?= BRAND_WEBSITE ?>" ><?= BRAND_NAME ?></a></strong></p>
                        </blockquote>
                    </div>
                </div>

    <!-- on student session -->
                <?php 
                    if(!is_null($this->errors) &&count($this->errors) > 0) {
                        foreach ($this->errors as $value) {
                            ?>
                            <div class="row">
                                <div>
                                    <span style="font-size:18px; margin-left: 10px;"><strong><?= $value ?></strong></span>
                                </div>
                            </div>
                        <?php
                        }
                    }else {
                ?>
                <div class="row">
                    <div>
                        <span style="font-size:16px;">Name of Student : <strong><?= Session::getSession('uname'); ?></strong></span>
                    </div>
                </div>
                <div class="row">
                    <div>
                        <span style="font-size:20px;">Program : <strong><?= $this->name ?></strong></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col md-12">
                    <p><?= htmlspecialchars_decode($this->welcome) ?></p><br><br>
                    <div class="col col-md-12 text-left">
                        <a href="<?= SITE_URL ?>/test/start"><button class="btn btn-success" type="button">Take Test</button></a>
                    </div>
                </div>
            </div>
            <br>
            <?php } ?>
            </div>
        <br><br>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="<?= BOWER_DIR ?>/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?= BOWER_DIR ?>/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?= BOWER_DIR ?>/metisMenu/dist/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="<?= JS_DIR ?>/sb-admin-2.js"></script>
</body>

</html>
