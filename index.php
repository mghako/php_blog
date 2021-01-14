<?php 
    require './config/config.php';
    session_start();
  
    if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
      header('Location: login.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Widgets</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition">
<div class="">


  <!-- Content Wrapper. Contains page content -->
  <div class="">
    <!-- Main content -->
    <section class="content">
      <div class="container">
        <div class="row d-flex justify-content-center align-items-center">
            <h2>Blog</h2>
        </div>
        <?php 
            // just grab all posts
            $statement = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
            $statement->execute();
            $rawResult = $statement->fetchAll();
        ?>
        <div class="row">
            <?php 
                if($rawResult) {
                    $i=1;
                    foreach($rawResult as $data) { ?>
                        <div class="col-md-4">
                        <!-- Box Comment -->
                        <div class="card card-widget">
                        <div class="card-header card-title clearfix">
                            <h4 class="text-center"><?php echo $data['title']; ?></h4>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div style="width: 200px; height: 150px; overflow:hidden;">
                                <a href="blogdetails.php?id=<?php echo $data['id'] ?>" class="w-full d-block">
                                    <img src="./admin/images/<?php echo $data['image'] ?>" alt="Image" class="d-block mx-auto text-center img-fluid">
                                </a>
                            </div>

                            <p><?php echo substr($data['content'], 0, 200). '...' ?></p>
                        </div>
                        </div>
                        <!-- /.card -->
                    </div>
                <?php   }
                }
            ?>
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <footer>
    <div class="container">
        <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.0.5
        </div>
        <strong>Copyright &copy; 2021 <a href="#">Blog</a>.</strong> All rights
        reserved.
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./dist/js/demo.js"></script>
</body>
</html>
