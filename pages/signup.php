<?php
    include_once '../header/header.php';
    // session_start();
?>

<section class="main-container">
    <div class="main-wrapper">
        <h2>Sign Up</h2>
        
        
        <!-- <form class="signup-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" >  -->
        <form class="signup-form" action="/dbfiles/signup.inc.php" method="POST" >
            <input type="text" name="first" placeholder="Aileena" >
            <!-- <span class="error">* <?php echo $_SESSION["first_error"];?></span>
            <br><br> -->

            <input type="text" name="last" placeholder="Buttercup">
            <!-- <span class="error">* <?php echo $_SESSION["last_error"];?></span>
            <br><br> -->

            <input type="text" name="email" placeholder="aileenaB@gmail.com">
            <!-- <span class="error">* <?php echo $_SESSION["email_error"];?></span>
            <br><br> -->

            <input type="text" name="uid" placeholder="aButtercup">
            <!-- <span class="error">* <?php echo $_SESSION["uid_error"];?></span>
            <br><br> -->

            <input type="password" name="pswd" placeholder="********">
            <!-- <span class="error">* <?php echo $_SESSION["pswd_error"];?></span>
            <br><br> -->

            <button type="submit" name="submit">Sign up</button>
        </form>
    </div>
</section>

<?php
    include_once '../footer/footer.php';
?>
