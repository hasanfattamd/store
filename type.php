<?php
include 'connection.php';
$insert_error = "";
$update_error = "";
$trash_message = "";

if (isset($_GET['del'])) {
    $query = "DELETE FROM type WHERE id = " . $_GET['del'];
    $result = $conn->query($query);
    header('location:type.php?msg=del');
    if (!$result) {
        $trash_message = "Can't Delete Record! Try again later";
    } else {
        header('location:type.php?msg=del');
    }
}
if (isset($_POST['btnSave'])) {
    if (isset($_GET['id'])) {
        $query = "UPDATE type SET type = '" . $_POST['pType'] . "' WHERE id = "
            . $_GET['id'];
        $result = $conn->query($query);
        if (!$result) {
            $update_error = "Can't Update Record! Try again later";
        } else {
            header('location:type.php?msg=update');
        }
    } else {
        $query = "insert into type(type) VALUES('" . $_POST['pType'] . "')";
        $result = $conn->query($query);
        if (!$result) {
            $insert_error = "Can't Insert Record! Try again later";
        } else {
            header('location:type.php?msg=save');
        }
    }
}

if (isset($_GET['id'])) {
    $query = "SELECT * FROM type WHERE id = " . $_GET['id'];
    $result = $conn->query($query);
    $rowcount = mysqli_fetch_assoc($result);
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Type</title>
</head>
<body>
<?php
if (isset($_GET['type'])){
    ?>
    <!-- Category Insert Form-->
    <h1>Add Product Type</h1>
    <div class="input-form">
        <form method="post">
            Add Product Type: <input type="text" name="pType" value="<?php if (isset($_GET['id'])) {
                echo
                $rowcount['type'];
            } ?>">
            <button style="border: orangered;border-radius: 5px; margin: 10px; padding: 15px 30px 15px 30px ; color:
                white;
                background-color: darkorange" type="submit" name="btnSave">Submit
            </button>
        </form>
    </div>
<?php }else{
?>
<!-- Alert Message -->
<?php
if (isset($_GET['msg'])){
if ($_GET['msg'] == 'save') {
    ?>
    <strong style="color: forestgreen">Record Added Successfully</strong>
<?php } else {
    ?>
    <strong style="color: orangered"><?php echo $insert_error; ?></strong>
<?php } ?>
<br>
<?php
if ($_GET['msg'] == 'update') {
?>
<strong>Record Updated Successfully.
    <?php } else {
        ?>
        <strong style="color: orangered"><?php echo $update_error; ?></strong>
    <?php } ?>
    <br>
    <?php
    if ($_GET['msg'] == 'del') {
        ?>
        <strong style="color: forestgreen">Record Deleted Successfully.</strong>
    <?php } else {
        ?>
        <strong style="color: red"><?php echo $trash_message; ?></strong>

    <?php } ?>
    <?php } ?>
    <!-- Data Display -->
    <div class="display-data">
        <a href="type.php?type=add">
            <button style="border:orangered; border-radius: 0; margin: 10px; padding: 15px; color: white;
                    background-color: #D2001A">
                Add Proudct Type
            </button>
        </a>
        <table border="1" style="border-collapse: collapse;">
            <thead>
            <tr>
                <th>Sr.No</th>
                <th>Product Type</th>
                <th>Action</th>
            </tr>
            </thead>
            <?php
            $count = 1;
            $query = "SELECT * FROM type";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $row['type']; ?></td>
                    <td>
                        <a href="type.php?type=edit&id=<?php echo $row['id']; ?>">
                            <button style="border:#11468F; color: white; background-color: #11468F; border-radius: 0;
                        margin: 10px
                            10px 10px 20px; padding: 15px 30px 15px 30px; ">
                                EDIT
                            </button>
                        </a>
                        <a onclick="return confirm('Are you sure you want to delete this record?')"
                           href="type.php?del=<?php echo $row['id']; ?>">
                            <button style="border: #191919; color: white; background-color: #191919; margin: 10px
                            10px 10px 20px; padding: 15px 30px 15px 30px;">
                                DELETE
                            </button>
                        </a>

                    </td>

                </tr>
            <?php } ?>
        </table>
    </div>
    <?php } ?>
</body>
</html>

