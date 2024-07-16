<?php

include('includes/config.php');

if (isset($_POST['query'])) {

   $Name = $_POST['query'];
   $sql = "SELECT* FROM (SELECT tblcountries.countryid AS ID, tblcountries.CountryName as Name FROM tblcountries
            UNION ALL
           SELECT tblcities.CityId AS ID,tblcities.CityName as Name FROM tblcities) AS Cities
           WHERE Name LIKE '%$Name%' ";

           
            $query = $dbh ->prepare($sql);
                $query->execute();
                $resultset = $query->fetchAll();
                if ($query->rowCount() > 0) {
            foreach($resultset as $city){
                $Result[] = $city["Name"];
            }
            echo json_encode($Result);
            }
}

?>