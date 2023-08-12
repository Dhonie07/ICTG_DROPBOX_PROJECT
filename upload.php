<?php
session_start();
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;

        // Check file size, file format, etc.
        $fileName = $_FILES["fileToUpload"]["name"];
        $fileSize = $_FILES["fileToUpload"]["size"];
        $fileType = $_FILES["fileToUpload"]["type"];

        // Check file size limit (2GB)
        $maxFileSize = 2 * 1024 * 1024 * 1024; // 2GB in bytes
        if ($fileSize > $maxFileSize) {
            $uploadOk = 0;
        }

        if ($uploadOk) {
            // Make sure to include your database connection settings here
            $servername = "localhost";
            $db_username = "root"; // Replace with your DB username
            $db_password = "";     // Replace with your DB password
            $dbname = "ddropbox";

            // Create a new connection
            $conn = new mysqli($servername, $db_username, $db_password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $username = $_SESSION["username"];

            // Get user ID
            $userQuery = "SELECT id FROM users WHERE username='$username'";
            $userResult = $conn->query($userQuery);
            if ($userResult && $userResult->num_rows > 0) {
                $userRow = $userResult->fetch_assoc();
                $userId = $userRow["id"];
            } else {
                echo "User not found.";
                $conn->close();
                exit();
            }

            // Check if the file already exists for the user
            $fileExistsQuery = "SELECT id FROM uploaded_files WHERE user_id='$userId' AND file_name='$fileName'";
            $fileExistsResult = $conn->query($fileExistsQuery);

            if ($fileExistsResult && $fileExistsResult->num_rows > 0) {
                $fileUploadedMessage = "Duplicate file detected. Please upload a different file.";
                echo "<script>
                        alert('$fileUploadedMessage');
                        window.location.href = 'index.php';
                      </script>";
                exit();
            } else {
                // Insert file information into the database
                $insertQuery = "INSERT INTO uploaded_files (user_id, file_name, file_size, file_type)
                                VALUES ('$userId', '$fileName', '$fileSize', '$fileType')";

                if ($conn->query($insertQuery) === TRUE) {
                    $fileUploadedMessage = "File uploaded successfully and database updated.";
                } else {
                    $fileUploadedMessage = "Error: " . $insertQuery . "<br>" . $conn->error;
                }
            }

            $conn->close();

            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                $fileUploadedMessage = "File uploaded successfully.";
            } else {
                $fileUploadedMessage = "Sorry, there was an error uploading your file.";
            }
        } else {
            $fileUploadedMessage = "File size exceeds the limit of 2GB.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>File Upload</title>
    <!-- Include your CSS and JavaScript files here -->
</head>
<body>
    <!-- Your HTML content here -->

    <script>
        // Display a JavaScript alert with the file uploaded message
        var fileUploadedMessage = "<?php echo $fileUploadedMessage; ?>";
        alert(fileUploadedMessage);

        // Redirect to login page after displaying the alert
        window.location.href = "index.php";
    </script>
</body>
</html>
