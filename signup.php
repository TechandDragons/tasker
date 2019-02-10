<!-- 
    Tasker.io
    A task management system
    This is the login page.
    Created by: Callum-James Smith (cs18804)
 -->
 <!DOCTYPE html>
 <!-- PHP Include -->
<?php
    include('signupPHP.php');
?>
 <head>
     
     <!-- Meta stuffs -->
     <meta type='description' content='A task management website.'>
 
     <!-- CSS -->
     <link rel='stylesheet' href="css/main.css" type="text/css">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
     
     <title>Task Manager</title>

 </head>
 
 <body>
 
     <header>
         <div id="logo">
             <!-- Logo goes here -->
             <h1 class="logo">Task.io</h1>
         </div>
     </header>
 
     <div class="loginBox">
         <form id="LoginForm" action="signupPHP.php" method="post">
             <h1 id="Sign In">Sign Up</h1>
             <input type="text" name="name" placeholder="Name..."><br>
             <input type="email" name="email" placeholder="Email..."><br>
             <input type="password" name="passowrd" placeholder="Password..."><br>
             <input type="Password" name="password-repeat" placeholder="Re-enter password..."><br>
             <button type="submit" name='signup-submit'>Sign Up</button>
         </form>
     </div>
 
 </body>
 
 </html>