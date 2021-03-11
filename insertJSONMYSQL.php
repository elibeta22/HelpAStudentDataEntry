<?php
$connect = mysqli_connect("localhost", "elibeta", "Rocketqueen1!", "study_guide_app");
$filename = "items_schools_18.json";
$data = file_get_contents($filename);
$array = json_decode($data, true);
$myDepartments = array();
$myDepartmentArray = [];
$myUserType = ["student","professor"];
$myStatesFull = ["Unknown", "Alabama",
"Alaska",
"Arizona",
"Arkansas",
"California",
"Colorado",
"Connecticut",
"Delaware",
"Florida",
"Georgia",
"Hawaii",
"Idaho",
"Illinois",
"Indiana",
"Iowa",
"Kansas",
"Kentucky",
"Louisiana",
"Maine",
"Maryland",
"Massachusetts",
"Michigan",
"Minnesota",
"Mississippi",
"Missouri",
"Montana",
"Nebraska",
"Nevada",
"New Hampshire",
"New Jersey",
"New Mexico",
"New York",
"North Carolina",
"North Dakota",
"Ohio",
"Oklahoma",
"Oregon",
"Pennsylvania",
"Rhode Island",
"South Carolina",
"South Dakota",
"Tennessee",
"Texas",
"Utah",
"Vermont",
"Virginia",
"Washington",
"West Virginia",
"Wisconsin",
"Wyoming"];

$myStatesAb = ["N/a","AL",
"AK",
"AZ",
"AR",
"CA",
"CO",
"CT",
"DE",
"FL",
"GA",
"HI",
"ID",
"IL",
"IN",
"IA",
"KS",
"KY",
"LA",
"ME",
"MD",
"MA",
"MI",
"MN",
"MS",
"MO",
"MT",
"NE",
"NV",
"NH",
"NJ",
"NM",
"NY",
"NC",
"ND",
"OH",
"OK",
"OR",
"PA",
"RI",
"SC",
"SD",
"TN",
"TX",
"UT",
"VT",
"VA",
"WA",
"WV",
"WI",
"WY"];


//this is to insert states into database
//for ($i = 0; $i<51; $i++){
//    $date=date('Y-m-d H:i:s');
//    $addNum = $i + 1;
//    $stmt = $connect->prepare("INSERT INTO states(id, state, code, created_at) VALUES (?,?,?,?)");
//    $stmt->bind_param('isss',$addNum,$myStatesFull[$i], $myStatesAb[$i], $date);
//    if(!$stmt->execute()){
//        echo $connect->error;
//    }
//}


//    this is for inserting schools into local database
$id =0;
//$professor_id = 0;
//$school_inc_id = 1;
foreach($array as $row){
//
//    $id++;
//    $school_location = $row["school_location"];
//    $school_state = strtoupper($row["school_state"]);
//    $school_total_top_professors = $row["school_total_top_professors"];


//    you need to leave this uncommented for professors database
    $school_name = $row["school_name"];


//    $stmt = $connect->prepare("SELECT id FROM states WHERE code = ?");
//    $stmt->bind_param("s", $school_state);
//    $stmt->execute();
//    $stateResult = $stmt->get_result();
//    $state_id_row = mysqli_fetch_assoc($stateResult);
//    $state_id = isset($state_id_row['id']) ? $state_id_row['id'] : 1;
//    echo $state_id;
//    echo "\n";
//    $school_inc_id++;
//    $date=date('Y-m-d H:i:s');
//    $sql = "INSERT INTO schools(id, school_name, school_location, school_state_id, school_total_top_professors, created_at, updated_at) VALUES (?,?, ?,?, ?,?,?)";
//    $stmt = $connect->prepare($sql);
//    $stmt->bind_param('issiiss',$school_inc_id, $school_name, $school_location, $state_id, $school_total_top_professors, $date,$date);
//    $stmt->execute();

//
//    if(!$stmt->execute()){
//        echo $connect->error;
//    }

//    $school_id = "SELECT id FROM schools WHERE school_name = ?";
//
//    $stmt = $connect->prepare("SELECT id FROM schools WHERE school_name = ?");
//
//    $stmt->bind_param("s", $school_name);
//
//    $stmt->execute();
//    $result = $stmt->get_result();
//    $school_id_row = mysqli_fetch_assoc($result);
//    $school_id = $school_id_row['id'];
//

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
        $stmt2->bind_param("s", $professor_department);
        $stmt2->execute();
        $result_department = $stmt2->get_result();
        $department_id_row = mysqli_fetch_assoc($result_department);
        $department_id = $department_id_row['id'];




//        this needs to be uncommented for insertion of departments into database
        array_push($myDepartmentArray, $professor_department);


//        $professor_rating = $row['school_top_professors']['professor_rating'][$i];
//        if($professor_rating == NULL){
//            $professor_rating = "NONE";
//        }
//        $professor_id++;
//        $sql = "INSERT INTO professors(professor_id, professor_name, school_id, department_id, rate, created_at) VALUES (?,?, ?,?, ?,?)";
//        $stmt = $connect->prepare("INSERT INTO professors(professor_id, professor_name, school_id, department_id, rate, created_at) VALUES (?,?, ?,?, ?,?)");
//        $stmt2 = $connect->prepare($school_id);
//        $stmt->bind_param('isiiis',$professor_id, $professor_name, $school_id, $department_id, $professor_rating, $date);
//        if(!$stmt->execute()){
//            echo $connect->error;
//        }
//
    }
}


//This is to insert departments into databases
$allDepartments = array_unique($myDepartmentArray);
foreach($allDepartments as $departmentName){

    $id++;
    $date=date('Y-m-d H:i:s');
    $stmt = $connect->prepare("INSERT INTO departments(id, name, created_at, updated_at) VALUES (?,?, ?,?)");
    $stmt->bind_param('isss',$id, $departmentName, $date, $date);
    if(!$stmt->execute()){
        echo $connect->error;
    }
}
?>