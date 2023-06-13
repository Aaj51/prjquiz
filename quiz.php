<?php
session_start();
include 'connection.php';


if (isset($_GET['topic_id'])) {
    $topicID = $_GET['topic_id'];

    // Fetch the topic name from the database
    $query = "SELECT topic_name FROM quiz_topics WHERE topic_id = '$topicID'";
    $result = mysqli_query($con, $query);



    if ($result) {
        $topic = mysqli_fetch_assoc($result);
        $topicName = $topic['topic_name'];
    } else {
        echo "Error: " . mysqli_error($con);
    }
    $randomSeed = time();
    $query = "SELECT * FROM questions WHERE topic_id = '$topicID' ORDER BY RAND($randomSeed) LIMIT 10";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $questions = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        echo "No questions found for the selected topic.";
    }
} else {
    echo "No topic selected.";
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Quiz System - Quiz</title>
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

        .question {
            margin-bottom: 20px;
        }

        .question-text {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .options {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .option {
            margin-bottom: 10px;
        }

        .option-label {
            display: inline-block;
            font-weight: bold;
            margin-right: 10px;
        }

        .submit-btn {
            display: block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }
        #timer-container {
    text-align: center;
    margin-bottom: 10px;
}

#timer-bar {
    width: 100%;
    height: 20px;
    background-color: #f2f2f2;
    position: relative; 
}

#timer-bar::before {
    content: "";
    display: block;
    position: absolute;
    top: -12px;
    left: 0;
    height: 100%;
    animation: timer-animation 600s linear;
}

@keyframes timer-animation {
    0% {
        width: 100%;
        background-color: #4caf50; /* Green */
    }
    50% {
        width: 50%;
        background-color: #ffff00; /* Yellow */
    }
    100% {
        width: 0;
        background-color: #ff0000; /* Red */
    }
}


#timer {
    font-size: 20px;
    font-weight: bold;
    margin-top: 10px;
}

    </style>
       <!-- <script>
        // Countdown Timer
        var minutes = 1;
        var seconds = 0;

        function startTimer() {
            var countdownElement = document.getElementById("countdown");

            function updateTimer() {
                var minutesDisplay = minutes < 10 ? "0" + minutes : minutes;
                var secondsDisplay = seconds < 10 ? "0" + seconds : seconds;
                countdownElement.innerHTML = minutesDisplay + ":" + secondsDisplay;

                if (minutes === 0 && seconds === 0) {
                    clearInterval(timerInterval);
                    document.getElementById("quizForm").submit(); // Automatically submit the quiz when the time is up
                } else if (seconds === 0) {
                    minutes--;
                    seconds = 59;
                } else {
                    seconds--;
                }
            }

            updateTimer();
            var timerInterval = setInterval(updateTimer, 1000);
        }

        // Start the timer when the page loads
        window.addEventListener("load", startTimer);
    </script> -->
</head>
<body>
<div id="timer-container">
    <div id="timer-bar"></div>
    <div id="timer">10:00</div>
</div>

    <div class="container">
        <div class="header">
        <div id="countdown"></div> <!-- Display the countdown timer here -->
            <h1 class="title"><?php echo $topicName; ?> Quiz</h1>
            <div class="container">
        <?php if (isset($questions) && count($questions) > 0) : ?>
            <form action="submit_quiz.php" method="post">
                <?php foreach ($questions as $question) : ?>
                    <div class="question">
                        <p class="question-text"><?php echo $question['question']; ?></p>
                        <ul class="options">
                            <li class="option">
                                <label class="option-label">
                                    <input type="radio" name="answer[<?php echo $question['question_id']; ?>]" value="<?php echo $question['option1']; ?>" required>
                                    <?php echo $question['option1']; ?>
                                </label>
                            </li>
                            <li class="option">
                                <label class="option-label">
                                    <input type="radio" name="answer[<?php echo $question['question_id']; ?>]" value="<?php echo $question['option2']; ?>" required>
                                    <?php echo $question['option2']; ?>
                                </label>
                            </li>
                            <li class="option">
                                <label class="option-label">
                                    <input type="radio" name="answer[<?php echo $question['question_id']; ?>]" value="<?php echo $question['option3']; ?>" required>
                                    <?php echo $question['option3']; ?>
                                </label>
                            </li>
                            <li class="option">
                                <label class="option-label">
                                    <input type="radio" name="answer[<?php echo $question['question_id']; ?>]" value="<?php echo $question['option4']; ?>" required>
                                    <?php echo $question['option4']; ?>
                                </label>
                            </li>
                        </ul>
                    </div>
                <?php endforeach; ?>
                <input type="hidden" name="topic_id" value="<?php echo $topicID; ?>">
                <button type="submit" class="submit-btn">Submit Quiz</button>
            </form>
        <?php endif; ?>
    </div>
</body>
<script>
    function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            clearInterval(timerInterval);
            alert("Time's up!");
            // Add your code here to handle the timeout event
        }
    }, 1000);
}

window.onload = function () {
    var tenMinutes = 60 * 10,
        display = document.querySelector('#timer');

    startTimer(tenMinutes, display);
};

</script>
</html>
