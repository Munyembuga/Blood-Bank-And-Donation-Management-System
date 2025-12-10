<?php
include 'conn.php';
include 'session.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Simple Query Test</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container" style="margin-top: 50px;">
        <h1>User Query - Simple Version</h1>
        <hr>
        
        <?php
        $sql = "SELECT * FROM contact_query ORDER BY query_date DESC";
        $result = mysqli_query($conn, $sql);
        
        if(!$result) {
            echo '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
        } else {
            $num_rows = mysqli_num_rows($result);
            echo '<p><strong>Found ' . $num_rows . ' records</strong></p>';
            
            if($num_rows > 0) {
        ?>
        
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['query_id']; ?></td>
                    <td><?php echo $row['query_name']; ?></td>
                    <td><?php echo $row['query_mail']; ?></td>
                    <td><?php echo $row['query_number']; ?></td>
                    <td><?php echo substr($row['query_message'], 0, 50); ?></td>
                    <td><?php echo $row['query_date']; ?></td>
                    <td><?php echo ($row['query_status'] == 1) ? 'Read' : 'Pending'; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <?php 
            } else {
                echo '<div class="alert alert-info">No queries found.</div>';
            }
        }
        ?>
        
        <p><a href="query.php" class="btn btn-primary">Back to Full Query Page</a></p>
    </div>
</body>
</html>
