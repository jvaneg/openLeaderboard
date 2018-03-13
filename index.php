<?php
    include "header/header.php";
?>

<section class="main-container">
    <div class="main-wrapper">
        <h2>openLeaderboard</h2>
        <?php
        if(isset($_SESSION['u_uid']))
        {
            echo "Welcome to ELO ";
            echo $_SESSION['u_uid'];

        }
        ?>
    </div>
</section>

<?php
    include 'footer/footer.php';
?>
