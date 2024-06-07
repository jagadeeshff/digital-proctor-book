<?php
$db = new PDO("mysql:host=localhost;dbname=moon", "root", "");

$user = $_POST['id'];
$pass = $_POST['password'];
$sql = "SELECT * FROM student WHERE id = :user AND password = :pass";

$stmt = $db->prepare($sql);
$stmt->execute(['user' => $user, 'pass' => $pass]);

$result = $stmt->fetch(PDO::FETCH_ASSOC);
if ($result) {
  // echo"<a href='sem1.html'>semester1</a>";
  header("Location: sem1.html");
  exit(); 
} else{
  echo "<img src='ss.png' style= 'display: block;
  margin-left: auto;
  margin-right: auto';>";
  echo "<h1 style='font-style:italic; text-align:center;'>This website for only authorized proctor<h1>";
}
?>