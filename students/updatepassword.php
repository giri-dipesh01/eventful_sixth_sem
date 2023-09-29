<?php
include("studentsheader.php");

$successMessage = '';
$errorMessage = '';

if (isset($_POST['update'])) {
    // Assuming you have a database connection established
    $connection = new mysqli("localhost", "root", "", "eventful");

    // Check for database connection errors
    if ($connection->connect_errno != 0) {
        die("Database Connectivity Error");
    }

    // Retrieve user input
    $oldPassword = md5($_POST["password"]);
    $newPassword = md5($_POST["new"]);
    $confirmNewPassword = md5($_POST["newp"]);

    // Fetch the old password from the database using prepared statement
    $email = $_SESSION['students']['email'];
    $sql = "SELECT password FROM students WHERE email = ?";
    $stmt = $connection->prepare($sql);

    // Bind parameters and execute
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $dbPassword = $row['password'];

        // Check if the old password matches the database password
        if ($dbPassword == $oldPassword) {
            // Check if the new password and confirm new password match
            if ($newPassword == $confirmNewPassword) {
                // Update the password in the database using prepared statement
                $updateSql = "UPDATE students SET password = ? WHERE email = ?";
                $updateStmt = $connection->prepare($updateSql);
                $hashedNewPassword = md5($newPassword); // Use appropriate hashing method
                $updateStmt->bind_param("ss", $hashedNewPassword, $email);
                $updateResult = $updateStmt->execute();

                if ($updateResult) {
                    // Password updated successfully
                    $successMessage = "Password updated successfully";

                    // Destroy the session
                    session_destroy();

                    // Redirect to the login page
                    header("Location: ../index.php");
                    exit(); // Ensure that no further code is executed after the redirect
                } else {
                    // Error updating password in the database
                    $errorMessage = "Error updating password";
                }
            } else {
                // New password and confirm new password do not match
                $errorMessage = "New Password is not the same as Confirm Password";
            }
        } else {
            // Old password does not match the database password
            $errorMessage = "Old password is incorrect";
        }
    } else {
        // Error fetching old password from the database
        $errorMessage = "Error fetching old password from the database";
    }

    // Close the prepared statements and the database connection
    $stmt->close();

    // Check if $updateStmt is initialized before closing
    if ($updateStmt instanceof mysqli_stmt) {
        $updateStmt->close();
    }

    $connection->close();
}
?>
<style>
    /* Styles for the password update form */
.dash-content {
  padding: 20px;
}

.column {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.input-box {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 5px;
}

input[type="password"] {
  width: 100%;
  padding: 10px;
  box-sizing: border-box;
  border: 1px solid #ccc;
  border-radius: 5px;
}

/* Styles for the submit button */
input[type="submit"] {
  background-color: #9784bb;
  color: #fff;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  border-radius: 5px;
}

input[type="submit"]:hover {
  background-color: #776499;
}

/* Styles for messages */
.success-message {
  color: green;
  margin-top: 10px;
}

.error-message {
  color: red;
  margin-top: 10px;
}
</style>
<div class="dash-content">
    <div class="activity">
        <div class="title">
            <i class="uil uil-clock-three"></i>
            <span class="text">Update Password</span> 
        </div>
    </div>
    <form action="updatepassword.php" method="post">
        <div class="column">
            <div class="input-box">
                <label>Password</label>
                <input type="password" name="password" pattern="^.{10,}$" placeholder="Enter Your Old Password" required />
            </div>
            <div class="input-box">
                <label>New Password</label>
                <input type="password" name="new"  pattern="^.{10,}$" placeholder="Enter New Password" required />
            </div>
            <div class="input-box">
                <label>Confirm Password</label>
                <input type="password" name="newp"  pattern="^.{10,}$" placeholder="Confirm New Password" required />
            </div>
        </div>
        <button type="submit" name="update">Submit</button>
    </form>

    <!-- Display success or error messages -->
    <?php
    if (!empty($successMessage)) {
        echo '<div class="success-message">' . $successMessage . '</div>';
    }

    if (!empty($errorMessage)) {
        echo '<div class="error-message">' . $errorMessage . '</div>';
    }
    ?>
</div>
</section>
<script src="script.js"></script>
</body>
</html>