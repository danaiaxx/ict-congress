<?php
error_reporting(0);
ini_set('display_errors', 0);
include "db.php";
?>

<?php
// ===== ADD =====
if (isset($_POST['add'])){
    $idNum = $_POST['idNum'];
    $campus = $_POST['campus'];
    $studFName = $_POST['studFName'];
    $studLName = $_POST['studLName'];
    $amountPaid = $_POST['amountPaid'];

    $conn->query("INSERT INTO registration (idNum, campus, studFName, studLName, amountPaid, attended)
    VALUES ('$idNum','$campus','$studFName','$studLName','$amountPaid','No')");

    header("Location: registration.php");
    exit();
}

// ===== DELETE =====
if (isset($_GET['delete'])){
    $idNum = $_GET['delete'];
    $conn->query("DELETE FROM registration WHERE idNum=$idNum");

    header("Location: registration.php");
    exit();
}

// ===== EDIT FETCH =====
$editData = null;
if (isset($_GET['edit'])){
    $idNum = $_GET['edit'];
    $res = $conn->query("SELECT * FROM registration WHERE idNum=$idNum");
    $editData = $res->fetch_assoc();
}

// ===== UPDATE =====
if (isset($_POST['update'])){
    $idNum = $_POST['id']; //original id

    $newidNum = $_POST['idNum'];
    $campus = $_POST['campus'];
    $studFName = $_POST['studFName'];
    $studLName = $_POST['studLName'];
    $amountPaid = $_POST['amountPaid'];

    $check = $conn->query("SELECT * FROM registration WHERE idNum='$newidNum' AND idNum != '$idNum'");

    if ($check->num_rows > 0) {
        echo "<p style='color:red;'>ID already exists. Please use another ID.</p>";
    } else {
        $conn->query("UPDATE registration SET 
            idNum='$newidNum',
            campus='$campus',
            studFName='$studFName',
            studLName='$studLName',
            amountPaid='$amountPaid'
            WHERE idNum='$idNum'");

        header("Location: registration.php");
        exit();
    }
}

// ===== FETCH =====
$result = $conn->query("SELECT * FROM registration");
?>

<a href="index.php">Back</a>

<h2>Register a Student</h2>

<form method="POST">
<input type="hidden" name="id" value="<?= $editData['idNum'] ?? '' ?>">

Student ID: <input type="text" name="idNum" value="<?= $editData['idNum'] ?? '' ?>" required><br>
First Name: <input type="text" name="studFName" value="<?= $editData['studFName'] ?? '' ?>" required><br>
Last Name: <input type="text" name="studLName" value="<?= $editData['studLName'] ?? '' ?>" required><br>
Campus: <input type="text" name="campus" value="<?= $editData['campus'] ?? '' ?>" required><br>
Amount: <input type="number" name="amountPaid" value="<?= $editData['amountPaid'] ?? '' ?>" required><br><br>

<?php if ($editData): ?>
    <button name="update">Update</button>
<?php else: ?>
    <button name="add">Add</button>
<?php endif; ?>
</form>

<table border="1">
<tr>
    <th>ID#</th>
    <th>Name</th>
    <th>Campus</th>
    <th>Amount</th>
    <th>Actions</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['idNum'] ?></td>
    <td><?= $row['studFName']." ".$row['studLName'] ?></td>
    <td><?= $row['campus'] ?></td>
    <td><?= $row['amountPaid'] ?></td>
    
    <td>
        <a href="registration.php?edit=<?= $row['idNum'] ?>">Edit</a> |
        <a href="registration.php?delete=<?= $row['idNum'] ?>">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>