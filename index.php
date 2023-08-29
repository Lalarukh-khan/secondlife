<!DOCTYPE html>
<html>
<head>
    <title>Second Life</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Add more stylesheets or scripts as needed -->
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Create Your Character</h3>
                    </div>
                    <div class="card-body">
                    <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $dbHost = 'localhost';
                            $dbUser = 'root';
                            $dbPass = 'mysql';
                            $dbName = 'secondlife';
                            $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
                            if (!$conn) {
                                die("Database connection failed: " . mysqli_connect_error());
                            }
                            // Process form data
                            $avatarName = $_POST['avatarName'];
                            $appearance = $_POST['appearance'];
                            $clothing = $_POST['clothing'];
                            // Insert data into database
                            $query = "INSERT INTO character_data (avatarName, appearance, clothing) VALUES ('$avatarName', '$appearance', '$clothing')";
                            $result = mysqli_query($conn, $query);
                            if ($result) {
                                echo "<div class='alert alert-success'>Character created successfully!</div>";
                            } else {
                                echo "<div class='alert alert-danger'> Error creating character: ".mysqli_error($conn)."</div>";
                            }
                            mysqli_close($conn);
                        }
                        ?>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="mb-3">
                                <label for="avatarName" class="form-label">Avatar Name:</label>
                                <input type="text" class="form-control" id="avatarName" name="avatarName" required>
                            </div>
                            <!-- Other input fields for appearance, clothing, etc. -->
                            <div class="mb-3">
                                <label for="appearance" class="form-label">Appearance:</label>
                                <textarea class="form-control" id="appearance" name="appearance" rows="4"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="clothing" class="form-label">Clothing:</label>
                                <textarea class="form-control" id="clothing" name="clothing" rows="4"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Character</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
