<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
  <div class="container">
    <div class="col-md-12 text-center">
      <span class="display-1 d-block">
        <?php
            if(!is_null($this->message)) {
          ?>
          <h1> 
            <?= $this->message['header'] ?>
          </h1>
          </span>
          <div class="mb-4 lead"><?= $this->message['content'] ?></div>
          <a href="<?= $this->message['link'] ?>" type="submit" class="btn btn-lg btn-primary btn-block"><?= $this->message['link_content'] ?></a>
          </div>    
        <?php 
            } else {
        ?>
          <h1> 
            Error 404
          </h1>
          </span>
          <div class="mb-4 lead"><b>Page doesn't Exist</b></div>
          <a href="<?= SITE_URL ?>" type="submit" class="btn btn-lg btn-primary btn-block">Go Back Home</a>
          </div>  

        <?php
            }
        ?>
        
  </div>
</body>

</html>