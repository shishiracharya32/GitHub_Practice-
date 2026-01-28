<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Update participant scores</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <main class="container container-card">
    <div class="card p-4">
      <a class="small-muted" href=".">Back to index</a>
      <h1 class="h5 mt-2">Update participant scores</h1>

      <form action="edit_participant.php" method="POST" class="mt-3">
        <div class="mb-3">
          <label class="form-label">Participant Firstname</label>
          <input type="text" class="form-control" name="firstname" disabled value="<?php echo htmlspecialchars($firstname ?? ''); ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Participant Surname</label>
          <input type="text" class="form-control" name="surname" disabled value="<?php echo htmlspecialchars($surname ?? ''); ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Kills</label>
          <input type="number" min="0" step="0.01" class="form-control" name="kills" value="<?php echo htmlspecialchars($kills ?? '0'); ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Deaths</label>
          <input type="number" min="0" step="0.01" class="form-control" name="deaths" value="<?php echo htmlspecialchars($deaths ?? '0'); ?>" required>
        </div>

        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id ?? ''); ?>">

        <button class="btn btn-primary" type="submit">Update this player</button>
        <a class="btn btn-outline-secondary ms-2" href="view_participants_edit_delete.php">Cancel</a>
      </form>
    </div>
  </main>
</body>
</html>
