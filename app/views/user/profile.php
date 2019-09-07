<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?= WEBSITE_TITLE ?> | Profile</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?= BOWER_DIR ?>/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="<?= BOWER_DIR ?>/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= CSS_DIR ?>/sb-admin-2.css" rel="stylesheet">
    <link href="<?= CSS_DIR ?>/style.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?= BOWER_DIR ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->
        <?php include(INCLUDES_DIR.DS.'nav-bar.php'); ?>

        <div id="page-wrapper" <?php if(!Session::isLoggedIn(1)) echo 'class = "page-wrapperUser"'?>>
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">Profile</h2>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> 
                            <a href="<?= SITE_URL ?>/home/dashboard">Dashboard</a>
                        </li>
                        <li class="active">
                           Manage Profile
                        </li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Manage Profile
                        </div>
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist" id="myTabs">                                    
                                <li role="presentation" class="<?= ($this->activeTab == 'profile') ? "active" : "" ?>"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
                                <li role="presentation" class="<?= ($this->activeTab == 'security') ? "active" : "" ?>"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Security Accounts</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane <?= ($this->activeTab == 'profile') ? "active" : "" ?>" id="profile">
                                    <br>
                                    <form method="POST" action="<?= SITE_URL."/user/profile" ?>" role="form"  id="frmProfile" class="padding-top">
                                        <div class="form-group col-md-6" >
                                            <label>First Name</label>
                                            <input class="form-control" type="text" name="fname" id="fname" placeholder="First Name" minlength="1" value="<?=$this->profile['fname'] ?>" required />
                                            <span class="help-inline"></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Middle Name</label>
                                            <input class="form-control" type="text" name="mname" id="mname" placeholder="Middle Name" value="<?=$this->profile['mname'] ?>" / >
                                            <span class="help-inline"></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Last Name</label>
                                            <input class="form-control" type="text" name="lname" id="lname" placeholder="Last Name" minlength="1" value="<?=$this->profile['lname'] ?>" required />
                                            <span class="help-inline"></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Email</label>
                                            <input class="form-control" type="email" name="email" id= "email" placeholder="Email Address" minlength="5" value="<?=$this->profile['email'] ?>" required />
                                            <span class="help-inline"></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Phone No</label>
                                            <input class="form-control" type="text" name="mobileNo" id= "mobileNo" placeholder="Phone Number" minlength="2" value="<?=$this->profile['mobileNo'] ?>" required />
                                            <span class="help-inline"></span>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <button name="submit_profile" type = "submit" id="btn-save" class="btn btn-primary">  Update </button>
                                            <button type="reset" class="btn btn-warning" data-dismiss="modal">Reset</button>
                                        </div>
                                    </form>
                                </div>
                                <div role="tabpanel" class="tab-pane <?= ($this->activeTab == 'security') ? "active" : "" ?>" id="settings">
                                    <br>
                                    <form method="post" role="form" action="<?= SITE_URL."/user/profile" ?>" id="frmAccount" class="padding-top">
                                    
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label>Username</label>
                                                <input class="form-control" type="text" name="username" id="username" placeholder="Username" minlength="5" value="<?=$this->profile['username'] ?>" required />
                                                <span class="help-inline"></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>New Password</label>
                                                    <input class="form-control" type="password" name="passwordHash" id="password" placeholder="Password" />
                                                    <span class="help-inline"></span>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Confirm Password</label>
                                                    <input class="form-control" type="password" name="cpasswordHash" id="password2" placeholder="Confirm Password" />
                                                    <span class="help-inline"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <button name="submit_security" type = "submit" id="btn-save" class="btn btn-primary">  Update </button>
                                            <button type="reset" class="btn btn-warning" data-dismiss="modal">Reset</button>
                                        </div>
                                    </form>                                        
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="<?= BOWER_DIR ?>/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= BOWER_DIR ?>/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?= BOWER_DIR ?>/metisMenu/dist/metisMenu.min.js"></script>
    <!-- Notify -->
    <script src="<?= BOWER_DIR ?>/notifyjs/dist/notify.js"></script>
    <script src="<?= BOWER_DIR ?>/notifyjs/dist/styles/bootstrap/notify-bootstrap.js"></script>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="<?= BOWER_DIR ?>/bootstrap3-dialog/dist/js/bootstrap-dialog.min.js"></script>
    <!-- spinJS -->
    <script src="<?= BOWER_DIR ?>/spin.js/spin.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?= JS_DIR ?>/sb-admin-2.js"></script>
    <script type="text/javascript">
        <?php
            if(!is_null($this->success)) {
                if($this->success) {
        ?>
                $(document).ready(function() {
                    $.notify("Updated", "success");
                });
        <?php
                }else {
        ?>
                $(document).ready(function() {
                    $.notify("<?= $this->errors[0]?>", "error");
                });
        <?php
                }
            }
        ?>
    </script>

</body>

</html>