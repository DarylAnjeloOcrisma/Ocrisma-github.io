<?php

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="dark-mode-toggle">
        <span>Dark Mode</span>
        <input type="checkbox" id="dark-mode-switch">
        <label for="dark-mode-switch"></label>
    </div>
    <div class="box">
        <h1>Welcome, <span><?= $_SESSION['name']; ?></span></h1>
        <p>This is an <span>admin</span> page</p>
        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>

    <script>
        const darkModeSwitch = document.getElementById('dark-mode-switch');
        const body = document.body;

        function applyDarkMode(isDark) {
            if (isDark) {
                body.classList.add('dark-mode');
                darkModeSwitch.checked = true;
                document.querySelector('.dark-mode-toggle').classList.add('dark-mode');
            } else {
                body.classList.remove('dark-mode');
                darkModeSwitch.checked = false;
                document.querySelector('.dark-mode-toggle').classList.remove('dark-mode');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const savedMode = localStorage.getItem('dark-mode');
            applyDarkMode(savedMode === 'enabled');
        });

        darkModeSwitch.addEventListener('change', () => {
            if (darkModeSwitch.checked) {
                applyDarkMode(true);
                localStorage.setItem('dark-mode', 'enabled');
            } else {
                applyDarkMode(false);
                localStorage.setItem('dark-mode', 'disabled');
            }
        });
    </script>
</body>

</html>