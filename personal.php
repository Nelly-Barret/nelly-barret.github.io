<?php
require('db.php');
try {
	$SQL_CURRENT_COURSES = "SELECT * FROM course WHERE end_date = '1900-01-01';";
	$current_courses = $conn->query($SQL_CURRENT_COURSES);

	$SQL_FORMER_COURSES = "SELECT * FROM course WHERE end_date > '1900-01-01';";
	$former_courses = $conn->query($SQL_FORMER_COURSES);

	

	$SQL_ALL_TRAINING = "SELECT * FROM training;";
	$trainings = $conn->query($SQL_ALL_TRAINING);
} catch (Exception $e) {
	var_dump($e);
}

?>

<!DOCTYPE html>

<html lang="fr">
<?php include 'head.php'; ?>
    
<body>
	<?php include 'navbar.php'; ?>
    
    <section class="anchor light">
    
    	<div class="row">
        	<div class="col-sm-6" style="text-align: center">I recently got engaged with my partner<br/>
	        	<img src="./img/pacs.jpg" width="30%"/>
        	</div>
        	<div class="col-sm-6" style="text-align: center">On my free time, I enjoy doing puzzles:
				<img src="./img/puzzle-3.jpeg" width="90%"/>
        	</div>
      	</div>
      
      	<br/>

        <div class="row">
            Some former activities I enjoyed doing during my high school and university years:
            <div class="col-sm-12">
                <ul>
                    <li>Member of the <a href="https://aml.univ-lyon1.fr/">AML</a> (Computer Science students in Lyon) association during my university years. I also participated to the events they organized: Nuit de l'Info, running to get funds for breast cancer research, and many more!</li>
                    <li>Team leader of my group for the <a href="https://www.nuitdelinfo.com/" target="_blank">Nuit de l'Info</a> events, where the goal is to develop, in one night, a software on a given topic.</li>
                    <li>Volunteer gymnastics coach for 7 years in my hometown for a group of 22 young gymnasts.</li>
                </ul>
            </div>
        </div>
    </section>
</body>
</html>