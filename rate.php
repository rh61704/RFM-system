<!DOCTYPE HTML>  
<html>
<head>
  <title>RFM分析</title>
</head>
<style>
.error {color: #FF0000;}
  div{
    margin-left: 220px;
    background-image: url("bbb.png");
    background-repeat: no-repeat;
    background-position: right;
    height: 1000px;
    padding-top: 10px;
  }
  ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    width: 200px;
    height: 1000px;
    background-image: url("background.jpg");
    background-repeat: no-repeat;
    background-size: cover;
    float: left;


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

  table{
    background-color: #F0F0F0;
  }


</style>


<body>
<?php

$recency = $frequency = $monetary =$recencyErr =$frequencyErr=$monetaryErr= "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["recencyW"])) {
     $recencyErr = "未填寫權重";
   } else {
     $recency = test_input($_POST["recencyW"]);
   }
   if (empty($_POST["frequencyW"])) {
     $frequencyErr = "未填寫權重";
   } else {
     $frequency = test_input($_POST["frequencyW"]);
   }if (empty($_POST["monetaryW"])) {
     $monetaryErr = "未填寫權重";
   } else {
     $monetary = test_input($_POST["monetaryW"]);
   }
   
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>


  <?php

  $con = mysqli_connect("localhost","Tim","123","mydb");
  mysqli_query($con,"set names UTF8");

  $sql = "SELECT recency,GuestId from Myguests order by recency ";
  $result = mysqli_query($con,$sql);

  $sqlid = "SELECT*from Myguests ";
  $idresult = mysqli_query($con,$sqlid);

  $num=mysqli_num_rows($idresult);

  for ($i=0; $i < $num; $i++) { 
    $r=mysqli_fetch_assoc($idresult);
    $idrow[$i]=$r['GuestId'];
    $idname[$i]=$r['GuestName'];
  }

  if (!$idresult)
  {
    die('Error: ' . mysqli_error());
  }


  if (!$result)
  {
    die('Error: ' . mysqli_error());
  }
  

  $num=mysqli_num_rows($result);

  for ($i=0; $i < $num; $i++) { 
  	$r=mysqli_fetch_assoc($result);
  	$row[$i]=$r['GuestId'];
  	
  }



  
  for ($i=0; $i < $num; $i++) { 
  	$r=mysqli_fetch_assoc($result);
  	$list[$i]=$r['recency'];//
  	
  }



  for($i=0;$i < $num; $i++){

    if($i<$num*0.3){//recency前３０％

      $list[$i]=3; 

    }else if ($i>=$num*0.3&&$i<$num*0.7){

      $list[$i]=2; 


    }else{

      $list[$i]=1; 


    }
  }

  for($i=0;$i < $num; $i++){
    $setsql= "UPDATE Myguests SET shortkey1='$list[$i]' WHERE GuestId = '$row[$i]'";
    $shortkey="SELECT shortkey1 from Myguests ";
    
    $setresult= mysqli_query($con,$setsql);
    $keyresult= mysqli_query($con,$shortkey);
    if (!$setresult)
    {
      die('Error: ' . mysqli_error());
    }
  }

  for ($i=0; $i < $num; $i++) { 
    $r=mysqli_fetch_assoc($keyresult);
    $key[$i]=$r['shortkey1'];
    
  }


  ?>




  <?php

  $sql2 = "SELECT frequency,GuestId from Myguests order by frequency ";
  $result2= mysqli_query($con,$sql2);
  if (!$result2)
  {
    die('Error: ' . mysqli_error());
  }

  $num=mysqli_num_rows($result2);


  for ($i=0; $i < $num; $i++) { 
  	$r=mysqli_fetch_assoc($result2);
  	$row2[$i]=$r['GuestId'];
  	
  }

  
  for ($i=0; $i < $num; $i++) { 
  	$r=mysqli_fetch_assoc($result2);
  	$list2[$i]=$r['frequency'];
  	
  }


  for($i=0;$i < $num; $i++){

    if($i<$num*0.3){

      $list2[$i]=1; 

    }else if ($i>=$num*0.3&&$i<$num*0.7){

      $list2[$i]=2; 


    }else{

      $list2[$i]=3; 


    }
  }

  for($i=0;$i < $num; $i++){
    $setsql2= "UPDATE Myguests SET shortkey2='$list2[$i]' WHERE GuestId = '$row2[$i]'";
    $shortkey2="SELECT shortkey2 from Myguests ";
    $keyresult2= mysqli_query($con,$shortkey2);
    $setresult2= mysqli_query($con,$setsql2);
    if (!$setresult2)
    {
      die('Error: ' . mysqli_error());
    }
  }

  for ($i=0; $i < $num; $i++) { 
    $r=mysqli_fetch_assoc($keyresult2);
    $key2[$i]=$r['shortkey2'];
    
  }

  ?>



  <?php

  $sql3 = "SELECT monetary,GuestId from Myguests order by monetary ";
  $result3= mysqli_query($con,$sql3);
  if (!$result3)
  {
    die('Error: ' . mysqli_error());
  }

  $num=mysqli_num_rows($result3);

  for ($i=0; $i < $num; $i++) { 
    $r=mysqli_fetch_assoc($result3);
    $row3[$i]=$r['GuestId'];
    
  }

  
  for ($i=0; $i < $num; $i++) { 
    $r=mysqli_fetch_assoc($result3);
    $list3[$i]=$r['frequency'];
    
  }



  for($i=0;$i < $num; $i++){

    if($i<$num*0.3){

      $list3[$i]=1; 

    }else if ($i>=$num*0.3&&$i<$num*0.7){

      $list3[$i]=2; 


    }else{

      $list3[$i]=3; 


    }
  }


  for($i=0;$i < $num; $i++){
    $setsql3= "UPDATE Myguests SET shortkey3='$list3[$i]' WHERE GuestId = '$row3[$i]'";
    $shortkey3="SELECT shortkey3 from Myguests ";
    $keyresult3= mysqli_query($con,$shortkey3);
    $setresult3= mysqli_query($con,$setsql3);
    if (!$setresult3)
    {
      die('Error: ' . mysqli_error());
    }
  }

  for ($i=0; $i < $num; $i++) { 
    $r=mysqli_fetch_assoc($keyresult3);
    $key3[$i]=$r['shortkey3'];
    
  }


  ?>


  <?php

  $num=mysqli_num_rows($result);

  $total = array();

  for ($i=0; $i < $num; $i++) { 
    $total[$i]=$key[$i]*$recency+$key2[$i]*$frequency+$key3[$i]*$monetary;
    
  }

  ?>


  <ul>
    <li><a href="123.php">客戶資料</a></li>
    <li><a href="rate.php">客戶RFM分群</a></li>
  </ul>



  <div>
    <p>RFM 等級</p>
    <table width="546" border="1">
      <tr>
        <td>客戶ID</td>
        <td>recency</td>
        <td>frequency</td>
        <td>monetary</td>
        <td style="background-color:#FF9797">評分</td>
      </tr>

      <?php

      for ($i=0; $i < $num; $i++) { 

        if($list[$i]==3){
          $color="green";
        }else if($list[$i]==2){
          $color="#FF8000";
        }else{
          $color="red";
        }

        if($list2[$i]==3){
          $color1="green";
        }else if($list2[$i]==2){
          $color1="#FF8000";
        }else{
          $color1="red";
        }

        if($list3[$i]==3){
          $color2="green";
        }else if($list3[$i]==2){
          $color2="#FF8000";
        }else{
          $color2="red";
        }

        $color3="#FF9797";

        echo "<tr>
        <td>".$idrow[$i]." ".$idname[$i]."</td>
        <td style='color:".$color."'>".$key[$i]."</td>
        <td style='color:".$color1."'>".$key2[$i]."</td>
        <td style='color:".$color2."'>".$key3[$i]."</td>
        <td style='background-color:".$color3."'>".$total[$i]."</td>
      </tr>";
    }
    ?>

  </div>

  <form method="post" action="rate.php" >
recency權重：<input type="text" name="recencyW"><span class="error">* <?php echo $recencyErr;?></span>
frequency權重：<input type="text" name="frequencyW"><span class="error">* <?php echo $frequencyErr;?></span>
monetary權重：<input type="text" name="monetaryW"><span class="error">* <?php echo $monetaryErr;?></span>
<br><input type="submit" value="Submit">
</form>


</body>

</html>