<?php
session_start();

//ensure users are logged in to access this page
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: admin_login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Menu - UK E-Sports League</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body class="bg-dark">
    <nav class="navbar navbar-expand-lg navbar-dark gaming-nav">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-controller"></i> UK E-Sports League Admin
            </a>
            <span class="navbar-text">
                Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
            </span>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card gaming-card">
                    <div class="card-header bg-primary text-white">
                        <h1 class="h3 mb-0"><i class="bi bi-speedometer2"></i> Admin Dashboard</h1>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="admin-menu-item">
                                    <a href="search_form.php" class="text-decoration-none">
                                        <div class="card h-100 hover-effect">
                                            <div class="card-body text-center py-5">
                                                <i class="bi bi-search display-3 text-primary mb-3"></i>
                                                <h5 class="card-title">Search</h5>
                                                <p class="card-text text-muted">Search for teams or participants</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="admin-menu-item">
                                    <a href="view_participants_edit_delete.php" class="text-decoration-none">
                                        <div class="card h-100 hover-effect">
                                            <div class="card-body text-center py-5">
                                                <i class="bi bi-people display-3 text-success mb-3"></i>
                                                <h5 class="card-title">Manage Participants</h5>
                                                <p class="card-text text-muted">View, edit or delete participants</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="admin-menu-item">
                                    <a href="logout.php" class="text-decoration-none">
                                        <div class="card hover-effect bg-danger bg-opacity-10">
                                            <div class="card-body text-center py-3">
                                                <i class="bi bi-box-arrow-right text-danger me-2"></i>
                                                <span class="text-danger fw-bold">Logout</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>