<?php
    include_once 'header/header.php';
?>

<section class="main-container">
    <div class="main-wrapper">
        <h2>ELO Leaderboard System</h2>
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
    include_once 'footer/footer.php';
?>
