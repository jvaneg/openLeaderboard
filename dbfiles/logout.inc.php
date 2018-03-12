<?php

if(isset($_POST['submit']))
{
    // Session_unset just clears out the session for usage. Session_unset just removes all session variables 
    // but it does not destroy the session so the session would still be active. Thus you must use destroy 
    // after unset to free all the super global vars.
 
    session_start();
    session_unset();
    session_destroy();

    // Once user logs out they must be redirected to the main page.
    header("Location: ../index.php");
}