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
    <!-- Timeline CSS -->
    <link href="<?= CSS_DIR ?>/timeline.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= CSS_DIR ?>/sb-admin-2.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="<?= BOWER_DIR ?>/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?= BOWER_DIR ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>

<div id="wrapper">

<!-- Navigation -->
<?php include(INCLUDES_DIR.DS.'nav-bar.php'); ?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header text-primary">Attendance</h2>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>
                    <a href="<?= SITE_URL.DS.'home'.DS ?>dashboard">Dashboard</a>
                </li>
                <li class="active">
                    Attendance
                </li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="form-inline form-padding">
                <form id="frmSearch" role="form">
                    <input type="date" name="currentdate" id="currentdate" />
                    <select name="course" id="course">
                        <option value="select">Choose Course</option>
                        <option value="bca">BCA</option>
                        <option value="bph">BPH</option>
                        <option value="bba">BBA</option>
                    </select>
                    <select name="coursetype" id="coursetype">
                        <option value="type">Choose Course Type</option>
                        <option value="semester">Semester</option>
                        <option value="year">Year</option>
                    </select>
                    <select name="subject" id="subject">
                        <option value="type">Choose Subject</option>
                        <option value="dsa">DSA</option>
                        <option value="php">PHP</option>
                    </select>
                </form>
            </div>
            <br>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    List of Students
                </div>
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                      <table id="Tables" class="table table-bordered table-striped paginated tablesorter">
                          <thead>
                              <tr role="row">
                                    <th >
                                        Students Name
                                    </th>
                                    <th>
                                        Status
                                    </th>
                              </tr>
                          </thead>
                          <tr>
                              <td>Raju Lamsal</td>
                              <td><input type="checkbox" name="name1" />&nbsp;</td>
                          </tr>
                          <tr>
                              <td>Arjun Subedi</td>
                              <td><input type="checkbox" name="name1" />&nbsp;</td>
                          </tr>
                          <tr>
                              <td>Pravhu Gurung</td>
                              <td><input type="checkbox" name="name1" />&nbsp;</td>
                          </tr>
                          <tr>
                              <td>Pradeep Poudel</td>
                              <td><input type="checkbox" name="name1" />&nbsp;</td>
                          </tr>
                      </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /#wrapper -->
            <!-- modals -->
            <?php include(MODALS_DIR.DS.'course.php'); ?>
     <!-- jQuery -->
     <script src="<?= BOWER_DIR ?>/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?= BOWER_DIR ?>/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?= BOWER_DIR ?>/metisMenu/dist/metisMenu.min.js"></script>
     <!-- ckeditor -->
     <script src="<?= BOWER_DIR ?>/ckeditor/ckeditor.js"></script>
     <!-- jQuery tablesorter-->
    <script src="<?= BOWER_DIR ?>/jquery.tablesorter/dist/js/jquery.tablesorter.js"></script>
    <script src="<?= BOWER_DIR ?>/jquery.tablesorter/dist/js/jquery.tablesorter.widgets.js"></script>
    <!-- DataTables JavaScript -->
    <script src="<?= BOWER_DIR ?>/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?= BOWER_DIR ?>/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="<?= JS_DIR ?>/sb-admin-2.js"></script>
    <script src="<?= JS_DIR ?>/pages/attendance.js"></script>
</body>
</html>