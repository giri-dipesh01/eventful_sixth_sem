<?php
include("studentsheader.php");
?>
 <style>
        /* Table Styles */
      table 
      {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
      }

      th, td {
      padding: 10px;
      text-align: left;
      }
      
      
      th {
      background-color: #7fa6d1;
      color: var(--text-color);
      } 

      td {
      background-color: #ffe6ac;
      color: var(--text-color);
      border-bottom: 1px solid var(--border-color);
      }

      tr:nth-child(even) td {
      background-color: var(--box2-color);
      }

      tr:last-child td {
      border-bottom: none;
      }

      tr:hover td {
      background-color: #e6e5e5;
      }

      /* Form Styles */
      form {
      display: inline-block;
      }

      input[type="submit"] {
      background-color: #9784bb;
      color: var(--text-color);
      border: none;
      padding: 5px 10px;
      cursor: pointer;
      }

      input[type="submit"]:hover {
      background-color: var(--box3-color);
      }

      input[type="hidden"] {
      display: none;
      }

    </style>

<body>
    <div class="dash-content">
        <div class="overview">
            <div class="title">
                <i class="uil uil-tachometer-fast-alt"></i>
                <span class="text">Your Reviews</span> <br>    
            </div>
        </div>
        
        <!-- Review Information -->
        <table border='1' width="100%">
        <tr>
            <th style="width:1%">#</th>
            <th style="width:20%">Name</th>
            <th style="width:20%">Event Organizers</th>
            <th style="width:20%">Event Date</th>
            <th style="width:10%">Rated Date</th>
            <th style="width:5%">Rating</th>
            <th style="width:20%">Rating Status</th>
            <th>Action</th> 
        </tr>
        <?php
            $connection = new mysqli("localhost","root","","eventful");
            if($connection->connect_errno != 0){
                die("Connection failed");
            }
            
            $sql = "SELECT * FROM `participation` NATURAL JOIN events WHERE participation.student_email='$email';";
            $i = 1;
            if($result = $connection->query($sql))
            {
                while($row = $result->fetch_assoc())
                {
                    
                    echo 
                    "
                        <tr>
                            <td>".$i++."</td>
                            <td>".$row['event_name']."</td>
                            <td>".$row['event_organizers']."</td>
                            <td>".$row['event_startdate'].' '.$row['event_enddate']."</td>
                            <td>".$row['rated_date']."</td>
                            <td>".$row['rating']."</td>
                            <td>".$row['participation_status']."</td>
                            <td>
                                <form action='readreviews.php' method='post'>
                                    <input type='hidden' value='".$row['participation_id']."' name='review_update'>
                                    <input type='submit' value='View' name='update'>
                                </form>  
                            </td>           
                        </tr>
                    ";
                }
            }
        ?>  
        <tr>
            <th style="width:1%">#</th>
            <th style="width:20%">Name</th>
            <th style="width:20%">Event Organizers</th>
            <th style="width:20%">Event Date</th>
            <th style="width:10%">Rated Date</th>
            <th style="width:5%">Rating</th>
            <th style="width:20%">Rating Status</th>
            <th>Action</th> 
        </tr>    
    </table>
        
    </div>
    </section>
    <script src="script.js"></script>
</body>
</html>