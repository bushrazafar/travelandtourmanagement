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
	$uname = $_SESSION['uname'];
$useremail=$_SESSION['login'];
$userid = $_SESSION['user_id'];
$utype = $_SESSION['utype'];
$mnumber = $_SESSION['umobile'];

$pid=intval($_GET['pkgid']);
//getting flight name
$hotelsql = "SELECT * from tblflights WHERE flightid=".$pid;
						 $hotelquery = $dbh->prepare($hotelsql);
						 $hotelquery->execute();
             $hotelresult = $hotelquery ->fetchAll();
             if($hotelquery->rowCount() > 0){
               foreach($hotelresult as $result){
                 $flightname = $result['FlightName'];

               }

             }

$d_cityId=$_POST['d_cityId'];	
$to_cityId=$_POST['to_cityId'];
$t_category=$_POST['t_category'];	
$tperson=$_POST['tperson'];
$d_date=$_POST['d_date'];
$a_date=$_POST['a_date'];

$dhotelId=$_POST['dhotels'];
//getting hotel name
$hotelsql = "SELECT * from tblhotels WHERE HotelId=".$dhotelId;
						 $hotelquery = $dbh->prepare($hotelsql);
						 $hotelquery->execute();
             $hotelresult = $hotelquery ->fetchAll();
             if($hotelquery->rowCount() > 0){
               foreach($hotelresult as $result){
                 $hotelname = $result['HotelName'];

               }

			 }
			 
$cdate=$_POST['cdate'];
$odate=$_POST['odate'];
$hperson=$_POST['hperson'];
$comment=$_POST['comment'];
$status=0;
$pdate = date('d/m/yy');
$sql="INSERT INTO tbl_flight_hotel_booking(FlightId,DepartureFrom,GoingTo,TravelCategory,TravelPerson,
DepartureDate,ArrivalDate,HotelId,CheckIn,CheckOut,GuestPerson,Comment,status,userid,TravellerName,Email,
Usertype,CreationDate) 
VALUES(:pid,:d_cityId,:to_cityId,:t_category,:tperson,:d_date,:a_date,:dhotelId,:cdate,:odate,:hperson,:comment,
:status,:userid,:uname,:useremail,:utype,:pdate)";
$query = $dbh->prepare($sql);
$query->bindParam(':pid',$pid,PDO::PARAM_STR);
$query->bindParam(':d_cityId',$d_cityId,PDO::PARAM_STR);
$query->bindParam(':to_cityId',$to_cityId,PDO::PARAM_STR);
$query->bindParam(':t_category',$t_category,PDO::PARAM_STR);
$query->bindParam(':tperson',$tperson,PDO::PARAM_STR);
$query->bindParam(':d_date',$d_date,PDO::PARAM_STR);
$query->bindParam(':a_date',$a_date,PDO::PARAM_STR);

$query->bindParam(':dhotelId',$dhotelId,PDO::PARAM_STR);
$query->bindParam(':cdate',$cdate,PDO::PARAM_STR);
$query->bindParam(':odate',$odate,PDO::PARAM_STR);
$query->bindParam(':hperson',$hperson,PDO::PARAM_STR);
$query->bindParam(':comment',$comment,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);

$query->bindParam(':userid',$userid,PDO::PARAM_STR);
$query->bindParam(':uname',$uname,PDO::PARAM_STR);
$query->bindParam(':useremail',$useremail,PDO::PARAM_STR);
$query->bindParam(':utype',$utype,PDO::PARAM_STR);
$query->bindParam(':pdate',$pdate,PDO::PARAM_STR);
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
    '<b>Departure Flight:  </b>'.$d_date.'<br/>'.'<b>No of Travellers: </b>'.$tperson;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
   // echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

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
<title>TMS | Flight Details</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">
<link href="css/select2.min.css" rel='stylesheet' type='text/css'>
<!-- Custom Theme files -->
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/select2.min.js"></script>
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" />
	<script>
		 new WOW().init();
	</script>
<script src="js/jquery-ui.js"></script>
					<script>
						$(function() {
						$( ".date" ).datepicker({
                            format: 'LT' ,
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
		<h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;"> TMS -Flight Details</h1>
	</div>
</div>
<!--- /banner ---->
<!--- selectroom ---->
<div class="selectroom">
	<div class="container">	
		  <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
<?php 
$pid=intval($_GET['pkgid']);
$sql = "SELECT * from tblflights where flightid=:pid";
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
			<div class="col-md-3 selectroom_left wow fadeInLeft animated" data-wow-delay=".5s">
				<img src="admin/planeimages/<?php echo htmlentities($result->PlaneLogo);?>" class="img-responsive" alt="">
			</div>
			<div class="col-md-8 selectroom_right wow fadeInRight animated" data-wow-delay=".5s">
				<h3><?php echo htmlentities($result->FlightName);?></h3>
				<input type="hidden" name="flightName" value="<?php echo htmlentities($result->FlightName);?>">
				<input type="hidden" name="flightId" value="<?php echo htmlentities($result->flightid);?>">
				<?php
						 $cityid = $result->DepartureFrom;
						 $citysql = "SELECT CityName FROM tblcities WHERE CityId=".$cityid;
						 $cityquery = $dbh->prepare($citysql);
						 $cityquery->execute();
						 $queryresult = $cityquery ->fetchAll();
						 if($cityquery->rowCount() > 0){
							 foreach($queryresult as $city){
								 $cityname = $city['CityName'];
							 }

						 }
					 ?>
					 <br/>
				<p><b>Departure From :</b> <?php echo htmlentities($cityname);?></p>
				<?php
						 $cityid1 = $result->GoingTo;
						 $citysql1 = "SELECT CityName FROM tblcities WHERE CityId=".$cityid1;
						 $cityquery1 = $dbh->prepare($citysql1);
						 $cityquery1->execute();
						 $queryresult1 = $cityquery1 ->fetchAll();
						 if($cityquery1->rowCount() > 0){
							 foreach($queryresult1 as $city1){
								 $cityname1 = $city1['CityName'];
							 }

						 }
					 ?>
				<p><b>Going To :</b> <?php echo htmlentities($cityname1);?></p>
					<p><b>Travelling Class:</b> <?php echo htmlentities($result->TravelCategory);?></p>
					<p><b>Departure Date:</b> <?php echo htmlentities($result->DepartureDate);?></p>
					<p><b>Arrival Date:</b> <?php echo htmlentities($result->ArrivalDate);?></p>

					<input type="hidden" name="d_city" value="<?php echo htmlentities($cityname);?>">
					<input type="hidden" name="d_cityId" value="<?php echo htmlentities($result->DepartureFrom);?>">

					<input type="hidden" name="to_city" value="<?php echo htmlentities($cityname1);?>">
					<input type="hidden" name="to_cityId" value="<?php echo htmlentities($result->GoingTo);?>">
					<input type="hidden" name="t_category" value="<?php echo htmlentities($result->TravelCategory);?>">
					<input type="hidden" name="d_date" value="<?php echo htmlentities($result->DepartureDate);?>" >
					<input type="hidden" name="a_date" value="<?php echo htmlentities($result->ArrivalDate);?>" >
					<div class="ban-bottom">
			
            <div class="bnr-right">
				<label class="inputLabel">Travelling Persons</label>
				<input style="font-weight: bold; text-align: center; width: 120px;" class="form-control"  id="tperson" type="number"  name="tperson" value="1" max="5" min="1" required="">
			    
			 </div>
			 <div class="bnr-right">
				<label class="inputLabel">Fare Price</label>
				<h3>Rs<?php echo htmlentities($result->SeatFare);?></h3>
			    
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
			<h2>For Booking Hotel In Departure City (-Optional-)</h2>
			<div class="selectroom-info animated wow fadeInUp animated" data-wow-duration="1200ms" data-wow-delay="500ms" style="visibility: visible; animation-duration: 1200ms; animation-delay: 500ms; animation-name: fadeInUp; margin-top: -70px">
				<ul>
                    <br/><br/><br/>
                    <div class="row">
                          <div class="col-md-12">
                          <div class="col-md-3 pr-1">
                                  <div class="form-group">
                                  <label>Select Hotel</label>
                                        <select class="form-control" name="dhotels" id="dhotels">
											<option  selected value="">-Select Hotel-</option>
                                            <?php foreach($queryresult as $country): ?>
											<option value="<?= $country['HotelId']; ?>"><?= $country['HotelName']; ?></option>
											
										     <?php endforeach; ?>
                                        </select>
                                  </div>
                              </div>
                              <div class="col-md-3 px-1">
                                  <div class="form-group">
                                  
                                            <label>CheckIn Date</label>
                                            <input style="font-weight: bold;" class="date" id="cdate" name="cdate" type="text"  placeholder="dd-mm-yyyy" value="">
                                        
                                  </div>
                              </div>
                              <div class="col-md-3 px-1">
                                  <div class="form-group">
                                  
                                            <label>CheckOut Date</label>
                                            <input style="font-weight: bold;" class="date" id="odate" name="odate" type="text" value="" placeholder="dd-mm-yyyy">
                                        
                                  </div>
							  </div>
							  <div class="col-md-3 px-1">
                                  <div class="form-group">
       
                                            <label>Charges Per Day </label>
                                            <input style="width: 150px; height: 50px; text-align: center; font-size: medium; font-weight: bold;" type="text" id="hcharges" value="0"  name="hcharges" class="form-control" readonly>
                                  </div>
							  </div>
							 
                          </div>
					</div>
					
					<div class="row">
                          <div class="col-md-12">
                          <div class="col-md-3 pr-1">
                                  <div class="form-group">
                                  <label>Guest Person</label>
								  <input style="text-align: center; font-weight: bold; margin-top: 20px;" type="number" max="5" min="1" value="" id="hperson" name="hperson" class="form-control">
                                  </div>
                              </div>
							  <div class="col-md-4 pl-1">
                                  <div class="form-group">
								  <label>Hotel Features</label>
								  <input style="width: 500px;"  type="text" id="hfeature" name="hfeature" class="form-control2" readonly>
                                  </div>
							  </div>
														 
                          </div>
					</div>		
					
					<div class="clearfix"></div>
				</ul>
			</div>
			
		</div>

		<div class="selectroom_top">
			<h2>Traveller Comment</h2>
			<div class="selectroom-info animated wow fadeInUp animated" data-wow-duration="1200ms" data-wow-delay="500ms" style="visibility: visible; animation-duration: 1200ms; animation-delay: 500ms; animation-name: fadeInUp; margin-top: -70px">
				<ul>
				
					<li class="spe">
						<label class="inputLabel">Comment</label>
						<input class="special" type="text" name="comment" required="">
					</li>
					<?php if(isset($_SESSION['login']))
					{?>
						<li class="spe" align="center">
					<button type="submit" name="submit2" class="btn-primary btn">Book</button>
						</li>
						<?php } else {?>
							<li class="sigi" align="center" style="margin-top: 1%">
							<a href="#" data-toggle="modal" data-target="#myModal4" class="btn-success btn" >Booking For Registed User</a>
							<button type="submit" formaction="flight-booking.php?type=flights" name="submit3" class="btn-primary btn">Booking For Guest User</button>
							
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

          });
        </script>

</body>
</html>