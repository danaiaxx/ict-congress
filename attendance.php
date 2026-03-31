<?php include "db.php"; ?>

<?php
$message = '';
$displayResult = null;

// ===== MARK ATTENDANCE =====
if (isset($_POST['mark'])) {
    $idNum = $_POST['idNum'];
    $check = $conn->query("SELECT * FROM registration WHERE idNum=$idNum");

    if ($check->num_rows == 0) {
        $message = "ID IS NOT YET REGISTERED";
    } else {
        $student = $check->fetch_assoc();
        if ($student['attended'] == 'Yes') {
            $message = "Student's Attendance RECORD ALREADY EXISTS";
        } else {
            $conn->query("UPDATE registration SET attended='Yes' WHERE idNum=$idNum");
            $message = "Student Attendance is SUCCESSFULLY RECORDED";
        }
    }
    // Display only this student after marking
    $displayResult = $conn->query("SELECT * FROM registration WHERE idNum=$idNum");
}

// ===== SEARCH STUDENT =====
elseif (isset($_POST['search'])) {
    $idNum = $_POST['idNum'];
    $displayResult = $conn->query("SELECT * FROM registration WHERE idNum=$idNum");

    if ($displayResult->num_rows == 0) {
        $message = "ID IS NOT YET REGISTERED";
    } else {
        $student = $displayResult->fetch_assoc();
        if ($student['attended'] == 'Yes') {
            $message = "Student's Attendance RECORD ALREADY EXISTS";
        }
        // else: student exists, not marked → no message
        // reset pointer for display
        $displayResult = $conn->query("SELECT * FROM registration WHERE idNum=$idNum");
    }
}

// ===== DEFAULT: SHOW ALL STUDENTS =====
else {
    $displayResult = $conn->query("SELECT * FROM registration");
}
?>

<a href="index.php">Back</a>
<h2>Attendance</h2>

<?php if (!empty($message)): ?>
    <p style="color:blue; font-weight:bold;"><?= $message ?></p>
<?php endif; ?>

<form method="POST">
    Student ID: <input type="number" name="idNum" required>
    <button name="search">Search</button>
</form>

<br>

<table border="1">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Campus</th>
    <th>Amount</th>
    <th>Action</th>
</tr>

<?php while($row = $displayResult->fetch_assoc()): ?>
<tr>
    <td><?= $row['idNum'] ?></td>
    <td><?= $row['studFName'] . " " . $row['studLName'] ?></td>
    <td><?= $row['campus'] ?></td>
    <td><?= $row['amountPaid'] ?></td>
    <td>
        <?php if ($row['attended'] == 'No'): ?>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="idNum" value="<?= $row['idNum'] ?>">
                <button name="mark">Mark Attendance</button>
            </form>
        <?php else: ?>
            Attended
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>