<?php include("includes/header.php"); ?>

<?php
if (!$session->is_signed_in()) {
    redirect('login.php');
}

$users = User::find_all();
?>

<?php include("includes/sidebar.php"); ?>
<?php include("includes/content-top.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h2>Users <a href="add_user.php" class="btn btn-success rounded-o"><i class="fas fa-user-plus"></i>Add User</a></h2>
                <table class="table table-header">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Photo</th>
                        <th>Username</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Wijzig?</th>
                        <th>Delete?</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user->id ?></td>
                            <td><img src="<?php echo $user->image_path_and_placeholder() ?>" width="40" height="40" alt=""></td>
                            <td><?php echo $user->username ?></td>
                            <td><?php echo $user->first_name ?></td>
                            <td><?php echo $user->last_name ?></td>
                            <td><a href="edit_user.php?id=<?php echo $user->id; ?>" class="btn btn-primary rounded-0"><i class="fas fa-edit"></i></a></td>
                            <td><a href="delete_user.php?id=<?php echo $user->id; ?>" class="btn btn-danger rounded-0"><i class="fas fa-trash-alt"></i></a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php include("includes/footer.php"); ?>