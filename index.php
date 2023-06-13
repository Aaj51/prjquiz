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
        
        .description {
            font-size: 18px;
            color: #666;
        }
        
        .start-button {
            display: block;
            width: 200px;
            margin: 0 auto;
            padding: 10px 20px;
            text-align: center;
            background-color: #007bff;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
        }
        
        .start-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">Welcome to the Online Quiz System</h1>
            <p class="description">Test your knowledge with our interactive quizzes!</p>
        </div>
        <a href="userLogin.php" class="start-button">Start Quiz</a>
    </div>
</body>
</html>
