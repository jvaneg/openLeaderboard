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
            <input type="text" name="name" placeholder="Username" required> 
            <input type="text" name="email" placeholder="E-mail" required>
            <input type="password" name="pswd" placeholder="Password" required>
<!--            <textarea type="text" style="resize:none" name="bio" rows="10" cols="47" placeholder="Enter your Bio here..." tabindex="5" required></textarea>-->

            <button type="submit" name="submit">Sign up</button>
        </form>


    </div>
</section>

<?php
    $footerPath = $_SERVER['DOCUMENT_ROOT'];
    $footerPath .= "/footer/footer.php";
    include_once($footerPath);
?>
