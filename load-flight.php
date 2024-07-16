<?php

include('includes/config.php');

if (isset($_POST['query'])) {

   $Name = $_POST['query'];
   $sql = "SELECT CityId,CityName FROM tblcities
           WHERE CityName LIKE '%$Name%' ";

           
            $query = $dbh ->prepare($sql);
                $query->execute();
                $resultset = $query->fetchAll();
                if ($query->rowCount() > 0) {
            foreach($resultset as $city){
                $Result[] = $city["CityName"];
            }
            echo json_encode($Result);
            }
}

?>