<?php include 'db.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Research Papers</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #eef2f3, #dfe7fd);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
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

        h1 {
            color: rgb(0, 142, 152);
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .search-box {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
        }

        .search-input {
            width: 70%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        .btn {
            background-color: rgb(0, 142, 152);
            color: white;
            padding: 12px 20px;
            border: none;
            font-size: medium;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s ease-in-out;
        }

        .btn:hover {
            background-color: #007780;
            transform: scale(1.05);
        }

        .results {
            margin-top: 20px;
        }

        .result-item {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .error {
            color: red;
            font-weight: 600;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <main>
        <h1>Research Paper Search</h1>

        <form action="search.php" method="get" class="search-box">
            <input type="text" name="query" class="search-input" placeholder="Search by keywords" required>
            <button type="submit" class="btn">Search</button>
        </form>

        <div class="results">
            <?php
            if (isset($_GET['query'])) {
                $query = trim($_GET['query']);

                // Secure query using prepared statement
                $sql = "SELECT * FROM papers WHERE keywords LIKE ? OR title LIKE ?";
                $stmt = $conn->prepare($sql);
                $likeQuery = "%$query%";
                $stmt->bind_param("ss", $likeQuery, $likeQuery);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='result-item'>";
                        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                        echo "<p><strong>Author:</strong> " . htmlspecialchars($row['author']) . "</p>";
                        echo "<p><strong>Keywords:</strong> " . htmlspecialchars($row['keywords']) . "</p>";
                        echo "<p><strong>Bibliography:</strong> " . nl2br(htmlspecialchars($row['bib'])) . "</p>";

                        // Check if PDF exists and create a download link
                        if (!empty($row['pdf']) && file_exists($row['pdf'])) {
                            echo "<p><a href='" . htmlspecialchars($row['pdf']) . "' target='_blank' class='btn'>Download PDF</a></p>";
                        } else {
                            echo "<p><strong>No PDF available.</strong></p>";
                        }

                        echo "</div>";
                    }
                } else {
                    echo "<p class='error'>No results found.</p>";
                }
            }
            ?>
        </div>
    </main>
</body>
</html>
