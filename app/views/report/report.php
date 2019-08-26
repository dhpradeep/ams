<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>
        <?= WEBSITE_TITLE ?> | Dashboard</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?= BOWER_DIR ?>/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Core CSS -->
    <link href="<?= BOWER_DIR ?>/bootstrap3-dialog/dist/css/bootstrap-dialog.min.css" rel="stylesheet">
    
    <link href="<?= BOWER_DIR ?>/bootstrap/dist/css/daterangepicker.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="<?= BOWER_DIR ?>/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <!-- Timeline CSS -->
    <link href="<?= CSS_DIR ?>/timeline.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= CSS_DIR ?>/sb-admin-2.css" rel="stylesheet">
    <link href="<?= CSS_DIR ?>/style.css" rel="stylesheet">
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
            <div class="col-md-12">
                <h2>Reports</h2>
                <hr>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <br>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?= $this->noOfStudents ?></div>
                                    <div>Total Students</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <span class="pull-left">&nbsp;</span>
                            <span class="pull-right"></span>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <br>
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?= $this->noOfTeachers ?></div>
                                    <div>Total Teachers</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <span class="pull-left">&nbsp;</span>
                            <span class="pull-right"></span>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <br>
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-cube fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?= $this->noOfPrograms ?></div>
                                    <div>Total Program</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <span class="pull-left">&nbsp;</span>
                            <span class="pull-right"></span>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <br>
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?= $this->noOfSubjects ?></div>
                                    <div>Total Subjects</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <span class="pull-left">&nbsp;</span>
                            <span class="pull-right"></span>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Student Attendance Overview
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="filter_bar btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Filter
                                        <span class="caret"></span>
                                    </button>
                                </div>
                            </div>

                            <!-- expandable filter view -->
                            <div class="row filter_bar_val" style="padding-top:20px;">
                                <div class="col-md-12">

                                    <div class="col-md-3 col-sm-6 col-xs-6 report-small-device">
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
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12 report-small-device">
                                        <div class="input-group"> <span class="input-group-addon" style="width: 100px">Semester: </span>
                                            <select class="form-control" id="filterDataSemester" name="filterResultSemester">
                                                <option value="-1" name="None"> None </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12 report-small-device">
                                        <div class="input-group"> <span class="input-group-addon" style="width: 100px">Section: </span>
                                            <select class="form-control" id="filterDataSection" name="filterResultSection">
                                                <option value="-1" name="None"> None </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12 report-small-device">
                                        <div class="input-group"> <span class="input-group-addon">Date: </span>
                                            <input class="form-control" id="filterDataDate" type="text" name="daterange" value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-md-12 m-3">
                                    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-top: 10px">
                                        <input class="btn btn-primary" type="button" name="filter" value="Filter" id="filterOverview" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col col-md-6" style="max-height: 400px; overflow-y: scroll;">
                                    <ul class="list-group">
                                    <div class="row" id="studentList">                                     
                                        
                                    </div>
                                    </ul>
                                </div>
                                <div class="col col-md-6">
                                    <div id="morris-bar-chart"></div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <i class="fa fa-user fa-fw"></i> Student Attendance Table
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="filter_table btn btn-default btn-xs">
                                        Filter
                                        <span class="caret"></span>
                                    </button>
                                    <button type="button" id="export_excel" class="btn btn-primary btn-xs" style="margin-left:3px;">
                                        Export
                                    </button>
                                </div>
                            </div>

                            <!-- expandable filter view -->
                            <div class="row filter_table_val" style="padding-top:20px;">
                                <div class="col col-md-12">

                                <div class="col-md-3 col-sm-6 col-xs-12 report-small-device">
                                        <div class="input-group"> <span class="input-group-addon">Program: </span>
                                            <select class="form-control" id="filterDataProgram1" name="filterResultProgram1" style="width: 100px">
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
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12 report-small-device">
                                        <div class="input-group"> <span class="input-group-addon" style="width: 100px">Semester: </span>
                                            <select class="form-control" id="filterDataSemester1" name="filterResultSemester1">
                                                <option value="-1" name="None"> None </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12 report-small-device">
                                        <div class="input-group"> <span class="input-group-addon" style="width: 100px">Section: </span>
                                            <select class="form-control" id="filterDataSection1" name="filterResultSection1">
                                                <option value="-1" name="None"> None </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12 report-small-device">
                                        <div class="input-group"> <span class="input-group-addon">Date: </span>
                                            <input id="filterDataDate1" class="form-control" type="text" name="daterange" value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-md-12 m-3">
                                    <div class="col-md-3 col-sm-6 col-xs-6" style="margin-top: 10px">
                                        <input class="btn btn-primary" type="button" name="filter" value="Filter" id="filterOverview1" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive" id="toExport">
                                <table width="100%" id="studentTable" class="table table-striped table-bordered table-hover">
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>
            <br><br>
        </div>
        <!-- /#wrapper -->
        <!-- jQuery -->
        <script src="<?= BOWER_DIR ?>/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?= BOWER_DIR ?>/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?= BOWER_DIR ?>/bootstrap3-dialog/dist/js/bootstrap-dialog.min.js"></script>

        <!-- Notify -->
        <script src="<?= BOWER_DIR ?>/notifyjs/dist/notify.js"></script>
        <script src="<?= BOWER_DIR ?>/notifyjs/dist/styles/bootstrap/notify-bootstrap.js"></script>

        <!-- DataTables JavaScript -->
        <script src="<?= BOWER_DIR ?>/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="<?= BOWER_DIR ?>/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

        <!-- Moment.js -->
        <script src="<?= BOWER_DIR ?>/moment/moment.min.js"></script>

        <script src="<?= BOWER_DIR ?>/bootstrap/dist/js/daterangepicker.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?= BOWER_DIR ?>/metisMenu/dist/metisMenu.min.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="<?= JS_DIR ?>/sb-admin-2.js"></script>
        <!-- Morris Charts JavaScript -->
        <script src="<?= BOWER_DIR ?>/raphael/raphael-min.js"></script>
        <script src="<?= BOWER_DIR ?>/morrisjs/morris.min.js"></script>
        <script src="<?= JS_DIR ?>/data/morris-data.js"></script>
        <script src="<?= JS_DIR ?>/pages/report.js"></script>
</body>

</html>