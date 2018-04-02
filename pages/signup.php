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
            <?php
            if(isset($_GET['name'])){
                $nm = $_GET['name'];
                echo '<input type="text" name="name" placeholder="Username" required value=".$nm.">';
            }
            else
            {
                echo '<input type="text" name="name" placeholder="Username" required>';
            }
            ?>
<!--            <input type="text" name="name" placeholder="Username" required>-->
            <input type="text" name="email" placeholder="E-mail" required>
            <input type="password" name="pswd" placeholder="Password" required>
            <button type="submit" name="submit">Sign up</button>
        </form>
        <?php


        if(!isset($_GET['signup'])){
            exit();
        }
        else
        {
            $signupCheck = $_GET['signup'];
            if($signupCheck == "emptyfield"){ //lol
                echo "<p class ='error'>you pleab, fill in the stuff</p>";
                exit();
            }
            else if($signupCheck == "invalidusername"){
                echo "<p class ='error'> Invalid Username</p>";
                exit();
            }
            else if($signupCheck == "invalidemail"){
                echo "<p class ='error'> Invalid Email</p>";
                exit();
            }
            else if($signupCheck == "usertaken"){
                echo "<p class ='error'> Username Taken</p>";
                exit();
            }

        }
        ?>

    </div>




</section>

<?php
    $footerPath = $_SERVER['DOCUMENT_ROOT'];
    $footerPath .= "/footer/footer.php";
    include_once($footerPath);
?>
