<?php
$conn = mysqli_connect("localhost", "root", "", "mydatabase");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$author_name = $_GET['author'];

$sql = "SELECT articles.*, authors.name AS author_name 
        FROM articles 
        JOIN authors ON articles.author_id = authors.id 
        WHERE authors.name = '$author_name'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Articles by <?php echo $author_name; ?></title>
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
                margin-bottom: 20px;
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
        <h1>Articles by <?php echo $author_name; ?></h1>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="article">
                <h2><?php echo $row['title']; ?></h2>
                <p><?php echo $row['text']; ?></p>
                <p class="author">Author: <?php echo $row['author_name']; ?></p>
            </div>
            <?php
        }
        ?>
    </body>
    </html>
    <?php
} else {
    echo json_encode(array("error" => "No articles found for the author"));
}

mysqli_close($conn);
?>
