<?php

/*************** 
    
    Name: Harshdeep Devgan
    Date: 21 June, 2024
    Description: Home page

****************/

require('connect.php');

//SQL is written as a string and the order of posted entries is descending.
$query = "SELECT * FROM blog ORDER BY date_posted DESC LIMIT 5";

// A PDO::Statemnet is prepared from the query.
$statement = $db->prepare($query);

// Execution on the DB server is delayed until we execute().
$statement->execute();

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
    <header class = "my-header">
        <div class = "text-area">
            <h1>My Amazing Blog</h1>
        </div>
    </header>  

    <?php include('nav.php');?>
    
    <!--This class contains the heading for the blog entries which are recently created. -->
    <main class = "recent-container">
        <h2>Recently posted blog entries:</h2>
    
    <!--This is divide class is for when there is no blog data added.-->
    <?php if($statement->rowCount() == 0) : ?>
        <div class = "rownum">
            <p>No blog entries here!</p>
        </div>
    <?php exit; endif; ?>  
    
    <!--This is the main while loop for fetching the blog data.-->
    <?php while($row = $statement->fetch()): ?>

        <h3 class = "title-blog">
            <a href = "show.php?id=<?=$row['id']?>"><?=$row['title']?></a>
        </h3>

        <!--showing the format of date for the post-->
        <small class = "blog-date">Posted on <time datetime ="<?=$row['date_posted']?>">
        <?=date_format(date_create($row['date_posted']), 'F j, Y G:i') ?></time>
            &ensp;
        </small>    

        <!--edit link-->
        <a href = "edit.php?id=<?=$row['id']?>" class="blog-postedit">edit</a><br><br>
        <?php
            $content = $row['content'];
            if (strlen($content) > 200) {
                $truncated_content = substr($content, 0, 200) . '...';
                echo '<p>' . $truncated_content . '</p>';
                echo '<a href="show.php?id=' . $row['id'] . '">Read Full Post</a>';
            } else {
                echo '<p>' . $content . '</p>';
            }
            ?>
            <br><br><br>        
        <?php endwhile; ?>
    </main>
    <?php include('footer.php'); ?>
</body>
</html>