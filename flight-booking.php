<?php
session_start();
//error_reporting(0);

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
if(isset($_POST['submit1']))
{
  
$flightId=$_POST['flightId'];

//getting flight name
$hotelsql = "SELECT * from tblflights WHERE flightid=".$flightId;
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

$dhotelId=$_POST['dhotelId'];
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

$fname=$_POST['fname'];
$cnumber=$_POST['cnumber'];
$mnumber=$_POST['mnumber'];
$dgender=$_POST['dgender'];
$uemail=$_POST['uemail'];
$pdate = date('d/m/yy');

$sql="INSERT INTO  tblguestbooking(FlightId,DepartureFrom,GoingTo,TravelCategory,TravelPerson,DepartureDate,ArrivalDate,HotelId,CheckIn,CheckOut,GuestPerson,Comment,TravellerName,CNIC,ContactNo,Gender,Email,CreationDate) VALUES(:flightId,:d_cityId,:to_cityId,:t_category,:tperson,:d_date,:a_date,:dhotelId,:cdate,:odate,:hperson,:comment,:fname,:cnumber,:mnumber,:dgender,:uemail,:pdate)";
$query = $dbh->prepare($sql);

$query->bindParam(':flightId',$flightId,PDO::PARAM_STR);
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

$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':cnumber',$cnumber,PDO::PARAM_STR);
$query->bindParam(':mnumber',$mnumber,PDO::PARAM_STR);
$query->bindParam(':dgender',$dgender,PDO::PARAM_STR);
$query->bindParam(':uemail',$uemail,PDO::PARAM_STR);
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
    $mail->addAddress($uemail, $fname);     // Add a recipient
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
    $mail->Body    = '<b>Applicant Name :</b>'.$fname.'<br/>'.'<b>Contact No :</b>'.$mnumber.'<br/><br/><br/>'.
    '<b>Hotel Reservation Name:</b>'.$hotelname.'<br/>'.'<b>hotel CheckIN Date:</b>'.$cdate.'<br/>'.' <b>Hotel CheckOUT Date :</b>'.$odate.'<br/>'.
    '<b>Persons For Hotel : </b>'.$hperson.'<br/><br/><br/>'.'<b>Flight Name : </b>'.$flightname.'<br/>'.
    '<b>Departure Flight:  </b>'.$d_date.'<br/>'.'<b>No of Travellers: </b>'.$tperson;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
   // echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
// end php mailer

$msg="Successfully submited";
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
<title>TMS | Tourism Management System</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Tourism Management System In PHP" />
<script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">
<link href="css/bootstrap-datetimepicker.css" rel='stylesheet' type='text/css'>
<link href="css/bootstrap-datetimepicker.min.css" rel='stylesheet' type='text/css'>
<!-- Custom Theme files -->
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" />
	<script>
		 new WOW().init();
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
<div class="top-header">
<?php include('includes/header.php');?>
<div class="banner-1 ">
	<div class="container">
		<h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">TMS-Tourism Management System</h1>
	</div>
</div>
<!--- /banner-1 ---->
<!--- privacy ---->
<div class="privacy">
	<div class="container">
		<h3 class="wow fadeInDown animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">Flight Reservation </h3>
		<form name="enquiry" method="post">

		 <?php if(isset($error)){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
                else if(isset($msg)){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                
                <div class="selectroom_top">
			
			<div class="selectroom-info animated wow fadeInUp animated" data-wow-duration="1200ms" data-wow-delay="500ms" style="visibility: visible; animation-duration: 1200ms; animation-delay: 500ms; animation-name: fadeInUp; margin-top: -70px">
				<ul>
                    <h4>Provide Details For Booking</h4>
                    
                    <div class="row">
                 <div class="col-md-6 col-sm-6">
                    <div class="row">
                              <div class="col-md-6 pr-1">
                              <div class="form-group">
                              <label>Full Name</label>
                              <input type="text" name="fname" class="form-control" id="fname" placeholder="Full Name" required>
                              </div>
                              </div>
                    </div>
                    <div class="row">       
                              <div class="col-md-6 pr-1">
                              <div class="form-group">
                              <label>C.N.I.C</label>
                              <input class="form-control" name="cnumber" id="cnumber" type="text" placeholder="CNIC Without Dashes" maxlength="13" required>
                              </div>
                              </div>
                    </div> 
                    <div class="row">     
                              <div class="col-md-6 pr-1">
                              <div class="form-group">
                              <label>Contact Number</label>
                              <input class="form-control" name="mnumber" id="mnumber" type="text" placeholder="03xxxxxxxxx" maxlength="11" required>
                              </div>
                              </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6 pr-1">
                              <div class="form-group">
                              <label>Gender</label>
                              <select name="dgender" id="dgender" class="form-control">
                                  <option value="Male">Male</option>
                                  <option value="Female">Female</option>
                              </select>
                              </div>
                              </div>
                        </div>
                        <div class="row">   
                              <div class="col-md-6 pr-1">
                              <div class="form-group">
                              <label>Email Address</label>
                              <input class="form-control" name="uemail" id="uemail" type="email" placeholder="Active Email Address" required>
                              </div>
                              </div>
                        </div>
                 </div>

                 <?php

if(isset($_POST['submit3'])){

?>


<div class="col-md-6 col-sm-6">
<h4>Flight Details</h4>
<div class="form-group">
<input type="hidden" name="flightId" id="flightId" value="<?php echo $_POST['flightId'];?>" class="form-control" placeholder="" aria-describedby="helpId">
  <p><b>Flight Name &nbsp;&rarr;</b> <?php echo htmlentities($_POST['flightName']);?></p>
  <input type="hidden" name="flightName" id="flightName" value="<?php echo $_POST['flightName'];?>" class="form-control" placeholder="" aria-describedby="helpId">
  
</div>
<div class="form-group">
<p><b>Departure From &rarr; </b><?php echo $_POST['d_city'];?>&nbsp;&nbsp;</p>
  <input type="hidden" name="d_cityId" id="d_cityId" value="<?php echo $_POST['d_cityId'];?>" class="form-control" placeholder="" aria-describedby="helpId">
  <p><b>Going To &nbsp;&rarr; </b><?php echo $_POST['to_city'];?></p>
  <input type="hidden" name="to_cityId" id="to_cityId" value="<?php echo $_POST['to_cityId'];?>" class="form-control" placeholder="" aria-describedby="helpId">
</div>
<div class="form-group">
<p><b>Travelling Class &nbsp;&rarr;</b> <?php echo $_POST['t_category'];?></p>
  <input type="hidden" name="t_category" id="t_category" value="<?php echo $_POST['t_category'];?>" class="form-control" placeholder="" aria-describedby="helpId">
  <p><b>No Of Travellers &nbsp;&rarr;</b> <?php echo $_POST['tperson'];?></p>
  <input type="hidden" name="tperson" id="tperson" value="<?php echo $_POST['tperson'];?>" class="form-control" placeholder="" aria-describedby="helpId">
</div>
<div class="form-group">
<p><b>Departure Date &nbsp;&rarr; </b><?php echo $_POST['d_date'];?></p>
  <input type="hidden" name="d_date" id="d_date" value="<?php echo $_POST['d_date'];?>" class="form-control" placeholder="" aria-describedby="helpId">
  <p><b>Arrival Date &nbsp;&rarr; </b><?php echo $_POST['a_date'];?></p>
  <input type="hidden" name="a_date" id="a_date" value="<?php echo $_POST['a_date'];?>" class="form-control" placeholder="" aria-describedby="helpId">
</div>
<h4> Hotel Deatils</h4>
<div class="form-group">
  <?php
     $hotelid =  $_POST['dhotels'];
     $hotelsql = "SELECT * from tblhotels WHERE HotelId=".$hotelid;
						 $hotelquery = $dbh->prepare($hotelsql);
						 $hotelquery->execute();
             $hotelresult = $hotelquery ->fetchAll();
             if($hotelquery->rowCount() > 0){
               foreach($hotelresult as $result){
                 $hotelname = $result['HotelName'];

               }

             }
  ?>
  <p><b>Hotel Name &nbsp;&rarr; </b><?php echo $hotelname;?></p>
  <input type="hidden" name="dhotelId" id="dhotelId" value="<?php echo $_POST['dhotels'];?>" class="form-control" placeholder="" aria-describedby="helpId">
</div>
<div class="form-group">
<p><b>Check In Date &nbsp;&rarr;</b> <?php echo $_POST['cdate'];?></p>
  <input type="hidden" name="cdate" id="cdate" value="<?php echo $_POST['cdate'];?>" class="form-control" placeholder="" aria-describedby="helpId">
  <p><b>Check Out Date &nbsp;&rarr; <?php echo $_POST['odate'];?></p>
  <input type="hidden" name="odate" id="odate" value="<?php echo $_POST['odate'];?>" class="form-control" placeholder="" aria-describedby="helpId">
</div>
<div class="form-group">
<p><b>No of Guest Person &nbsp;&rarr;</b> <?php echo $_POST['hperson'];?></p>
  <input type="hidden" name="hperson" id="hperson" value="<?php echo $_POST['hperson'];?>" class="form-control" placeholder="" aria-describedby="helpId">
</div>
<div class="form-group">
<p><b>Comments &nbsp;&rarr;</b> <?php echo $_POST['comment'];?></p>
  <input type="hidden" name="comment" id="comment" value="<?php echo $_POST['comment'];?>" class="form-control" placeholder="" aria-describedby="helpId">
</div>


<!--<?php
    print_r($_POST);
?> -->
</div>
<?php
}
?>

                    </div>
											
					<div class="clearfix"></div>
				</ul>
			</div>
			
		</div>

			<p style="width: 350px;">
<button type="submit" name="submit1" class="btn btn-primary">Reserved</button>
			</p>
			</form>

		
	</div>
</div>
<!--- /privacy ---->
<!--- footer-top ---->
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
  <!-- /Bootstrap Core JavaScript -->
  <script src="js/bootstrap-datetimepicker.js"></script> 
   <script src="js/moment.min.js"></script> 
   <script src="js/bootstrap-datetimepicker.min.js"></script>
   <script type="text/javascript">
          $(document).ready(function(){
            $(".date").datetimepicker({
				
				format: 'DD/MM/YYYY' ,
				minDate:new Date() 
			});
          });
        </script>
</body>
</html>