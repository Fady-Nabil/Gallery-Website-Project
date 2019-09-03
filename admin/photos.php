<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()){redirect("login.php");} ?>
<?php

    $photos = Photo::find_all();
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
                        Photos
                    </h1>
                    <div class="col-md-12">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Photo</th>
                                    <th>File Name</th>
                                    <th>Alternate Text</th>
                                    <th>Title</th>
                                    <th>Caption</th>
                                    <th>Description</th>
                                    <th>Size</th>
                                    <th>Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($photos as $photo) : ?>
                                <tr>
                                    <td><?php echo $photo->id; ?></td>
                                    <td>
                                        <img class="img-responsive admin-photo-thumbnail" width="100" src="<?php echo $photo->picture_path(); ?>" alt="">
                                        <br>
                                        <div class="action_links pull-right">
                                            <a class="btn btn-danger btn-xs" href="delete_photo.php?id=<?php echo $photo->id; ?>">Delete</a>
                                            <a class="btn btn-success btn-xs" href="edit_photo.php?id=<?php echo $photo->id; ?>">Edit</a>
                                            <a class="btn btn-info btn-xs" href="../photo.php?id=<?php echo $photo->id ?>">View</a>
                                        </div>
                                    </td>
                                    <td><?php echo $photo->filename; ?></td>
                                    <td><?php echo $photo->alternate_text; ?></td>
                                    <td><?php echo $photo->title; ?></td>
                                    <td><?php echo $photo->caption; ?></td>
                                    <td><?php echo $photo->description; ?></td>
                                    <td><?php echo $photo->size; ?></td>
                                    <td>
                                        <a class="btn btn-default" href="comment_photo.php?id=<?php echo $photo->id; ?>">
                                        <?php
                                        $comments = Comment::find_the_comments($photo->id);
                                        echo count($comments);
                                        ?>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>