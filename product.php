<?php
include "connection.php";
$insert_error = "";
$update_error = "";
$trash_error = "";

if (isset($_POST['btnSave'])) {
    if (isset($_GET['id'])) {
        $get_image_name = $_FILES['image']['name'];
        $destination = "uploads/" . $_FILES['image']['name'];
        if ($get_image_name != "") {
            $get_image_name = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        } else {
            $get_image_name = $_POST['optimage'];
        }
        $query = "UPDATE product SET name = '" . $_POST['proname'] . "', image = '" . $get_image_name . "', catid = '"
            . $_POST['category'] . "', typeid = '" . $_POST['type'] . "' WHERE id=" . $_GET['id'];
        $result = $conn->query($query);
        if (!$result) {
            $update_error = "Sorry, Can't Update the Record!!!";
        } else {
            header('location:product.php?msg=update');
        }
    } else {
        // $_POST['image'] = $_FILES['image']['name'];
        //File Path
        $destination = "uploads/" . $_FILES['image']['name'];
        //Get the name of Image
        $get_image_name = $_FILES['image']['name'];
        //Image File Path
        move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        $query = "INSERT into product(name, image, catid, typeid) VALUES ('" . $_POST['proname'] . "', '" . $get_image_name . "', '"
            . $_POST['category'] . "', '" . $_POST['type'] . "')";
        $result = $conn->query($query);
        if (!$result) {
            $insert_error = "Sorry, Can't Insert Record!!!";
        } else {
            header('location:product.php?msg=save');
        }
    }
}
//Get Record for Update
if (isset($_GET['id'])) {
    $query = "SELECT * FROM product WHERE id=" . $_GET['id'];
    $result = $conn->query($query);
    $arr = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF - 8">
    <meta name="viewport" content="width = device - width, initial - scale = 1.0">
    <meta http-equiv="X - UA - Compatible" content="ie = edge">
    <title>Product</title>
</head>
<body>
<?php
if (isset($_GET['type'])) {
    ?>""
    <div class="data-form">
        <a href="product.php">
            <button style="border: #3AB0FF; border-radius: 0; border-color: #3AB0FF; color: white; background-color:
        #3AB0FF; margin: 5px 10px 5px 10px; padding: 25px;">Back to
                Home
            </button>
        </a>
        <h1> Add Product </h1>
        <form method="post" enctype="multipart/form-data">
            Enter Product Name: <input type="text" name="proname" value="<?php if (isset($_GET['id'])) {
                echo $arr['name'];
            } ?>">
            <br>
            <br>
            <label for="image"> Upload Image:</label>
            <input type="file" name="image" value="<?php if (isset($_GET['id'])) {
                echo $arr['image'];
            } ?>">
            <input type="hidden" name="optimage" value="<?php if (isset($_GET['id'])) {
                echo $arr['image'];
            } ?>">
            <img alt="image" src="uploads/<?php if (isset($_GET['id'])) {
                echo $arr['image'];
            } ?>" height="200" width="200">
            <br>
            <br>
            <label for="cars"> Select Category:</label>
            <select name="category">
                <?php 
                $query = "SELECT * FROM category";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <option <?php
                    if (isset($_GET['id'])) {
                        if ($row['id'] == $arr['catid']) {
                            echo "selected";
                        }
                    } ?> value="<?php echo $row['id'] ?>"><?php echo $row['title']; ?></option>
                <?php } ?>
            </select>
            <br>
            <br>
            <label for="type"> Select Type:</label>
            <select name="type">
                <?php
                $query = "SELECT * FROM type";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <option <?php if (isset($_GET['id'])) {
                        if ($row['id'] == $arr['typeid']) {
                            echo "selected";
                        }
                    }
                    ?> value="<?php echo $row['id']; ?>"><?php echo $row['type']; ?></option>
                <?php } ?>
            </select>
            <br>
            <br>
            <button type="submit" style="border: #D82148; border-radius: 0;background-color: #D82148;
            color: white; padding: 15px 30px 15px 30px; font - weight: 700;" name="btnSave">Submit
            </button>
        </form>
    </div>

<?php } else {
    ?>
    <!-- Data Display -->
    <div class="data-display">
        <a href="product.php?type=add">
            <button style="border: #FF1818; border-radius: 0; background-color: #FF1818; padding: 10px 20px 10px
            20px; margin: 5px 10px 5px 10px; color: white">
                Add new product
            </button>
        </a>
        <table border="1" style="border-collapse: collapse">
            <thead>
            <tr>
                <th>Name</th>
                <th>Image</th>
                <th>Category</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
            </thead>
            <?php
            $query = "SELECT p.*,(SELECT c.title FROM category as c WHERE c.id=p.catid) as catname,(SELECT t.type FROM type as t WHERE t.id=p.typeid) as typename FROM product as p";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><img src="uploads/<?php echo $row['image']; ?>" height=100 width="100"></td>
                    <td><?php echo $row['catname']; ?></td>
                    <td><?php echo $row['typename']; ?></td>
                    <td>
                        <a href="product.php?type=edit&id=<?php echo $row['id'] ?>">
                            <button style="border: #11468F; background-color:#11468F; border-radius: 5px; color: white;
                             padding:10px 40px 10px 40px; font-size:16px; margin: 5px;">
                                Edit
                            </button>
                            <a onclick="return confirm('Are you sure you want to delete this record?')"
                               href="category.php?del=<?php echo $row['id'] ?>">
                                <button style="border: #DA1212; background-color:#DA1212; border-radius: 5px; color:
                                white; padding:10px 40px 10px 40px; font-size:16px; margin: 5px;">
                                    Delete
                                </button>
                            </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php }
?>
</body>
</html>
