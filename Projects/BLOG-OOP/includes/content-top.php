<?php $user = User::find_by_id($session->user_id) ?>

<div class="container-fluid fixed-top">
    <div class="row bg-light">
        <div class="col-12 d-flex flex-row-reverse align-items-center">
            <img class="img-profile rounded-circle" src="<?php echo 'admin/' . $user->image_path_and_placeholder() ?>" width="40" height="40">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $user->username ?></span>
        </div>
    </div>
</div>

