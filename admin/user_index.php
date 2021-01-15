<?php 
  require '../config/config.php';
  session_start();
  
  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
  }
?>
<?php include('./include/header.php') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">User Table</h3>
              </div>
              <!--  -->
              <?php 
                if (!empty($_GET['pageno'])) {
                  $pageno = $_GET['pageno'];
                } else {
                  $pageno = 1;
                }
                $numOfrecs = 5;
                $offset = ($pageno -1) * $numOfrecs;

                if(empty($_POST['search'])) {

                  // just grab all posts
                  $statement = $pdo->prepare("SELECT * FROM users ORDER BY id DESC");
                  $statement->execute();
                  $rawResult = $statement->fetchAll();
                  // for pagination
                  $total_pages = ceil(count($rawResult) / $numOfrecs);

                  $statement = $pdo->prepare("SELECT * FROM users ORDER BY id DESC LIMIT $offset,$numOfrecs");
                  $statement->execute();
                  $result = $statement->fetchAll();

                } else {
                  // search title by users
                  $searchKey = $_POST['search'];
                  $statement = $pdo->prepare("SELECT * FROM users WHERE title LIKE '%$searchKey%' ORDER BY id DESC");
                  $statement->execute();
                  $rawResult = $statement->fetchAll();
                  $total_pages = ceil(count($rawResult) / $numOfrecs);

                  $statement = $pdo->prepare("SELECT * FROM users WHERE title LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
                  $statement->execute();
                  $result = $statement->fetchAll();

                }
               
                
              ?>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="user_add.php" class="btn btn-success btn-sm mb-4">New User</a>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th style="width: 40px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if($result) {
                        $i = 1;
                        foreach($result as $value) { ?>
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $value['name'] ?></td>
                            <td><?php echo $value['email'] ?></td>
                            <td><?php echo $value['role'] ?></td>
                            <td class="btn-group">
                              <a href="user_edit.php?id=<?php echo $value['id']; ?>" class="btn btn-warning btn-sm mr-1">Edit</a>
                              <a href="user_delete.php?id=<?php echo $value['id']; ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                          </tr>
                      <?php $i++;  }
                      }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <!-- pagination -->
              <nav class="Page navigation">
                <ul class="pagination float-right">
                  <li class="page-item"><a href="?pageno=1" class="page-link">First</a></li>
                  <li class="page-item <?php if($pageno <= 1) {echo 'disabled';} ?>">
                    <a href="
                      <?php if ($pageno <= 1) 
                        {echo '#';} 
                        else { echo "?pageno=".($pageno-1); } ?>" class="page-link">Previous</a>
                  </li>
                  <li class="page-item"><a href="#" class="page-link"><?php echo $pageno; ?></a></li>
                  <li class="page-item <?php if($pageno >= $total_pages) {echo 'disabled';} ?>">
                    <a href="<?php if ($pageno >= $total_pages) {echo '#';} else { echo '?pageno='.($pageno+1); } ?>" class="page-link">Next</a>
                  </li>
                  <li class="page-item"><a href="?pageno=<?php echo $total_pages; ?>" class="page-link">Last</a></li>
                </ul>
              </nav>
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

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <a href="logout.php" class="btn btn-info">Logout</a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020 <a href="#">mghako</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>