<?php include 'db.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Research Paper</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script>
        function addBibField() {
            var container = document.getElementById("bibContainer");
            var input = document.createElement("textarea");
            input.name = "bib[]"; 
            input.placeholder = "Bibliography";
            input.required = true;
            input.classList.add("form-control");
            container.appendChild(input);
        }
    </script>
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #eef2f3, #dfe7fd);
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

        h1 {
            color: rgb(0, 142, 152);
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        label {
            font-weight: 500;
            display: block;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .btn {
            background-color: rgb(0, 142, 152);
            color: white;
            padding: 14px 28px;
            font-size: 16px;
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

        .upload-btn {
            display: inline-block;
            background-color: rgb(149, 149, 149);
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
        }

        .success {
            color: green;
            font-weight: 600;
            margin-top: 10px;
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
        <h1>Add Research Paper</h1>
        <form action="submit.php" method="post" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="form-control" required>

            <label for="author">Author</label>
            <input type="text" id="author" name="author" class="form-control" required>

            <label for="keywords">Keywords</label>
            <input type="text" id="keywords" name="keywords" class="form-control" placeholder="Enter keywords (comma separated)" required>

            <label for="bib">Bibliography</label>
            <div id="bibContainer">
                <textarea name="bib[]" class="form-control" placeholder="Enter bibliography" required></textarea>
            </div>
            <button type="button" class="btn" onclick="addBibField()">+ Add More Bibliographies</button>

            <label for="pdf" class="upload-btn">Upload PDF</label>
            <input type="file" id="pdf" name="pdf" accept=".pdf" class="form-control" required>

            <button type="submit" name="submit" class="btn">Submit</button>
        </form>
    </main>
</body>
</html>

<?php
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $keywords = $_POST['keywords'];
    $bibs = $_POST['bib']; // Array of bibliographies
    $bibString = implode("; ", $bibs);

    // File upload handling
    $pdf = $_FILES['pdf'];

    if ($pdf['error'] == 0) {
        $uploadDir = 'uploads/';
        $fileExtension = pathinfo($pdf['name'], PATHINFO_EXTENSION);
        
        if ($fileExtension == 'pdf') {
            $fileName = uniqid() . '.' . $fileExtension;
            $filePath = $uploadDir . $fileName;
            
            if (move_uploaded_file($pdf['tmp_name'], $filePath)) {
                $sql = "INSERT INTO papers (title, author, keywords, bib, pdf) VALUES ('$title', '$author', '$keywords', '$bibString', '$filePath')";
                
                if ($conn->query($sql) === TRUE) {
                    echo "<p class='success'>Paper submitted successfully!</p>";
                } else {
                    echo "<p class='error'>Error: " . $conn->error . "</p>";
                }
            } else {
                echo "<p class='error'>Error uploading the PDF file.</p>";
            }
        } else {
            echo "<p class='error'>Only PDF files are allowed.</p>";
        }
    } else {
        echo "<p class='error'>Error: " . $pdf['error'] . "</p>";
    }
}
?>
