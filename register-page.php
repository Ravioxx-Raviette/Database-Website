<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Page</title>
    <link rel="stylesheet" href="register_pageCSS.css">
</head>
<body>  
    <?php include('header.php');?>
    <?php include('nav2.php'); ?>
    <div class="register-container"> 
        <div class="register-content"> 
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $errors = array(); //initialize error array
                if (empty($_POST['fname'])) {
                    $errors[] = 'Please enter your first name.';
                } else {
                    $fn = trim($_POST['fname']);
                }

                if (empty($_POST['lname'])) {
                    $errors[] = 'Please enter your last name.';
                } else {
                    $ln = trim($_POST['lname']);
                }

                if (empty($_POST['email'])) {
                    $errors[] = 'Please enter your email.';
                } else {
                    $e = trim($_POST['email']);
                }

                if (!empty($_POST['psword1'])) {
                    if ($_POST['psword1'] != $_POST['psword2']) {
                        $errors[] = 'Your passwords do not match.';
                    } else {
                        $p = password_hash(trim($_POST['psword1']), PASSWORD_DEFAULT);
                    }
                } else {
                    $errors[] = 'Please enter your password.';
                }

                require ('mysqli_connect.php'); // Connect to the db.

                // Check for duplicate email
                $sql = "SELECT * FROM users WHERE email ='" . $_POST['email'] . "'";
                $result = @mysqli_query($dbc, $sql);
                $row = mysqli_fetch_row($result);

                if (!empty($row)) {
                    $errors[] = 'Email already exists, Please try a different email.';
                }

                if (empty($errors)) { // No errors, proceed
                    // Register the user in the database
                    $q = "INSERT INTO users (fname, lname, email, psword, registration_date) 
                        VALUES ('$fn', '$ln', '$e', '$p', NOW())";
                    $result = @mysqli_query($dbc, $q); // Run the query
                    if ($result) { // If successful
                        header("Location: register-thanks.php");
                        exit();
                    } else { // If error
                        echo '<h2>System Error</h2>';
                        echo '<p class="error-message">It did not work. Please try again later.</p>';
                        echo '<p>' . mysqli_error($dbc) . '</p>';
                    }
                    mysqli_close($dbc); // Close database connection
                    include('footer.php');
                    exit();
                } else { // Errors found
                    echo '<div class="error-container">';
                    echo '<h3>The following errors occurred:</h3>';
                    echo '<ul>';
                    foreach ($errors as $msg) {
                        echo "<li>$msg</li>";
                    }
                    echo '</ul>';
                    echo '</div>';
                }
            }
            ?>

            <h2 class="register-heading">Register</h2>
            <form action="register-page.php" method="post">
                <p>
                    <label class="input-label" for="fname">First Name: &nbsp;</label>
                    <input type="text" class="input-field" id="fname" name="fname" size="30" maxlength="40" value="<?php if (isset($_POST['fname'])) echo $_POST['fname']; ?>">
                </p>

                <p>
                    <label class="input-label" for="lname">Last Name: &nbsp;</label>
                    <input type="text" class="input-field" id="lname" name="lname" size="30" maxlength="40" value="<?php if (isset($_POST['lname'])) echo $_POST['lname']; ?>">
                </p>

                <p>
                    <label class="input-label" for="email">Email Address: &nbsp;</label>
                    <input type="email" class="input-field" id="email" name="email" size="30" maxlength="50" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
                </p>

                <p>
                    <label class="input-label" for="psword1">Password: &nbsp;</label>
                    <input type="password" class="input-field" id="psword1" name="psword1" size="20" maxlength="40">
                </p>

                <p>
                    <label class="input-label" for="psword2">Confirm Password: &nbsp;</label>
                    <input type="password" class="input-field" id="psword2" name="psword2" size="20" maxlength="40">
                </p>

                <p><input type="submit" class="submit-button" id="submit" name="submit" value="Register"></p>
            </form>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
