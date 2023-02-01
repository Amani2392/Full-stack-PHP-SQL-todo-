<?php 

if( isset($_GET["task_ID"])) {
    $taskId = $_GET["task_ID"];
}
if (isset($_GET["id"])) {
    $id = $_GET["id"];
  }
$servername = "localhost";
$username = "root";
$password = "";
$database = "todo";

$connection = new mysqli($servername, $username, $password, $database);

$sql = "DELETE FROM tasks WHERE task_ID=$taskId";
$connection->query($sql);


header("location: /todo/details.php?id=$id");
exit;
 ?>
