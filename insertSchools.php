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

//    this is for inserting schools into local database
$id =0;
//$professor_id = 0;
$school_inc_id = 0;
foreach($array as $row){

    $id++;
    $school_location = $row["school_location"];
    $school_state = strtoupper($row["school_state"]);
    $school_total_top_professors = $row["school_total_top_professors"];
    $school_name = $row["school_name"];

    $stmt = $connect->prepare("SELECT id FROM states WHERE code = ?");
    $stmt->bind_param("s", $school_state);
    $stmt->execute();
    $stateResult = $stmt->get_result();
    $state_id_row = mysqli_fetch_assoc($stateResult);
    $state_id = isset($state_id_row['id']) ? $state_id_row['id'] : 1;

    $school_inc_id++;
    $date=date('Y-m-d H:i:s');
    $sql = "INSERT INTO schools(id, school_name, school_location, school_state_id, school_total_top_professors, created_at, updated_at) VALUES (?,?, ?,?, ?,?,?)";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param('issiiss',$school_inc_id, $school_name, $school_location, $state_id, $school_total_top_professors, $date,$date);
    $stmt->execute();

}



?>