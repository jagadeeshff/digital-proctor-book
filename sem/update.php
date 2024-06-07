<?php

// Step 1: Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moon";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Handle form submission and update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the number of records submitted
    $table_name = $_POST['table_name'];
    $record_count = count($_POST['test1_mark']);

    // Loop through each record
    for ($i = 0; $i < $record_count; $i++) {
        // Calculate the ID (assuming IDs start from 1)
        $id = $i + 1;

        // Retrieve data from the form
        $test1_mark = $_POST['test1_mark'][$i];
        $test1_attend = $_POST['attend1'][$i];
        $test2_mark = $_POST['test2_mark'][$i];
        $test2_attend = $_POST['attend2'][$i];
        $internal_marks = $_POST['internal_marks'][$i];
        $university_exam_results = $_POST['university_exam_results'][$i];

        // Prepare SQL statement to update each row
        $sql = "UPDATE $table_name SET test1_mark='$test1_mark', attend1='$test1_attend', test2_mark='$test2_mark', attend2='$test2_attend', internal_marks='$internal_marks', university_exam_results='$university_exam_results' WHERE id='$id'";

        // Execute SQL statement
        if ($conn->query($sql) !== TRUE) {
            echo "Error updating record: " . $conn->error;
            exit;
        }
    }

    // Display success message
    header("Location: fetcher.php?table_name=$table_name");
    exit; 
}

// Step 3: Close the database connection
$conn->close();

?>
