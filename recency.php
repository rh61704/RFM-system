<?php

$name = $recency = $recencyrate= "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["name"]);
  $recency = test_input($_POST["recency"]);
  
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$con = mysql_connect("localhost","root","");
mysql_select_db("my_db", $con);

$sql = "SELECT recency from costomer where name = '$name'";

$result = mysql_query($sql,$con);

if (!$result)
  {
  die('Error: ' . mysql_error());
  }


?>