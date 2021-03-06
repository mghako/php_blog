<?php 
  require '../config/config.php';
  session_start();
  // check user login session empty or not
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
  }
    //   if post request exist
  if($_POST) {
      $file = 'images/'.($_FILES['image']['name']);
      $imageType = pathinfo($file, PATHINFO_EXTENSION);

      if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
        echo "<script>alert('Image must be png, jpg or jpeg!');</script>";
      } else {

          move_uploaded_file($_FILES['image']['tmp_name'], $file);
          $statement = $pdo->prepare("INSERT INTO posts(title, content, image, author_id) VALUES (:title, :content, :image, :author_id)");
          $result = $statement->execute(
              array(
                  ':title' => $_POST['title'],
                  ':content' => $_POST['content'],
                  ':image' => $_FILES['image']['name'],
                  ':author_id' => $_SESSION['user_id'],
              )
          );
          if($result) {
              echo "<script>alert('New Post Added!');</script>";
          }
      }
  }
?>
<?php include('./include/header.html') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Starter Page</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="add.php" method="POST" class="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" name="title" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Content</label>
                            <textarea name="content" id="" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Image</label>
                            <input type="file" name="image">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="SUBMIT" class="btn btn-primary">
                            <a href="index.php" class="btn btn-info">Back</a>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

<?php include('./include/footer.html') ?>
