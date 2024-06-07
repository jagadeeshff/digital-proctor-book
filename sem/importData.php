<?php
// Load the database configuration file
include_once 'dbConfig.php';

// Include PhpSpreadsheet library autoloader
require_once 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if(isset($_POST['importSubmit'])){ 
    
    // Get the table name from the form
 $table_name = $_POST['username'];

    // Allowed mime types
    $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    // Validate whether the selected file is an Excel file
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $excelMimes)){ 
        
        // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){ 
            $reader = new Xlsx();
            $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
            $worksheet = $spreadsheet->getActiveSheet();  
            $worksheet_arr = $worksheet->toArray();

            // Remove header row
            unset($worksheet_arr[0]);

            foreach($worksheet_arr as $row){ 
                $subject_code = $row[0];
                $test1_mark = $row[1];
                $attend1 = $row[2];
                $test2_mark = $row[3];
                $attend2 = $row[4];
                $internal_mark = $row[5];
                $university_exam_results = $row[6];
                $credits=$row[7];
                // Check whether the subject code already exists in the database
                $prevQuery = "SELECT id FROM $table_name WHERE subject_code = '".$subject_code."'"; 
                $prevResult = $db->query($prevQuery); 
                 
                if($prevResult->num_rows > 0){ 
                    // Update the record in the database
                    $updateQuery = "UPDATE $table_name SET test1_mark = '$test1_mark', attend1 = '$attend1', test2_mark = '$test2_mark', attend2 = '$attend2', internal_marks = '$internal_mark', university_exam_results = '$university_exam_results',credits='$credits' WHERE subject_code = '$subject_code'";
                    if ($db->query($updateQuery) === TRUE) {
                        echo "Record updated successfully<br>";
                    } else {
                        echo "Error updating record: " . $db->error . "<br>";
                    }
                } else { 
                    // Insert a new record in the database
                    $insertQuery = "INSERT INTO $table_name (subject_code, test1_mark, attend1, test2_mark, attend2, internal_marks, university_exam_results,credits) VALUES ('$subject_code', '$test1_mark', '$attend1', '$test2_mark', '$attend2', '$internal_mark', '$university_exam_results','$credits')";
                    if ($db->query($insertQuery) === TRUE) {
                        echo "New record inserted successfully<br>";
                    } else {
                        echo "Error inserting record: " . $db->error . "<br>";
                    }
                } 
            } 

            $qstring = '?status=succ'; 
        } else { 
            $qstring = '?status=err'; 
        } 
    } else { 
        $qstring = '?status=invalid_file'; 
    } 
}
header("Location: importfetch.php?table_name=$table_name");
exit;  
?>
