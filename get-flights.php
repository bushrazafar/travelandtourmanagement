<?php

include('includes/config.php');

if(isset($_POST["type"]))
{
 if($_POST["type"] == "flight_data")
 {
  $query = "SELECT * FROM tblflights ORDER BY FlightName ASC";
  $statement = $dbh->prepare($query);
  $statement->execute();
  $data = $statement->fetchAll();
  foreach($data as $row)
  {
   $output[] = array(
    'id'  => $row["flightid"],
    'name'  => $row["FlightName"]
   );
  }
  echo json_encode($output);
 }
 
}

?>