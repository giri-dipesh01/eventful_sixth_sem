<?php
    if(isset($_POST['delete']))
    {
        $connection=new mysqli("localhost","root","","eventful");
        if($connection->connect_errno!=0)
        {
        echo("Connection Error");
        }
        $id=$_POST['delete_id'];
        $sql="DELETE FROM events WHERE event_id='$id'";
        if($result=$connection->query($sql))
        {
            header("Location:events.php");
        }
        else{
        echo("Error");
        }
    }
?>