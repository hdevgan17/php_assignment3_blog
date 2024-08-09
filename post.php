<?php

/*******w******** 
    
    Name: Harshdeep Devgan
    Date: 21 June, 2024
    Description: Create and insert new blog into database

****************/

require('authenticate.php');
require('connect.php');

date_default_timezone_set('America/Winnipeg');

if ($_POST && !empty($_POST['title']) && !empty($_POST['content'])) {
    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $date_posted = date('Y-m-d H:i:s');

    // Build the parameterized SQL query and bind to the above sanitized values.
    $query = "INSERT INTO blog (title, content, date_posted) VALUES (:title, :content, :date_posted)";
    $statement = $db->prepare($query);

    // Bind values to the parameters
    $statement->bindValue(':title', $title);
    $statement->bindValue(':content', $content);
    $statement->bindValue(':date_posted', $date_posted);

    // Execute the INSERT
    if($statement->execute()) {
        $id = $db->lastInsertId();
        header("Location: show.php?id={$id}");
        exit;
    } else {
        echo "Error: Could not create the blog post.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Welcome to My Blogs!</title>
</head>
<body>
<header class = "my-header">
        <div class = "text-area">
            <h1>My Amazing Blog</h1>
        </div>
    </header>  

    <?php include('nav.php');?>

    <!--label fields-->
    <main class ="recent-container" id = "create-post">
        <form action = "post.php" method = "POST">
            <h2>New post!</h2>

            <div class = "group-form">
                <label for = "title"> Title <br><br> </label>
                <input type = "text" name = "title" id = "title" minlength = "1" required>
            </div><br><br>

            <div class = "group-form">
                <label for = "content"> Content </label><br><br>
                <textarea name = "content" id = "content" cols = "70" rows = "8" minlength = "1" required></textarea>
            </div><br><br>

            <button type = "submit" class = "primary-button"> Submit! </button>
        </form>
    </main> 

    <?php include('footer.php'); ?>
    
</body>
</html>