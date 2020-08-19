<?php
include('includes/header.php');
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 4;
$items_total_count = Photo::count_all();
$paginate = new Paginate($page, $items_per_page, $items_total_count);
$sql = "SELECT * FROM photo LIMIT {$items_per_page} OFFSET {$paginate->offset()}";
$photos = Photo::find_this_query($sql);
?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row m-5">
                    <?php foreach ($photos as $photo): ?>
                        <div class="col-3">
                            <a href="photo.php?id=<?php echo $photo->id; ?>">
                                <img src="<?php echo 'admin' . DS . $photo->picture_path(); ?>" alt="<?php echo $photo->alternate_text; ?>" class="img-fluid">
                            </a>
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="row d-flex justify-content-center align-items-center">
                    <ul class="pagination">
                        <?php
                        if ($paginate->page_total() > 1) {
                            if ($paginate->has_previous()) {
                                echo "<li class='page-item'><a href='index.php?page={$paginate->previous()}' class='page-link'>Previous</a></li>";
                            } else {
                                echo "<li class='disabled page-item'><a class='page-link'>Previous</a></li>";
                            }
                            for ($i = 1; $i <= $paginate->page_total(); $i++) {
                                if ($i == $paginate->current_page) {
                                    echo "<li class='active page-item'><a href='index.php?page={$i}' class='page-link'>{$i}</a></li>";
                                } else {
                                    echo "<li class='page-item'><a href='index.php?page={$i}' class='page-link'>{$i}</a></li>";
                                }
                            }
                            if ($paginate->has_next()) {
                                echo "<li class='page-item'><a href='index.php?page={$paginate->next()}' class='page-link'>Next</a></li>";
                            } else {
                                echo "<li class='disabled page-item'><a class='page-link'>Next</a></li>";
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php
include('includes/footer.php');
?>