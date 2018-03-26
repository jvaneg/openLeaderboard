<?php

// if the user clicked on the submit buttion then process the form
//else return to signup

if(isset($_POST['submit'])) //if($_SERVER['submit'] == "POST")
{
    include_once 'db.inc.php';
    $name = $_POST['name'];
    $email = $_POST['email'];
    $bio = $_POST['bio'];
    $pswd = $_POST['pswd'];

    //checking if fields are filled
    if(empty($name) || empty($email) || empty($pswd) || empty($bio))
    {
        header("Location: ../pages/signup.php?signup=emptyfield");
        exit();
    }
    else   
    {
        //checking for valid chars
        if(!preg_match("/^[a-zA-Z0-9]+$/", $name))
        {
            header("Location: ../pages/signup.php?signup=invalidusername");
            exit();
        }
        else
        {
            //checking for valid email
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                header("Location: ../pages/signup.php?signup=invalidemail");
                exit();
            }
            else
            {
                //checking for existing user
                $sql = "SELECT * FROM User WHERE user_name = '$name'";
                $result = mysqli_query($connection, $sql);
                $resultCheck = mysqli_num_rows($result);
                
                if($resultCheck > 0)
                {
                    header("Location: ../pages/signup.php?signup=usertaken");
                    exit(); 
                }
                else
                {
                    //$sql = "INSERT INTO user (name, email, pswd) VALUES ('$name', '$email', '$pswd');";
                    
                    $hashPswd = password_hash($pswd, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO User (name, email, bio, pswd) VALUES ('$name', '$email','$bio' , '$hashPswd');";

                     mysqli_query($connection, $sql);
                     header("Location: ../pages/signup.php?signup=success");
                     exit();
                }
            }
        }
    }
}
else
{
    header("Location: ../pages/signup.php");
    exit();
}