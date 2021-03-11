<?php
function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

$connect = mysqli_connect("localhost", "elibeta", "Rocketqueen1!", "study_guide_app");
$filename = "HAS_PROF_DATA";
$data = file_get_contents($filename);
$array = json_decode($data, true);
$myDepartments = array();
$myDepartmentArray = [];
$myUserType = ["student","professor"];

$id =0;
$professor_id = 0;
$id_for_review = 0;
$user_id = 1;

foreach($array as $row) {
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

    for ($i = 0; $i < count($row['school_professors']['professor_names']); $i++){
        $id++;
        $date=date('Y-m-d H:i:s');
        $professor_name = $row['school_professors']['professor_names'][$i];
        $professor_department = $row['school_professors']['professor_departments'][$i];
        if($professor_department == NULL){
            $professor_department = "Unknown";
        }
        $stmt2 = $connect->prepare("SELECT id FROM departments WHERE department_name = ?");
        $stmt2->bind_param("s", $professor_department);
        $stmt2->execute();
        $result_department = $stmt2->get_result();
        $department_id_row = mysqli_fetch_assoc($result_department);
        $department_id = $department_id_row['id'];

        $professor_rating = $row['school_professors']['professor_ratings'][$i];
        if($professor_rating == NULL){
            $professor_rating = "NONE";
        }
        $professor_id++;
        $user_id++;
        $random_string = randomPassword();
        $email = "hasapp{$random_string}@gmail.com";
        $user_type = 2;
        $image = "Pictures\ME";
        $password = password_hash($random_string, PASSWORD_DEFAULT);
        $coment = "Review found on the web for this professor!";
        $is_able = 1;
        $review_by = 1;
        $sql = $connect->prepare("INSERT INTO users(id, user_type_id, email, email_verified_at, password, image, is_able_to_login) VALUES (?,?,?, ?,?, ?,?)");

        $sql2 = $connect->prepare("INSERT INTO professors(id, professor_user_id, professor_name, school_id, department_id, created_at) VALUES (?,?, ?,?, ?,?)");
        $sql->bind_param('iissssi',$user_id, $user_type, $email, $date,$password, $image, $is_able );
        $sql2->bind_param('iisiis',$professor_id, $user_id, $professor_name, $school_id, $department_id, $date);
        $sql->execute();
        $sql2->execute();
        if($professor_rating>0.00){
            $id_for_review++;
            $sql3 = $connect->prepare("INSERT INTO reviews(id, review_for, review_by, rating, review_date, comment) VALUES (?,?,?,?, ?,?)");
            $sql3->bind_param('iiiiss',$id_for_review, $professor_id, $review_by, $professor_rating,$date, $coment);
            $sql3->execute();


        }



    }
}

?>