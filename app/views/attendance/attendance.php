<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?= WEBSITE_TITLE ?> | Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="<?= BOWER_DIR ?>/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?= BOWER_DIR ?>/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= CSS_DIR ?>/sb-admin-2.css" rel="stylesheet">
    <link href="<?= CSS_DIR ?>/style.css" rel="stylesheet">

    <!-- Font awesome CSS -->
    <link href="<?= BOWER_DIR ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
</head>
<body>
  <div id="wrapper">
    <!-- Navigation -->
    <?php include(INCLUDES_DIR.DS.'nav-bar.php'); ?>
    <!-- Page Wrapper -->
    <div id="page-wrapper" <?php if(!Session::isLoggedIn(1)) echo 'class = "page-wrapperUser"'?>>
      <div class="container-fluid">
        <div class="row" style="margin:20px auto;">
          <div class="col-lg-12">
                    <h2 class="page-header">Attendance</h2>
          </div>
          <div class="col-md-2">
            <form role="form" class="form-group">
              <label for="currentdate">Current Date</label>
              <input class="form-control" type="date" id="currentdate" min="2019-01-01" max="<?= date("Y-m-d") ?>" name="currentdate" value="<?= date("Y-m-d") ?>" class="form-control"/>
            </form>
          </div>
          <div class="col-md-6"></div>
        </div>
        <!-- End First Row -->
        <!-- start 2nd row -->
        <div class="row" style="margin:0 auto;">
          <div class="col-md-6">
           
              <div class="panel-group attendance-panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <?php
                if(!is_null($this->errors) ) {
                  echo $this->errors;
                }else if(count($this->subjects) <= 0){
                  echo "You have no subject assigned.";
                }else {
                  foreach ($this->subjects as $key => $value) {
                ?>

                  <div class="panel panel-default attendance-panel-default">
                      <div class="panel-heading attendance-panel-heading" role="tab" id="headingOne">
                          <h4 class="panel-title">
                              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$value['id']?>" aria-expanded="true" aria-controls="collapseOne">
                                  <i class="more-less glyphicon glyphicon-plus"></i>
                                  <?= $value['name'] ?> | <b>Year/Semester :</b><?= $value['yearOrSemester'] ?> | <?= $value['sectionName'] ?>
                              </a>
                          </h4>
                      </div>
                      <div id="collapse<?=$value['id']?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                          <div class="panel-body"><p>
                                <b>Program :</b> <?= $value['programName'] ?>
                                <br>
                                <b>Details :</b> <?= $value['details'] ?>

                                </p><a href="#" data-id='<?= $value['id'] ?>' class="btn btn-info text-center fetchAttendance" role="button">Select</a>
                          </div>
                      </div>
                  </div> 
                <?php
                    }
                  }
                ?>

              </div>
          </div>
          <div class="col-md-6"></div>
        </div>
        <!-- End 2nd Row -->
        <div class="row">
          <div class="col-md-6" id="tableToHide">
          </div>
          <div class="col-md-6">
          </div>
        </div>
      </div>
    </div>
  </div>

        <!-- jQuery -->
        <script src="<?= BOWER_DIR ?>/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?= BOWER_DIR ?>/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Notify -->
        <script src="<?= BOWER_DIR ?>/notifyjs/dist/notify.js"></script>
        <script src="<?= BOWER_DIR ?>/notifyjs/dist/styles/bootstrap/notify-bootstrap.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?= BOWER_DIR ?>/metisMenu/dist/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="<?= JS_DIR ?>/sb-admin-2.js"></script>
    <script src="<?= JS_DIR ?>/pages/attendance.js"></script>
</body>
</html>