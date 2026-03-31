<?php include "db.php"; ?>
<a href="index.php">Back</a>
<h2>Summary Report</h2>

<?php
// ===== PER CAMPUS SUMMARY =====
$data = $conn->query("
    SELECT 
        campus,
        COUNT(*) as registered,
        SUM(CASE WHEN attended='Yes' THEN 1 ELSE 0 END) as attended,
        SUM(amountPaid) as totalCollection
    FROM registration
    GROUP BY campus
");

// ===== TOTALS =====
$totals = $conn->query("
    SELECT 
        COUNT(*) as totalRegistered,
        SUM(CASE WHEN attended='Yes' THEN 1 ELSE 0 END) as totalAttended,
        SUM(amountPaid) as grandTotal
    FROM registration
")->fetch_assoc();
?>

<table border="1">
<tr>
    <th>Campus</th>
    <th>Registered</th>
    <th>Attended</th>
    <th>Total Collection</th>
</tr>

<?php while($row = $data->fetch_assoc()): ?>
<tr>
    <td><?= $row['campus'] ?></td>
    <td><?= $row['registered'] ?></td>
    <td><?= $row['attended'] ?></td>
    <td><?= $row['totalCollection'] ?? 0 ?></td>
</tr>
<?php endwhile; ?>

<!-- TOTAL ROW -->
<tr>
    <th>TOTAL</th>
    <th><?= $totals['totalRegistered'] ?></th>
    <th><?= $totals['totalAttended'] ?></th>
    <th><?= $totals['grandTotal'] ?? 0 ?></th>
</tr>

</table>

<br>

<!-- DATE GENERATED -->
<p><b>Date Generated:</b> <?= date("F d, Y h:i A") ?></p>