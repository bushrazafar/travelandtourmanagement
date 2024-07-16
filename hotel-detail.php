<?php
session_start();
error_reporting(0);

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'lib/vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

include('includes/config.php');
if(isset($_POST['submit2']))
{
	
$pid=intval($_GET['pkgid']);

//getting hotel name
$hotelsql = "SELECT * from tblhotels WHERE HotelId=".$pid;
						 $hotelquery = $dbh->prepare($hotelsql);
						 $hotelquery->execute();
             $hotelresult = $hotelquery ->fetchAll();
             if($hotelquery->rowCount() > 0){
               foreach($hotelresult as $result){
                 $hotelname = $result['HotelName'];

               }

             }

$uname = $_SESSION['uname'];
$useremail=$_SESSION['login'];
$userid = $_SESSION['user_id'];
$utype = $_SESSION['utype'];
$mnumber = $_SESSION['umobile'];

$flightid = $_POST['dflight'];
//getting flight name
$hotelsql = "SELECT * from tblflights WHERE flightid=".$flightid;
						 $hotelquery = $dbh->prepare($hotelsql);
						 $hotelquery->execute();
             $hotelresult = $hotelquery ->fetchAll();
             if($hotelquery->rowCount() > 0){
               foreach($hotelresult as $result){
                 $flightname = $result['FlightName'];

               }

			 }
			 
$d_cityId=$_POST['dcity'];	
$to_cityId=$_POST['CityId'];
$t_category=$_POST['tcategory'];	
$tperson=$_POST['tperson'];
$d_date=$_POST['ddate'];
$a_date=$_POST['rdate'];

$cdate=$_POST['cdate'];
$odate=$_POST['odate'];
$hperson=$_POST['hperson'];
$comment=$_POST['comment'];

if(isset($_POST['rdWork'])){

	$rdWork=$_POST['rdWork'];
  }
  else{
	$rdWork = 'Not-select';
  }
  
  if(isset($_POST['rdBook'])){
  
	$rdBook=$_POST['rdBook'];
  }
  else
  {
	$rdBook = 'Not-select';
  }
  if(isset($_POST['defaultCheck1'])){
	$defaultCheck1=$_POST['defaultCheck1'];
  }
  else{
	$defaultCheck1 = 'No';
  
  }

$status=0;
$pdate = date('Y-m-d H:i:s');
$sql="INSERT INTO tbl_flight_hotel_booking(FlightId,DepartureFrom,GoingTo,TravelCategory,TravelPerson,
DepartureDate,ArrivalDate,HotelId,CheckIn,CheckOut,GuestPerson,Comment,status,userid,TravellerName,Email,
Usertype,WorkPurpose,BookingFor,CarBooking) 
VALUES(:flightid,:d_cityId,:to_cityId,:t_category,:tperson,:d_date,:a_date,:pid,:cdate,:odate,:hperson,:comment,
:status,:userid,:uname,:useremail,:utype,:rdWork,:rdBook,:defaultCheck1)";
$query = $dbh->prepare($sql);

$query->bindParam(':flightid',$flightid,PDO::PARAM_INT);
$query->bindParam(':d_cityId',$d_cityId,PDO::PARAM_INT);
$query->bindParam(':to_cityId',$to_cityId,PDO::PARAM_INT);
$query->bindParam(':t_category',$t_category,PDO::PARAM_STR);
$query->bindParam(':tperson',$tperson,PDO::PARAM_STR);
$query->bindParam(':d_date',$d_date,PDO::PARAM_STR);
$query->bindParam(':a_date',$a_date,PDO::PARAM_STR);

$query->bindParam(':pid',$pid,PDO::PARAM_INT);
$query->bindParam(':cdate',$cdate,PDO::PARAM_STR);
$query->bindParam(':odate',$odate,PDO::PARAM_STR);
$query->bindParam(':hperson',$hperson,PDO::PARAM_STR);
$query->bindParam(':comment',$comment,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_INT);

$query->bindParam(':userid',$userid,PDO::PARAM_INT);
$query->bindParam(':uname',$uname,PDO::PARAM_STR);
$query->bindParam(':useremail',$useremail,PDO::PARAM_STR);
$query->bindParam(':utype',$utype,PDO::PARAM_STR);
$query->bindParam(':rdWork',$rdWork,PDO::PARAM_STR);
$query->bindParam(':rdBook',$rdBook,PDO::PARAM_STR);
$query->bindParam(':defaultCheck1',$defaultCheck1,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{

	// send Email Work

	try {
		//Server settings
		$mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Enable verbose debug output
		$mail->isSMTP();                                            // Send using SMTP
		$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		$mail->Username   = 'aaspnet440@gmail.com';                     // SMTP username
		$mail->Password   = 'passwordis';                               // SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		$mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
	
		//Recipients
		$mail->setFrom('aaspnet440@gmail.com', 'E-Travels');
		$mail->addAddress($useremail, $uname);     // Add a recipient
		// $mail->addAddress('ellen@example.com');               // Name is optional
		// $mail->addReplyTo('info@example.com', 'Information');
		// $mail->addCC('cc@example.com');
		// $mail->addBCC('bcc@example.com');
	
		// // Attachments
		// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	
		// Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = 'Reservation Applicant';
		$mail->Body    = '<b>Applicant Name :</b>'.$uname.'<br/>'.'<b>Contact No :</b>'.$mnumber.'<br/><br/><br/>'.
		'<b>Hotel Reservation Name:</b>'.$hotelname.'<br/>'.'<b>hotel CheckIN Date:</b>'.$cdate.'<br/>'.' <b>Hotel CheckOUT Date :</b>'.$odate.'<br/>'.
		'<b>Persons For Hotel : </b>'.$hperson.'<br/><br/><br/>'.'<b>Flight Name : </b>'.$flightname.'<br/>'.
		'<b>Departure Date:  </b>'.$d_date.'<br/>'.'<b>No of Travellers: </b>'.$tperson.'<br/>'.'<b> Booking For Work: </b>'.$rdWork
		.'<br/>'.'<b> Booking For: </b>'.$rdBook.'<br/>'.'<b> Car Book:  </b>'.$defaultCheck1;
		// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	
		$mail->send();
	   // echo 'Message has been sent';
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
	// end php mailer

$msg="Booked Successfully";
header('Location: thankyou.php');

}
else 
{
$error="Something went wrong. Please try again";
}

}

?>
<!DOCTYPE HTML>
<html>
<head>
<title>TMS | Hotels</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">
<!-- Custom Theme files -->
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<link href="css/select2.min.css" rel='stylesheet' type='text/css'>
<script src="js/select2.min.js"></script>
<script src="js/wow.min.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" />
	<script>
		 new WOW().init();
	</script>
<script src="js/jquery-ui.js"></script>
					<script>
						$(function() {
						$( ".date" ).datepicker({
                            format: 'DD/MM/YYYY' ,
				            minDate:new Date() 
                        });
						});
					</script>
	  <style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>				
</head>
<body>
<!-- top-header -->
<?php include('includes/header.php');?>
<div class="banner-3">
	<div class="container">
		<h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;"> TMS -Hotels</h1>
	</div>
</div>
<!--- /banner ---->
<!--- selectroom ---->
<div class="selectroom">
	<div class="container">	
		  <?php if($error){?><div class="errorWrap bg-danger"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap bg-success"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
<?php 
$pid=intval($_GET['pkgid']);
$sql = "SELECT tblcountries.CountryName,tblcities.CityId,tblcities.CityName,tblhotels.HotelId,tblhotels.HotelName,tblhotels.StayPrice,tblhotels.HotelFeature,tblhotels.HotelImage
FROM tblhotels
JOIN tblcountries on tblhotels.CountryId = tblcountries.countryid
JOIN tblcities on tblhotels.CityId = tblcities.CityId 
WHERE tblhotels.HotelId =:pid";
$query = $dbh->prepare($sql);
$query -> bindParam(':pid', $pid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{	?>

<form name="book" method="post">
		<div class="selectroom_top">
			<div class="col-md-4 selectroom_left wow fadeInLeft animated" data-wow-delay=".5s">
				<img src="admin/countryimages/hotelsimages/<?php echo htmlentities($result->HotelImage);?>" class="img-responsive" alt="">
			</div>
			<div class="col-md-8 selectroom_right wow fadeInRight animated" data-wow-delay=".5s">
				<h2><?php echo htmlentities($result->HotelName);?></h2>
				<input type="hidden" name="HotelName" value="<?php echo htmlentities($result->HotelName);?>">
				<input type="hidden" name="HotelId" value="<?php echo htmlentities($result->HotelId);?>">

				<p><b>Country :</b> <?php echo htmlentities($result->CountryName);?></p>
				<input type="hidden" name="CountryName" value="<?php echo htmlentities($result->CountryName);?>">
				<input type="hidden" name="CountryId" value="<?php echo htmlentities($result->CountryId);?>">

				<p><b>City :</b> <?php echo htmlentities($result->CityName);?></p>
				<input type="hidden" name="CityName" value="<?php echo htmlentities($result->CityName);?>">
				<input type="hidden" name="CityId" value="<?php echo htmlentities($result->CityId);?>">

					<p><b>Features:</b> <?php echo htmlentities($result->HotelFeature);?></p>
					<div class="ban-bottom">
				<div class="bnr-right">
				<label class="inputLabel">CheckIn Date</label>
				<input style="font-weight: bold;" class="date" id="cdate" name="cdate" type="text" placeholder="dd-mm-yyyy"   required="">
			</div>
			<div class="bnr-right">
				<label class="inputLabel">Arrival Date</label>
				<input style="font-weight: bold;" class="date" id="odate" name="odate" type="text" placeholder="dd-mm-yyyy"  required="">
			</div>
			
            <div class="bnr-right">
			&nbsp; &nbsp;&nbsp;
				<label class="inputLabel">Guest Persons</label>
				<input style="font-weight: bold; text-align: center; width: 120px;" class="form-control"  id="hperson" name="hperson" type="number"   value="1" max="5" min="1" required="">
			</div>
			<div class="bnr-right">
			&nbsp; &nbsp;&nbsp;
				<label class="inputLabel">Fare Per Person</label>
				<h3>Rs<?php echo htmlentities($result->StayPrice);?></h3>
			</div>
			</div>
						<div class="clearfix"></div>
				
			</div>
	
				<div class="clearfix"></div>
		</div>
		<?php
						 $cityid1 = $result->GoingTo;
						 $citysql1 = "SELECT * from tblhotels WHERE CityId=".$cityid1;
						 $cityquery1 = $dbh->prepare($citysql1);
						 $cityquery1->execute();
						 $queryresult = $cityquery1 ->fetchAll();
						 
					 ?>
		
        
		<div class="selectroom_top">
			<h2>Reserve Flight Seat To Go </h2>
			<div class="selectroom-info animated wow fadeInUp animated" data-wow-duration="1200ms" data-wow-delay="500ms" style="visibility: visible; animation-duration: 1200ms; animation-delay: 500ms; animation-name: fadeInUp; margin-top: -70px">
				<ul>
                    <br/><br/>
                    <div class="row">
					<div class="col-md-12">
					<div class="col-md-3 pr-1">
                                  <div class="form-group">
								  <label>Find Flight</label>
                                        <select class="form-control" name="dflight" id="dflight">                                         
                                            
                                        </select>
                                  </div>
							  </div>
							  <div class="col-md-3 px-1">
                                  <div class="form-group">
                                  
                                            <label>Departure City</label>
                                            <select class="form-control" name="dcity" id="dcity">                                         
                                            
                                        </select>
                                        
                                  </div>
							  </div>
							  <div class="col-md-3 pl-1">
                                  <div class="form-group">
                                  
                                            <label>Cabin</label>
                                            <select style="margin-top: 0px;" class="form-control" name="tcategory" id="tcategory">                                         
											<option value="Economy">Economy</option>
											<option value="Exective">Exective Economy</option>
											<option value="Business">Business</option>
                                        </select>
                                        
                                  </div>
                              </div>
					</div>
					<br/><br/><br/><br/>
                          <div class="col-md-12">
						 
                              <div class="col-md-3 pr-1">
                                  <div class="form-group">
                                  
                                            <label>Dparture Date</label>
                                            <input style="font-weight: bold;" class="date" id="ddate" name="ddate" type="text"  placeholder="dd-mm-yyyy" required>
                                        
                                  </div>
                              </div>
                              <div class="col-md-3 px-1">
                                  <div class="form-group">
                                  
                                            <label>Return Date</label>
                                            <input style="font-weight: bold;" class="date" id="rdate" name="rdate" type="text"  placeholder="dd-mm-yyyy" required>
                                        
                                  </div>
							  </div>
							  <div class="col-md-3 pl-1">
                                  <div class="form-group">
                                  <label>Person To Be Travall</label>
								  <input style="text-align: center; width: 90px; font-weight: bold; margin-top: 15px;" type="number" min="1" value="1" id="tperson" name="tperson" class="form-control">
                                  </div>
                              </div>
							 
                          </div>
					</div>
					
					<div class="row">
                          <div class="col-md-12">
                          														 
                          </div>
					</div>						
					<div class="clearfix"></div>
				</ul>
			</div>
			
		</div>

		<div class="selectroom_top">
			<h2>Traveller Comment</h2>
			<br/><br/>
			<div class="selectroom-info animated wow fadeInUp animated" data-wow-duration="1200ms" data-wow-delay="500ms" style="visibility: visible; animation-duration: 1200ms; animation-delay: 500ms; animation-name: fadeInUp; margin-top: -70px">
				<ul>
				<div class="row">

                 <div class="col-md-6 col-sm-6">

				 <div class="row">
                              <div class="col-md-6 pr-1">
                              <label>Are you travelling for work?</label>
                              <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="rdWork" id="inlineRadio1" value="YES">
                              <label class="form-check-label" for="inlineRadio1">Yes</label> &nbsp;
                              <input class="form-check-input" type="radio" name="rdWork" id="inlineRadio2" value="NO">
                              <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
                            
                              
                              </div>
					</div>
					<br/>
					<div class="row">
                              <div class="col-md-12 pr-1">
                              <label>Who are you booking for?</label>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rdBook" id="inlineRadio3" value="Owner">
                                <label class="form-check-label" for="inlineRadio3">&nbsp; I am the main guest</label>
                                <input class="form-check-input" type="radio" name="rdBook" id="inlineRadio4" value="Guest">
                                <label class="form-check-label" for="inlineRadio4">&nbsp;Booking is for someone else</label>
                              </div>
                              
                              </div>
					</div>
					<br/>
					<div class="row">
                              <div class="col-md-10 pr-1">
                              <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="YES" name="defaultCheck1" id="defaultCheck1">
                              <label class="form-check-label" for="defaultCheck1">&nbsp;
                              I'm interested in renting a car
                              </label>
                            </div>
                              </div>
                    </div>
					
				 </div>

				</div>
				
					<li class="spe">
						<label class="inputLabel">Comment</label>
						<input class="special" type="text" name="comment" required="">
					</li>
					<?php if(isset($_SESSION['login']))
					{?>
						<li class="spe" align="center">
					<button type="submit" name="submit2" class="btn-primary btn">Booking Request</button>
						</li>
						<?php } else {?>
							<li class="sigi" align="center" style="margin-top: 1%">
							<a href="#" data-toggle="modal" data-target="#myModal4" class="btn-success btn" >Booking For Registed User</a>
							
							<button type="submit" formaction="hotel-booking.php?type=hotels" name="submit3" class="btn-primary btn">Booking For Guest User</button>
						</li>
							<?php } ?>
					<div class="clearfix"></div>
				</ul>
			</div>
			
		</div>
		</form>
<?php }} ?>


	</div>
</div>
<!--- /selectroom ---->
<!--- /footer-top ---->
<?php include('includes/footer.php');?>
<!-- signup -->
<?php include('includes/signup.php');?>			
<!-- //signu -->
<!-- signin -->
<?php include('includes/signin.php');?>			
<!-- //signin -->
<!-- write us -->
<?php include('includes/write-us.php');?>

<script type="text/javascript">
          $(document).ready(function(){
			  
			$("#dhotels").change(function(){
        var deptid = $(this).val();
        $.ajax({
            url: 'get-hotels.php',
            type: 'post',
            data: {depart:deptid},
            dataType: 'json',
            success:function(response){
                var len = response.length;           
                for( var i = 0; i<len; i++){
                    var id = response[i]['StayPrice'];
                    var name = response[i]['HotelFeature'];
					
					$("#hcharges").val(id);
                     $("#hfeature").val(name);
                }
            }
        });
		
    }); 
	   
	   // for get flights

	        load_data('flight_data');

            function load_data(type)
                {
                    $.ajax({
                    url:"get-flights.php",
                    method:"POST",
                    data:{type:type},
                    dataType:"json",
                    success:function(data)
                    {
                        var html = '';
                        for(var count = 0; count < data.length; count++)
                        {
                        html += '<option value="'+data[count].id+'">'+data[count].name+'</option>';
                        }
                        if(type == 'flight_data')
                        {
                        $('#dflight').html(html);
                       
                        }
                        $("#dflight").select2({
                            data: data
                            });
                    
                    }
                    })
                } ;

				load_data1('city_data');

				function load_data1(type)
					{
						$.ajax({
						url:"get-cities.php",
						method:"POST",
						data:{type:type},
						dataType:"json",
						success:function(data)
						{
							var html = '';
							for(var count = 0; count < data.length; count++)
							{
							html += '<option value="'+data[count].id+'">'+data[count].name+'</option>';
							}
							if(type == 'city_data')
							{
							$('#dcity').html(html);
						
							}
							$("#dcity").select2({
								data: data
								});
						
						}
						})
					};

          });
        </script>

</body>
</html>