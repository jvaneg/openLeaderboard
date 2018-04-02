<?php

//To save the session var
session_start();

// if the user clicked on the submit buttion then process the form
//else return to signup

if(isset($_POST['submit'])) //if($_SERVER['submit'] == "POST")
{
    include_once($_SERVER['DOCUMENT_ROOT'] . "/dbfiles/dbFunctions.php");

    $name = $_POST['name'];
    $email = $_POST['email'];
    $pswd = $_POST['pswd'];

    //checking if fields are filled
    if(empty($name) || empty($email) || empty($pswd))
    {
        header("Location: ../pages/signup.php?signup=emptyfield");
        exit();
    }
    else
    {
        //checking for valid chars
        if(!preg_match("/^[a-zA-Z0-9]+$/", $name))
        {
            header("Location: ../pages/signup.php?signup=invalidusername&name=$name&email=$email");
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
                $result = checkUserInDB($name);
                $resultCheck = mysqli_num_rows($result);

                if($resultCheck > 0)
                {
                    header("Location: ../pages/signup.php?signup=usertaken");
                    exit();
                }
                else
                {
                    addNewUser($name, $email, $pswd);
                    $_SESSION['user_id'] = $name;
                    $_SESSION['user_pswd'] = $pswd;
                    $_SESSION['user_pswd'] = $email;

                    header("Location: /index.php?signup=success");
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