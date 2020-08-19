<?php include("includes/header.php"); ?>

<?php
if (!$session->is_signed_in()) {
    redirect('login.php');
}
if (empty($_GET['id'])) {
    redirect('photos.php');
}

$comments = Comment::find_the_comment($_GET['id']);
?>

<?php include("includes/sidebar.php"); ?>
<?php include("includes/content-top.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h2>Comments for this photo <a href="add_comment.php" class="btn btn-success rounded-o"><i class="fas fa-user-plus"></i>Add Comment</a></h2>
                <table class="table table-header">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Author</th>
                        <th>Body</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($comments as $comment): ?>
                        <tr>
                            <td><?php echo $comment->id; ?></td>
                            <td><?php echo $comment->author; ?></td>
                            <td><?php echo $comment->body; ?></td>
                            <td><a href="delete_comment_photo.php?id=<?php echo $comment->id; ?>"
                                   class="btn btn-primary rounded-0"><i class="fas fa-trash-alt"></i></a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php include("includes/footer.php"); ?>