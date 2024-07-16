<?php 

include('includes/config.php');

$departid = $_POST['depart'];   // department id

$sql = "SELECT CityId,CityName FROM tblcities WHERE countryid=".$departid;
$result = $dbh->prepare($sql);
$result->execute();
$resultset = $result->fetchAll();

$users_arr = array();

foreach($resultset as $city){
    $cityid = $city['CityId'];
    $name = $city['CityName'];
    $users_arr[] = array("CityId" => $cityid, "CityName" => $name);
}
// encoding array to json format
echo json_encode($users_arr);
 