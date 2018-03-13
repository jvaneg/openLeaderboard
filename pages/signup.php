<?php
    $headerPath = $_SERVER['DOCUMENT_ROOT'];
    $headerPath .= "/header/header.php";
    include_once($headerPath);
?>

<section class="main-container">
    <div class="main-wrapper">
        <h2>Sign Up</h2>
        
        
        <!-- <form class="signup-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" >  -->
        <form class="signup-form" action="../dbfiles/signup.inc.php" method="POST" >
            <input type="text" name="first" placeholder="Aileena" required>

            <input type="text" name="last" placeholder="Buttercup" required>

            <input type="text" name="email" placeholder="aileenaB@gmail.com" required>

            <input type="text" name="uid" placeholder="aButtercup" required>

            <input type="password" name="pswd" placeholder="********" required>

            <button type="submit" name="submit">Sign up</button>
        </form>
    </div>
</section>

<?php
    $footerPath = $_SERVER['DOCUMENT_ROOT'];
    $footerPath .= "/footer/footer.php";
    include_once($footerPath);
?>
