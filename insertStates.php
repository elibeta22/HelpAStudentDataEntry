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
for ($i = 0; $i<51; $i++){
    $date=date('Y-m-d H:i:s');
    $addNum = $i + 1;
    $stmt = $connect->prepare("INSERT INTO states(id, state, code, created_at) VALUES (?,?,?,?)");
    $stmt->bind_param('isss',$addNum,$myStatesFull[$i], $myStatesAb[$i], $date);
    if(!$stmt->execute()){
        echo $connect->error;
    }
}

?>