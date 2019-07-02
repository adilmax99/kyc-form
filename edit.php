<?php
session_start();
  function __autoload($class){
    require_once "class/$class.php";
  }

  if (isset($_GET['id'])) {
    $eid = $_GET['id'];

    $employee = new Employee();
    $result = $employee->editOne($eid);
    //print_r($result);
  }

if (isset($_POST['submit'])) {

  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $mobile = $_POST['mobile'];
  $dob = $_POST['dob'];

  if (!empty($first_name) && !empty($last_name) && !empty($mobile) && !empty($dob)) {

    $first_name = filter_var($first_name, FILTER_SANITIZE_STRING);
    $last_name = filter_var($last_name, FILTER_SANITIZE_STRING);
    $mobile = filter_var($mobile, FILTER_SANITIZE_NUMBER_INT);

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
// Check if file already exists
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }
// Check file size
    if ($_FILES["image"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }
// Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }
// Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      $target_file = basename($_FILES["image"]["name"]);
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  } 

  $fields=[
    'first_name' =>$first_name,
    'last_name' =>$last_name,
    'mobile' =>$mobile,
    'dob' =>$dob,
    'image' =>$target_file
  ];

  $id = $_POST['id'];
  $employee = new Employee();
  $employee->insert($fields);

}else{
  $employee = new Employee();
  $employee->handlError();  
}
}
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Employee Crud</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="css/parsley.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
   <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <script src="js/parsley.min.js"></script>
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
          <h4 class="mb-4">Edit Employees KYC</h4>
            <form action="" method="post" data-parsley-validate enctype="multipart/form-data">
            <div class="form-group">
              <label for="Name">First Name:</label>
              <input type="text" class="form-control" id="first_name" value="<?=$result['first_name'];?>" name="first_name" data-parsley-required>
              <?php if (isset($_SESSION['error["first_name"]'])) {
                ?>
                <div class="alert alert-danger mt-2" role="alert">
                  <?php echo $_SESSION['error["first_name"]'];?>
                </div>
              <?php }?>
            </div>
            <div class="form-group">
              <label for="Name">Last Name:</label>
              <input type="text" class="form-control" id="last_name" value="<?=$result['last_name'];?>" name="last_name" data-parsley-required>
              <?php if (isset($_SESSION['error["last_name"]'])) {
                ?>
                <div class="alert alert-danger mt-2" role="alert">
                  <?php echo $_SESSION['error["last_name"]'];?>
                </div>
              <?php }?>
            </div>
            <div class="form-group">
              <label for="mobile">Mobile:</label>
              <input type="number" class="form-control" id="mobile" value="<?=$result['mobile'];?>" name="mobile" data-parsley-required>
              <?php if (isset($_SESSION['error["mobile"]'])) {
                ?>
                <div class="alert alert-danger mt-2" role="alert">
                  <?php echo $_SESSION['error["mobile"]'];?>
                </div>
              <?php }?>
            </div> 
            <div class="form-group">
              <label for="DOB">DOB:</label>
              <input type="date" class="form-control" id="dob" value="<?=$result['dob'];?>" name="dob" data-parsley-required>
              <?php if (isset($_SESSION['error["dob"]'])) {
                ?>
                <div class="alert alert-danger mt-2" role="alert">
                  <?php echo $_SESSION['error["dob"]'];?>
                </div>
              <?php }?>
            </div>

            <div class="form-group">

              <?php session_unset();?>

            </div>
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
                  <span><a href=""></a><a href="uploads/<?php echo $image; ?>" download><img src="uploads/<?php echo $image; ?>" width="50" /></a></span>
                  <br>
                  <br>
                <?php } } ?>
            <input type="submit" name="submit" class="btn btn-primary" value="Submit">
          </form>
        </div>        
      </div>
    </div>
  </div>

</body>
</html>
