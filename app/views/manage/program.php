<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= WEBSITE_TITLE ?> | Model</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?= BOWER_DIR ?>/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?= BOWER_DIR ?>/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Bootstrap Core CSS -->
    <link href="<?= BOWER_DIR ?>/bootstrap3-dialog/dist/css/bootstrap-dialog.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= CSS_DIR ?>/sb-admin-2.css" rel="stylesheet">
    <link href="<?= CSS_DIR ?>/style.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?= BOWER_DIR ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>

    <div id="wrapper">
        <div id="target1"></div>
        <!-- Navigation -->
        <?php include(INCLUDES_DIR.DS.'nav-bar.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">All Programs</h2>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i>
                            <a href="<?= SITE_URL.DS.'home'.DS ?>dashboard">Dashboard</a>
                        </li>
                        <li class="active">
                            Program
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
                            <a onclick="create_program()" class="btn btn-primary">Add Program</a>
                            <a onclick="refresh()" class="btn btn-info">Refresh</a>
                        </form>
                    </div>
                    <br>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            List of Program
                        </div>
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                              <table id="programTable" class="table table-bordered table-striped paginated tablesorter">
                                  <thead>
                                      <tr role="row">
                                            <th >
                                                Program Name
                                            </th>
                                            <th>
                                                Total Year/Semester
                                            </th>
                                            <th>
                                                Details
                                            </th>
                                            <th style="min-width: 150px">Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <tr role="row">
                                            <td>
                                                Diploma In hotem Management
                                            </td>
                                            <td>
                                                6 semester
                                            </td>
                                            <td>
                                                Total 6 semesters 3 years.
                                            </td>
                                            <td style="min-width: 150px">
                                                <a data-id="1" class='edit-icon btn btn-success btn-xs'><i class='fa fa-pencil'></i></a>
                                                <a data-id="1" class='remove-icon btn btn-danger btn-xs'><i class='fa fa-remove'></i></a>
                                            </td>
                                      </tr>
                                  </thead>
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
     <?php include(MODALS_DIR.DS.'program.php'); ?>

    <!-- jQuery -->
    <script src="<?= BOWER_DIR ?>/jquery/dist/jquery.min.js"></script>

     <!-- jQuery tablesorter-->
    <script src="<?= BOWER_DIR ?>/jquery.tablesorter/dist/js/jquery.tablesorter.js"></script>
    <script src="<?= BOWER_DIR ?>/jquery.tablesorter/dist/js/jquery.tablesorter.widgets.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= BOWER_DIR ?>/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?= BOWER_DIR ?>/metisMenu/dist/metisMenu.min.js"></script>

     <!-- DataTables JavaScript -->
    <script src="<?= BOWER_DIR ?>/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?= BOWER_DIR ?>/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- ckeditor -->
    <script src="<?= BOWER_DIR ?>/ckeditor/ckeditor.js"></script>

    <!-- Notify -->
    <script src="<?= BOWER_DIR ?>/notifyjs/dist/notify.js"></script>
    <script src="<?= BOWER_DIR ?>/notifyjs/dist/styles/bootstrap/notify-bootstrap.js"></script>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="<?= BOWER_DIR ?>/bootstrap3-dialog/dist/js/bootstrap-dialog.min.js"></script>
    <!-- spinJS -->
    <script src="<?= BOWER_DIR ?>/spin.js/spin.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="<?= JS_DIR ?>/sb-admin-2.js"></script>
    <script src="<?= JS_DIR ?>/pages/program.js?v=1" type="text/javascript"></script>
</body>

</html>
