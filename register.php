<?php
if (session_id() === "") {
    session_start();
}
if (isset($_SESSION['authenticatedUser'])) {
    if (isset($_SESSION['lastPage'])){
    $lastPage = $_SESSION['lastPage'];
    header("Location: $lastPage");
    exit;
} else {
    header("Location: index.php");
    exit;
}
};
?>

<html>
<head>
    <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body id="registerBody">


<fieldset id="registerFieldset">
    <legend>New User Details</legend>

    <form id ="registerForm">
        <?php
            $formNames = array('First_Name', 'Last_Name', 'Username', 'Password', 'Confirm_Password', 'Email');
foreach ($formNames as $formName){
    $noUnderscore = str_replace("_", " ", $formName);
    if (($formName == 'Password') || ($formName == 'Confirm_Password')){
        echo "<p><label for=$formName>$noUnderscore</label>
                    <input type='password' name='$formName' id='$formName' class='register-field' autocomplete='new-password' required></p>"; //maybe add option to show
    } else {
        echo "<p><label for=$formName>$noUnderscore</label>
                    <input type='text' name='$formName' id='$formName' class='register-field' autocomplete='off' required></p>";
    }
                    }

?>
        <input type="submit" name="registerUser" id="registerUser" class="lightGreenButton" value="Register">

    </form>
</fieldset>
<?php

include('htaccess/databaseconnect.php');


$formOK = false;
if (isset($_GET['Username'])) {
    $formOK = true;
    $firstName = $_GET['First_Name'];
    $lastName = $_GET['Last_Name'];
    $username = $_GET['Username'];
    $password1 = $_GET['Password'];
    $password2 = $_GET['Confirm_Password'];
    $email = $_GET['Email'];
    
    // Perform query to see how many users there are with given username
    $stmt = $conn->prepare("SELECT * FROM Users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        // OK, there is no user with that username
        //echo "<h3>You can use that username! </h3>";
    } else {
        $formOK = false;
        echo "<h3> Username already in use.</h3>";
    }

    if ($password1 != $password2) {
        $formOK = false;
        echo"<h3>Passwords do not match. </h3>";
    }
    if (strlen($password1) < 8) {
        echo "<h3>Password needs to be at least 8 characters. </h3>";
        $formOK = false;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<h3>Please enter valid email</h3>";
        $formOK = false;
    }
    // Perform query to see how many users there are with given username
    $stmt = $conn->prepare("SELECT * FROM Users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        // OK, there is no user with that username
        //echo "<h3>You can use that email! </h3>";
    } else {
         echo "<h3> Email already in use.</h3>";
        $formOK = false;
    }
    
    

    }
    if ($formOK) {
        $query = "INSERT INTO Users (first_name, last_name, username, password, email, role) 
            VALUES ('$firstName', '$lastName', '$username', SHA('$password1'), '$email', 'user');";
        $conn->query($query);

        if ($conn->error) {
            print($conn->error);
            echo "<h3> Something went wrong. </h3>";
            echo "<h3> Please email admin@environmentfriend.site and explain what happened. </h3>";
        } else {
            $_SESSION['authenticatedUser'] = $username;
            $row = $result->fetch_assoc();
            $role = $row['role'];
            $_SESSION['role'] = $role;

            $lastPage = $_SESSION['lastPage'];
            header("Location: $lastPage");
            exit;
        }
        

        
        $result->free();
        $conn->close();
    }


?>

</body>
</html>
