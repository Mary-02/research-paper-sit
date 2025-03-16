<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Research Papers</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f0f0, #dfe7fd);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        main {
            text-align: center;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            width: 50%;
        }

        /* Header */
        h1 {
            color: rgb(0, 142, 152);
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        p {
            color: #333;
            font-size: 18px;
            margin-bottom: 20px;
        }

        /* Buttons */
        .btn {
            background-color: rgb(0, 142, 152);
            color: white;
            padding: 14px 28px;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s ease-in-out;
            margin: 10px;
        }

        .btn:hover {
            background-color: #007780;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <main>
        <h1>Research Papers</h1>
        <p>Welcome! You can add and search for research papers.</p>

        <!-- Buttons -->
        <a href="search.php" class="btn">Search Papers</a>
        <a href="submit.php" class="btn">Add Research Paper</a>
    </main>
</body>
</html>
