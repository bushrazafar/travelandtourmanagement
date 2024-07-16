<?php 
include('includes/config.php');

 if(isset($_POST["userid"]))  
 {
    $userid = $_POST['userid'];  
      $output = '';
      $sql = "SELECT tblguestbooking.BookingId AS BookID,tblguestbooking.TravellerName as FullName,tblguestbooking.status as status,tblguestbooking.CancelledBy as CancelBy,
      tblguestbooking.Email as Email,tblguestbooking.TravelPerson as TotalPerson,tblguestbooking.ContactNo as MobileNo,
      tblguestbooking.DepartureDate as DDate,tblflights.FlightName,
      tblcities.CityName as FromCity,tblguestbooking.GoingTo as GoingTo,tblhotels.HotelName as HotelName
      FROM tblguestbooking JOIN tblflights on tblguestbooking.FlightId = tblflights.flightid
      JOIN tblhotels on tblguestbooking.HotelId = tblhotels.HotelId
      JOIN tblcities on tblguestbooking.DepartureFrom = tblcities.CityId
      WHERE tblguestbooking.BookingId =".$userid;  
      $query = $dbh -> prepare($sql);
      $query->execute();
      $results=$query->fetchAll();
      if($query->rowCount() > 0)
      {    
        $output .= '  
        <div class="table-responsive">  
             <table class="table table-bordered">';  
             foreach($results as $row)
             { 

                $cityid1 = $row["GoingTo"];
						 $citysql1 = "SELECT CityName FROM tblcities WHERE CityId=".$cityid1;
						 $cityquery1 = $dbh->prepare($citysql1);
						 $cityquery1->execute();
						 $queryresult1 = $cityquery1 ->fetchAll();
						 if($cityquery1->rowCount() > 0){
							 foreach($queryresult1 as $city1){
								 $cityname1 = $city1['CityName'];
							 }

						 }
                 
             $output .= '  
                  <tr>  
                       <td width="30%"><label>Name</label></td>  
                       <td width="70%">'.$row["FullName"].'</td>  
                  </tr>  
                  <tr>  
                       <td width="30%"><label>Email</label></td>  
                       <td width="70%">'.$row["Email"].'</td>  
                  </tr>  
                  <tr>  
                       <td width="30%"><label>MobileNo</label></td>  
                       <td width="70%">'.$row["MobileNo"].'</td>  
                  </tr>  
                  <tr>  
                       <td width="30%"><label>FlightName</label></td>  
                       <td width="70%">'.$row["FlightName"].'</td>  
                  </tr>  
                  <tr>  
                       <td width="30%"><label>FromCity</label></td>  
                       <td width="70%">'.$row["FromCity"].'</td>  
                  </tr>  
                  <tr>  
                       <td width="30%"><label>GoingTo</label></td>  
                       <td width="70%">'.$cityname1.'</td>  
                  </tr>
                  <tr>  
                       <td width="30%"><label>DepartureDate</label></td>  
                       <td width="70%">'.$row["DDate"].' </td>  
                  </tr>
                  <tr>  
                       <td width="30%"><label>TotalPerson</label></td>  
                       <td width="70%">'.$row["TotalPerson"].' </td>  
                  </tr>
                  <tr>  
                       <td width="30%"><label>HotelName</label></td>  
                       <td width="70%">'.$row["HotelName"].' </td>  
                  </tr>
                  ';  
        }  
        $output .= "</table></div>";  
        echo $output;  
    }  
 } 

 ?>