<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vulnerable PHP Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            text-align: center; 
        }
        .container {
            max-width: 600px;
            margin: 50px auto; 
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            text-align: left; 
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="submit"] {
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            cursor: pointer;
        }
        pre {
            white-space: pre-wrap; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP Application!</h1>

        <form method="post">
            <label for="command">Enter a command (e.g., echo):</label><br>
            <input type="text" id="command" name="command"><br><br>
            <input type="submit" value="Run Command">
        </form>

        <?php
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $command = isset($_POST['command']) ? $_POST['command'] : '';
            $command = trim($command);

            if (isValidCommand($command)) {
                echo "<p>Valid command: $command</p>";

                $output = shell_exec($command);

                echo "<p>Command output:</p>";
                echo "<div style='text-align: center;'>";
                echo "<pre>$output</pre>";
                echo "</div>";
            } else {
                echo "<p>Invalid command!</p>";
            }
        }

        function isValidCommand($command) {
            if (stripos($command, 'echo') === 0) {
                return true;
            }

            return false;
        }
        ?>
    </div>
</body>
</html>
