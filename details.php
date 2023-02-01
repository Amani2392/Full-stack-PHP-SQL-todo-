<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="app.css">
</head>

<body>

    <div id="content">
    <a href="/todo/index.php">
        <img src="logo2.png" alt="logo" id="logo">
        </a>
    </div>
    <div class="container my-5">


        <h2 class="text-xl-center">Todos</h2>

        <br>
        <?php
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }
        ?>

        <a class="btn btn-primary" href="/todo/createTodo.php?id=<?php echo $id; ?>" role="button">

            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard2-plus" viewBox="0 0 16 16">
                <path d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5h3Z" />
                <path d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-12Z" />
                <path d="M8.5 6.5a.5.5 0 0 0-1 0V8H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V9H10a.5.5 0 0 0 0-1H8.5V6.5Z" />
            </svg> Lägg till todo</a>
        <br><br>
        <div class="row mb-3">
                <label class="col-sm-3 col-form-label"></label>
                <div class="col-sm-6">
                <input type="text" class="form-control" id="myInput" onkeyup="searchFunc()" placeholder="sök efter titel..." title="Type in a name">
                </div>
            </div>
      
        <table class="table" id="myTable">
            <thead>
                <tr>

                    <th>Titel</th>
                    <th>Beskrivning</th>
                    <th>Deadline</th>

                </tr>
            </thead>
            <tbody>

                <?php


                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "todo";

                $connection = new mysqli($servername, $username, $password, $database);
                if ($connection->connect_error) {
                    die("FEL" . $connection->connect_error);
                }
                if (isset($_GET["id"])) {
                    $id = $_GET["id"];
                }
                $sql = " SELECT * FROM tasks JOIN students ON tasks.student_ID = students.id WHERE tasks.student_ID = $id";

                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                while ($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>$row[title]</td>
                        <td>$row[description]</td>
                        <td>$row[deadline]</td>
                      
                        <td>
                        <a class='btn btn-info btn-sm' href='/todo/editTodo.php?task_ID=$row[task_ID]&id=$row[id]'>Redigera</a>
                        <a class='btn btn-danger btn-sm' href='/todo/deleteTodo.php?task_ID=$row[task_ID]&id=$row[id]'>Ta bort</a>x
                    </tr>
    
                    ";
                }

                ?>
            </tbody>
        </table>
    </div>
    <script>
        function searchFunc() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
        
    </script>
</body>

</html>