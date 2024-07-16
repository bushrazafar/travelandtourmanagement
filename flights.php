<?php
session_start();
error_reporting(0);
include('includes/config.php');
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'lib/vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
$countryname ='';
if(isset($_POST['submit']))
{
    

    
    if(isset($_SESSION['login']))
    {

        $userid =$_SESSION['user_id'];
        $fname= $_SESSION['uname'];
        $dgender= $_SESSION['ugender'];
        $vmobile=$_SESSION['umobile'] ;
        $vemail= $_SESSION['login'];
        $utype=$_SESSION['utype'] ;

        if(isset($_POST['rdroot'])){

            $rdroot = $_POST['rdroot'];
        }

        if($rdroot==="Return"){

            $dflight = $_POST['dflight'];
            $dcity = $_POST['dcity'];
            $acity = $_POST['acity'];
            $ddate = $_POST['ddate'];
            $rdate = $_POST['rdate'];

               // getting city name
               $hotelsql = "SELECT tblcities.CityId,tblcities.CityName FROM tblcities
               WHERE tblcities.CityId = '$dcity' ";
               $hotelquery = $dbh->prepare($hotelsql);
               $hotelquery->execute();
               $hotelresult = $hotelquery ->fetchAll();
               if($hotelquery->rowCount() > 0){
               foreach($hotelresult as $result){
       
               $DepartCity = $result['CityName'];
               
       
               }
           }      

        }

        if($rdroot==="OneWay"){

            $dflight = $_POST['dflight'];
            $dcity = $_POST['dcity'];
            $acity = $_POST['acity'];
            $ddate = $_POST['ddate'];
            $rdate = 'Not Available';

            $hotelsql = "SELECT tblcities.CityId,tblcities.CityName FROM tblcities
            WHERE tblcities.CityId = '$dcity' ";
            $hotelquery = $dbh->prepare($hotelsql);
            $hotelquery->execute();
            $hotelresult = $hotelquery ->fetchAll();
            if($hotelquery->rowCount() > 0){
            foreach($hotelresult as $result){
    
            $DepartCity = $result['CityName'];
            
    
            }
        }
           
        }

        // getting arrival city name

        $hotelsql = "SELECT tblcities.CityId,tblcities.CityName FROM tblcities
        WHERE tblcities.CityId = '$acity' ";
        $hotelquery = $dbh->prepare($hotelsql);
        $hotelquery->execute();
        $hotelresult = $hotelquery ->fetchAll();
        if($hotelquery->rowCount() > 0){
        foreach($hotelresult as $result){
        $ArrivCity = $result['CityName'];

        }
    }

        // getting flight name
        $hotelsql = "SELECT * from tblflights WHERE flightid=".$dflight;
						 $hotelquery = $dbh->prepare($hotelsql);
						 $hotelquery->execute();
             $hotelresult = $hotelquery ->fetchAll();
             if($hotelquery->rowCount() > 0){
               foreach($hotelresult as $result){
                 $flightname = $result['FlightName'];

               }

             }

        $passenger = $_POST['passenger'];
        $dcabin = $_POST['dcabin'];

$status=0;

$pdate = date('Y-m-d H:i:s');;

$sql="INSERT INTO tblflightbooking(FlightId,DepartureCity,ArrivalCity,DepartureDate,ReturnDate,Passenger,Cabin,FullName,Gender,ContactNo,Email,EnquiryType,UserType,userid,status)
                            VALUES(:dflight,:dcity,:acity,:ddate,:rdate,:passenger,:dcabin,:fname,:dgender,:vmobile,:vemail,:rdroot,:utype,:userid,:status)";
$query = $dbh->prepare($sql);

$query->bindParam(':dflight',$dflight,PDO::PARAM_INT);
$query->bindParam(':dcity',$dcity,PDO::PARAM_INT);
$query->bindParam(':acity',$acity,PDO::PARAM_INT);
$query->bindParam(':ddate',$ddate,PDO::PARAM_STR);
$query->bindParam(':rdate',$rdate,PDO::PARAM_STR);

$query->bindParam(':passenger',$passenger,PDO::PARAM_INT);
$query->bindParam(':dcabin',$dcabin,PDO::PARAM_STR);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':dgender',$dgender,PDO::PARAM_STR);
$query->bindParam(':vmobile',$vmobile,PDO::PARAM_STR);
$query->bindParam(':vemail',$vemail,PDO::PARAM_STR);
$query->bindParam(':rdroot',$rdroot,PDO::PARAM_STR);

$query->bindParam(':utype',$utype,PDO::PARAM_STR);
$query->bindParam(':userid',$userid,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
    }

   // end if condition

    // guest user data...

    else{

       

        if(isset($_POST['rdroot'])){

            $rdroot = $_POST['rdroot'];
        }

        if($rdroot==="Return"){

            $dflight = $_POST['dflight'];
            $dcity = $_POST['dcity'];
            $acity = $_POST['acity'];
            $ddate = $_POST['ddate'];
            $rdate = $_POST['rdate'];

                // getting departure city name
        $hotelsql = "SELECT tblcities.CityId,tblcities.CityName FROM tblcities
        WHERE tblcities.CityId = '$dcity' ";
        $hotelquery = $dbh->prepare($hotelsql);
        $hotelquery->execute();
        $hotelresult = $hotelquery ->fetchAll();
        if($hotelquery->rowCount() > 0){
        foreach($hotelresult as $result){

        $DepartCity = $result['CityName'];
        

        }
    }
}
        
        if($rdroot==="OneWay"){

            $dflight = $_POST['dflight'];
            $dcity = $_POST['dcity'];
            $acity = $_POST['acity'];
            $ddate = $_POST['ddate'];
            $rdate = '0';


        $hotelsql = "SELECT tblcities.CityId,tblcities.CityName FROM tblcities
        WHERE tblcities.CityId = '$dcity' ";
        $hotelquery = $dbh->prepare($hotelsql);
        $hotelquery->execute();
        $hotelresult = $hotelquery ->fetchAll();
        if($hotelquery->rowCount() > 0){
        foreach($hotelresult as $result){

        $DepartCity = $result['CityName'];

        }
           }     
        }

        // getting arrival city name
        $hotelsql = "SELECT tblcities.CityId,tblcities.CityName FROM tblcities
        WHERE tblcities.CityId = '$acity' ";
        $hotelquery = $dbh->prepare($hotelsql);
        $hotelquery->execute();
        $hotelresult = $hotelquery ->fetchAll();
        if($hotelquery->rowCount() > 0){
        foreach($hotelresult as $result){

        $ArrivCity = $result['CityName'];

        }
           }

         // getting flight name
         $hotelsql = "SELECT * from tblflights WHERE flightid=".$dflight;
         $hotelquery = $dbh->prepare($hotelsql);
         $hotelquery->execute();
            $hotelresult = $hotelquery ->fetchAll();
            if($hotelquery->rowCount() > 0){
            foreach($hotelresult as $result){
            $flightname = $result['FlightName'];

}

}
        $passenger = $_POST['passenger'];
        $dcabin = $_POST['dcabin'];

$fname=$_POST['fname'];
$dgender=$_POST['dgender'];
$vmobile=$_POST['vmobile'];
$vemail=$_POST['vemail'];
$status=0;
$utype= 'Guest';

$pdate = date('Y-m-d H:i:s');;
$sql="INSERT INTO tblflightbooking(FlightId,DepartureCity,ArrivalCity,DepartureDate,ReturnDate,Passenger,Cabin,FullName,Gender,ContactNo,Email,EnquiryType,UserType,status)
                            VALUES(:dflight,:dcity,:acity,:ddate,:rdate,:passenger,:dcabin,:fname,:dgender,:vmobile,:vemail,:rdroot,:utype,:status)";

$query = $dbh->prepare($sql);

$query->bindParam(':dflight',$dflight,PDO::PARAM_INT);
$query->bindParam(':dcity',$dcity,PDO::PARAM_INT);
$query->bindParam(':acity',$acity,PDO::PARAM_INT);
$query->bindParam(':ddate',$ddate,PDO::PARAM_STR);
$query->bindParam(':rdate',$rdate,PDO::PARAM_STR);

$query->bindParam(':passenger',$passenger,PDO::PARAM_INT);
$query->bindParam(':dcabin',$dcabin,PDO::PARAM_STR);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':dgender',$dgender,PDO::PARAM_STR);
$query->bindParam(':vmobile',$vmobile,PDO::PARAM_STR);
$query->bindParam(':vemail',$vemail,PDO::PARAM_STR);
$query->bindParam(':rdroot',$rdroot,PDO::PARAM_STR);

$query->bindParam(':utype',$utype,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);

$query->execute();
    }
    // end else condition

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
    $mail->addAddress($vemail, $fname);     // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // // Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Flight Enquiry';
    $mail->Body    = '<b>Applicant Name :</b>'.$fname.'<br/>'.'<b>Contact No :</b>'.$vmobile.'<br/>'.
    '<b>Flight Name:</b>'.$flightname.'<br/>'.'<b>Departure City:</b>'.$DepartCity.'<br/>'.' <b>Arival City :</b>'.$ArrivCity.'<br/>'.'<br/>'.
    '<b>Departure Date : </b>'.$ddate.'<br/>'.'<b>Return Date : </b>'.$rdate.'<br/>'.
    '<b>Passenger : </b>'.$passenger.'<br/>'.'<b>Enquiry Type : </b>'.$rdroot.'<br/>'.
    '<b>Passenger Type : </b>'.$utype;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
   // echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

$msg="Enquiry  Successfully submited";
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
<title>E-Travels & Tours</title>
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

<link href="css/select2.min.css" rel='stylesheet' type='text/css'>
<!-- Custom Theme files -->
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/select2.min.js"></script>
<link href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css' rel='stylesheet' type='text/css'>

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
		<h1 class="wow zoomIn animated animated" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: zoomIn;">E-Travels & Tours</h1>
	</div>
</div>
<!--- /banner-1 ---->
<!--- privacy ---->
<div class="privacy">
	<div class="container">
		<h3 class="wow fadeInDown animated animated" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInDown;">Flight Enquiry</h3>
		<form name="enquiry" method="post">
		 <?php if($error){?><div class="errorWrap bg-danger"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
                else if($msg){?><div class="succWrap bg-success"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
            
            <div class="selectroom_top">
            
			<div class="selectroom-info animated wow fadeInUp animated" data-wow-duration="1000ms" data-wow-delay="500ms" style="visibility: visible; animation-duration: 1000ms; animation-delay: 500ms; animation-name: fadeInUp; margin-top: -90px">
				<ul>
                    
                <div class="row">
                <h4>Destination</h4>
                 <div class="col-md-12 col-sm-6">              
                 <div class="row">
                              <div class="col-md-8 pr-1">

                              <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rdroot" id="inlineRadio1" value="Return" checked>
                                          <label class="form-check-label" for="inlineRadio1">Return</label>&nbsp; &nbsp;
                                    <input class="form-check-input" type="radio" name="rdroot" id="inlineRadio2" value="OneWay">
                                    <label class="form-check-label" for="inlineRadio2">OneWay</label>
                                </div>
                                

                              </div>
                 </div> 
                 <div class="row">
                              <div class="col-md-4 pr-1">
                              <div class="form-group">
                                  <label>Flight</label>
                              <select name="dflight" id="dflight" class="form-control">
                              </select>
                              </div>
                              </div>

                        </div> 
                        
                        <!-- return div -->

                        <div class="row" id="returnDiv">
                              <div class="col-md-4 pr-1">
                              <div class="form-group">
                                  <label>From</label>
                              <select name="dcity" class="form-control dcity">
                              </select>
                              </div>
                              </div>

                              <div class="col-md-4 px-1">
                              <div class="form-group">
                                  <label>To</label>
                              <select name="acity" class="form-control acity">
                              </select>
                              </div>
                              </div>
                                
                        </div>

                        <div class="row" id="returnDiv1">
                              <div class="col-md-4 pr-1" id="returndivdate">
                              <div class="form-group">
                              <label>Departure</label>
                              <input type="text" class="form-control datepicker" name="ddate" id="ddate" placeholder="select departure date" required>
                              </div>
                              </div>
                              <div class="col-md-4 px-1" id="colreturndate">
                              <div class="form-group">
                              <label id="lblreturn">Return</label>
                              <input type="text" class="form-control datepicker" name="rdate" id="rdate" placeholder="select departure date" required>
                              </div>
                              </div>

                        </div>

                        <!-- return div end -->

                        <!-- one way div end -->

                        <div class="row">
                              <div class="col-md-4 pr-1">
                              <div class="form-group">
                              <label>Passenger(s)</label>
                              <input type="number" class="form-control" min="1" name="passenger" value="1" id="passenger" required>
                              </div>
                              </div>
                              <div class="col-md-4 px-1">
                              <div class="form-group">
                              <label>Cabin</label>
                              <select style="margin-top: -1px;" class="form-control" name="dcabin" id="dcabin">
                                  <option value="Economy">Economy</option>
                                  <option value="Exective">Exective Economy</option>
                                  <option value="Business">Business</option>
                              </select>
                              </div>
                              </div>

                        </div>                

                </div>
                </div>

                <div class="clearfix"></div>
				</ul>
			</div>
			
        </div>
        <?php if(isset($_SESSION['login']))
                    {?>
                    <p style="width: 350px;">
<button type="submit" align="center" name="submit" class="btn btn-primary">Submit Enquiry</button>
            </p>
            <?php } else {?>
        <div class="selectroom_top">
			
			<div class="selectroom-info animated wow fadeInUp animated" data-wow-duration="1000ms" data-wow-delay="500ms" style="visibility: visible; animation-duration: 1000ms; animation-delay: 500ms; animation-name: fadeInUp; margin-top: -70px">
				<ul>
                 <h4>Personal Detail</h4>
                <div class="row">
                <div class="col-md-10 col-sm-6">
                              
                          <div class="row">
                              <div class="col-md-6 pr-1">
                                  <div class="form-group">
                                  <label>Full Name</label>
                                  <input style="margin-top: 20px;" type="text" name="fname" class="form-control" id="fname" placeholder="First Name" maxlength="20" required>
                                  </div>
                              </div>
                              <div class="col-md-6 pl-1">
                                  <div class="form-group">
                                    <label>Gender</label>
                                    <select class="form-control" name="dgender" id="dgender">
                                       <option selected disabled>Gender</option>
                                       <option value="Male">Male</option>
                                       <option value="Female">Female</option>
                                    </select>
                                  </div>
                              </div>
                              
                          </div>
                          <div class="row">
                              
                              <div class="col-md-6 pr-1">
                                  <div class="form-group">
                                  <label>Contact Number</label>
                                  <input style="margin-top: 20px;" type="text" class="form-control" placeholder="Mobile number" maxlength="11" id="vmobile" name="vmobile" required="">
                                  </div>
                              </div>
                              <div class="col-md-6 pl-1">
                                  <div class="form-group">
                                  <label>Email</label>
                                  <input style="margin-top: 20px;" type="email" class="form-control" placeholder="abcd@gmail.com"  id="vemail" name="vemail"  required="">
                                  </div>
                              </div>

                          </div>       
                </div>

                </div>
  <div class="clearfix"></div>
				</ul>
			</div>
			
        </div>

			<p style="width: 330px;">
<button type="submit" align="center" name="submit" class="btn btn-primary">Submit Enquiry</button>
            </p>
            <?php } ?>
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
  <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js' type='text/javascript'></script>
   
   <script type="text/javascript">
          $(document).ready(function(){
           //Datepicker
        $('.datepicker').datepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            immediateUpdates: true,
            todayBtn: true,
            todayHighlight: true,
            numberOfMonths: 2,
            startDate: new Date()
        }).datepicker("setDate", "0");

        // radio button change funtion

        $("input[type='radio']").change(function(){

            if($(this).val()=="Return"){
                $("#returnDiv").show();
                $("#returndivdate").show();
                $("#colreturndate").show();

                $("#onewayDiv1").hide();
                
            }
            
            if($(this).val()=="OneWay")
            {
                $("#returnDiv").show();
                $("#returndivdate").show();

                
                $("#colreturndate").hide();
                
                
            }
            else
            {
                $("#mcitydiv").hide();
            }

            });
            $("#onewayDiv").hide();
            $("#onewayDiv1").hide();

            // for data search
            load_data('load_departurecity');
            load_data('load_arrivalcity');

            load_data('load_flights');

            function load_data(type)
                {
                    $.ajax({
                    url:"load_country.php",
                    method:"POST",
                    data:{type:type},
                    dataType:"json",
                    success:function(data)
                    {
                        var html = '';
                         
                        html += '<option selected disabled>select</option>';
                        for(var count = 0; count < data.length; count++)
                        {
                        html += '<option value="'+data[count].id+'">'+data[count].name+'</option>';
                        }
                        // departure city
                        if(type == 'load_departurecity')
                        {
                        $('.dcity').html(html);
                          
                        }
                        $(".dcity").select2({
                            data: data
                            });

                            // arraival city

                        if(type == 'load_arrivalcity')
                        {
                        $('.acity').html(html);
                        
                        }
                        $(".acity").select2({
                            data: data
                            });

                            // flights
                            if(type == 'load_flights')
                        {
                        $('#dflight').html(html);
                       
                        }
                        $("#dflight").select2({
                            data: data
                            });
                    
                    }
                    })
                } 

          });
        </script>
</body>
</html>