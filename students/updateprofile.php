<?php
include("studentsheader.php");
if (isset($_POST['submit']) && isset($_FILES['my_file'])) {
    // Get the file details
    $file_name = $_FILES['my_file']['name'];
    $file_size = $_FILES['my_file']['size'];
    $tmp_name = $_FILES['my_file']['tmp_name'];
    $error = $_FILES['my_file']['error'];

    // Get the file extension
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    // Allowed file extensions
    $allowed_extensions = array('png', 'jpeg', 'jpg');

    if ($error == 0) {
        if (!in_array($file_extension, $allowed_extensions)) {
            $error_var = "Invalid file format. Allowed formats:PNG, JPEG, JPG";
            header("Location: updateprofile.php?error=$error_var");
            exit;
        } elseif ($file_size >2000000) {
            $error_var = "Sorry, your file is too large, it must be less than 2MB";
            header("Location: updateprofile.php?error=$error_var");
            exit;
        } else {
            // Get the image dimensions
            $image_info = getimagesize($tmp_name);
            $image_width = $image_info[0];
            $image_height = $image_info[1];

            // Check image dimensions
            if ($image_width > 350 || $image_height > 350) {
                $error_var = "Image dimensions must not exceed 350px in width and height";
                header("Location: updateprofile.php?error=$error_var");
                exit;
            }

            $upload_directory = "../profile/";
            $target_file =$upload_directory.$file_name;

            if (move_uploaded_file($tmp_name, $target_file)) {
                // Update the database with the file information
                $sql = "UPDATE students_profile SET photo='$target_file' WHERE email='$email'";
                if ($connection->query($sql) === true) {
                    $success = "File uploaded successfully";
                    header("Location: updateprofile.php?success=$success");
                    exit;
                } else {
                    $error_var = "Error uploading the file to the database. Please try again.";
                    header("Location: updateprofile.php?error=$error_var");
                    exit;
                }
            } else {
                $error_var = "Error uploading the file";
                header("Location: updateprofile.php?error=$error_var");
                exit;
            }
        }
    } else {
        $error_var = "Error uploading the file. Please try again.";
        header("Location: updateprofile.php?error=$error_var");
        exit;
    }
}
if (isset($_POST['cardsubmit']) && isset($_FILES['card'])) {
    // Get the file details
    $file_name = $_FILES['card']['name'];
    $file_size = $_FILES['card']['size'];
    $tmp_name = $_FILES['card']['tmp_name'];
    $error = $_FILES['card']['error'];

    // Get the file extension
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Allowed file extensions
    $allowed_extensions = array('png', 'jpeg', 'jpg');

    if ($error == 0) {
        if (!in_array($file_extension, $allowed_extensions)) {
            $error_var = "Invalid file format. Allowed formats:PNG, JPEG, JPG";
            header("Location: updateprofile.php?carderror=$error_var");
            exit;
        } elseif ($file_size >2000000) {
            $error_var = "Sorry, your file is too large, it must be less than 2MB";
            header("Location: updateprofile.php?carderror=$error_var");
            exit;
        } else {
            // Get the image dimensions
            $image_info = getimagesize($tmp_name);
            $image_width = $image_info[0];
            $image_height = $image_info[1];

            // Check image dimensions
            if ($image_width > 600|| $image_height > 600) {
                $error_var = "Image dimensions must not exceed 600px in width and height";
                header("Location: updateprofile.php?carderror=$error_var");
                exit;
            }

            $upload_directory = "../card/";
            $target_file = $upload_directory.$file_name;

            if (move_uploaded_file($tmp_name, $target_file)) {
                // Update the database with the file information
                $sql = "UPDATE students_profile SET id_card='$target_file' WHERE email='$email'";
                if ($connection->query($sql) === true) {
                    $cardsuccess = "File uploaded successfully";
                    header("Location: updateprofile.php?success=$cardsuccess");
                    exit;
                } else {
                    $carderror_var = "Error uploading the file to the database. Please try again.";
                    header("Location: updateprofile.php?error=$carderror_var");
                    exit;
                }
            } else {
                $carderror_var = "Error uploading the file";
                header("Location: updateprofile.php?error=$carderror_var");
                exit;
            }
        }
    } else {
        $error_var = "Error uploading the id card. Please try again.";
        header("Location: updateprofile.php?error=$carderror_var");
        exit;
    }
}
?>
    <div class="dash-content">
    <div class="activity">
            <div class="title">
                <a href="updatepassword.php"><span class="text">Update Password</span> </a>
            </div>
        </div>
        <div class="activity">
            <div class="title">
                <i class="uil uil-clock-three"></i>
                <span class="text">Update Photo</span> 
            </div>
        </div>
    </div>  
    <div>
        <div>
            <div class="passport">
                <form action="updateprofile.php" method="post" enctype="multipart/form-data">
                <div>
                    <?php
                    $sql = "SELECT * FROM students s NATURAL JOIN students_profile p WHERE s.email='$email' AND p.email='$email'";
                    $result = $connection->query($sql);// query execution

                    if ($result && $result->num_rows > 0) {
                        $data = $result->fetch_assoc();
                        if ($data['photo'] == '') {
                            echo('<img class="profile-pic" src="../profile/default.png">');
                        } else {
                            echo ("<img class='profile-pic' src='" . $data['photo'] . "'>");
                        }
                    } else {
                        echo('<img class="profile-pic" src="../profile/default.png">');
                    }
                    ?>
                </div>
                <div class="p-image">
                    <?php if (isset($_GET['error'])) : ?>
                        <p><?php echo $_GET['error']; ?></p>
                    <?php elseif (isset($_GET['success'])) : ?>
                        <p><?php echo $_GET['success']; ?></p>
                    <?php endif ?>
                    <label for="my_file">Choose Passort Size Photo:</label>
                    <span>350 px *350 px, MAX Size 2MB </span> <br> <br>
                    <input type="file" name="my_file" id="my_file" accept=".pdf, .png, .jpeg, .jpg" onchange="validateImage(this)">
                    <input type="submit" name="submit" value="Upload">
                </div>
                </form> 
                <br> <br>
                <div class="dash-content">
                    <div class="activity">
                        <div class="title">
                            <i class="uil uil-clock-three"></i>
                            <span class="text">Update ID CARD</span> 
                        </div>
                    </div>
                </div> 
                    <div class="idcard">
                        <form  action="updateprofile.php" method="post" enctype="multipart/form-data">
                        <div>
                        <?php
                        $sql = "SELECT * FROM students s NATURAL JOIN students_profile p WHERE s.email='$email' AND p.email='$email'";
                        $result = $connection->query($sql);// query execution

                        if ($result && $result->num_rows > 0) {
                        $data = $result->fetch_assoc();
                        if ($data['id_card'] == '') {
                            echo('<img class="profile-pic" src="../profile/default.png">');
                        } else {
                            echo ("<img class='profile-pic' src='" . $data['id_card'] . "'>");
                        }
                        } else {
                        echo('<img class="profile-pic" src="../profile/default.png">');
                        }
                        ?>
                    </div>
                    <div class="p-image">
                    <?php if (isset($_GET['carderror'])) : ?>
                        <p><?php echo $_GET['carderror']; ?></p>
                    <?php elseif (isset($_GET['cardsuccess'])) : ?>
                        <p><?php echo $_GET['cardsuccess']; ?></p>
                    <?php endif ?>
                    <label for="my_file">Choose ID CARD Photo:</label>
                    <span>600 px *600 px, MAX Size 2MB </span> <br> <br>
                    <input type="file" name="card" id="card" accept=".png, .jpeg, .jpg" onchange="validateImage(this)">
                    <input type="submit" name="cardsubmit" value="Upload">
                    </div>
                    </form>
                    </div>
            </div>     
        </div>
    </div>  
</section>
<script src="script.js"></script>
</body>
</html>