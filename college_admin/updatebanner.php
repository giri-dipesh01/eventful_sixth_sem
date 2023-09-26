<?php
include("adminheader.php"); 
$image = '';
if (isset($_POST['bannersubmit']) && isset($_FILES['banner'])) {
    // Get the file details
    $banner_name = $_FILES['banner']['name'];
    $banner_size = $_FILES['banner']['size'];
    $banner_tmp = $_FILES['banner']['tmp_name'];
    $banner_error = $_FILES['banner']['error'];

    // Get the file extension
    $banner_extension = strtolower(pathinfo($banner_name, PATHINFO_EXTENSION));
    $banner_id = $_POST['banner_id'];
    // Allowed file extensions
    $allowed_extensions = array('png', 'jpeg', 'jpg');

    if ($banner_error === 0) {
        if (!in_array($banner_extension, $allowed_extensions)) {
            $error_var = "Invalid file format. Allowed formats: PNG, JPEG, JPG";
            header("Location: updatebanner.php?bannererror=$error_var");
            exit;
        } elseif ($banner_size > 5000000) { // Adjust the size limit as needed
            $error_var = "Sorry, your file is too large. It must be less than 5MB.";
            header("Location: updatebanner.php?bannererror=$error_var");
            exit;
        } else {
            // Get the image dimensions
            $image_info = getimagesize($banner_tmp);
            $image_width = $image_info[0];
            $image_height = $image_info[1];

            // Check image dimensions (adjust the dimensions as needed)
            if ($image_width > 1600 || $image_height > 900) {
                $error_var = "Image dimensions must not exceed 1600x900 pixels.";
                header("Location: updatebanner.php?bannererror=$error_var");
                exit;
            }

            $upload_directory = "../banners/";
            $banner_filename = uniqid() . "_" . $banner_name;
            $target_banner = $upload_directory . $banner_filename;

            if (move_uploaded_file($banner_tmp, $target_banner)) {
                // Update the event banner path in the database
                $sql = "UPDATE events SET event_banner='$target_banner' WHERE event_id='$banner_id'";
                if ($connection->query($sql)) {
                    $success = "Banner updated successfully";
                    header("Location: updateevents.php?bannersuccess=$success");
                    exit;
                } else {
                    $error_var = "Error updating event banner in the database";
                    header("Location: updateevents.php?bannererror=$error_var");
                    exit;
                }
            } else {
                $error_var = "Error uploading the banner";
                header("Location: updateevents.php?bannererror=$error_var");
                exit;
            }
        }
    } else {
        $error_var = "Error uploading the banner. Please try again.";
        header("Location: updateevents.php?bannererror=$error_var");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Event Banner</title>
    <style>
    fieldset {
        border: 1px solid #ccc;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        background-color: #fff;
    }

    legend {
        font-size: 1.2em;
        font-weight: bold;
        margin-bottom: 10px;
    }

    label {
        display: block;
        margin-bottom: 15px;
        font-weight: bold;
    }

    input[type="text"],
    textarea,
    select,
    input[type="date"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 10px;
        font-size: 14px;
    }

    textarea {
        resize: vertical;
    }

    input[type="submit"] {
        background-color: #9784bb;
        color: #fff;
        border: none;
        padding: 12px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
        background-color: #7f679e;
    }

    /* Improved form layout */
    .form-row {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .form-label {
        flex: 1;
        padding-right: 10px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            align-items: flex-start;
        }

        input[type="submit"] {
            width: 100%;
        }
    }
    /* Custom file input styling */
.file-input-container {
    position: relative;
    display: inline-block;
    overflow: hidden;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #fff;
}

.file-input-label {
    display: block;
    padding: 10px 15px;
    cursor: pointer;
}

.file-input {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}
</style>
</head>
<body>
    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div>
            <img src="images/profile.jpg" alt="">
        </div>
        <div class="dash-content">
            <div class="activity">
                <div class="title">
                    <i class="uil uil-clock-three"></i>
                    <span class="text">Events</span>
                </div>
                <fieldset>
                    <legend>Update Event Banner</legend>
                    <?php
                    if (isset($_POST['banner_update'])) {
                        $id = $_POST['banner_id'];
                        
                        $sql ="SELECT * FROM events  WHERE event_id='$id'";
                        $result = $connection->query($sql);

                        if ($result && $result->num_rows > 0) {
                            $data = $result->fetch_assoc();
                            $image = $data['event_banner'];
                            $name = $data['event_name'];
                            $banner_uid = $data['event_id'];
                        }
                    
                    ?>
                    <div class="idcard">
                        <?php
                        if (empty($image)) {
                            echo('<img class="banner" src="../banners/default.png" width="300px" height="300px">');
                        } else {
                            echo("<img class='banner' src='" . $image . "'>");
                        }
                        ?>
                        <p><?php echo isset($name) ? $name : ''; ?></p>
                    </div>
                    <?php if (isset($_GET['bannererror'])) : ?>
                        <p><?php echo $_GET['bannererror']; ?></p>
                    <?php elseif (isset($_GET['bannersuccess'])) : ?>
                        <p><?php echo $_GET['bannersuccess']; ?></p>
                    <?php endif ?>
                    <form action="updatebanner.php" method="post" enctype="multipart/form-data">
                        <label for="banner">Choose Event Banner:</label>
                        <span>Recommended 16:9 ratio (1600x900 is best) and < 5 MB </span> <br> <br>
                        <input type="file" name="banner" id="banner" accept=".png, .jpeg, .jpg">
                        <input type='hidden' name='banner_id' id='banner_id' value='<?php echo isset($banner_uid) ? $banner_uid : ''; ?>'>
                        <input type="submit" name="bannersubmit" value="Upload">
                    </form>
                    </fieldset>
            </div>
        </div>
        <?php
    }
    ?>
    </section>
    <!-- Add your JavaScript file if needed -->
    <script src="script.js"></script>
</body>
</html>