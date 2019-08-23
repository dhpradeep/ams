<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= WEBSITE_TITLE ?> | Students</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?= BOWER_DIR ?>/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?= BOWER_DIR ?>/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="<?= BOWER_DIR ?>/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?= BOWER_DIR ?>/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

    <!-- Bootstrap Core CSS -->
    <link href="<?= BOWER_DIR ?>/bootstrap3-dialog/dist/css/bootstrap-dialog.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= CSS_DIR ?>/sb-admin-2.css" rel="stylesheet">
    <link href="<?= CSS_DIR ?>/style.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?= BOWER_DIR ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        td.details-control {
            background: url('<?= IMAGE_DIR ?>/details_open.png') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('<?= IMAGE_DIR ?>//details_close.png') no-repeat center center;
        }
        .choices {
            padding: 5px 20px;
            font-weight: bold;
        }
        .answers {
            padding: 5px 20px;
        }
    </style>
</head>

<body>

    <div id="wrapper">
        <div id="target1"></div>
        <!-- Navigation -->
        <?php include(INCLUDES_DIR.DS.'nav-bar.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">Students</h2>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> 
                            <a href="<?= SITE_URL.DS.'home'.DS ?>dashboard">Dashboard</a>
                        </li>
                        <li class="active">
                            Students
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
                            <a onclick="create_student()" class="btn btn-primary">Add Student</a>
                            <a onclick="refresh()" class="btn btn-info">Refresh</a>
                            <div class="input-group"> <span class="input-group-addon">Program: </span>
                                <select class="form-control" id="filterDataProgram" name="filterResultProgram" style="width: 100px">
                                    <option data-no="-1" data-value='-1' value='-1' name="None">None</option>
                                    <?php
                                        foreach ($this->program as $value) {
                                    ?>
                                            <option data-no='<?= $value['noOfYearOrSemester'] ?>' data-value='<?= $value['id'] ?>' value="<?= $value['id'] ?>" name="<?= $value['name'] ?>"><?= $value['name'] ?></option>
                                    <?php
                                         } 
                                    ?>
                                </select>
                            </div>
                            <div class="input-group"> <span class="input-group-addon">Semester: </span>
                                <select class="form-control" id="filterDataSemester" name="filterResultSemester">
                                    <option value="-1" name="None"> None </option>
                                </select>
                            </div>
                            <div class="input-group"> <span class="input-group-addon">Section: </span>
                                <select class="form-control" id="filterDataSection" name="filterResultSection">
                                    <option value="-1" name="None"> None </option>
                                </select>
                            </div>
                            <a onclick="getAllData(2)" class="btn btn-success" style="float:right">Export to excel</a>
                        </form>
                    </div>
                    <br>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            List of Students
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover paginated tablesorter" id="studentTable">
                                    <thead>
                                        <tr>
                                            <th style="min-width: 60px">Details</th>
                                            <th>Fullname</th>
                                            <th>Program</th>
                                            <th>Semester/Year</th>
                                            <th>Section</th>
                                            <th style="min-width: 30px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="searchable">
                                    </tbody>
                                </table>
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

        <div id="mytable"></div>

        <!-- modals -->
     <?php include(MODALS_DIR.DS.'student.php'); ?>

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

    <!-- Notify -->
    <script src="<?= BOWER_DIR ?>/notifyjs/dist/notify.js"></script>
    <script src="<?= BOWER_DIR ?>/notifyjs/dist/styles/bootstrap/notify-bootstrap.js"></script>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="<?= BOWER_DIR ?>/bootstrap3-dialog/dist/js/bootstrap-dialog.min.js"></script>

    <!-- spinJS -->
    <script src="<?= BOWER_DIR ?>/spin.js/spin.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?= JS_DIR ?>/sb-admin-2.js"></script>
    <script src="<?= JS_DIR ?>/pages/student.js?v=1"></script>


</body>

</html>
