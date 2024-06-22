<?php

/*******w******** 
    
    Name: Harshdeep Devgan
    Date: 21 June, 2024
    Description: This PHP script retrieves and displays a specific blog post based on the ID provided in the URL query parameters

 ****************/

// print_r($_GET); -- to get variables that we have...
require('connect.php');

if (isset($_GET['id'])) { // Retrieve blog to be edited, if id GET parameter is in URL.
    // Sanitize the id. Like above but this time from INPUT_GET.
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Build the parameterized SQL query using the filtered id.
    $query = "SELECT * FROM blog WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    // Execute the SELECT and fetch the single row returned.
    $statement->execute();
    $blog = $statement->fetch();
} else {
    $id = false;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Welcome to my Blogs!</title>
</head>

<body>
    <header class="my-header">
        <div class="text-area">
            <h1>My Amazing Blog</h1>
        </div>
    </header>

    <?php include('nav.php'); ?>

    <main class="recent-container">
        <?php if ($id) : ?>
            <h1 class="title-blog"><?= $blog['title'] ?></h1>
            <small class="blog-date">Posted on <time datetime="<?= $blog['date_posted'] ?>">
                    <?= date_format(date_create($blog['date_posted']), 'F j, Y G:i') ?><time>
                        &ensp;
            </small>

            <!--edit link-->
            <a href="edit.php?id=<?= $blog['id'] ?>" class="blog-postedit">edit</a>
            <p class="blog-content">
                <?= $blog['content'] ?>
            </p>
        <?php else : ?>
            <p>No blog selected. <a href="?id=1"> Try this link... </a>.</p>
        <?php endif ?>
    </main>

    <?php include('footer.php'); ?>
</body>

</html>