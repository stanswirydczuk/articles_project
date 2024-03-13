<?php
$conn = mysqli_connect("localhost", "root", "", "mydatabase");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$article_id = $_GET['id'];

$sql = "SELECT articles.*, authors.name AS author_name FROM articles JOIN authors ON articles.author_id = authors.id WHERE articles.id = $article_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $article = mysqli_fetch_assoc($result);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Article</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                margin: 20px;
            }
            .article {
                background-color: #f9f9f9;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }
            .article h2 {
                margin-top: 0;
            }
            .article p {
                margin-bottom: 10px;
            }
            .article .author {
                font-style: italic;
                color: blue;
            }
        </style>
    </head>
    <body>
        <div class="article">
            <h2><?php echo $article['title']; ?></h2>
            <p><?php echo $article['text']; ?></p>
            <p class="author">Author: <?php echo $article['author_name']; ?></p>
        </div>
    </body>
    </html>
    <?php
} else {
    echo json_encode(array("error" => "Article not found"));
}

mysqli_close($conn);
?>
