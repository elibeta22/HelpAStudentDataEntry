<?php
$connect = mysqli_connect("localhost", "elibeta", "Rocketqueen1!", "study_guide_app");
$filename = "items_schools_18.json";
$data = file_get_contents($filename);
$array = json_decode($data, true);
$myDepartments = array();
$myDepartmentArray = [];
$myUserType = ["student","professor"];


//    this is for inserting schools into local database
$id =0;
$depart_id =0;
foreach($array as $row){

//this is to insert professors or departments into database
    for ($i = 0; $i < count($row['school_top_professors']['professor_name']); $i++){
        $id++;
        $date=date('Y-m-d H:i:s');
        $professor_department = $row['school_top_professors']['professor_department'][$i];
        if ($professor_department == NULL){
            $professor_department = "Unknown";
        }
//        this needs to be uncommented for insertion of departments into database
        array_push($myDepartmentArray, $professor_department);

    }
}

//This is to insert departments into databases
$allDepartments = array_unique($myDepartmentArray);
foreach($allDepartments as $departmentName){
    $depart_id++;
    $date=date('Y-m-d H:i:s');
    $stmt = $connect->prepare("INSERT INTO departments(id, department_name, created_at, updated_at) VALUES (?,?, ?,?)");
    $stmt->bind_param('isss',$depart_id, $departmentName, $date, $date);
    if(!$stmt->execute()){
        echo $connect->error;
    }
}
?>