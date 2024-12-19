<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="register_pageCSS.css">
</head>
<?php include('header.php');?>
<?php include('nav2.php');?>

<div class="register-content">
    <?php
    // Initialize error array
    $errors = array();

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        require('mysqli_connect.php');

        // Initialize variables
        $e = $p = '';

        if(empty($_POST['email'])){
            $errors[] = 'You forgot to enter your email address.';
        }else{
            $e = trim($_POST['email']);
        }

        if(empty($_POST['psword'])){
            $errors[] = 'You forgot to enter your password.';
        }else{
            $p = trim($_POST['psword']);
        }

        // Check if both email and password are set
        if($e && $p){
            $q = "SELECT user_id, fname, user_level, psword FROM users WHERE email='$e'";
            $result = @mysqli_query($dbc, $q);

            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                if(password_verify($p, $row['psword'])) {
                    session_start();
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['fname'] = $row['fname'];
                    $_SESSION['user_level'] = (int)$row['user_level'];

                    $url = ($_SESSION['user_level'] === 1) ? 'Admin_page.php' : 'members_page.php';
                    header("Location: $url");
                    mysqli_free_result($result);
                    mysqli_close($dbc);
                    exit();
                } else {
                    $errors[] = 'There might be something wrong with either the email or password';
                }
            } else {
                $errors[] = 'There might be something wrong with either the email or password';
            }
        }
        mysqli_close($dbc);
    }

    // Display any errors at the top
    if (!empty($errors)) {
        echo '<div class="error-message">';
        echo '<h3>The following errors occurred:</h3>';
        echo '<ul>';
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo '</ul>';
        echo '</div>';
    }
    ?>
    <!--form-->
    <div class="register-container">
        <h2 class="register-heading">Login</h2>
        <form action="login.php" method="post">
            <div class="form-row">
                <label class="input-label" for="email">Email Address:</label>
                <input type="email" class="input-field" id="email" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']?>">
            </div>

            <div class="form-row">
                <label class="input-label" for="psword">Password:</label>
                <input type="password" class="input-field" id="psword" name="psword">
            </div>

            <div class="form-row">
                <input type="submit" class="submit-button" id="submit" name="submit" value="Login">
            </div>
        </form>
        
    </div>
</div>

<?php include('footer.php');?>

</body>
</html>
