<!-- 
    Tasker.io
    A task management system
    This is the landing page, after the user has logged in.
    Created by: Callum-James Smith (cs18804)
 -->
<!DOCTYPE html>
<!-- Checks to see if the user has a session -->
<?php 
    session_start();
    if (!isset($_SESSION['name'])) {
        header("Location: index.php?error=nosession");
        exit();
    }
?>
<head>

    <!-- Meta stuffs -->
    <meta type='description' content='A task management website.'>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSS -->
    <link rel='stylesheet' href="css/main.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    
    <title>Task Manager</title>

</head>

<body>

    <header>
        <div id="logo">
            <!-- Logo goes here -->
            <!-- <h1 class="logo">Tasker.io</h1> -->
            <img class="logo" src="img/Logo-header.png" alt="Tasker.io logo">
        </div>
        
        <div class="project-selector">
                <?php 
                    include 'functions.inc.php';
                    ProjectSelector();
                ?>
        </div>

        <div class="new-project">
            <a href="#openModalProject" id="open-modal-project"><button><i class="fas fa-plus"></i></button></a>
            <a href="#openProjectDelete" id="open-project-delete"><button><i class="fas fa-minus"></i></button></a>
        </div>

        <div id="openModalProject" style="display: none;" class="modalDialog">
            <div>
                <a href="#close" title="Close" class="close">X</a>
                <h1>New Project</h1>
                <?php 
                    echo(
                        '<form class="add-item" action="newProject.inc.php" method="post">
                            <h3>Please make a new project</h3>
                            <input type="text" name="project-name" placeholder="Project name...">
                            <button type="submit" name="add-project">Add Project</button>
                        </form>'
                    );
                ?>
            </div>
        </div>

        <div id="openProjectDelete" style="display: none;" class="modalDialog">
            <div>
                <a href="#close" title="Close" class="close">X</a>
                <h1>Delete Project?</h1>
                <?php 
                    echo(
                        '<form class="add-item" action="functions.inc.php" method="get">
                            <input type="submit" name="delete-project" value="delete-project">
                        </form>'
                    );
                ?>
            </div>
        </div>
        
        <div id="user">
            <?php 
                echo("<p id='userHello'>Hello, ".$_SESSION['name'])."</p>" ?>
        </div>

        <div id="signout">
            <form action="signout.inc.php" method="post">
                <button class="signout" type="submit" name="signout">Sign Out</button>
            </form>
        </div>

    </header>

    <div class="container">

        <div class="to-do-container-wrapper">
        <div id="sorting">
            <form action="landing.php" method="get">
                <input name="sorting" type="text" value="date-asc" style="display:none;">
                <button type="submit" title="sort by date ASC"><i class="fas fa-arrows-alt-v"></i>D</button><br/>
            </form>
            <form action="landing.php" method="get">
                <input name="sorting" type="text" value="priority-asc" style="display:none;">
                <button type="submit" title="sort by priority ASC"><i class="fas fa-arrows-alt-v"></i>P</button><br/>
            </form>
            <form action="landing.php" method="get">
                <input name="sorting" type="text" value="date-desc" style="display:none;">
                <button type="submit" title="sort by date DESC"><i class="fas fa-arrows-alt-v"></i>d</button><br/>
            </form>
            <form action="landing.php" method="get">
                <input name="sorting" type="text" value="priority-desc" style="display:none;">
                <button type="submit" title="sort by priority DESC"><i class="fas fa-arrows-alt-v"></i>p</button><br/>
            </form>
        </div>

            <h3 class="headerTitle">To Do</h3>
            <hr>

            <div class="box-1"> <!-- TODO Box -->
            	<?php 
                    CheckProjects();
                    EditTask();
                    
                    if (isset($_GET['delete-task'])) {
                        require 'db.php';
                        $TaskTitle = $_GET['delete-task'];
                        $sql = mysqli_query($connection, "DELETE FROM tasks WHERE task_title='".$TaskTitle."'");	
                    }
                    elseif (isset($_GET['complete-task'])) {
                        require 'db.php';

                        $Task_title = $_GET['complete-task'];
                        $sql = mysqli_query($connection, "UPDATE tasks SET task_state='Completed' WHERE task_title='".$Task_title."'");
                    }
                    elseif (isset($_GET['undo-task'])) {
                        require 'db.php';

                        $Task_title = $_GET['undo-task'];
                        $sql = mysqli_query($connection, "UPDATE tasks SET task_state='To Do' WHERE task_title='".$Task_title."'");
                    }
                    
                    if (isset($_GET['sorting'])) {
                        if ($_GET['sorting'] == 'date-desc') {
                            PrintTasks('date-desc');
                        }
                        else if ($_GET['sorting'] == 'date-asc') {
                            PrintTasks('date-asc');
                        }
                        else if ($_GET['sorting'] == 'priority-desc') {
                            PrintTasks('priority-desc');
                        }
                        else if ($_GET['sorting'] == 'priority-asc') {
                            PrintTasks('priority-asc');
                        }
                    } 
                    else {
                        PrintTasks(false);
                    }
                ?>
			
			</div>

				<div class="addItem">  <!-- This holds the add item div-->
					
					<a href="#openModal" id="open-modal"><button class="add-item-button" id="add-item"><i class="far fa-plus-square"></i></button></a> <!-- button to activate modal -->
                    
                    <div id="openModal" class="modalDialog" style="display: none;"> <!-- The modal box that holds everything -->
                        <div> <!-- the element inside -->
                            <a href="#close" title="Close" class="close">X</a> <!-- The close button -->
                            <h1>Add Task</h1>
                            <?php 
                                AddTask();
                            ?>
                        </div>
                    </div>
					
				</div>
            </div>


        <div class="completed-container-wrapper">
            <h3 class="headerTitle">Completed</h3>
            <hr>
            <div class="box-3"> <!-- Completed Box -->
                   <?php
                        PrintCompletedTasks();
                    ?>
            </div>
        </div>

    </div>

</body>
<script>
document.getElementById("open-modal").onclick = function() // Stop the modal boxes from appearing quickly every time the page is refreshed
{
    var modal = document.getElementById("openModal");
    modal.style.display = 'block';
}
document.getElementById("open-modal-project").onclick = function() // Stop the modal boxes from appearing quickly every time the page is refreshed
{
    var modal = document.getElementById("openModalProject");
    modal.style.display = 'block';
}
document.getElementById("open-project-delete").onclick = function()
{
    var modal = document.getElementById("openProjectDelete");
    modal.style.display = 'block';
}
</script>
</html>