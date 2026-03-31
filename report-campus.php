<?php include "db.php"; ?>

<a href="index.php">Back</a>
<h2>Report by Campus</h2>

<form method="GET">
<select name="campus">
    <option value="Main">Main</option>
    <option value="Banilad">Banilad</option>
    <option value="LM">LM</option>
</select>
<button>Generate</button>
</form>

<?php
if (isset($_GET['campus'])) {
    $campus = $_GET['campus'];

    $result = $conn->query("SELECT * FROM registration WHERE campus='$campus'");
    ?>

    <table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Campus</th>
        <th>Amount</th>
        <th>Attended</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['idNum'] ?></td>
        <td><?= $row['studFName']." ".$row['studLName'] ?></td>
        <td><?= $row['campus'] ?></td>
        <td><?= $row['amountPaid'] ?></td>
        <td><?= $row['attended'] ?></td>
    </tr>
    <?php endwhile; ?>
    </table>

    <?php
        // Reuse campus filter
        $campusFilter = '';
        if (isset($_GET['campus']) && $_GET['campus'] != '') {
            $campus = $_GET['campus'];
            $campusFilter = "WHERE campus='$campus'";
        }

        // ===== REGISTRANTS =====
        $regStats = $conn->query("
            SELECT COUNT(*) as totalRegistrants, 
                SUM(amountPaid) as totalCollection 
            FROM registration
            $campusFilter
        ");
        $reg = $regStats->fetch_assoc();

        // ===== ATTENDEES =====
        $attFilter = $campusFilter ? $campusFilter . " AND attended='Yes'" : "WHERE attended='Yes'";

        $attStats = $conn->query("
            SELECT COUNT(*) as totalAttendees, 
                SUM(amountPaid) as totalGenerated 
            FROM registration
            $attFilter
        ");
        $att = $attStats->fetch_assoc();
    ?>

<p>
    <b># of Registrants:</b> <?= $reg['totalRegistrants'] ?> |
    <b>Total Collection:</b> <?= $reg['totalCollection'] ?? 0 ?>
</p>

<p>
    <b># of Attendees:</b> <?= $att['totalAttendees'] ?> |
    <b>Total Generated:</b> <?= $att['totalGenerated'] ?? 0 ?>
</p>

<?php } ?>

