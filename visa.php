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
    
    if(isset($_SESSION['login'])){
        $userid =$_SESSION['user_id'];
        $fname= $_SESSION['uname'];
        $dgender= $_SESSION['ugender'];
        $vmobile=$_SESSION['umobile'] ;
        $vemail= $_SESSION['login'];
        $utype=$_SESSION['utype'] ;

        $dcountry=$_POST['dcountry'];

        // gettting country name
        $sql = "SELECT tblcountries.CountryName FROM tblcountries JOIN tblvisa on tblcountries.countryid = tblvisa.CountryId
        WHERE tblvisa.CountryId =".$dcountry;
        $query = $dbh -> prepare($sql);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        if($query->rowCount() > 0)
            {
            foreach($results as $result)
            {
                $CountryName = $result->CountryName;
            }
            }

            // end for country name

        $ddate=$_POST['ddate'];	
        $rdate=$_POST['rdate'];
        $vtraveler=$_POST['vtraveler'];	
        $vtype=$_POST['vtype'];
        $status=0;
        $pdate = date('Y-m-d H:i:s');

        $sql="INSERT INTO tblvisa(CountryId,DepartureDate,ReturnDate,TotalTraveller,VisaType,FullName,Gender,ContactNo,Email,Status,userid,UserType) VALUES(:dcountry,:ddate,:rdate,:vtraveler,:vtype,:fname,:dgender,:vmobile,:vemail,:status,:userid,:utype)";
$query = $dbh->prepare($sql);

$query->bindParam(':dcountry',$dcountry,PDO::PARAM_INT);
$query->bindParam(':ddate',$ddate,PDO::PARAM_STR);
$query->bindParam(':rdate',$rdate,PDO::PARAM_STR);
$query->bindParam(':vtraveler',$vtraveler,PDO::PARAM_STR);
$query->bindParam(':vtype',$vtype,PDO::PARAM_STR);

$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':dgender',$dgender,PDO::PARAM_STR);
$query->bindParam(':vmobile',$vmobile,PDO::PARAM_STR);
$query->bindParam(':vemail',$vemail,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':userid',$userid,PDO::PARAM_INT);
$query->bindParam(':utype',$utype,PDO::PARAM_STR);
$query->execute();
    }

    else{
$dcountry=$_POST['dcountry'];

// gettting country name
$sql = "SELECT tblcountries.CountryName FROM tblcountries JOIN tblvisa on tblcountries.countryid = tblvisa.CountryId
WHERE tblvisa.CountryId =".$dcountry;
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
    {
    foreach($results as $result)
    {
        
        $CountryName = $result->CountryName;
    }
    
    }
    
    
    // end for country name

$ddate=$_POST['ddate'];	
$rdate=$_POST['rdate'];
$vtraveler=$_POST['vtraveler'];	
$vtype=$_POST['vtype'];

$fname=$_POST['fname'];
$dgender=$_POST['dgender'];
$vmobile=$_POST['vmobile'];
$vemail=$_POST['vemail'];
$status=0;
$utype= 'Guest';

$pdate = date('Y-m-d H:i:s');
$sql="INSERT INTO tblvisa(CountryId,DepartureDate,ReturnDate,TotalTraveller,VisaType,FullName,Gender,ContactNo,Email,Status,UserType) VALUES(:dcountry,:ddate,:rdate,:vtraveler,:vtype,:fname,:dgender,:vmobile,:vemail,:status,:utype)";
$query = $dbh->prepare($sql);

$query->bindParam(':dcountry',$dcountry,PDO::PARAM_INT);
$query->bindParam(':ddate',$ddate,PDO::PARAM_STR);
$query->bindParam(':rdate',$rdate,PDO::PARAM_STR);
$query->bindParam(':vtraveler',$vtraveler,PDO::PARAM_STR);
$query->bindParam(':vtype',$vtype,PDO::PARAM_STR);

$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':dgender',$dgender,PDO::PARAM_STR);
$query->bindParam(':vmobile',$vmobile,PDO::PARAM_STR);
$query->bindParam(':vemail',$vemail,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':utype',$utype,PDO::PARAM_STR);
$query->execute();
    }
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
    $mail->Subject = 'Visa Applicant';
    $mail->Body    = '<b>Applicant Name :</b>'.$fname.'<br/>'.'<b>Contact No :</b>'.$vmobile.'<br/>'.
    '<b>Visa Applied For:</b>'.$CountryName.'<br/>'.'<b>Departure Date:</b>'.$ddate.'<br/>'.' <b>Return Date :</b>'.$rdate.'<br/>'.
    '<b>Visa Type : </b>'.$vtype.'<br/>'.'<b>No# of Traveller : </b>'.$vtraveler;
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
		<h1 class="wow zoomIn animated animated" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: zoomIn;">TMS-Tourism Management System</h1>
	</div>
</div>
<!--- /banner-1 ---->
<!--- privacy ---->
<div class="privacy">
	<div class="container">
		<h3 class="wow fadeInDown animated animated" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInDown;">Apply For Visa Process</h3>
		<form name="enquiry" method="post">
		 <?php if($error){?><div class="errorWrap bg-danger"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
                else if($msg){?><div class="succWrap bg-success"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
            
            <div class="selectroom_top">
            <br/>
            
			<div class="selectroom-info animated wow fadeInUp animated" data-wow-duration="1000ms" data-wow-delay="500ms" style="visibility: visible; animation-duration: 1000ms; animation-delay: 500ms; animation-name: fadeInUp; margin-top: -70px">
				<ul>
                    
                <div class="row">
                <h4>Destination</h4>
                 <div class="col-md-12 col-sm-6">              
                                       
                        <div class="row">
                              <div class="col-md-4 pr-1">
                              <div class="form-group">
                              <label>Select Destination</label>
                              <select name="dcountry" id="dcountry" class="form-control">

                              </select>
                              </div>
                              </div>
                              <div class="col-md-4 px-1">
                              <div class="form-group">
                              <label>Departure</label>
                              <input class="form-control datepicker" name="ddate" id="ddate" type="text" placeholder="Departure Date" required>
                              </div>
                              </div>
                              <div class="col-md-4 pl-1">
                              <div class="form-group">
                              <label>Return</label>
                              <input class="form-control datepicker" name="rdate" id="rdate" type="text" placeholder="Return Date" required>
                              </div>
                              </div>
                        </div>
                        <div class="row">
                              <div class="col-md-4 pr-1">
                              <div class="form-group">
                              <label>Travellers</label>
                              <input class="form-control" name="vtraveler" id="vtraveler" type="number" placeholder="Number of Travellers" value="1" required>
                              </div>
                              </div>
                              <div class="col-md-4 px-1">
                              <div class="form-group">
                              <label>Select Visa</label>
                              <select style="margin-top: 3px;" class="form-control" name="vtype" id="vtype">
                                       
                                       <option value="Single">Single Entry</option>
                                       <option value="Multiple">Multiple Entry</option>
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
<button type="submit" align="center" name="submit" class="btn btn-primary">Apply Process</button>
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
<button type="submit" align="center" name="submit" class="btn btn-primary">Apply Process</button>
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

            // for data search
            load_data('country_data');

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
                        html += '<option selected disabled>Choose Country</option>';
                        for(var count = 0; count < data.length; count++)
                        {
                        html += '<option value="'+data[count].id+'">'+data[count].name+'</option>';
                        }
                        if(type == 'country_data')
                        {
                        $('#dcountry').html(html);
                       
                        }
                        $("#dcountry").select2({
                            data: data
                            });
                    
                    }
                    })
                } 

          });
        </script>
</body>
</html>