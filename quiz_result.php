<?php
session_start();

include 'connection.php';


$query = "SELECT u.question_id, u.selected_option, q.correct_option 
          FROM user_responses u 
          JOIN questions q ON u.question_id = q.question_id";
$result = mysqli_query($con, $query);

$userAnswers = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $questionID = $row['question_id'];
        $selectedOption = $row['selected_option'];
        $correctOption = $row['correct_option'];

        // Retrieve the question text from the questions table
        $questionQuery = "SELECT question FROM questions WHERE question_id = $questionID";
        $questionResult = mysqli_query($con, $questionQuery);

        if ($questionResult) {
            $questionRow = mysqli_fetch_assoc($questionResult);
            $questionText = $questionRow['question'];

            $userAnswers[] = array(
                'question' => $questionText,
                'selected_option' => $selectedOption,
                'correct_option' => $correctOption
            );
        } else {
            echo "Error retrieving question text: " . mysqli_error($con);
        }
    }

    // Calculate the number of correct and wrong answers
    $correctCount = 0;
    $wrongCount = 0;

    foreach ($userAnswers as $answer) {
        if ($answer['selected_option'] === $answer['correct_option']) {
            $correctCount++;
        } else {
            $wrongCount++;
        }
    }

    // Store the user's score in the leaderboard table
    $userID = $_SESSION["userid"]; // Replace with the actual user ID
    $username=$_SESSION["username"];
    $score = $correctCount; // Use the correct count as the score
        
  // Retrieve the user's score
$query = "SELECT username, score FROM leaderboard WHERE user_id = $userID";
$result = mysqli_query($con, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        // User exists in the leaderboard, update the score
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
        $currentScore = $row['score'];
        $newScore = $currentScore + $score;

        $updateQuery = "UPDATE leaderboard SET score = $newScore WHERE user_id = $userID";
        $updateResult = mysqli_query($con, $updateQuery);

        if ($updateResult) {
            echo "<script>console.log(insert succesful)</script>";
        } else {
            echo "Error updating score: " . mysqli_error($con);
        }
    } else {
        // User does not exist in the leaderboard, insert a new row
        $insertQuery = "INSERT INTO leaderboard (user_id, username, score) VALUES ($userID, '$username', $score)";
        $insertResult = mysqli_query($con, $insertQuery);

        if ($insertResult) {
            echo "Score added successfully for user: sayal";
        } else {
            echo "Error adding score: " . mysqli_error($con);
        }
    }
} else {
    echo "Error executing query: " . mysqli_error($con);
}
    // Delete user responses from the table
    $deleteQuery = "DELETE FROM user_responses";
    $deleteResult = mysqli_query($con, $deleteQuery);

    if (!$deleteResult) {
        echo "Error deleting user responses: " . mysqli_error($con);
    }
} else {
    echo "Error executing query: " . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Quiz Results</h1>

    <h2>Summary</h2>
    <p>Number of correct answers: <?php echo $correctCount; ?></p>
    <p>Number of wrong answers: <?php echo $wrongCount; ?></p>

    <table>
        <tr>
            <th>Question</th>
            <th>User's Answer</th>
            <th>Correct Answer</th>
        </tr>
        <?php foreach ($userAnswers as $answer): ?>
            <tr>
                <td><?php echo $answer['question']; ?></td>
                <td><?php echo $answer['selected_option']; ?></td>
                <td><?php echo $answer['correct_option']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
