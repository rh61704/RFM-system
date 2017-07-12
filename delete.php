

<?php
$name = $adress  = $customer =  $phone  =  "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["name"]);
  $adress = test_input($_POST["adress"]);
  $customer = test_input($_POST["customerid"]);
  $phone = test_input($_POST["phone"]);
  
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$con = mysqli_connect("localhost","Tim","123","mydb");

mysqli_query($con,"set names UTF8");

  
  $sql_delete = "DELETE FROM  myguests WHERE GuestName = '$name'";
  $result= mysqli_query($con,$sql_delete);

  if (!$result)
  {
  die('Error: ' . mysqli_error());
  }

 echo "已刪除{$name}";


?>
<button onclick="location.href='123.php'">返回</button>