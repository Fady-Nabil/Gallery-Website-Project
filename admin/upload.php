<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()){redirect("login.php");} ?>
<?php
$message = "";
if(isset($_POST['submit'])) {
    $photo = new Photo();
    $photo->title = $_POST['title'];
    $photo->description = $_POST['description'];
    $photo->set_file($_FILES['file_upload']);
    if($photo->save()) {
        $message = "photo uploaded succesfully";
    } else {
        $message =join("<br>", $photo->errors);
    }
}

?>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <?php include("includes/top_nav.php") ?>
        <?php include("includes/side_nav.php") ?>
    </nav>

    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Upload
                    </h1>
                    <div class="col-md-6">
                        <?php echo $message; ?>
                        <form action="upload.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <input class="form-control" type="text" name="title" placeholder="image title">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="description" placeholder="image description">
                            </div>
                            <div class="form-group">
                                <input type="file" name="file_upload">
                            </div>
                            <input class="btn btn-primary form-control" type="submit" name="submit">
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>