<?php
include("adminheader.php");

if (isset($_POST["event_entry"])) {
    $event_name = $_POST["event_name"];
    $event_description = $_POST["event_description"];
    $event_startdate = $_POST["event_startdate"];
    $event_enddate = $_POST["event_enddate"];
    $event_organizers = $_POST["event_organizers"];
    $event_category = $_POST["event_category"];
    echo $event_category.$event_organizers;

    $sql = "INSERT INTO events(event_name, event_description, event_organizers, event_startdate, event_enddate, event_category) 
            VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $connection->prepare($sql)) 
    {
        $stmt->bind_param("ssssss", $event_name, $event_description, $event_organizers, $event_startdate, $event_enddate, $event_category);

        if ($stmt->execute()) 
        {
            $stmt->close();
            header("Location:events.php");
            exit();
        } 
        else
        {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } 
    else 
    {
        echo "Error preparing statement: " . $connection->error;
    }
}
?>
<style>
    fieldset {
        border: 1px solid #ccc;
        padding: 20px;
        margin-bottom: 20px;
    }

    legend {
        font-size: 1.2em;
        font-weight: bold;
        margin-bottom: 10px;
    }

    label {
        display: block;
        margin-bottom: 15px;
    }

    input[type="text"],
    textarea,
    select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    input[type="date"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    input[type="submit"] {
        background-color: #9784bb;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #7f679e;
    }
    a button {
        background-color: #9784bb;
        color: #fff;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
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
                <span class="text">Add Events</span> 
            </div>
            <a href="events.php"><button>View All Events</button></a>
            <br> <br>
            <fieldset>
            
            <legend> Insert Event</legend>
            
                <form action="insertevents.php" method="post" onsubmit="return validateForm()">
                <label for="event_name">Event Name:- 
                    <input type="text" name="event_name" id="event_name" size="100" required>
                </label>
                <br> <br>
               
                <br> <br>
                <label for="event_description">Event Description:- 
                    <textarea name="event_description" id="event_description" cols="100" rows="5" required>
                    </textarea>
                </label> <br> <br>
                 <label for="event_category">Event Category:- 
    <select name="event_category" id="event_category" required>
        <option value='Sports'>Sports</option><option value='Internet of Things'>Internet of Things</option><option value='Hackathon'>Hackathon</option><option value='Music & Culutral Events'>Music & Culutral Events</option><option value='Education Fair'>Education Fair</option><option value='Art & Design'>Art & Design</option><option value='Others'>Others</option><option value='Programming'>Programming</option>    </select>
</label>
                <br> <br>
                <label for="event_organizers">Event Organizer:- 
                <select name="event_organizers" id="event_organizers" required>
                <option value='Danfe Student Council'>Danfe Student Council</option><option value='Danfe Sports Club'>Danfe Sports Club</option><option value='Danfe Developers Club'>Danfe Developers Club</option><option value='Danfe Media & Entertainment Club'>Danfe Media & Entertainment Club</option><option value='Danfe IOT & Robotics Club'>Danfe IOT & Robotics Club</option><option value='Danfe Designers Club'>Danfe Designers Club</option>                </select>
                </label>
                <br> <br>
                <label for="event_startdate">Event Start Date:- 
                    <input type="date" name="event_startdate" id="event_startdate" size="100" min="<?php echo date("Y-m-d"); ?>" required>
                </label>
                <br> <br>
                <label for="event_enddate">Event End Date: 
                        <input type="date" name="event_enddate" id="event_enddate" size="100" min="<?php echo date("Y-m-d"); ?>" required>
                        <span id="date-error" style="color: red;"></span>
                    </label>
                    <br> <br>

                    <input type="submit" name="event_entry" id="event_entry">
                </form>
            </fieldset>
        </div>
    </div>
</section>
<script>
    function validateEndDate() {
        var startDate = new Date(document.getElementById("event_startdate").value);
        var endDate = new Date(document.getElementById("event_enddate").value);
        var dateError = document.getElementById("date-error");

        if (endDate <= startDate) {
            dateError.textContent = "End date must be greater than the start date.";
            return false;
        } else {
            dateError.textContent = "";
            return true;
        }
    }

    function validateForm() {
        return validateEndDate();
    }
</script>
<script src="script.js"></script>
</body>
</html>