<?php
// INSERT INTO `notesapp` (`sno.`, `title`, `desc`, `dtstamp`) VALUES ('1', 'Go to buy some fruits', 'i will go the market to buy some things but buy some fruits is my main perpose.', current_timestamp());
$insert = false;
$update = false;
$delete = false;
// connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "notesapp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}
//else {
//     echo "Connected successfully";
// }
// if the form is submitted
// check if the form is submitted

if (isset($_GET['delete'])) {
    $sno=$_GET['delete'];
    $delete=true;
    //echo $sno;
    // delete the data from the database
    $sql = "DELETE FROM `notesapp` WHERE `notesapp`.`sno.` = $sno";
    $result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        //echo "update";
        //exit();
        // update the data in the database
        $sno = $_POST['snoEdit'];
        $title = $_POST['titleEdit'];
        $desc = $_POST['descEdit'];

        $sql = "UPDATE `notesapp` SET `title` = '$title', `desc` = '$desc' WHERE `notesapp`.`sno.` = $sno";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            //echo "Data updated successfully";
            // redirect to the same page to avoid resubmission of the form
            $update = true;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        //echo "insert";
        // exit();
        $title = $_POST['title'];
        $desc = $_POST['desc'];

        // insert the data into the database
        $sql = "INSERT INTO `notesapp` (`title`, `desc`) VALUES ('$title', '$desc')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            //echo "Data inserted successfully";
            // redirect to the same page to avoid resubmission of the form
            $insert = true;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
    <script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>


    <title>Bhupesh:iNotes App </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>

    <!-- Edit modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
Edit Modal
</button> -->

    <!--Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">edit this node </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/CRUD APP/index.php" method="post">
                <div class="modal-body">
                    
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="mb-3">
                            <label for="title" class="form-label">Notes Title</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">We'll never share your informtaion with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="desc" class="form-label">Notes Description</label>
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="descEdit" name="descEdit"
                                    style="height: 100px"></textarea>
                                <label for="floatingTextarea2">Descriptions</label>
                            </div>
                        </div>
                        
                    
                </div>
                <div class="modal-footer d-block mr-auto">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="/Bhupesh inotes CRUD APP/Crud app.png" height="21px" alt="INOTES" srcset="">Bhupesh iNotes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    
    <?php
    if ($insert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your note has been added successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <?php
    if ($update) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your note has been updated successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <?php
    if ($delete) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your note has been deleted successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>

    <div class="container my-4">
        <h2>Welcome to Bhupesh iNotes App</h2>
        <form action="/CRUD APP/index.php" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Notes Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your informtaion with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Notes Description</label>
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Leave a comment here" id="desc" name="desc"
                        style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Descriptions</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>
    <div class="container">
        <h4>Your Notes</h4>
        <p>Here are your notes</p>
    </div>
    <div class="container my-4">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">Sno.</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `notesapp`";
                $result = mysqli_query($conn, $sql);
                $Sno = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    // code to be executed for each row in the result set
                    // echo "<br> $result rows in the table";
                    $Sno = $Sno + 1;
                    echo "<tr>
                    <th scope='row'>" . $Sno . "</th>
                    <td>" . $row['title'] . "</td>
                    <td>" . $row['desc'] . "</td>
                    <td> <button class='edit btn btn-sm btn-primary' id=" . $row['sno.'] . ">Edit</button>  <button class='delete btn btn-sm btn-primary' id=d" . $row['sno.'] . ">Delete</button></td>
                     </tr>";
                }

                ?>
            </tbody>

        </table>
    </div>
    <hr>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <script>
        edits = document.getElementsByClassName('edit');

        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit", e.target.parentNode.parentNode);
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText;
                desc = tr.getElementsByTagName("td")[1].innerText;
                console.log(title, desc);
                descEdit.value = desc;
                console.log(e.target.id);
                titleEdit.value = title;
                snoEdit.value = e.target.id;
                $('#editModal').modal('toggle');
            })

        })
        deletes = document.getElementsByClassName('delete');
        
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit", e.target.parentNode.parentNode);
                tr = e.target.parentNode.parentNode;
                sno = e.target.id.substr(1,);
                if (confirm("Are You Sure to delete this note  !")) {
                    console.log("yes");
                    window.location = `/CRUD APP/index.php?delete=${sno}`;
                    
                } else {
                    console.log("no");
                }
                // console.log(title, desc);
                // descEdit.value = desc;
                // console.log(e.target.id);
                // titleEdit.value = title;
                // snoEdit.value = e.target.id;
                // $('#editModal').modal('toggle');
            })

        })
    </script>

</body>

</html>