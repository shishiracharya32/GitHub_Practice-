<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login - UK E-Sports League</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-dark">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card gaming-card">
                    <div class="card-body p-5">
                        <?php
                        include 'dbconnect.php';
                        
                        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                            try {
                                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                // Get posted credentials
                                $posted_username = $_POST['username'];
                                $posted_password = $_POST['password'];
                                
                                // Validate input
                                if(empty($posted_username) || empty($posted_password)) {
                                    echo '<div class="alert alert-danger">Please enter both username and password.</div>';
                                    echo '<a href="admin_login.html" class="btn btn-primary">Go Back</a>';
                                } else {
                                    // Check credentials against database
                                    $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username AND password = :password");
                                    $stmt->bindParam(':username', $posted_username);
                                    $stmt->bindParam(':password', $posted_password);
                                    $stmt->execute();
                                    
                                    if($stmt->rowCount() > 0) {
                                        // Login successful
                                        $_SESSION['logged_in'] = true;
                                        $_SESSION['username'] = $posted_username;
                                        
                                        echo '<div class="alert alert-success">Login successful! Redirecting...</div>';
                                        echo '<script>setTimeout(function(){window.location.href="admin_menu.php";}, 1500);</script>';
                                    } else {
                                        // Login failed
                                        echo '<div class="alert alert-danger">Invalid username or password.</div>';
                                        echo '<a href="admin_login.html" class="btn btn-primary">Try Again</a>';
                                    }
                                }
                            }
                            catch(PDOException $e) {
                                echo '<div class="alert alert-danger">Database error: ' . $e->getMessage() . '</div>';
                            }
                        }
                        else{
                            echo '<div class="alert alert-warning">You\'re here by mistake</div>';
                            echo '<a href="index.html" class="btn btn-primary">Go to Homepage</a>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>