<?php
ini_set('session.gc_maxlifetime', 120);

session_set_cookie_params(120);
session_start();

// If the user wants to log out
if (isset($_GET['logout'])) {
    session_destroy(); // Destroy the session

    // Redirect to index.php after destroying the session
    header("Location: index.php");
    exit();
}

// Check if the user is authenticated
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: index.php"); // Redirect to index.php if not authenticated
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Company Intranet</title>
  <link rel="stylesheet" href="hstyles.css">
</head>
<body>
  <div class="user-profile">
    <p> Welcome, <?php echo $_SESSION['username']; ?></p>
    <a href="?logout=true">Log Out</a>
  </div>
  <header>
    <h1>Welcome to the Company Intranet</h1>
  </header>
  <div class="container">
    <a href="scripts\hive.php" class="tile">
    <img src="images\hive.png" alt="Hive Image" class="tile-image">
      <h2>Hive</h2>
      <p>Collaboration and communication platform.</p>
    </a>
    <a href="scripts\people.php" class="tile">
    <img src="images\people.png" alt="Hive Image" class="tile-image">
      <h2>People System</h2>
      <p>Manage and access employee information.</p>
    </a>

    <a href="scripts\transactions.php" class="tile">
    <img src="images\tran.png" alt="Hive Image" class="tile-image">
  <h2>Transactions</h2>
  <p>View and manage customer transactions.</p>
  </a>
<a href="scripts\account-management.php" class="tile">
<img src="images\user.png" alt="Hive Image" class="tile-image">
  <h2>Account Management</h2>
  <p>Manage customer accounts and settings.</p>
</a>
<a href="scripts\loan-processing.php" class="tile">
<img src="images\loan.png" alt="Hive Image" class="tile-image">
  <h2>Loan Processing</h2>
  <p>Process and track loan applications.</p>
</a>
<a href="scripts\reports.php" class="tile">
<img src="images\report.png" alt="Hive Image" class="tile-image">
  <h2>Reports</h2>
  <p>Access and generate financial reports.</p>
</a>
    <!-- Add more tiles as needed -->
  </div>
</body>
</html>
