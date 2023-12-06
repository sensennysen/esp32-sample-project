<?php
//database connection
include 'dbConn.php';

$stmt = $pdo->query("SELECT * FROM employees");
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="attendance.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>

  <?php include ('sidebar.php');?>

  <section class="home-section">
    <div class="home-content">
      <span class="text">Attendance List</span>
    </div>
    <div class="search">
            <form action="#">
                <input type="text" placeholder=" Search" name="search">
                  <button><i class="fa fa-search"style="font-size: 18px;"></i></button>
    </div>
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default panel-table">
        <div class="panel-heading">
          <div class="row">
            <div class="col col-xs-6">
              <h3 class="panel-title">Panel Heading</h3>
            </div>
            <div class="col col-xs-6 text-right">
              <button type="button" class="btn btn-sm btn-primary btn-create">Create New</button>
            </div>
          </div>
            <div class="panel-body">
              <?php 
                if ($result) {
                    //Table header
                  echo "<table border= '1'> ";
                  echo "<tr><th>ID</th><th>Name</th><th>Department</th><th>Date</th><th>Time In</th><th>Time Out</th><th>Reason</th></tr>";
                }
                ?>
                  <tbody>
                    <tr>
                      <td align="center">
                        <a class="btn btn-default"><em class="fa fa-pencil"></em></a>
                        <a class="btn btn-danger"><em class="fa fa-trash"></em></a>
                      </td>
                      <td class="hidden-xs">1</td>
                       
                      </tr>
                  </tbody>
              </table>
            </div>
          <div class="panel-footer">
            <div class="row">
              <div class="col col-xs-4">Page 1 of 5</div>
                  <div class="col col-xs-8">
                    <ul class="pagination hidden-xs pull-right">
                      <li><a href="#">1</a></li>
                      <li><a href="#">2</a></li>
                      <li><a href="#">3</a></li>
                      <li><a href="#">4</a></li>
                      <li><a href="#">5</a></li>
                    </ul>
                    <ul class="pagination visible-xs pull-right">
                        <li><a href="#">«</a></li>
                        <li><a href="#">»</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
  </div>
</body>
</html>