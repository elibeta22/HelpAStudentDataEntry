<?php
$connect = mysqli_connect("localhost", "root", "root", "study_guide_app");
$filename = "items_schools_18.json";
$data = file_get_contents($filename);
$array = json_decode($data, true);
$myDepartments = array();
$myDepartmentArray = [];
$myUserType = ["student","professor"];

$id =0;
$professor_id = 0;
foreach($array as $row){
//
    $id++;

//    you need to leave this uncommented for professors database
    $school_name = $row["school_name"];

    $stmt = $connect->prepare("SELECT id FROM schools WHERE school_name = ?");
    $stmt->bind_param("s", $school_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $school_id_row = mysqli_fetch_assoc($result);
    $school_id = $school_id_row['id'];



//this is to insert professors or departments into database
    for ($i = 0; $i < count($row['school_top_professors']['professor_name']); $i++){
        $id++;
        $date=date('Y-m-d H:i:s');
        $professor_name = $row['school_top_professors']['professor_name'][$i];
        $professor_department = $row['school_top_professors']['professor_department'][$i];
        if($professor_department == NULL){
            $professor_department = "Unknown";
        }
        $stmt2 = $connect->prepare("SELECT id FROM departments WHERE name = ?");
        $stmt3 = $connect->prepare("SELECT id FROM users WHERE name = ?");
        $stmt2->bind_param("s", $professor_department);
        $stmt3->bind_param("s", $professor_name);
        $stmt2->execute();
        $stmt3->execute();
        $result_department = $stmt2->get_result();
        $result_name = $stmt3->get_result();
        $user_id_row = mysqli_fetch_assoc($result_name);
        $department_id_row = mysqli_fetch_assoc($result_department);
        $department_id = $department_id_row['id'];
        $professor_user_id = $user_id_row['id'];

        $professor_rating = $row['school_top_professors']['professor_rating'][$i];
        if($professor_rating == NULL){
            $professor_rating = "NONE";
        }
        $professor_id++;
        $sql = "INSERT INTO professors(professor_id, user, school_id, department_id, rate, created_at) VALUES (?,?, ?,?, ?,?)";
        $stmt = $connect->prepare("INSERT INTO professors(id, professor_user_id, school_id, department_id, rate, created_at) VALUES (?,?, ?,?, ?,?)");
        $stmt2 = $connect->prepare($school_id);
        $stmt->bind_param('iiiiis',$professor_id, $professor_user_id, $school_id, $department_id, $professor_rating, $date);
        if(!$stmt->execute()){
            echo $connect->error;
        }

    }
}

?>