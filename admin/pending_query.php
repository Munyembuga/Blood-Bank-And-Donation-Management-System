<?php
include 'conn.php';
include 'session.php';

// Check if logged in BEFORE any HTML output
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<style>
body { background-color: #f5f5f5; }
#sidebar{position:fixed;top:0;left:0;width:210px;height:100vh;margin-top:0;z-index:100;overflow-y:auto;}
#content{margin-left:220px;min-height:100vh;background:white;padding:30px;position:relative;z-index:1;color:#333;}
@media screen and (max-width: 600px) {
  #sidebar{position:relative;width:100%;height:auto;}
  #content {margin-left:0;}
}
#he{
  font-size: 14px;
  font-weight: 600;
  text-transform: uppercase;
  padding: 3px 7px;
  color: #fff;
  text-decoration: none;
  border-radius: 3px;
  text-align:center;
}
.table-responsive{overflow-x:auto;margin-top:20px;}
.page-title{color:#333;margin-bottom:20px;}
.table{color:#333;}
.table td, .table th{color:#333;}
</style>
</head>
<body>
<div id="header">
<?php include 'header.php';
?>
</div>
<div id="sidebar">
<?php $active="query"; include 'sidebar.php'; ?>

</div>
<div id="content" >
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 lg-12 sm-12">

          <h1 class="page-title">Pending Query</h1>

        </div>

      </div>
      <hr>

      <?php
      // Handle marking query as read
      if(isset($_GET['id']) && is_numeric($_GET['id'])) {
          $que_id = intval($_GET['id']);
          $sql1 = "UPDATE contact_query SET query_status='1' WHERE query_id={$que_id}";
          mysqli_query($conn, $sql1);
          echo '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Query marked as read!</div>';
      }
      ?>

      <?php
          $limit = 10;
          if(isset($_GET['page'])){
            $page = $_GET['page'];
          }else{
            $page = 1;
          }
          $offset = ($page - 1) * $limit;
          $count=$offset+1;
        $sql= "SELECT * FROM contact_query WHERE (query_status IS NULL OR query_status != 1) LIMIT {$offset},{$limit}";
        $result=mysqli_query($conn,$sql);
        
        if(!$result) {
            echo '<div class="alert alert-danger">Database Error: ' . mysqli_error($conn) . '</div>';
        } else {
            $num_rows = mysqli_num_rows($result);
            if($num_rows > 0) {
       ?>

       <div class="table-responsive">
      <table class="table table-bordered" style="text-align:center">
          <thead style="text-align:center">
          <th style="text-align:center">S.no</th>
          <th style="text-align:center">Name</th>
          <th style="text-align:center">Email Id</th>
          <th style="text-align:center">Mobile Number</th>
          <th style="text-align:center">Message</th>
          <th style="text-align:center">Posting Date</th>
          <th style="text-align:center">Status</th>
          <th style="text-align:center">Action</th>
          </thead>
          <tbody>
            <?php
            while($row = mysqli_fetch_assoc($result)) { ?>
          <tr>

                  <td><?php echo $count++; ?></td>
                  <td><?php echo $row['query_name']; ?></td>
                  <td><?php echo $row['query_mail']; ?></td>
                  <td><?php echo $row['query_number']; ?></td>
                  <td><?php echo $row['query_message']; ?></td>
                  <td><?php echo $row['query_date']; ?></td>
                  <?php if($row['query_status']==1) { ?>
                      <td><span class="label label-success">Read</span></td>
                  <?php } else { ?>
                      <td><a href="pending_query.php?id=<?php echo $row['query_id'];?>" class="btn btn-xs btn-warning" onclick="return confirm('Mark this query as read?');">Pending</a></td>
                  <?php } ?>
                    <td id="he" style="width:100px">
                    <a style="background-color:aqua" href='delete_query.php?id=<?php echo $row['query_id']; ?>'> Delete </a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
      </table>
    </div>
    <?php 
            } else {
                echo '<div class="alert alert-info">No pending queries found.</div>';
            }
        }
    ?>

    <div class="table-responsive"style="text-align:center;align:center">
        <?php
        $sql1 = "SELECT * FROM contact_query WHERE (query_status IS NULL OR query_status != 1)";
        $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");

        if(mysqli_num_rows($result1) > 0){

          $total_records = mysqli_num_rows($result1);

          $total_page = ceil($total_records / $limit);

          echo '<ul class="pagination admin-pagination">';
          if($page > 1){
            echo '<li><a href="pending_query.php?page='.($page - 1).'">Prev</a></li>';
          }
          for($i = 1; $i <= $total_page; $i++){
            if($i == $page){
              $active = "active";
            }else{
              $active = "";
            }
            echo '<li class="'.$active.'"><a href="pending_query.php?page='.$i.'">'.$i.'</a></li>';
          }
          if($total_page > $page){
            echo '<li><a href="pending_query.php?page='.($page + 1).'">Next</a></li>';
          }

          echo '</ul>';
        }
        ?>

        </div>
      </div>
    </div>

</body>
</html>
