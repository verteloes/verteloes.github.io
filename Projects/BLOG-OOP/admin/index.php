<?php include("includes/header.php");?>

<?php

if(!$session->is_signed_in()){
    redirect("login.php");}

$aantalUsers = User::find_all();
$aantalComments = Comment::find_all();
$aantalPhotos = Photo::find_all();

?>

<?php include("includes/sidebar.php"); ?>

<?php include("includes/content-top.php"); ?>

<?php include("includes/content.php"); echo INCLUDES_PATH; ?>

<?php include("includes/footer.php"); ?>
