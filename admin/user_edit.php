<?php 
  require '../config/config.php';
  session_start();
  // check user login session empty or not
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
  }
  // get user data
  if(empty($_GET['id'])) {
    
    header('Location:user_index.php');
  } else {
    $statement = $pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
    $statement->execute();
    
    $userResult = $statement->fetchAll();
  }
    //   if post request exist
    if ($_POST) {
      if (empty($_POST['name']) || empty($_POST['email'])) {
        if (empty($_POST['name'])) {
          echo "<script>alert('Edit data not found');window.location.href='user_index.php';</script>";
        }
        if (empty($_POST['email'])) {
          echo "<script>alert('Edit data not found');window.location.href='user_index.php';</script>";
        }
      }elseif (!empty($_POST['password']) && strlen($_POST['password']) < 4) {
        
      }else{
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        if (empty($_POST['role'])) {
          $role = 0;
        }else{
          $role = 1;
        }
    
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email AND id!=:id");
        $stmt->execute(
          array(
          ':email'=>$email,
          ':id'=>$id
          )
        );
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {
          echo "<script>alert('Email duplicated')</script>";
        }else{
          if ($password != null) {
            $stmt = $pdo->prepare("UPDATE users SET name='$name',email='$email',password='$password',role='$role' WHERE id='$id'");
          }else{
            $stmt = $pdo->prepare("UPDATE users SET name='$name',email='$email',role='$role' WHERE id='$id'");
          }
          $result = $stmt->execute();
          if ($result) {
            echo "<script>alert('Successfully Updated');window.location.href='user_index.php';</script>";
          }
        }
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
            <h1 class="m-0 text-dark">Edit User Page</h1>
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
                    <form action="" method="POST" class="">
                      <input type="hidden" name="id" value="<?php echo $userResult[0]['id']; ?>">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" id="" class="form-control" value="<?php echo $userResult[0]['name']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" name="email" id="" class="form-control" value="<?php echo $userResult[0]['email']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Is this user Admin ?</label>
                            <input type="checkbox" name="role" value="1" <?php if($userResult[0]['role'] == 1) { echo "checked";} else { echo ''; }?>>
                        </div>                        
                        <div class="form-group">
                            <input type="submit" value="Save" class="btn btn-primary">
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
