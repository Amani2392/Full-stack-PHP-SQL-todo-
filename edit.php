<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "todo";

$connection = new mysqli($servername, $username, $password, $database);


$id = "";
$name = "";
$email = "";
$project = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["id"])) {
        header("location: /todo/index.php");
        exit;
    }
    $id = $_GET["id"];

    $sql = "SELECT * FROM students WHERE id=$id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: /todo/index.php");
        exit;
    }
    $name = $row["name"];
    $email = $row["email"];
    $project = $row["project"];
} else {

    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $project = $_POST["project"];

    do {

        if (empty($id) || empty($name) || empty($email) || empty($project)) {
            $errorMessage = "Du måste fylla i namn och e-post adress";
            break;
        }
        $sql = "UPDATE students SET name = '$name', email = '$email', project = '$project' WHERE id= $id";

        $result = $connection->query($sql);

        if(!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }
        $successMessage = "r";
        header("location: /todo/index.php");

    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="app.css">
</head>

<body>
    <div class="container my-5">
        <h2>Ny deltagare</h2>
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
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Namn</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">E-post</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Projekt</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="project" value="<?php echo $project; ?>">
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
                <a class="btn btn-outline-primary" href="/todo/index.php" role="button">Avbryt</a>
            </div>
        </form>
    </div>
</body>

</html>