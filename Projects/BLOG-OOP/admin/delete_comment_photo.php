<?php
include ("includes/header.php");
if(!$session->is_signed_in()){
    redirect('login.php');
}
if (empty($_GET['id'])){
    redirect('comments.php');
}
$comment = Comment::find_by_id($_GET['id']);
if($comment){
    $comment->delete();
    redirect("comments_photo.php?id={$comments->photo_id}");
}else{
    redirect("comments_photo.php?id={$comments->photo_id}");
}
include ("includes/sidebar.php");
include ("includes/content-top.php");
?>

<h1>Welcome on the Delete Page</h1>

<?php include ("includes/footer.php"); ?>
