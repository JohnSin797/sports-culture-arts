<?php
/**fixed validation correct*/
    session_start();

    if (isset($_SESSION['Student_id'])) {
    // Redirect to the homepage if logged in
    header("Location: home/homepage.php");
    exit;
}

    $Empty_error_message_username = "";
    $Empty_error_message_password = "";
    $Unmatched_error_message_username = "";
    $Unmatched_error_message_password = "";

    include('connection/dbase.php');
    
    if (isset($_POST['Continue'])) {
        $studentid = $_POST['username'];
        $password = $_POST['password'];
    
        if (empty($studentid)) {
            $Empty_error_message_username = "Please enter a Username/Student ID";
        } else {
            $studentid = trim(htmlspecialchars($studentid));
        }
    
        if (empty($password)) {
            $Empty_error_message_password = "Please enter a password";
        } else if (strlen($password) < 8) {
            $Empty_error_message_password = "Password must be 8 characters long";
        } else {
            $password = trim(htmlspecialchars($password));
        }
    
        if (!empty($studentid) && !empty($password)) {
            $stmt = $CON->prepare("SELECT * FROM tblaccount WHERE Student_id = ? AND Pass = ?");
            $stmt->bind_param("ss", $studentid, $password);
            $stmt->execute();
            $res = $stmt->get_result();
    
            if ($row = $res->fetch_assoc()) {
                // Successful login
                if ($password === $row['Pass']) {
                // Regenerate session ID to prevent session fixation
                session_regenerate_id(true);

                $_SESSION['id'] = $row['id'];
                $_SESSION['Student_id'] = $row['Student_id'];
                $_SESSION['Fullname'] = $row['Fullname'];
                $_SESSION['Usertype'] = $row['Usertype'];
                $_SESSION['Firstname'] = $row['Firstname'];
                $_SESSION['Lastname'] = $row['Lastname'];
    
                echo "<script>window.location.href = 'home/homepage.php';</script>";
            } else {
                echo "<script>window.location.href = 'index.php';</script>";
                exit();
                }
            }else{
                // Set unmatched error messages only if login fails
                $Unmatched_error_message_username = "Username is not matched";
                $Unmatched_error_message_password = "Password is not matched";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"/>
    <title>SKC Bulan Campus</title>
</head>
<body>
    <div class="bodyloginpage">
        <div class="maincontainer">
            <div class="bgcontainer">
                <div class="insidebgcontainer">
                    <img class="skclogo" src="img/SKC LOGO.svg" alt="logo of skc"/>
                    <p class="welcome-to-sports">Welcome to Sports Culture and Arts Portal<br/>SorSU Bulan Campus</p>
                </div>
                <form method="post" id="LoginForm" autocomplete="on">
                    <h1>Sign in</h1>
                    <div class="formcontainer">
                        <div class="input-groupStudent_id">
                            <label id="username" class="user-name">Username</label>
                            <img class="Studentlogo" src="img/login/UserName.svg" alt="student icon"/>
                            <input type="text" name="username" class="input-student-id" placeholder="Student ID" autocomplete="on">
                            <span id="username-error" class="error-message">
                            <?php echo $Empty_error_message_username != "" ? $Empty_error_message_username : $Unmatched_error_message_username ?>
                            </span>
                        </div>
                    <div class="input-groupPassword">
                        <label for="password" class="pass-word">Password</label>
                        <img class="lockicon" src="img/login/IconLockPass.svg" alt="password icon"/>
                        <input type="password" name="password" class="input-password" id="password" placeholder="Password" autocomplete="on">
                        <span id="password-error" class="error-message">
                            <?php echo $Empty_error_message_password ?>
                            <?php echo $Unmatched_error_message_password ?>
                        </span>
                        <img id="show-icon" src="img/login/open-eye-show.svg" alt="Show Password" click="togglePasswordVisibility()">
                        <img id="hide-icon" src="img/login/CloseEyeHIDE.svg" alt="Hide Password" style="display: none;" click="togglePasswordVisibility()">
                    </div>
                    <button type="submit" class="continue" value="Continue" name="Continue">Continue</button>
                    <a href="#" class="forgotpass">Forget Password</a>
                    <a href="https://www.facebook.com/profile.php?id=100064099749286"><img class="fb-logo" src="img/login/facebook.svg" alt="fb of skc page"/></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="loginscript.js"></script>
</body>
</html>