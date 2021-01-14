<?php 
  require './config/config.php';
  session_start();

  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
  }
  // get blog post details
  $statement = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
  $statement->execute();
  $result = $statement->fetchAll();

  // get comments code
  $statement = $pdo->prepare("SELECT * FROM comments WHERE post_id=".$_GET['id']);
  $statement->execute();
  $comments = $statement->fetchAll();
  
  $authorResult= [];

  if($comments) {
    foreach ($comments as $key => $value) {
      $authorId = $comments[$key]['author_id'];
      $statementAuthor = $pdo->prepare("SELECT * FROM users WHERE id=$authorId");
      $statementAuthor->execute();
      $authorResult[] = $statementAuthor->fetchAll();
    }
  }

  // get comments author
  // $statement = $pdo->prepare("SELECT * FROM users WHERE id=".$comments[0]['author_id']);
  // $statement->execute();
  // $author = $statement->fetchAll();

  $post_id = $_GET['id'];

  // store comments
  if($_POST) {
    
    $comment = $_POST['comment'];
    $statement = $pdo->prepare("INSERT INTO comments(content, author_id, post_id) VALUES (:content, :author_id, :post_id)");
            $result = $statement->execute(
                array(
                    ':content' => $comment,
                    ':author_id' => $_SESSION['user_id'],
                    ':post_id' => $post_id,
                )
            );
            if($result) {
                header('Location: blogdetails.php?id='.$post_id);
            }
  }

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Blog | Details</title>
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
<body class="hold-transition sidebar-mini">
<div class="">


  <!-- Content Wrapper. Contains page content -->
  <div class="">
    <!-- Main content -->
    <section class="content mt-4">
      <div class="container">
        
        <div class="row">
          <div class="col-md-10 mx-auto">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header card-title clearfix">
                <h4 class="text-center"><?php echo $result[0]['title'] ?></h4>
              </div>
              <div class="card-body">
                <img class="img-fluid" src="./admin/images/<?php echo $result[0]['image'] ?>" alt="Photo">
                <p><?php echo $result[0]['content'] ?></p>
                <h3>Comments</h3> <hr>
                <a href="index.php" type="button" class="btn btn-info">Go Back</a>
              </div>
              <!-- /.card-body -->
              <div class="card-footer card-comments">
                <!-- comment section -->
                <div class="card-comment">
                  <?php if ($comments) {?>
                    <div class="comment-text ml-0">
                      <?php foreach ($comments as $key => $value) { ?>
                        <span class="username">
                          <?php echo $authorResult[$key][0]['name']; ?>
                          <span class="text-muted float-right"><?php echo $value['created_at']; ?></span>
                        </span><!-- /.username -->
                        <?php echo $value['content']; ?><br> <hr>
                      <?php
                      }
                      ?>
                      
                    </div>
                  <?php
                  }
                  ?>
                  <!-- /.comment-text -->
                </div>               
              </div>
              <div class="card-footer">
                <!-- comment section -->
                <div class="card-comment">
                  <div class="comment-text ml-0">
                    <form action="" method="POST">
                    <div>
                      <input type="text" name="comment" class="form-control" placeholder="Type comments... and Press Enter...">
                    </div>
                    </form>
                  </div>
                  <!-- /.comment-text -->
                </div>
                
              </div>
            </div>
            <!-- /.card -->
          </div>
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
      <div class="row">
        <div class="col-md-10 mx-auto">
          <div class="float-right d-none d-sm-block">
            <b>Version</b> Beta
          </div>
          <strong>Copyright &copy; 2021 <a href="#">Blog</a>.</strong> All rights
          reserved.
        </div>
      </div>
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
