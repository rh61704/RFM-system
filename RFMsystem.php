
<!DOCTYPE HTML>  
<html>
<head>
<title>客戶資料管理系統</title>
</head>
<style>
div.form{
  border-style: solid;
  background-image: url("aaa.jpg");
  background-repeat: no-repeat;
  background-position: right;
  padding-left: 50px;
  padding-top: 10px;
  padding-bottom: : 10px;
  margin-top: 0px;
  margin-left: 200px;
  
}
div.head{
width: 100%;
background-image: url("background.jpg");
background-repeat: repeat-x;
color: black;
margin-top: 5px;
height: 100px;
padding-top:40px;
padding-left: 10px;

}
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    width: 200px;
    height: 242px;
    background-color: #f1f1f1;
    float: left;
    border-style: solid;

}

li a {
    display: block;
    color: #000;
    padding: 8px 16px;
    text-decoration: none;
}

/* Change the link color on hover */
li a:hover {
    background-color: lightblue;
    color: white;
}

.error {color: #FF0000;}

</style>
<body > 
 
<?php
// define variables and set to empty values
$name = $adress  = $customer =  $phone  = $recency = $frequency = $monetary = "";
$nameErr = $idErr = $addressErr = $phoneErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
     $nameErr = "姓名是必填的";
   } else {
     $name = test_input($_POST["name"]);
   }
   if (empty($_POST["customerid"])) {
     $idErr = "Id是必填的";
   } else {
     $customer = test_input($_POST["customerid"]);
   }
   if (empty($_POST["adress"])) {
     $addressErr = "地址是必填的";
   } else {
     $adress = test_input($_POST["adress"]);
   }
   if (empty($_POST["phone"])) {
     $phoneErr = "電話是必填的";
   } else {
     $phone = test_input($_POST["phone"]);
   }
  $phone = test_input($_POST["phone"]);
  
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<div class= "head">
<h2> 客戶資料管理系統</h2>
</div>
<ul>
  <li><a href="123.php">客戶資料</a></li>
  <li><a href="rate.php">客戶RFM分群</a></li>
</ul>
<div class="form" >
<form method="post" action="" name= "form1">

  客戶姓名: <br><input type="text" name="name"><span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  客戶ID: <br><input type="text" name="customerid"><span class="error">* <?php echo $idErr;?></span>
  <br><br>
  地址: <br><input type="text" name="adress"><span class="error">* <?php echo $addressErr;?></span>
  <br><br>
  電話: <br><input type="text" name="phone"><span class="error">* <?php echo $phoneErr;?></span>
  <br><br>
  
 <input type="button" value="新增" type="submit" onclick="form1.action='123.php';form1.submit();"/>  
 <input type="button" value="刪除" type="submit" onclick="form1.action='delete.php';form1.submit();"/>
 <input type="button" value="修改" type="submit" onclick="form1.action='edit.php';form1.submit();"/>
</form>
</div>
<div style="position:absolute;left: 7px">
<table width="546" border="1">
<tr style="background-color:#CAFFFF">
<td>客戶ID</td>
<td>客戶姓名</td>
<td>地址</td>
<td>電話號碼</td>
<td>訂購時距近度(天)</td>
<td>消費頻率(一年內)</td>
<td>消費金額(一年內)</td>
</tr>

<?php
$date=date("Y-m-d");

$con = mysqli_connect("localhost","Tim","123","mydb");
mysqli_query($con,"set names UTF8");

$sql="select GuestId from Myguests";
$res=mysqli_query($con,$sql);
for ($i=0; $i < mysqli_num_rows($res); $i++) { 
  $guest=mysqli_fetch_row($res);
  $gid=$guest[0];
  $money=0;
  $sql="select Sdate,金額 from sellOrder where GuestId='$gid' order by Sdate desc";
  $end=date("Y-m-d",strtotime($date.'-1 year'));
  $result=mysqli_query($con,$sql);  
    $resul=mysqli_query($con,$sql); 
    $freq=mysqli_num_rows($resul);
    for ($j=0; $j <mysqli_num_rows($resul) ; $j++) { 
      $check=mysqli_fetch_row($resul);
      if(strtotime($date)<strtotime($check[0])||strtotime($end)>strtotime($check[0])){
        $freq--;
      }
      else{
        $money=$money+$check[1];
      }
    }
  

      
      


  
  $sdate=mysqli_fetch_row($result);
  $day=$sdate[0];
  while(strtotime($day)>strtotime($date)){
    $sdate=mysqli_fetch_row($result);
    $day=$sdate[0];
  }
  
  
  $recency=round((strtotime($date)-strtotime($day))/3600/24);
  mysqli_query($con,"update Myguests set recency='$recency', frequency='$freq',monetary='$money'  where GuestId='$gid'");
}



$selectsql= "select*from Myguests";
$result = mysqli_query($con,$selectsql);
for($i=1;$i<=mysqli_num_rows($result);$i++)
{ $rs=mysqli_fetch_assoc($result);
?><tr style="background-color:#BBFFBB">
<td><?php echo $rs['GuestId']?></td>
<td><?php echo $rs['GuestName']?></td>
<td><?php echo $rs['address']?></td>
<td><?php echo $rs['GuestPhone']?></td>
<td><?php echo $rs['recency']?></td>
<td><?php echo $rs['frequency']?></td>
<td><?php echo $rs['monetary']?></td>
</tr>
<?php }?>

</table>
</div>
<?php

if($customer!=""&&$name!=""&&$adress!=""&&$phone!=""){
$sql="INSERT INTO customer (GuestId, GuestName, address,GuestPhone,recency,frequency,monetary)
VALUES
('$customer','$name','$adress','$phone','$recency','$frequency','$monetary')";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
echo "<br>";
echo "已新增{$name}";}

?>




</body>
</html>