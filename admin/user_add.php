<?php 
  require '../config/config.php';
  session_start();
  // check user login session empty or not
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
  }
    //   if post request exist
  if($_POST) {
        $role = null;
        if (empty($_POST['role'])) {
            $role = 0;
        }else{
            $role = 1;
        }
        
        $statement = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)");
        $result = $statement->execute(
            array(
                ':name' => $_POST['name'],
                ':email' => $_POST['email'],
                ':password' => $_POST['password'],
                ':role' => $role,
            )
        );
        if($result) {
            echo "<script>alert('New User Added!');</script>";
        }
    }
  
?>
<?php include('./include/header.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add User Page</h1>
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
                    <form action="" method="POST" class="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" name="email" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Is this user Admin ?</label>
                            <input type="checkbox" name="role" value="1">
                        </div>
                        
                        <div class="form-group">
                            <input type="submit" value="SUBMIT" class="btn btn-primary">
                            <a href="user_index.php" class="btn btn-info">Back</a>
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

<?php include('./include/footer.php') ?>
