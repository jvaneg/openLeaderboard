<?php
 session_start();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>openLeaderboard</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/style/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="main-wrapper">
                <ul>
                    <li>
                        <a href="/index.php">openLeaderboard</a>
                    </li>
                    <?php
                        if(isset($_SESSION['user_id']))
                        {
                            echo    '<li>
                        					<a href="/pages/profile.php">Profile</a>
                    						</li>
                    						<li>
                        					<a href="/pages/leaderboardSearch.php">Leaderboards</a>
                    						</li>
                    						<li>
                       						<a href="/pages/userSearch.php">Users</a>
                    						</li>
                    						<li>
                        					<a href="/pages/submitted.php">Match Submissions</a>
                    						</li>';
                        }
                    ?>
                    
                </ul>
                <div class="nav-login">
                    <?php
                        // if we are logged in 
                        if(isset($_SESSION['user_id']))
                        {
                            echo    '<form action="/dbfiles/logout.inc.php" method="POST">
                                        <button type="submit" name="submit"> Log out</button>
                                    </form>';
                        }
                        else
                        {
                            echo    '<form action="/dbfiles/login.inc.php" method="POST">
                                        <input type="text" name="name" placeholder="Username">
                                        <input type="password" name="pswd" placeholder="Password">
                                        <button type="submit" name="submit">Login</button>
                                    </form>
                                    <a href="/pages/signup.php">Sign up</a>';
                        }
                        
                    ?>
                </div>
            </div>
        </nav>
    </header>