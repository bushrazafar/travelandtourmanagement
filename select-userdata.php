<?php 
include('includes/config.php');

 if(isset($_POST["userid"]))  
 {
    $userid = $_POST['userid'];  
      $output = '';
      $sql = "SELECT tbl_flight_hotel_booking.BookingId as BookId, tbl_flight_hotel_booking.TravelCategory as Category,
      tbl_flight_hotel_booking.TravelPerson as TotalPerson, tbl_flight_hotel_booking.DepartureDate as Ddate ,tbl_flight_hotel_booking.GoingTo AS GoingTo, 
      tbl_flight_hotel_booking.ArrivalDate as Adate,tbl_flight_hotel_booking.Comment as comment, 
      tbl_flight_hotel_booking.status as status, tbl_flight_hotel_booking.CancelledBy as cancelBy,
      tbl_flight_hotel_booking.CheckIn as CheckIn, tbl_flight_hotel_booking.CheckOut as CheckOut, 
      tblusers.FullName as FullName,tblusers.MobileNumber as MobileNo,
      tblusers.EmailId AS Email,tblflights.FlightName,tblcities.CityName as Departurecity, 
      tblhotels.HotelName as Hotel FROM tbl_flight_hotel_booking 
      JOIN tblusers on tbl_flight_hotel_booking.userid = tblusers.userid 
      JOIN tblcities ON tbl_flight_hotel_booking.DepartureFrom = tblcities.CityId 
      JOIN tblhotels ON tbl_flight_hotel_booking.HotelId = tblhotels.HotelId 
      JOIN tblflights ON tbl_flight_hotel_booking.FlightId = tblflights.flightid
      WHERE tbl_flight_hotel_booking.BookingId =".$userid;  
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
                       <td width="70%">'.$row["Departurecity"].'</td>  
                  </tr>  
                  <tr>  
                       <td width="30%"><label>GoingTo</label></td>  
                       <td width="70%">'.$cityname1.'</td>  
                  </tr>
                  <tr>  
                       <td width="30%"><label>DepartureDate</label></td>  
                       <td width="70%">'.$row["Ddate"].' </td>  
                  </tr>
                  <tr>  
                       <td width="30%"><label>TotalPerson</label></td>  
                       <td width="70%">'.$row["TotalPerson"].' </td>  
                  </tr>
                  <tr>  
                       <td width="30%"><label>HotelName</label></td>  
                       <td width="70%">'.$row["Hotel"].' </td>  
                  </tr>
                  ';  
        }  
        $output .= "</table></div>";  
        echo $output;  
    }  
 } 

 ?>