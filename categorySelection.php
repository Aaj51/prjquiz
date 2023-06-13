<?php
session_start();

$con = new mysqli('localhost', 'root', '', 'quizdb') or die("Could not connect to MySQL: " . $con->connect_error);

$query = "SELECT * FROM categories";
$result = mysqli_query($con, $query);

if ($result) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo "Error: " . mysqli_error($con);
}


mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Quiz System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: center;
        }

        .category-item {
            display: inline-block;
            margin: 10px;
        }

        .category-link {
            display: block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .category-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">Welcome to the Online Quiz System</h1>
            <p>Select a category to start</p>
        </div>
        <ul class="category-list">
            <?php foreach ($categories as $category) : ?>
                <li class="category-item">
                    <a href="topicSelection.php?category_id=<?php echo $category['category_id'] ; ?>" class="category-link"><?php echo $category['category_name']; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
