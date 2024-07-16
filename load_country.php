<?php

include('includes/config.php');

if(isset($_POST["type"]))
{
 if($_POST["type"] == "country_data")
 {
  $query = "SELECT * FROM tblcountries ORDER BY CountryName ASC";
  $statement = $dbh->prepare($query);
  $statement->execute();
  $data = $statement->fetchAll();
  foreach($data as $row)
  {
   $output[] = array(
    'id'  => $row["countryid"],
    'name'  => $row["CountryName"]
   );
  }
  echo json_encode($output);
 }

 // departure city

 if($_POST["type"] == "load_departurecity")
 {
  $query = "SELECT CityId,CityName FROM tblcities ORDER BY CityName ASC";
  $statement = $dbh->prepare($query);
  $statement->execute();
  $data = $statement->fetchAll();
  foreach($data as $row)
  {
   $output[] = array(
    'id'  => $row["CityId"],
    'name'  => $row["CityName"]
   );
  }
  echo json_encode($output);
 }

 // arrival city

 if($_POST["type"] == "load_arrivalcity")
 {
  $query = "SELECT CityId,CityName FROM tblcities ORDER BY CityName ASC";
  $statement = $dbh->prepare($query);
  $statement->execute();
  $data = $statement->fetchAll();
  foreach($data as $row)
  {
   $output[] = array(
    'id'  => $row["CityId"],
    'name'  => $row["CityName"]
   );
  }
  echo json_encode($output);
 }

// flights

 if($_POST["type"] == "load_flights")
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
