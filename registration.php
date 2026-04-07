<?php
include "db.php";
session_start();
?>

<?php
// ===== ADD =====
if (isset($_POST['add'])){
    $idNum = $_POST['idNum'];
    $campus = $_POST['campus'];
    $studFName = $_POST['studFName'];
    $studLName = $_POST['studLName'];
    $amountPaid = $_POST['amountPaid'];

    $check = $conn->query("SELECT * FROM registration WHERE idNum='$idNum' OR 
    (studFName='$studFName' AND studLName='$studLName')");

    if ($check->num_rows > 0) {
            $_SESSION['msg_error'] = 'Student already exists. Please input another.';
    } else {
        $conn->query("INSERT INTO registration (idNum, campus, studFName, studLName, amountPaid, attended)
        VALUES ('$idNum','$campus','$studFName','$studLName','$amountPaid','No')");

        $_SESSION['msg'] = 'Student is successfully ADDED!';

        header("Location: registration.php");
        exit();
    }
}

// ===== DELETE =====
if (isset($_GET['delete'])){
    $idNum = $_GET['delete'];
    $conn->query("DELETE FROM registration WHERE idNum=$idNum");

    $_SESSION['msg'] = 'Student is successfully DELETED!';

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

    $check = $conn->query("SELECT * FROM registration WHERE (idNum='$newidNum' OR 
    (studFName='$studFName' AND studLName='$studLName')) AND idNum != '$idNum'");

    if ($check->num_rows > 0) {
        $_SESSION['msg_error'] = 'Student already exists. Please input another';
    } else {
        $conn->query("UPDATE registration SET 
            idNum='$newidNum',
            campus='$campus',
            studFName='$studFName',
            studLName='$studLName',
            amountPaid='$amountPaid'
            WHERE idNum='$idNum'");

            $_SESSION['msg'] = 'Student is successfully UPDATED!';

        header("Location: registration.php");
        exit();
    }
}

// ===== FETCH =====
$result = $conn->query("SELECT * FROM registration");
?>

    <a href="index.php">Back</a>

<h2>Register a Student</h2>

<! display message !>
<!-- Success Message -->
<?php if (isset($_SESSION['msg'])): ?>
    <div class="alert alert-success" style="color: green;">
        <?= $_SESSION['msg']; unset($_SESSION['msg']); ?>
    </div>
<?php endif; ?>

<!-- Error Message -->
<?php if (isset($_SESSION['msg_error'])): ?>
    <div class="alert alert-danger" style="color: red;">
        <?= $_SESSION['msg_error']; unset($_SESSION['msg_error']); ?>
    </div>
<?php endif; ?>

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