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
        <h2 class="text-xl-center">Deltagarlista</h2>
        <br>

        <a class="btn btn-primary" href="/todo/create.php" role="button">

            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
            </svg> Lägg till deltagare
        </a>
        <br><br>
        <div class="row mb-3">
                <label class="col-sm-3 col-form-label"></label>
                <div class="col-sm-6">
                <input type="text" class="form-control" id="myInput" onkeyup="searchFunc()" placeholder="sök efter elevens namn..." title="Type in a name">
                </div>
            </div>
       
        <table class="table" id="myTable">
            <thead>
                <tr>

                    <th>Namn</th>
                    <th>E-post</th>
                    <th>Projekt</th>
                    <th>Skapat</th>

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

                $sql = "SELECT * FROM students";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Invalid query: " . $connection->error);
                }

                while ($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        
                        <td class='test' id='$row[id]'>$row[name]</td>
                        <td>$row[email]</td>
                        <td>$row[project]</td>
                        <td>$row[created_at]</td>
                     
                        <td>
                            <a class='btn btn btn-success btn-sm' href='/todo/details.php?id=$row[id]'>Todos</a>
                            <a class='btn btn-info btn-sm' href='/todo/edit.php?id=$row[id]'>Redigera</a>
                            <a class='btn btn-danger btn-sm' href='/todo/delete.php?id=$row[id]'>Ta bort</a>
                          
                        </td>  
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