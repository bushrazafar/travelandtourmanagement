<?php

include('includes/config.php');

if(isset($_POST["type"]))
{
 if($_POST["type"] == "city_data")
 {
  $query = "SELECT tblcities.CityId,tblcities.CityName FROM tblcities JOIN tblcountries 
  on tblcities.countryid = tblcountries.countryid
  WHERE tblcountries.CountryName = 'pakistan'
  ORDER BY tblcities.CityName ASC";
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
 elseif($_POST["type"] == "gcity_data"){

    $query = "SELECT * from tblcities ORDER by tblcities.CityName DESC";
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

 elseif($_POST["type"] == "country_data"){

   $query = "SELECT* from tblcountries ORDER by tblcountries.CountryName ASC";
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
 
}

?>