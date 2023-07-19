<?php
include("studentsheader.php");
?>
    <div class="dash-content">
        <div class="overview">
            <div class="title">
                <i class="uil uil-tachometer-fast-alt"></i>
                <span class="text">
                <?php 
                    date_default_timezone_set("Asia/Kathmandu");  
                    $h = date('G');
                    if($h>=5 && $h<=11)
                    {
                        echo ("Good Morning $full_name!");
                    }
                    else if($h>=12 && $h<=15)
                    {
                        echo ("Good Afternoon $full_name!");
                    }
                    else
                    {
                        echo ("Good Evening $full_name!");
                    }
                ?>
                </span>
            </div>
        </div>
            <div class="activity">
                <div class="title">
                    <i class="uil uil-clock-three"></i>
                    <span class="text">List of Events of Your Interests</span> 
                </div>
            </div>
    </div> 
</section>
<script src="script.js"></script>
</body>
</html>