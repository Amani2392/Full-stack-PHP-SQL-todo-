<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "todo";

$connection = new mysqli($servername, $username, $password, $database);


$id = "";
$title = "";
$description = "";
$deadline = "";
$task_ID = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["id"])) {
        header("location: /todo/details.php?id=$id");
        exit;
    }
    $id = $_GET["id"];
    $task_ID = $_GET["task_ID"];

    $sql = "SELECT * FROM tasks WHERE task_ID=$task_ID";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: /todo/details.php?id=$id");
        exit;
    }
    $title = $row["title"];
    $description = $row["description"];
    $deadline = $row["deadline"];
} else {
    $task_ID = $_POST["task_ID"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $deadline = $_POST["deadline"];

    do {

        if (empty($title) || empty($description) || empty($deadline) || empty($task_ID)) {
            $errorMessage = "Du måste fylla i namn och e-post adress";
            break;
        }
        $sql = "UPDATE tasks SET title = '$title', description = '$description', deadline = '$deadline' WHERE task_ID= $task_ID";

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }
        $id = $_GET["id"];
        $successMessage = "Uppdaterat!";
        header("location: /todo/details.php?id=$id");
    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="app.css">
</head>

<body>
    <div class="container my-5">
        <h2>Redigera task</h2>
        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button class='btn-close' data-bs-dismiss='alert' aria-label='close' type='button' ></button>
        </div>
            ";
        }
        ?>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="task_ID" value="<?php echo $task_ID; ?>">

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Titel</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="title" value="<?php echo $title; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Beskrivning</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="description" value="<?php echo $description; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Deadline</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="deadline" value="<?php echo $deadline; ?>">
                </div>
            </div>

            <?php
            if (!empty($successMessage)) {
                echo "
    <div class='row mb-3'> 
    <div class='offset-sm-3 col-sm-6'>
    <div class='alert alert-success alert-dismissible fade show' role='alert'>
              <strong>$successMessage</strong>
              <button class='btn-close' data-bs-dismiss='alert' aria-label='close' type='button' ></button>
          </div>
    </div>
    </div>
    ";
            }


            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Lägg till</button>
                </div>
            </div>
            <div class="offset-sm-3 col-sm-3 d-grid">
                <a class="btn btn-outline-primary" href="/todo/details.php?id=<?php echo $id; ?>" role="button">Avbryt</a>
            </div>
        </form>
    </div>
</body>

</html>