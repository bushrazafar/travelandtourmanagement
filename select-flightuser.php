<?php 
include('includes/config.php');

 if(isset($_POST["userid"]))  
 {
    $userid = $_POST['userid'];  
      $output = '';
      $sql = "SELECT* from tblflightbooking
      WHERE tblflightbooking.BookingId =".$userid;  
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

                $cityid1 = $row["ArrivalCity"];
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
                       <td width="70%">'.$row["ContactNo"].'</td>  
                  </tr>  
                   
                    
                  <tr>  
                       <td width="30%"><label>GoingTo</label></td>  
                       <td width="70%">'.$cityname1.'</td>  
                  </tr>
                  <tr>  
                       <td width="30%"><label>ReturnDate</label></td>  
                       <td width="70%">'.$row["ReturnDate"].' </td>  
                  </tr>
                  <tr>  
                       <td width="30%"><label>TotalPerson</label></td>  
                       <td width="70%">'.$row["Passenger"].' </td>  
                  </tr>
                  <tr>  
                       <td width="30%"><label>Cabin</label></td>  
                       <td width="70%">'.$row["Cabin"].' </td>  
                  </tr>
                  ';  
        }  
        $output .= "</table></div>";  
        echo $output;  
    }  
 } 

 ?>