<html>
<head>


<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Image uploader</title>
</head>
<body>

<script type="text/javascript">
  $(document).on('click', '.browse', function(){ 
    var file = $(this).parent().parent().parent().find('.file');
    console.log(file);
    file.trigger('click'); 
  });
  $(document).on('change', '.file', function(){
    $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
  });

</script>

<style type="text/css">
  .file {
    visibility: hidden;
    position: absolute;
  }
</style>

<div class="container">



<div class="alert alert-success" role="alert">Only extensions allowed is jpg, jpeg, png and gif!</div>

<form action="" method="post" class="col-md-6" enctype="multipart/form-data">
  <div class="form-group">
    <input type="file" name="fileup" id="fileup" class="file">
    <div class="input-group col-xs-12">
      <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
      <input type="text" class="form-control input-lg" name="im" disabled placeholder="Upload Image">
      <span class="input-group-btn">
        <button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
      </span>
    </div>
    </br>
    <input type="submit" value="Upload Image" class="btn btn-primary" name="submit">
  </div>

</form>


<?php

if(empty($_FILES['fileup']['tmp_name'])) {
  echo "<div class='alert alert-warning col-md-4'>
  <strong>Warning!</strong> You should choose an image.
</div>";
}


if(isset($_POST["submit"]) && !empty($_FILES['fileup']['tmp_name'])) {

  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["fileup"]["name"]);
  $uploadOk = 1;
  $limit = 500000;
  $infoimg = pathinfo($target_file,PATHINFO_EXTENSION);

  $hash = md5_file($_FILES["fileup"]["tmp_name"]);
  $new_target = $target_dir.$hash.date('Y-m-d-H-i-s').".".$infoimg;

  $url_img = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  $url_img = $url_img.$new_target;
  $home = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  $succes = "
  <div class='col-md-4'>
  <img class='img-responsive' src='$new_target'>
  </br>

  <a href='$new_target' class='btn btn-success' download> Download image </a>
  <a href='$url_img' target='_blank' class='btn btn-primary'> Open link </a>
  <a href='$home' class='btn btn-primary'> New image </a>
  </br>
  </br>
  <input type='text' onClick='this.select();' class='form-control' value='$url_img' >

  
  </div>

";
  $errors = array('exterror' => "Sorry, only JPG, JPEG, PNG & GIF files are allowed.",
          'limiterror' => "Sorry, your file is too large.",
          'notuploaded' => "Sorry, your file was not uploaded.",
          'unexpected' => "Sorry, there was an error uploading your file."
    );

  $check = getimagesize($_FILES["fileup"]["tmp_name"]);
  if($check == false) {
      $uploadOk = 0;
      echo "File is not an image.";
      echo $errors["notuploaded"];;
  }
  if ($infoimg != "jpg" && $infoimg != "png" && $infoimg != "jpeg" && $infoimg != "gif" ) {
    $uploadOk = 0;
      echo $errors["exterror"];
  }
  if ($_FILES["fileup"]["size"] > $limit) {
    $uploadOk = 0;
      echo $errors["limit"];
  }

  if ($uploadOk == 1) {
      if (move_uploaded_file($_FILES["fileup"]["tmp_name"], $new_target)) {
        echo $succes;
      } else {
          echo $errors["unexpected"];
      }
  }

}
?>
</div>

</body>
</html>

