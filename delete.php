<?php
session_start();
// Ensure users are logged in to access this page
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
    <title>Delete Participant - UK E-Sports League</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-dark">
    <nav class="navbar navbar-expand-lg navbar-dark gaming-nav">
        <div class="container">
            <a class="navbar-brand" href="admin_menu.php">
                <i class="bi bi-controller"></i> UK E-Sports League Admin
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="admin_menu.php"><i class="bi bi-house"></i> Dashboard</a>
                <a class="nav-link" href="view_participants_edit_delete.php"><i class="bi bi-arrow-left"></i> Back</a>
                <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card gaming-card">
                    <div class="card-body">
                        <?php
                        include 'dbconnect.php';

                        try {
                            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            
                            // DELETE - complete the functionality
                            if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
                                $id = $_POST['id'];
                                
                                // First, get participant details for confirmation message
                                $selectStmt = $conn->prepare("SELECT firstname, surname FROM participant WHERE id = :id");
                                $selectStmt->bindParam(':id', $id);
                                $selectStmt->execute();
                                $participant = $selectStmt->fetch(PDO::FETCH_ASSOC);
                                
                                if($participant) {
                                    // Delete the participant
                                    $deleteStmt = $conn->prepare("DELETE FROM participant WHERE id = :id");
                                    $deleteStmt->bindParam(':id', $id);
                                    
                                    if($deleteStmt->execute()) {
                                        echo '<div class="text-center p-5">';
                                        echo '<i class="bi bi-check-circle text-success display-1 mb-3"></i>';
                                        echo '<h2 class="text-success mb-3">Participant Deleted Successfully</h2>';
                                        echo '<p class="text-white fs-5">Participant <strong>' . htmlspecialchars($participant['firstname'] . ' ' . $participant['surname']) . '</strong> has been removed from the system.</p>';
                                        echo '<div class="mt-4">';
                                        echo '<a href="view_participants_edit_delete.php" class="btn btn-primary btn-lg me-2">';
                                        echo '<i class="bi bi-arrow-left"></i> Back to Participants';
                                        echo '</a>';
                                        echo '<a href="admin_menu.php" class="btn btn-secondary btn-lg">';
                                        echo '<i class="bi bi-house"></i> Dashboard';
                                        echo '</a>';
                                        echo '</div>';
                                        echo '</div>';
                                    } else {
                                        echo '<div class="alert alert-danger">';
                                        echo '<i class="bi bi-x-circle"></i> Failed to delete participant. Please try again.';
                                        echo '</div>';
                                        echo '<a href="view_participants_edit_delete.php" class="btn btn-primary">Back to Participants</a>';
                                    }
                                } else {
                                    echo '<div class="alert alert-warning">';
                                    echo '<i class="bi bi-exclamation-triangle"></i> Participant not found.';
                                    echo '</div>';
                                    echo '<a href="view_participants_edit_delete.php" class="btn btn-primary">Back to Participants</a>';
                                }
                            } else {
                                echo '<div class="alert alert-danger">';
                                echo '<i class="bi bi-x-octagon"></i> Invalid request. No participant ID provided.';
                                echo '</div>';
                                echo '<a href="view_participants_edit_delete.php" class="btn btn-primary">Back to Participants</a>';
                            }
                        }
                        catch(PDOException $e) {
                            echo '<div class="alert alert-danger">';
                            echo '<i class="bi bi-database-x"></i> Database error: ' . $e->getMessage();
                            echo '</div>';
                            echo '<a href="view_participants_edit_delete.php" class="btn btn-primary">Back to Participants</a>';
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