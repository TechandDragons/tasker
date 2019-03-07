<?php 
/**
 * signupPHP.php
 * This script controls the user signup process
 * Created by: Callum-James Smith (cs18804)
 */
if (isset($_POST['signup-submit'])) // Checks to see if user clicked "signup"
{
    require 'db.php'; // include the Database connection handler file

    $name = $_POST['name']; // The name given by the user
    $email = $_POST['email']; // The email address given by the user
    $password = $_POST['password']; // The password given by the user
    $passwordRepeat = $_POST['password-repeat']; // The repeated version of the initial password, given by user
    $HashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hashes the password using BCRYPT
    
    $EmailQuery = "SELECT email FROM users WHERE email='".$email."'";
    $NameQuery = "SELECT name FROM users WHERE name='".$name."'";
    $EmailResult = mysqli_query($connection, $EmailQuery);
    $NameResult = mysqli_query($connection, $NameQuery);
    $EmailRowNumber = mysqli_num_rows($EmailResult);
    $NameRowNumber = mysqli_num_rows($NameResult);

    if (empty($name) || empty($email) || empty($password) || empty($passwordRepeat))
    // Checks to see if any of the fields are empty
    {
        header("Location: signup.php?error=emptyfields&name=".$name."&email=".$email);
        // ^ throws an error and re-applies the data back into the fields if available
        exit(); // Stop script from running
    }
    else if ($EmailRowNumber >= 1 || $NameRowNumber >= 1) // If a row matching the email address is found
    {
        header("Location: signup.php?error=userexists");
        // ^ throws an error and re-applies the data back into the fields if available
        exit(); // Stop script from running
    }
    else if ($password != $passwordRepeat)  // Checks to see if the password are the same
    {
        header("Location: signup.php?error=passwordmismatch&name=".$name."&email=".$email);
        // ^ throws an error and re-applies the data back into the fields if available
        exit();
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        header("Location: signup.php?error=invalidemail&name=".$name);
        // ^ throws an error and re-applies the data back into the fields if available
        exit();
    }
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $name)) // Checks to see if the username is valid (contains letters A-Z and integers 0-9)
    {
        header("Location: signup.php?error=invalidname&email=".$email);
        // ^ throws an error and re-applies the data back into the fields if available
        exit();
    }
    else {

        mysqli_query($connection, "INSERT INTO users(name,email,password) VALUES('".$name."','".$email."','".$HashedPassword."')");
        include_once "functions.inc.php";
        $Project = Project_Name();
        header("Location: index.php?signup=success&projects=$Project");
        exit();
    }
}