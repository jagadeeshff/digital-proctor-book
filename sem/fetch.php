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
        <h1>DIGITAL PROCTOR BOOK UPDATING</h1>
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
            <input type="hidden" name="table_name" value="<?php echo isset($_GET['table_name']) ? htmlspecialchars($_GET['table_name']) : ''; ?>">
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

                    if(isset($_GET['table_name'])) {
                     $table_name = $_GET['table_name'];

                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "moon";
                    $conn = new mysqli($servername, $username, $password, $dbname);
                
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                
                    // Step 2: Fetch Data from the Database
                    $sql = "SELECT * FROM $table_name";
                    $result = $conn->query($sql);
                
                    // Step 3: Populate HTML Table with Data
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo"<td>" .$row["subject_code"]."' </td>";
                            echo "<td><input type='number' name='test1_mark[]' value='" . $row["test1_mark"] . "'></td>";
                            echo "<td><input type='number' name='attend1[]' value='" . $row["attend1"] . "'></td>";
                            echo "<td><input type='number' name='test2_mark[]' value='" . $row["test2_mark"] . "'></td>";
                            echo "<td><input type='number' name='attend2[]' value='" . $row["attend2"] . "'></td>";
                            echo "<td><input type='number' name='internal_marks[]' value='" . $row["internal_marks"] . "'></td>";
                            echo "<td><input type='text' name='university_exam_results[]' value='" . $row["university_exam_results"] . "'></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "0 results";
                    }
                    $conn->close();
                }
                    ?>
                </table>
                <button type="submit">Update</button>
            </form>
        </center>
    </div>
    <div class="foot2">
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
            All rights reseved
        </center>
    </footer>
    <script src="main.js"></script>
</body>
</html>