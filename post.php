<?php

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

function posts($page_num) {
    $per_page = 10;
    if (isset($page_num)) {
        $page_num = $page_num;
    } else {
        $page_num = 1;
    }

    $page_Start = ($page_num - 1) * $per_Page;

    $conn = new mysqli("localhost", "root", "", "mystore");
    $query = $conn->query("SELECT * FROM post ORDER BY id DESC LIMIT $Page_Start,$Per_Page");
    return $query;
}
?>

<?php if (isset($_POST['page_num'])): ?>
    <?php $query = posts($_POST['page_num']); ?>
    <?php while ($data = $query->fetch_assoc()) ?>
        <div class="my-posts">
            <h3><?php echo $data['title']; ?></h3>
            <p><?php echo $data['meta_description']; ?></p>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
