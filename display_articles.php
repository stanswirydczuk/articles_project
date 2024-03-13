<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit and Display Articles</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Submit Article</h2>
    <form action="display_articles.php" method="POST">
        <label for="author">Author Name:</label>
        <input type="text" id="author" name="author" required>

        <label for="title">Article Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="text">Article Text:</label>
        <textarea id="text" name="text" required></textarea>

        <input type="submit" value="Submit Article">
    </form>
</div>

<div class="container">
    <h2>Articles</h2>
    <?php
    
$conn = mysqli_connect("localhost", "root", "", "mydatabase");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $author = $_POST['author'];
    $title = $_POST['title'];
    $text = $_POST['text'];
    $creation_date = date('Y-m-d'); 

    $sql = "SELECT id FROM authors WHERE name='$author'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $author_id = $row['id'];
    } else {
        $sql = "INSERT INTO authors (name) VALUES ('$author')";
        if (mysqli_query($conn, $sql)) {
            $author_id = mysqli_insert_id($conn); 
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    $sql = "INSERT INTO articles (author_id, title, text, creation_date) VALUES ('$author_id', '$title', '$text', '$creation_date')";
    if (mysqli_query($conn, $sql)) {
        echo "Article submitted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

$sql = "SELECT articles.*, authors.name AS author_name FROM articles JOIN authors ON articles.author_id = authors.id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div>";
        echo "<hr>";
        echo "<h3>" . $row['title'] . "</h3>";
        echo "<p>" . $row['text'] . "</p>";
        echo "<p style='font-style: italic; color: blue;'>Author: " . $row['author_name'] . "</p>"; 
        echo "</div>";
    }
} else {
    echo "No articles found.";
}

mysqli_close($conn);
?>

</div>

<div class="container">
    <h2>API Endpoints</h2>
    <form action="get_article.php" method="GET">
        <label for="articleId">Enter Article ID:</label>
        <input type="text" id="articleId" name="id">
        <input type="submit" value="Get Article">
    </form>
    <br> <br> <br>
    <form action="get_articles_by_author.php" method="GET">
        <label for="authorName">Enter Author Name:</label>
        <input type="text" id="authorName" name="author">
        <input type="submit" value="Get Articles by Author">
    </form>
    <br> <br> <br>
    <form action="get_top_authors.php" method="GET">
        <label for="authorName">Get top 3 most active authors</label>
        <br> <br>
        <input type="submit" value="Click here">
    </form>
</div>

</body>
</html>
