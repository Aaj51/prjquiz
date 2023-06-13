<?php
session_start();
$con = new mysqli('localhost', 'root', '', 'quizdb') or die("Could not connect to MySQL: " . $con->connect_error);


if (isset($_GET['category_id'])) {
    $categoryID = $_GET['category_id'];

    $query = "SELECT * FROM quiz_topics WHERE category_id = '$categoryID'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        echo "Error: " . mysqli_error($con);
    }
} else {
    echo "No category selected.";
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Quiz System - Topics</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            color: #000000;
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

        .topic-list {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: center;
        }

        .topic-item {
            display: inline-block;
            margin: 10px;
        }

        .topic-link {
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

        .topic-link:hover {
            background-color: #0056b3;
        }

        .no-topics {
            text-align: center;
            margin-top: 20px;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999;
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s, opacity 0.5s;
        }

        .message {
            background-color: #000000;
            padding: 20px;
            border-radius: 5px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }

        .show-overlay {
            visibility: visible;
            opacity: 1;
            transition-delay: 3s;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1 class="title">Select a Topic</h1>
            <p>Choose a topic from the list below</p>
        </div>
        <?php if (isset($topics) && count($topics) > 0) : ?>
            <ul class="topic-list">
                <?php foreach ($topics as $topic) : ?>
                    <li class="topic-item">
                        <a href="#" class="topic-link" data-topic-id="<?php echo $topic['topic_id']; ?>"><?php echo $topic['topic_name']; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p class="no-topics">No topics found for the selected category.</p>
        <?php endif; ?>
    </div>

    <div class="overlay" id="overlay">
        <div class="message" id="message">
            Be ready to play
        </div>
    </div>

    <script>
        const topicLinks = document.querySelectorAll('.topic-link');
        const overlay = document.getElementById('overlay');
        const message = document.getElementById('message');

        topicLinks.forEach((link) => {
            link.addEventListener('click', showOverlay);
        });

        function showOverlay(e) {
            e.preventDefault(); // Prevent the default link behavior

            const topicId = this.getAttribute('data-topic-id');
            const quizUrl = `quiz.php?topic_id=${topicId}`;

            overlay.classList.add('show-overlay');
            setTimeout(() => {
                window.location.href = quizUrl;
            }, 3000); // 3000 milliseconds = 3 seconds
        }
    </script>

</body>

</html>



