<?php
// Database connection details

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moon";
$conn = new mysqli($servername, $username, $password, $dbname);
                
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(isset($_GET['table_name'])) {
    $table_name = $_GET['table_name'];
    
$query = "SELECT credit,university_exam_results FROM $table_name"; // Replace CGP with your actual table name
$result = mysqli_query($conn, $query);

$totalGradePoints = 0;
$totalCredits = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $grade = $row['university_exam_results'];
    $credit = $row['credit'];
    $gradePoint = 0;
    
    // Assign grade points based on grades
    switch ($grade) {
        case 'O':
            $gradePoint = 10;
            break;
        case 'A+':
            $gradePoint = 9;
            break;
        case 'A':
            $gradePoint = 8;
            break;
        case 'B+':
            $gradePoint = 7;
            break;
        case 'B':
            $gradePoint = 6;
            break;
        case 'C':
            $gradePoint = 5;
            break;
        case 'U':
            $gradePoint = 0; // Assuming 'U' grade is equivalent to 0 grade points
            break;
    }
    
    // Calculate total grade points and credits
    $totalGradePoints += $gradePoint * $credit;
    $totalCredits += $credit;
}

// Calculate GPA
$gpa = 0;
if ($totalCredits > 0) {
    $gpa = $totalGradePoints / $totalCredits;
     // Output GPA
}

// Fetch the count of 'U' grades
$sql_u = "SELECT COUNT(*) AS num_u FROM $table_name WHERE university_exam_results = 'U'";
$result_u = $conn->query($sql_u);
$num_u = ($result_u->num_rows > 0) ? $result_u->fetch_assoc()['num_u'] : 0;

// Fetch attendance data
$sql_attendance = "SELECT SUM(attend1) AS total_attend1, SUM(attend2) AS total_attend2 FROM $table_name";
$result_attendance = $conn->query($sql_attendance);
$total_attend1 = 0;
$total_attend2 = 0;
if ($result_attendance->num_rows > 0) {
    $row = $result_attendance->fetch_assoc();
    $total_attend1 = $row['total_attend1'];
    $total_attend2 = $row['total_attend2'];
}

// Calculate attendance percentage
// Calculate attendance percentage
$attendance_percentage = 0;
if ($total_attend1 > 0 && $total_attend2 > 0) {
    $total_hours = $total_attend1 + $total_attend2;
    $attendance_percentage = ($total_hours / (2 * $total_attend1)) * 100;
}


// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="sem.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Protor Book</title>
    <link rel="icon" href="download-6.webp">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="semhead2">
        <h1>FINAL RESULT</h1>
    </div>
    <div class="bars1" onclick="show()">
        <i class="fa-solid fa-bars"></i>
    </div>
    <div class="main2">
        <div class="pro1name2">
            <h1>Name of the proctor  : Ganesh</h1>
        </div>
    </div>
    <div class="sem2table">
        <center>
            <form method="post" action="update.php">
                <table border="2" class="sem2content">
                    <tr>
                        <th>Subject code<br>Name of subject</th>
                        <th colspan="2">Test 1</th>
                        <th colspan="2">Test 2</th>
                        <th>Internal marks</th>
                        <th>University Exam<br>(Results)</th>
                    </tr>
                    <tr>
                        <th>ID</th>
                        <th>Mark<br>(%)</th>
                        <th>Attendance<br>(Hours)</th>
                        <th>Mark<br>(%)</th>
                        <th>Attendance<br>(Hours)</th>
                        <th>-</th>
                        <th>-</th>
                    </tr>
                    <?php
                    // Fetch data from the database
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT * FROM $table_name";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['subject_code']}</td>";
                            echo "<td><input type='number' name='test1_mark[]' value='{$row["test1_mark"]}'></td>";
                            echo "<td><input type='number' name='attend1[]' value='{$row["attend1"]}'></td>";
                            echo "<td><input type='number' name='test2_mark[]' value='{$row["test2_mark"]}'></td>";
                            echo "<td><input type='number' name='attend2[]' value='{$row["attend2"]}'></td>";
                            echo "<td><input type='number' name='internal_marks[]' value='{$row["internal_marks"]}'></td>";
                            echo "<td><input type='text' name='university_exam_results[]' value='{$row["university_exam_results"]}'></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "0 results";
                    }
                    $conn->close();
                }
                    ?>
                </table>
            </form>
        </center>
    </div>
    <div class="foot2">
        <form class="sem2track">
            <tr>
                <td><h2>Number of standing arrears:</h2></td><br>
                <td><input type="TEXT" value="<?php echo $num_u; ?>"></td>
            </tr>
            <br>
            <br>
            <br>
            <tr>
                <td><h2>Attendance percentage (overall):</h2></td><br>
                <td><input type="text" value="<?php echo $attendance_percentage; ?>%"></td>
            </tr>
            <br>
            <br>
            <br>
            <tr>
                <td><h2>GPA:</h2></td> <br>
                <td><input type="text" value="<?php echo $gpa; ?>"></td>
            </tr>
            <br>
            <br>
            <br>
            <tr>
                <td><h2>CGPA:</h2></td>
                <td><input type="text"></td>
            </tr>
        </form>
    </div>
    <footer class="semfooter2">
        <center>
            <h1>Jerusalem college of Engineering</h1>
        </center>
        <br>
        <h3>For more details visit:</h3>
        <br>
        <h1>
            <i class="fa-brands fa-whatsapp" style="margin-left:20px;"></i>
            <i class="fa-brands fa-instagram"style="margin-left: 20px;"></i></i>
            <i class="fa-brands fa-facebook"style="margin-left: 20px;"></i></i>
            <i class="fa-brands fa-linkedin"style="margin-left: 20px;"></i></i>
        </h1>
        <br>
        <br>
        <h3><i class="fa-solid fa-phone" style="margin-right: 15px;"></i> 75400 37999
        <i class="fa-solid fa-envelope"style="margin-right: 15px;"></i> admission@jerusalemengg.ac.in</h3>
        <center>
            All rights reserved
        </center>
    </footer>
    <script src="main.js"></script>
</body>
</html>
