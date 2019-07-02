  <?php
  function __autoload($class){
    require_once "class/$class.php";
  }

  if (isset($_GET['del'])) {
    $id = $_GET['del'];

    $employee = new Employee();
    $employee->delete($id);
  }


?> 

<!DOCTYPE html>
<html lang="en">
<head>
  <title>KYC EMPLOYEE FORM</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

  <!---- Navbar---->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Power Employee</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contac</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>
  <!---- Table list with the employee---->
  <div class="container mt-4">
    <div class="row">
      <div class="col-lg-12">
        <div class="jumbotron">
          <a href="create.php" class="btn btn-success float-right">Create KYC Employee</a>
          <h4 class="mb-4">All KYC Employees</h4>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Mobile</th>
                <th scope="col">DOB</th>
                <th scope="col">Image</th>
                <th scope="col">Date</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $employee = new Employee();
                $rows = $employee->select();
                if (is_array($rows) || is_object($rows))
{

                foreach ($rows as $row ) {
                  $image = $row["image"];

                    if(isset($_REQUEST["file"])){
                    $image = $row["image"];
                    $images = explode(" ", $image);
                    // Get parameters
                    $file = urldecode($_REQUEST["file"]); // Decode URL-encoded string
                    if(in_array($file, $images, true)){
                    $filepath = "uploads/" . $file;
                    }
}
                  ?>
                     <tr>
                      <th scope="row"><?= $row['id']?></th>
                      <td><?= $row['first_name']?></td>
                      <td><?= $row['last_name']?></td>
                      <td><?= $row['mobile']?></td>
                      <td><?= $row['dob']?></td>
                      <td with="auto"><a href="uploads/<?php echo $image; ?>" download><img src="uploads/<?php echo $image; ?>" width="50" /></a></td>
                      <td><?= $row['date']?></td>
                      <td><a class="btn btn-sm btn-primary" href="edit.php?id=<?= $row['id']?>">Edit</a> &nbsp; <a class="btn btn-sm btn-danger" href="index.php?del=<?= $row['id']?>">Delete</a></td>
                    </tr>
                    <?php
                      }
                }
              ?>
           
            </tbody>
          </table>
        </div>        
      </div>
    </div>
  </div>

</body>
</html>
