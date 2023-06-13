<?php
// Assuming you have established a database connection
$con = new mysqli('localhost', 'root', '', 'quizdb') or die("Could not connect to MySQL: " . $con->connect_error);

// Retrieve the scores from the leaderboard table
$query = "SELECT u.username, l.score 
          FROM leaderboard l
          JOIN user u ON l.user_id = u.user_id
          ORDER BY l.score DESC";
$result = mysqli_query($con, $query);

$scores = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $username = $row['username'];
        $score = $row['score'];

        $scores[] = array(
            'username' => $username,
            'score' => $score
        );
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
    <title>Leaderboard</title>
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
    <h1>Leaderboard</h1>

    <table>
        <tr>
            <th>Username</th>
            <th>Score</th>
        </tr>
        <?php foreach ($scores as $score): ?>
            <tr>
                <td><?php echo $score['username']; ?></td>
                <td><?php echo $score['score']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
