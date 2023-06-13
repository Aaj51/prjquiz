<?php

session_start();
if (!isset($_SESSION["username"])) {
    header("Location: userLogin.php");
    exit;
}


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
        .navbar {
            background-color: #333;
            color: #fff;
            padding: 10px;
        }

        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .navbar li {
            float: left;
        }

        .navbar li a {
            display: block;
            color: #fff;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navbar li a:hover {
            background-color: #555;
            color: red;
        }
                /* Default light mode styles */

/* Dark mode styles */
body.dark-mode {
  background-color: #000000;
  color: #ffffff;
}

/* Toggle switch styles */
.toggle-container {
  display: flex;
  align-items: center;
  margin-bottom: 1rem;
}

.toggle-label {
  margin-right: 0.5rem;
}

.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  border-radius: 34px;
  transition: 0.4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  border-radius: 50%;
  transition: 0.4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:checked + .slider:before {
  transform: translateX(26px);
}

/* Icon styles */
.fa-sun,
.fa-moon {
  position: absolute;
  top: 4px;
  left: 4px;
  font-size: 20px;
  color: #ffffff;
  transition: 0.4s;
}

input:checked + .slider .fa-moon {
  opacity: 0;
}

input:checked + .slider .fa-sun {
  opacity: 1;
}
    </style>
</head>

<div class="navbar">
    <ul>
    <class="toggle-container">
    <span class="toggle-label">Dark Mode</span>
    <label class="switch">
      <input type="checkbox" id="toggle-switch">
      <span class="slider round">
        <i class="fas fa-sun"></i>
        <i class="fas fa-moon"></i>
      </span>
    </label>
        <li><a href="userDashboard.php">Home</a></li>
    
        <li><a href="leaderboard.php">Leaderboard</a></li>
        <li><a href="questions.php">Question</a></li>
        <li><a href="logout.php">Logout</a></li>
        
    </ul>
</div>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">Welcome to the Online Quiz System</h1>
            <p>Select a category to start</p>
        </div>
        <ul class="category-list">
            <?php foreach ($categories as $category) : ?>
                <li class="category-item">
                    <a href="topicSelection.php?category_id=<?php echo $category['category_id']; ?>" class="category-link"><?php echo $category['category_name']; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
    <script>
    // Get the toggle switch element
const toggleSwitch = document.getElementById('toggle-switch');

// Function to switch between light and dark mode
function switchMode(e) {
  if (e.target.checked) {
    document.body.classList.add('dark-mode');
  } else {
    document.body.classList.remove('dark-mode');
  }
}

// Event listener for the toggle switch
toggleSwitch.addEventListener('change', switchMode);
</script>
</html>
