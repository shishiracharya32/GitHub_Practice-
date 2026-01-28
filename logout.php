<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to homepage with logout message
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - UK E-Sports League</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-dark">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card gaming-card">
                    <div class="card-body text-center p-5">
                        <i class="bi bi-check-circle text-success display-3 mb-3"></i>
                        <h3>Successfully Logged Out</h3>
                        <p class="text-muted">You have been safely logged out of the admin area.</p>
                        <a href="index.html" class="btn btn-primary">Return to Homepage</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function(){
            window.location.href = "index.html";
        }, 2000);
    </script>
</body>
</html>