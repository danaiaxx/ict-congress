<?php include "db.php"; ?>
<a href="index.php">Back</a>
<h2>Raffle</h2>

<!-- Campus Filter Form -->
<form method="GET">
    Select Campus: 
    <select name="campus">
        <option value="">All</option>
        <option value="main" <?= (isset($_GET['campus']) && $_GET['campus'] == 'main') ? 'selected' : '' ?>>Main</option>
        <option value="banilad" <?= (isset($_GET['campus']) && $_GET['campus'] == 'banilad') ? 'selected' : '' ?>>Banilad</option>
        <option value="lm" <?= (isset($_GET['campus']) && $_GET['campus'] == 'lm') ? 'selected' : '' ?>>LM</option>
    </select>
    <button type="submit">Pick Winner</button>
</form>

<?php
// Prepare the query
$campusFilter = '';
if (isset($_GET['campus']) && $_GET['campus'] != '') {
    $campus = $_GET['campus'];
    $campusFilter = " AND campus='$campus'";
}

// Select a random attendee (filtered by campus if set)
$winner = $conn->query("SELECT * FROM registration WHERE attended='Yes' $campusFilter ORDER BY RAND() LIMIT 1");

if ($winner->num_rows > 0) {
    $w = $winner->fetch_assoc();
    echo "<h3>Winner: ".$w['studFName']." ".$w['studLName']."</h3>";
    echo "Campus: ".$w['campus'];
} else {
    echo "<p>No attendees yet for this selection.</p>";
}
?>