<?php
$conn = mysqli_connect("localhost", "root", "", "mydatabase");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$start_date = date('Y-m-d', strtotime('-1 week'));
$end_date = date('Y-m-d');

$sql = "SELECT authors.name AS author_name, COUNT(articles.id) AS article_count
        FROM articles
        JOIN authors ON articles.author_id = authors.id
        WHERE articles.creation_date BETWEEN '$start_date' AND '$end_date'
        GROUP BY authors.name
        ORDER BY article_count DESC
        LIMIT 3";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Top Authors Last Week</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                margin: 20px;
            }
            .author {
                background-color: #f9f9f9;
                padding: 10px;
                border-radius: 5px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                margin-bottom: 10px;
            }
            .author h2 {
                margin-top: 0;
            }
            .author p {
                margin-bottom: 5px;
            }
        </style>
    </head>
    <body>
        <h1>Top Authors Last Week</h1>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="author">
                <h2><?php echo $row['author_name']; ?></h2>
                <p>Number of Articles: <?php echo $row['article_count']; ?></p>
            </div>
            <?php
        }
        ?>
    </body>
    </html>
    <?php
} else {
    echo json_encode(array("error" => "No authors found"));
}


mysqli_close($conn);
?>
