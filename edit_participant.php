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
    <title>Update Participant Scores - UK E-Sports League</title>
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
                <?php
                //including connection variables   
                include 'dbconnect.php';

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    if($_SERVER['REQUEST_METHOD'] == 'POST') //has the user submitted the form and edited the participant
                    {
                        // UPDATE section
                        $id = $_POST['id'];
                        $kills = $_POST['kills'];
                        $deaths = $_POST['deaths'];
                        
                        // Validate numeric inputs
                        if(!is_numeric($kills) || !is_numeric($deaths) || $kills < 0 || $deaths < 0) {
                            echo '<div class="alert alert-danger">Invalid input. Kills and deaths must be positive numbers.</div>';
                        } else {
                            $updateStmt = $conn->prepare("UPDATE participant SET kills = :kills, deaths = :deaths WHERE id = :id");
                            $updateStmt->bindParam(':kills', $kills);
                            $updateStmt->bindParam(':deaths', $deaths);
                            $updateStmt->bindParam(':id', $id);
                            
                            if($updateStmt->execute()) {
                                echo '<div class="card gaming-card">';
                                echo '<div class="card-body text-center p-5">';
                                echo '<i class="bi bi-check-circle text-success display-3 mb-3"></i>';
                                echo '<h3>Scores Updated Successfully!</h3>';
                                echo '<p class="text-muted">The participant\'s kills and deaths have been updated.</p>';
                                echo '<div class="mt-4">';
                                echo '<a href="view_participants_edit_delete.php" class="btn btn-primary me-2">';
                                echo '<i class="bi bi-arrow-left"></i> Back to Participants';
                                echo '</a>';
                                echo '<a href="edit_participant.php?id=' . $id . '" class="btn btn-secondary">';
                                echo '<i class="bi bi-pencil"></i> Edit Again';
                                echo '</a>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            } else {
                                echo '<div class="alert alert-danger">Failed to update participant scores.</div>';
                            }
                        }
                    }
                    else{
                        // SELECT section
                        if(!isset($_GET['id'])) {
                            echo '<div class="alert alert-danger">No participant ID provided.</div>';
                            echo '<a href="view_participants_edit_delete.php" class="btn btn-primary">Back to Participants</a>';
                        } else {
                            $id = $_GET['id'];
                            
                            $stmt = $conn->prepare("SELECT p.*, t.name as team_name 
                                                   FROM participant p 
                                                   LEFT JOIN team t ON p.team_id = t.id 
                                                   WHERE p.id = :id");
                            $stmt->bindParam(':id', $id);
                            $stmt->execute();
                            $participant = $stmt->fetch(PDO::FETCH_ASSOC);
                            
                            if($participant) {
                                $firstname = $participant['firstname'];
                                $surname = $participant['surname'];
                                $kills = $participant['kills'];
                                $deaths = $participant['deaths'];
                                $team_name = $participant['team_name'];
                                
                                // Include the form
                                ?>
                                <div class="card gaming-card">
                                    <div class="card-header bg-warning text-dark">
                                        <h3 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Participant Scores</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-info mb-4">
                                            <i class="bi bi-info-circle"></i> You can only update the <strong>Kills</strong> and <strong>Deaths</strong> for this participant.
                                        </div>
                                        
                                        <form action="edit_participant.php" method="POST" id="editForm">
                                            <div class="mb-3">
                                                <label class="form-label">Participant Name</label>
                                                <input type="text" class="form-control" disabled value="<?php echo htmlspecialchars($firstname . ' ' . $surname); ?>">
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Team</label>
                                                <input type="text" class="form-control" disabled value="<?php echo htmlspecialchars($team_name ?: 'No Team'); ?>">
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="kills" class="form-label">Kills <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-success text-white"><i class="bi bi-trophy"></i></span>
                                                        <input type="number" 
                                                               class="form-control" 
                                                               id="kills"
                                                               name="kills" 
                                                               value="<?php echo $kills; ?>" 
                                                               min="0" 
                                                               required>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 mb-3">
                                                    <label for="deaths" class="form-label">Deaths <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-danger text-white"><i class="bi bi-x-circle"></i></span>
                                                        <input type="number" 
                                                               class="form-control" 
                                                               id="deaths"
                                                               name="deaths" 
                                                               value="<?php echo $deaths; ?>" 
                                                               min="0" 
                                                               required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Current K/D Ratio</label>
                                                <div class="h4">
                                                    <?php 
                                                    $kdRatio = $deaths > 0 ? number_format($kills / $deaths, 2) : $kills;
                                                    $kdClass = $kdRatio >= 1 ? 'text-success' : 'text-danger';
                                                    echo '<span class="' . $kdClass . '">' . $kdRatio . '</span>';
                                                    ?>
                                                </div>
                                            </div>
                                            
                                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                                            
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <a href="view_participants_edit_delete.php" class="btn btn-secondary">
                                                    <i class="bi bi-x-circle"></i> Cancel
                                                </a>
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="bi bi-save"></i> Update Scores
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                
                                <script>
                                    // Live K/D ratio calculation
                                    document.getElementById('kills').addEventListener('input', calculateKD);
                                    document.getElementById('deaths').addEventListener('input', calculateKD);
                                    
                                    function calculateKD() {
                                        const kills = parseFloat(document.getElementById('kills').value) || 0;
                                        const deaths = parseFloat(document.getElementById('deaths').value) || 0;
                                        const ratio = deaths > 0 ? (kills / deaths).toFixed(2) : kills;
                                        // Update display if needed
                                    }
                                </script>
                                <?php
                            } else {
                                echo '<div class="alert alert-danger">Participant not found.</div>';
                                echo '<a href="view_participants_edit_delete.php" class="btn btn-primary">Back to Participants</a>';
                            }
                        }
                    }
                }
                catch(PDOException $e) {
                    echo '<div class="alert alert-danger">Database error: ' . $e->getMessage() . '</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>