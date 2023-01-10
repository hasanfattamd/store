<?php
include 'connection.php';
$insert_error = "";
$update_error = "";
$trash_error = "";

if (isset($_GET['del'])) {
    $query = "delete from category where id= " . $_GET['del'];
    $result = $conn->query($query);
    if (!$result) {
        $trash_error = "Sorry!Can't Delete the Record! Try again later";
    } else {
        header("location:category.php?msg=del");
    }
}
//get record for update
if (isset($_GET['id'])) {
    $query = "SELECT * FROM category WHERE id =" . $_GET['id'];
    $result = $conn->query($query);
    $rowcount = mysqli_fetch_assoc($result);
}

if (isset($_POST['btnSave'])) {
    if (isset($_GET['id'])) {
        $query = "UPDATE category SET title = '" . $_POST['cTitle'] . "' WHERE id =" . $_GET['id'];
        $result = $conn->query($query);
        if (!$result) {
            $update_error = "Can't Update the Record, Try again later";
        } else {
            header('location:category.php?msg=update');
        }
    } else {
        $query = "insert into category(title) values('" . $_POST['cTitle'] . "')";
        $result = $conn->query($query);
        if (!$result) {
            $insert_error = "Can't inert the Record, Try again later";
        } else {
            header('location:category.php?msg=save');
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Store Product Categories</title>
</head>
<body>
<?php
if (isset($_GET['type'])) {
    ?>
    <!-- Category Insert Form-->
    <a href="category.php">
        <button style="border: #3AB0FF; border-radius: 0; border-color: #3AB0FF; color: white; background-color:
        #3AB0FF; margin: 5px 10px 5px 10px; padding: 25px;">Back to
            Home</button>
    </a><br><br>

    <h1>Add Product Category</h1>
    <div class="input-form">
        <form method="post">
            Add Product Category: <input type="text" name="cTitle" value="<?php if (isset($_GET['id'])) {
                echo
                $rowcount['title'];
            } ?>">
            <button style="border: orangered;border-radius: 5px; margin: 10px; padding: 15px 30px 15px 30px ; color:
                white;
                background-color: darkorange" type="submit" name="btnSave">Submit
            </button>
        </form>
    </div>

<?php } else {
    ?>
    <!-- Alert Message -->
    <?php
    if (isset($_GET['msg'])) {
        if ($_GET['msg'] == 'save') {
            ?>
            <strong style="color: #357C3C">Record Added Successfully!!!</strong><br>
        <?php } else { ?>
            <strong style="color: #CD1818"><?php echo $insert_error; ?></strong>
        <?php }
        if ($_GET['msg'] == 'update') {
            ?>
            <strong style="color: #357C3C">Record Updated Successfully!!!</strong>
        <?php } else {
            ?>
            <strong style="color: #CD1818"><?php echo $update_error; ?></strong>
        <?php }
        if ($_GET['msg'] == 'del') {
            ?>
            <strong style="color: #357C3C">Record Deleted Successfully!!!</strong>
        <?php } else { ?>
            <strong style="color: #CD1818"><?php echo $trash_error; ?></strong>
        <?php }
    } ?>
    <!-- Data Display -->
    <div class="data-display">
        <a href='category.php?type=add'>
            <button style="border: orangered;border-radius: 5px; margin: 10px; padding: 15px; color: dodgerblue;background-color: black">
                Add Product Category
            </button>
        </a>
        <table border="1" style="border-collapse: collapse">
            <thead>
            <tr>
                <th>Sr. No</th>
                <th>Product Category</th>
                <th>Action</th>
            </tr>
            </thead>
            <?php
            $query = "SELECT * FROM category";
            $result = $conn->query($query);
            $count = 1;
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $row['title'] ?></td>
                    <td>
                        <a href="category.php?type=edit&id=<?php echo $row['id'] ?>">Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                        <a onclick="return confirm('Are you sure you want to delete this record?')"
                           href="category.php?del=<?php echo $row['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php }
?>

</body>
</html>
