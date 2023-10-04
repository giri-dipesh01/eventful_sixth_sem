<?php
include("adminheader.php");

if (isset($_POST['update_event'])) {
    $un = $_POST["un"];
    $ud = $_POST["ud"];
    $usd = $_POST["usd"];
    $ued = $_POST["ued"];
    $uo = $_POST["uo"];
    $uc = $_POST["uc"];
    $update_id = $_POST["update_id"];

    // Use prepared statements to prevent SQL injection
    $sql = "UPDATE events SET 
        event_name=?, 
        event_description=?, 
        event_organizers=?, 
        event_startdate=?, 
        event_enddate=?, 
        event_category=? 
        WHERE event_id=?";

    if ($stmt = $connection->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("ssssssi", $un, $ud, $uo, $usd, $ued, $uc, $update_id);

        // Execute the statement
        if ($stmt->execute()) {
            $stmt->close();
            header("Location: events.php");
            exit;
        } else {
            $error_var = "Error updating event details in the database";
            header("Location: updateevents.php?error=$error_var");
            exit;
        }
    } else {
        echo "Error preparing statement: " . $connection->error;
    }
}
?>

<!-- Rest of your HTML and CSS code remains unchanged -->

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
                <legend> Update Event</legend>
                <?php
    if(isset($_POST['update']))
    {
    ?>
    
    <form action="updateevents.php" method="POST" onsubmit="return validateEndDate()">
                        <?php
                 $conn= new mysqli("localhost","root","","eventful");
                if($conn->connect_errno!=0)
                {
                    die("connection failed");
                }
                $id=$_POST['event_updateid'];         
                $sql="SELECT * FROM events WHERE event_id='$id'";
                 if($result = $conn->query($sql))
                { $row = $result->fetch_assoc();}
                $image=$row['event_banner'];
                if (empty($image)) {
                    echo('<img class="banner" src="../banners/default.png" width="300px" height="300px">');
                } else {
                    echo("<img class='banner' src='" . $image . "'>");
                }
                ?>
                    
                 <label for="un">Event Name:- 
                    <input type="text" name="un" id="un" size="100" value="<?php echo $row['event_name'];?>" >
                </label>
                <br> <br>
                <label for="ud">Event Description:- 
                    <textarea name="ud" id="ud" cols="100" rows="5"> <?php echo $row['event_description'];?>
                    </textarea>
                </label>
                <br> <br>
                <label for="uo">Event Organizer:- 
    <select name="uo" id="uo" required>
        <option value='Danfe Student Council' >Danfe Student Council</option><option value='Danfe Sports Club' selected>Danfe Sports Club</option><option value='Danfe Developers Club' >Danfe Developers Club</option><option value='Danfe Media & Entertainment Club' >Danfe Media & Entertainment Club</option><option value='Danfe IOT & Robotics Club' >Danfe IOT & Robotics Club</option><option value='Danfe Designers Club' >Danfe Designers Club</option>    </select>
</label>
                <br> <br>
                <label for="uc">Event Category:- 
    <select name="uc" id="uc">
        <option value='Sports' >Sports</option><option value='Internet of Things' selected>Internet of Things</option><option value='Hackathon' >Hackathon</option><option value='Music & Culutral Events' >Music & Culutral Events</option><option value='Education Fair' >Education Fair</option><option value='Art & Design' >Art & Design</option><option value='Others' >Others</option><option value='Programming' >Programming</option>    </select>
</label>
                <br> <br>
                
                <label for="usd">Event Start Date:- 
    <input type="date" name="usd" id="usd" size="100" min="<?php echo date("Y-m-d");?>" value="<?php echo $row['event_startdate']?>" required>
</label>
<br> <br>
<label for="ued">Event End Date:- 
    <input type="date" name="ued" id="ued" size="100" min="<?php echo date("Y-m-d");?>" value="<?php echo $row['event_enddate']?>" required>
    <span id="date-error" style="color: red;"></span>
</label>
<br> <br>
                <input type="submit" name="update_event" id="update_event" >
                <input type='hidden' name='update_id' id='update_id' value="<?php echo $row['event_id'];?>">
        
        
    </form>
    <form action='deleteevents.php' method='post'>
                <input type='hidden' name='delete_id' value="<?php echo $row['event_id'];?>">
                <input type='submit'value = 'Delete' name='delete'>
        </form>  
        <form action='updatebanner.php' method='post'>
                <input type='hidden' name='banner_id' value='<?php echo $row['event_id'];?>'>
                <input type='submit'value = 'Update Banner' name='banner_update'>
        </form>
    <?php
    }
    ?>
            </fieldset>   
        </div>
    </div>
</section>
<script>
    function validateEndDate() {
        var startDate = new Date(document.getElementById("usd").value);
        var endDate = new Date(document.getElementById("ued").value);
        var dateError = document.getElementById("date-error");

        if (endDate < startDate) {
            dateError.textContent = "End date must be equal to or later than the start date.";
            return false;
        } else {
            dateError.textContent = "";
            return true;
        }
    }

    // Attach the validateEndDate function to the oninput event of the end date input
    document.getElementById("ued").oninput = validateEndDate;
</script>
<script src="script.js"></script>
</body>
</html>