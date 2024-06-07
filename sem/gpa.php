<?php 
    ob_start(); 
    include 'sem1.php'; 
    include("database.php");

    
    $query="SELECT credit,grade FROM DATBASE_NAME ;
    $result = mysqli_query($conn,$query);
    $totalcredits=0;
    $credits=0;
    while ($row = $result->fetch_assoc()) 
    {
        $grade = $row['grade'];
        $credit = $row['credit'];
        $gradePoint = 0;
        
    
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
                $gradePoint = 0;
                break;
        }
        
        $totalGradePoints += $gradePoint * $credit;
        $totalCredits += $credit;
    }
    
    $gpa = 0;
    if ($totalCredits > 0) {
        $gpa = $totalGradePoints / $totalCredits;
        echo '<input type="text" name="id" value='$gpa'>';   

    }
                   
    
    
    mysqi_close($conn);
?>
