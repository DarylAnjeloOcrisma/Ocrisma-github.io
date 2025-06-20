<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Neon Results</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600&display=swap" rel="stylesheet"/>
  <style>
    body {
      font-family: 'Orbitron', sans-serif;
      background: linear-gradient(135deg, #1a002b, #002233, #330033);
      background-size: 400% 400%;
      animation: neonBgShift 15s ease infinite;
      color: #f0f9ff;
    }

    @keyframes neonBgShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .neon-text {
      text-shadow: 0 0 5px #ff00cc, 0 0 10px #00ffff, 0 0 20px #ff00cc;
      color: #ff99ff;
    }

    .neon-box {
      box-shadow: 0 0 10px #00ffff, 0 0 20px #ff00cc, 0 0 30px #00ffff;
    }

    .glass {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
    }

    table, th, td {
      border-color: #ff00cc;
    }

    a:hover {
      filter: brightness(1.3);
    }

    .btn-glow {
      background: linear-gradient(90deg, #00ffff, #ff00cc);
      box-shadow: 0 0 12px #ff00cc, 0 0 24px #00ffff;
      transition: 0.3s ease-in-out;
    }

    .btn-glow:hover {
      background: linear-gradient(90deg, #ff00cc, #00ffff);
      transform: translateY(-2px);
      box-shadow: 0 0 16px #ff00cc, 0 0 32px #00ffff;
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
  <div class="w-full max-w-2xl glass neon-box rounded-2xl p-8">
    <h1 class="text-4xl font-bold text-center neon-text mb-8">System Results</h1>

    <?php
    $errors = [];

    if (!isset($_POST['fullName']) || empty($_POST['fullName'])) $errors[] = "Full Name is required.";
    if (!isset($_POST['birthYear']) || empty($_POST['birthYear'])) $errors[] = "Birth Year is required.";
    if (!isset($_POST['sleepingHours']) || empty($_POST['sleepingHours'])) $errors[] = "Sleeping Hours per Day is required.";
    if (!isset($_POST['city']) || empty($_POST['city'])) $errors[] = "City is required.";

    if (empty($errors)) {
        $fullName = htmlspecialchars($_POST['fullName']);
        $birthYear = filter_var($_POST['birthYear'], FILTER_SANITIZE_NUMBER_INT);
        $sleepingHours = filter_var($_POST['sleepingHours'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $city = htmlspecialchars($_POST['city']);

        if (!is_numeric($birthYear) || $birthYear < 1900 || $birthYear > date('Y')) {
            $errors[] = "Birth Year must be between 1900 and " . date('Y') . ".";
        }

        if (!is_numeric($sleepingHours) || $sleepingHours < 0 || $sleepingHours > 24) {
            $errors[] = "Sleeping Hours must be between 0 and 24.";
        }

        if (empty($errors)) {
            $currentYear = date('Y');
            $age = $currentYear - $birthYear;
            $totalYearsSleeping = ($sleepingHours * 365 * $age) / 24;

            echo '<div class="mb-6">';
            echo '<h2 class="text-2xl font-semibold neon-text mb-4">User Information</h2>';
            echo '<table class="w-full text-sm text-left border border-pink-500 rounded">';
            echo '<thead class="bg-pink-900/30 text-cyan-200">';
            echo '<tr><th class="p-3 border-b">Field</th><th class="p-3 border-b">Value</th></tr>';
            echo '</thead><tbody class="text-cyan-100">';
            echo "<tr><td class='p-3 border-b'>Full Name</td><td class='p-3 border-b'>{$fullName}</td></tr>";
            echo "<tr><td class='p-3 border-b'>Birth Year</td><td class='p-3 border-b'>{$birthYear}</td></tr>";
            echo "<tr><td class='p-3 border-b'>Sleeping Hours/Day</td><td class='p-3 border-b'>{$sleepingHours} hours</td></tr>";
            echo "<tr><td class='p-3 border-b'>City</td><td class='p-3 border-b'>{$city}</td></tr>";
            echo "<tr><td class='p-3 border-b'>Computed Age</td><td class='p-3 border-b'>{$age} years</td></tr>";
            echo "<tr><td class='p-3'>Total Years Sleeping</td><td class='p-3'>" . number_format($totalYearsSleeping, 2) . " years</td></tr>";
            echo '</tbody></table></div>';

            echo '<div class="bg-pink-800/30 text-cyan-100 border border-pink-400 p-5 rounded-md mb-6">';
            echo '<h3 class="text-lg font-semibold mb-2 neon-text">Messages:</h3>';
            if ($age > 50) echo '<p class="mb-1">• You might want to start planning for retirement.</p>';
            if ($totalYearsSleeping > 15) echo '<p class="mb-1">• You’ve spent a huge part of your life sleeping!</p>';
            if ($city !== "Quezon City") echo '<p class="mb-1">• You don’t live in the best city.</p>';
            else echo '<p class="mb-1">• Quezon City rocks!</p>';
            if ($age <= 25) echo '<p class="mb-1">• You\'re still young, enjoy learning!</p>';
            echo '</div>';
        }
    }

    if (!empty($errors)) {
        echo '<div class="bg-red-500/30 border border-red-300 text-red-100 p-5 rounded-md mb-6">';
        echo '<h3 class="text-lg font-semibold mb-2">Error(s):</h3><ul class="list-disc pl-5">';
        foreach ($errors as $err) echo "<li>{$err}</li>";
        echo '</ul></div>';
    }
    ?>

    <a href="info_form.html" class="block text-center w-full md:w-auto btn-glow text-black font-bold px-6 py-3 mt-4 rounded-lg">⬅ Go Back to Form</a>
  </div>
</body>
</html>
