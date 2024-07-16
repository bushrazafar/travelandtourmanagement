<?php
session_start();


error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<title>TMS  | Flight List</title>
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
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
</head>
<body>
<?php include('includes/header.php');?>
<!--- banner ---->
<div class="banner-3">
	<div class="container">
		<h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;"> TMS- Package List</h1>
	</div>
</div>
<!--- /banner ---->
<!--- rooms ---->
<div class="rooms">
	<div class="container">
		
		<div class="room-bottom">
			<h3>Flights List</h3>

					
<?php $sql = "SELECT * from tblflights";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{	?>
			<div class="rom-btm">
				<div class="col-md-3 room-left wow fadeInLeft animated" data-wow-delay=".5s">
					<img src="admin/planeimages/<?php echo htmlentities($result->PlaneLogo);?>" class="img-responsive" alt="">
				</div>
				<div class="col-md-6 room-midle wow fadeInUp animated" data-wow-delay=".5s">
                    <h4>Flight Name: <?php echo htmlentities($result->FlightName);?></h4>
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
                    <h6>Departure From : <?php echo htmlentities($cityname);?></h6>
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
                    <p><b>Travelling Class :</b> <?php echo htmlentities($result->TravelCategory);?></p>
					<p><b>Departure Date :</b> <?php echo htmlentities($result->DepartureDate);?></p>
				</div>
				<div class="col-md-3 room-right wow fadeInRight animated" data-wow-delay=".5s">
					<h5>PKR <?php echo htmlentities($result->SeatFare);?></h5>
					<a href="flight-detail.php?pkgid=<?php echo htmlentities($result->flightid);?>" class="view">Details</a>
				<?php //echo $_SESSION['user_id'];?>
				</div>
				<div class="clearfix"></div>
			</div>

<?php }} ?>
			
		
		
		</div>
	</div>
</div>
<!--- /rooms ---->

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
<!-- //write us -->
</body>
</html>