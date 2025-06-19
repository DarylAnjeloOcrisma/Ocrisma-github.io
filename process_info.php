<?php
// Set the content type to HTML
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information System Results</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8; /* Light blue-gray background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .container {
            background-color: #ffffff;
            padding: 2.5rem;
            border-radius: 1rem; /* Rounded corners for the container */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); /* Soft shadow */
            width: 100%;
            max-width: 600px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
        }
        th, td {
            border: 1px solid #e2e8f0; /* Slate-200 */
            padding: 0.75rem;
            text-align: left;
        }
        th {
            background-color: #f8fafc; /* Slate-50 */
            font-weight: 600;
            color: #475569; /* Slate-600 */
        }
        td {
            color: #334155; /* Slate-700 */
        }
        .message-box {
            margin-top: 1.5rem;
            padding: 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            line-height: 1.5;
        }
        .message-box.info {
            background-color: #e0f2fe; /* Blue-100 */
            color: #0c4a6e; /* Blue-900 */
            border: 1px solid #93c5fd; /* Blue-300 */
        }
        .message-box.warning {
            background-color: #fef3c7; /* Yellow-100 */
            color: #854d09; /* Yellow-900 */
            border: 1px solid #fde68a; /* Yellow-300 */
        }
        .message-box.success {
            background-color: #dcfce7; /* Green-100 */
            color: #166534; /* Green-900 */
            border: 1px solid #86efac; /* Green-300 */
        }
        .error-message {
            color: #ef4444; /* Red-500 */
            background-color: #fee2e2; /* Red-100 */
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid #fca5a5; /* Red-300 */
        }
        .back-button {
            display: inline-block;
            margin-top: 1.5rem;
            padding: 0.75rem 1.5rem;
            background-color: #64748b; /* Slate-500 */
            color: #ffffff;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
            text-decoration: none; /* Remove underline for links acting as buttons */
            text-align: center;
        }
        .back-button:hover {
            background-color: #475569; /* Slate-600 */
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Information System Results</h1>

        <?php
        // Initialize an array to store error messages
        $errors = [];

        // Check if all required fields are set and not empty
        if (!isset($_POST['fullName']) || empty($_POST['fullName'])) {
            $errors[] = "Full Name is required.";
        }
        if (!isset($_POST['birthYear']) || empty($_POST['birthYear'])) {
            $errors[] = "Birth Year is required.";
        }
        if (!isset($_POST['sleepingHours']) || empty($_POST['sleepingHours'])) {
            $errors[] = "Sleeping Hours per Day is required.";
        }
        if (!isset($_POST['city']) || empty($_POST['city'])) {
            $errors[] = "City is required.";
        }

        // Proceed only if there are no initial missing field errors
        if (empty($errors)) {
            // Retrieve and sanitize inputs
            $fullName = htmlspecialchars($_POST['fullName']);
            $birthYear = filter_var($_POST['birthYear'], FILTER_SANITIZE_NUMBER_INT);
            $sleepingHours = filter_var($_POST['sleepingHours'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $city = htmlspecialchars($_POST['city']);

            // Validate birth year is numeric
            if (!is_numeric($birthYear)) {
                $errors[] = "Birth Year must be a numeric value.";
            } elseif ($birthYear < 1900 || $birthYear > date('Y')) { // Added a sensible range check
                $errors[] = "Birth Year must be between 1900 and " . date('Y') . ".";
            }

            // Validate sleeping hours are numeric and within a reasonable range
            if (!is_numeric($sleepingHours)) {
                $errors[] = "Sleeping Hours per Day must be a numeric value.";
            } elseif ($sleepingHours < 0 || $sleepingHours > 24) {
                $errors[] = "Sleeping Hours per Day must be between 0 and 24.";
            }

            // If there are no validation errors, perform calculations and display results
            if (empty($errors)) {
                $currentYear = date('Y'); // Get the current year
                $age = $currentYear - $birthYear; // Arithmetic operator
                $totalYearsSleeping = ($sleepingHours * 365 * $age) / 24; // Arithmetic operator

                // Display results using an HTML table and div elements
                echo '<div class="mb-4">';
                echo '<h2 class="text-2xl font-semibold mb-4 text-gray-700">User Information</h2>';
                echo '<table class="min-w-full bg-white rounded-lg shadow-sm">';
                echo '<thead>';
                echo '<tr><th>Field</th><th>Value</th></tr>';
                echo '</thead>';
                echo '<tbody>';
                echo '<tr><td>Full Name</td><td>' . $fullName . '</td></tr>';
                echo '<tr><td>Birth Year</td><td>' . $birthYear . '</td></tr>';
                echo '<tr><td>Sleeping Hours per Day</td><td>' . $sleepingHours . ' hours</td></tr>';
                echo '<tr><td>City</td><td>' . $city . '</td></tr>';
                echo '<tr><td>Computed Age</td><td>' . $age . ' years</td></tr>';
                echo '<tr><td>Total Years Sleeping</td><td>' . number_format($totalYearsSleeping, 2) . ' years</td></tr>'; // Format to 2 decimal places
                echo '</tbody>';
                echo '</table>';
                echo '</div>';

                echo '<div class="message-box info">';
                echo '<h2 class="text-xl font-semibold mb-2 text-gray-700">Messages:</h2>';

                // Comparison and logical operators for messages
                if ($age > 50) {
                    echo '<p>&bull; You might want to start planning for retirement.</p>';
                }

                if ($totalYearsSleeping > 15) {
                    echo '<p>&bull; You’ve spent a huge part of your life sleeping!</p>';
                }

                if ($city !== "Quezon City") { // Comparison operator
                    echo '<p>&bull; You don’t live in the best city.</p>';
                } else {
                    echo '<p>&bull; Quezon City rocks!</p>';
                }

                if ($age <= 25) { // Comparison operator
                    echo '<p>&bull; You\'re still young, enjoy learning!</p>';
                }
                echo '</div>'; // Close message-box
            }
        }

        // Display any errors that occurred
        if (!empty($errors)) {
            echo '<div class="error-message">';
            echo '<h2 class="text-xl font-semibold mb-2">Error(s):</h2>';
            echo '<ul>';
            foreach ($errors as $error) {
                echo '<li>&bull; ' . $error . '</li>';
            }
            echo '</ul>';
            echo '</div>'; // Close error-message
        }
        ?>
        <a href="info_form.html" class="back-button">Go Back to Form</a>
    </div>
</body>
</html>
