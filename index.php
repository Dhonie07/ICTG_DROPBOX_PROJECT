<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view.css">
    <title>DropBox App</title>
</head>
<body>
    <header>
        <h1 class="logo">DropBox App</h1>
        <button class="login-button" id="logout-button">Logout</button>
    </header>
    <main>
        <div class="upload-container">
            <p class="upload-instructions">Welcome to your personal DropBox! Easily store and access your files from anywhere.</p>
            <div class="upload-content">
                <img src="./icons8-download-50.png" alt="Upload Icon" class="upload-icon">
                <p class="upload-info">Click the button below to upload your files:</p>
                <form action="upload.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <br><br>
                    <input type="submit" value="Upload File" name="submit">
                </form>
                
            </div>
        </div>
    </main>
    <footer>
        <p class="footer-text">DESIGNED BY ADEBOYE DANIEL_ICTG_TEST</p>
    </footer>
    
    <script>
        // Get the logout button element
        const logoutButton = document.getElementById('logout-button');

        // Add click event listener to the logout button
        logoutButton.addEventListener('click', function() {
            // Redirect to the login page
            window.location.href = 'login.html';
        });
    </script>
</body>
</html>
