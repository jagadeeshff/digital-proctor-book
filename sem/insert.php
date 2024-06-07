<?php
// Assuming your database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moon";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the table name from the HTML form
if(isset($_POST['table_name'])) {
    $table_name = $_POST['table_name'];

    // Retrieve all subject codes from the database for the specified table
    $sql_subject_codes = "SELECT DISTINCT subject_code FROM $table_name";
    $result_subject_codes = $conn->query($sql_subject_codes);

    if ($result_subject_codes->num_rows > 0) {
        // Loop through each subject code
        while($row = $result_subject_codes->fetch_assoc()) {
            $subject_code = $row['subject_code'];
            
            // Retrieve other form data for the current subject code
            $test1_mark = $_POST[$subject_code . 'Test1'];
            $test1_attendance = $_POST[$subject_code . 'Atte1'];
            $test2_mark = $_POST[$subject_code . 'Test2'];
            $test2_attendance = $_POST[$subject_code . 'Atte2'];
            $internal_marks = $_POST[$subject_code . 'i_marks'];
            $result = $_POST[$subject_code . 'result'];
            $credits = $_POST[$subject_code . 'credits'];

            // Sanitize and validate data (not implemented here)

            // Check if record already exists for subject code
            $sql_check = "SELECT * FROM $table_name WHERE subject_code='$subject_code'";
            $result_check = $conn->query($sql_check);

            if ($result_check->num_rows > 0) {
                // If record already exists, update it
                $sql_update = "UPDATE $table_name SET test1_mark='$test1_mark', attend1='$test1_attendance', test2_mark='$test2_mark', attend2='$test2_attendance', internal_marks='$internal_marks', university_exam_results='$result',credit='$credits' WHERE subject_code='$subject_code'";
            
                if ($conn->query($sql_update) === TRUE) {
                    echo "Marks and attendance updated successfully <br>";
                } else {
                    echo "Error updating record for " . $conn->error ;
                }
            } else {
                // If record does not exist, insert it
                $sql_insert = "INSERT INTO $table_name (subject_code, test1_mark, attend1, test2_mark, attend2, internal_marks, university_exam_results,credit) VALUES ('$subject_code', '$test1_mark', '$test1_attendance', '$test2_mark', '$test2_attendance', '$internal_marks', '$result','$credits')";
            
                if ($conn->query($sql_insert) === TRUE) {
                    echo "Marks and attendance inserted successfully <br>";
                } else {
                    echo "Error inserting record for " . $conn->error ;
                }
            }
        }
        // Redirect to another PHP file
        header("Location: fetch.php?table_name=$table_name");
        exit();
    }
}

// Close connection
$conn->close();
?>
