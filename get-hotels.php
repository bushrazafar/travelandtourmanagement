<?php 

include('includes/config.php');

$departid = $_POST['depart'];   // department id

$sql = "SELECT * FROM tblhotels WHERE HotelId=".$departid;
$result = $dbh ->prepare($sql);
$result->execute();
$resultset = $result->fetchAll();

$users_arr = array();

foreach($resultset as $city){
    $cityid = $city['StayPrice'];
    $name = $city['HotelFeature'];
    $users_arr[] = array("StayPrice" => $cityid, "HotelFeature" => $name);
}
// encoding array to json format
echo json_encode($users_arr);