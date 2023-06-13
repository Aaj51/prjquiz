<?php

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userID = 1; 


    $userAnswers = $_POST['answer'];


    $topicID = $_POST['topic_id'];

    $query = "SELECT question_id, correct_option FROM questions WHERE topic_id = '$topicID'";
    $result = mysqli_query($con, $query);


    if ($result && mysqli_num_rows($result) > 0) {
        $correctAnswers = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        echo "No correct answers found for the selected topic.";
      
        echo "Error: " . mysqli_error($con);
        exit;
    }


    foreach ($userAnswers as $questionID => $selectedOption) {
        $correctOption = '';

        foreach ($correctAnswers as $answer) {
            if ($answer['question_id'] == $questionID) {
                $correctOption = $answer['correct_option'];
                break;
            }
        }

        $query = "INSERT INTO user_responses (user_id, question_id, selected_option, correct_option) VALUES ('$userID', '$questionID', '$selectedOption', '$correctOption')";
        $result = mysqli_query($con, $query);


        if (!$result) {
            echo "Error storing user response: " . mysqli_error($con);
       
            echo "Query: " . $query;
            exit;
        }
    }

    mysqli_close($con);
    header("Location: quiz_result.php");
    exit;
}
?>
