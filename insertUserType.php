<?php
$connect = mysqli_connect("localhost", "elibeta", "Rocketqueen1!", "study_guide_app");
$myUserType = ["student","professor"];
$addNum=0;
for ($i = 0; $i<sizeof($myUserType); $i++){
    $date=date('Y-m-d H:i:s');
    $addNum = $i + 1;
    $stmt = $connect->prepare("INSERT INTO user_type(id, type, created_at) VALUES (?,?,?)");
    $stmt->bind_param('iss',$addNum,$myUserType[$i],  $date);
    if(!$stmt->execute()){
        echo $connect->error;
    }
}