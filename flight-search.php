<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<title>TMS | Tourism Management System</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">
<link href="css/bootstrap-datetimepicker.css" rel='stylesheet' type='text/css'>
<link href="css/bootstrap-datetimepicker.min.css" rel='stylesheet' type='text/css'>
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
<!--//end-animate-->
</head>
<body>
<?php include('includes/header.php');?>
<div class="banner">
	<div class="container">
		
		<h3 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">

	    </h3>

    </div>
    
</div>


<!--- rupes ---->
<!-- <div class="container">
	
	<div class="rupes">
	<div class="col-md-4 rupes-left wow fadeInDown animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">
			<div class="rup-left">
				<a href="offers.html"><i class="fa fa-usd"></i></a>
			</div>
			<div class="rup-rgt">
				<h3>UP TO USD. 50 OFF</h3>
				<h4><a href="offers.html">TRAVEL SMART</a></h4>
				
			</div>
				<div class="clearfix"></div>
		</div>
		<div class="col-md-4 rupes-left wow fadeInDown animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">
			<div class="rup-left">
				<a href="offers.html"><i class="fa fa-h-square"></i></a>
			</div>
			<div class="rup-rgt">
				<h3>UP TO 70% OFF</h3>
				<h4><a href="offers.html">ON HOTELS ACROSS WORLD</a></h4>
				
			</div>
				<div class="clearfix"></div>
		</div>
		<div class="col-md-4 rupes-left wow fadeInDown animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">
			<div class="rup-left">
				<a href="offers.html"><i class="fa fa-mobile"></i></a>
			</div>
			<div class="rup-rgt">
				<h3>FLAT USD. 50 OFF</h3>
				<h4><a href="offers.html">US APP OFFER</a></h4>
			
			</div>
				<div class="clearfix"></div>
		</div>
</div>

	
	</div>
<!--- /rupes ---->

<!---holiday---->
<div class="container">
	<div class="holiday">
	
	<h3>Available Flights</h3>
					<!-- Page row Listing is Here -->

<?php 
$dcity = $gcity = $ddate = $rdate = $sql = "";
if(isset($_POST['submit3'])){

    $dcity = $_POST['dcity'];
    $gcity = $_POST['gcity'];
    $ddate = $_POST['ddate'];
    
    if(isset($_POST['dcity']) || isset($_POST['gcity']) || isset($_POST['ddate'])){
        $sql = "SELECT * from tblflights
        WHERE tblflights.DepartureFrom = '$dcity' OR tblflights.GoingTo = '$gcity' OR tblflights.DepartureDate ='$ddate'";
        
    }
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{
		?>
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
				</div>
				<div class="clearfix"></div>
			</div>

<?php }}
}
?>
<div><a href="flight-list.php" class="view">View More Flights</a></div>
</div>
			<div class="clearfix"></div>
	</div>



<!--- routes ---->
<div class="routes">
	<div class="container">
		<div class="col-md-4 routes-left wow fadeInRight animated" data-wow-delay=".5s">
			<div class="rou-left">
				<a href="#"><i class="glyphicon glyphicon-list-alt"></i></a>
			</div>
			<div class="rou-rgt wow fadeInDown animated" data-wow-delay=".5s">
				<h3>80000</h3>
				<p>Enquiries</p>
			</div>
				<div class="clearfix"></div>
		</div>
		<div class="col-md-4 routes-left">
			<div class="rou-left">
				<a href="#"><i class="fa fa-user"></i></a>
			</div>
			<div class="rou-rgt">
				<h3>1900</h3>
				<p>Regestered users</p>
			</div>
				<div class="clearfix"></div>
		</div>
		<div class="col-md-4 routes-left wow fadeInRight animated" data-wow-delay=".5s">
			<div class="rou-left">
				<a href="#"><i class="fa fa-ticket"></i></a>
			</div>
			<div class="rou-rgt">
				<h3>7,00,00,000+</h3>
				<p>Booking</p>
			</div>
				<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

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

 <!-- /Bootstrap Core JavaScript -->
 <script src="js/bootstrap-datepicker.js"></script> 
   <script src="js/moment.min.js"></script> 
   <script src="js/bootstrap-datetimepicker.min.js"></script>
   <script type="text/javascript">
          $(document).ready(function(){
            $(".date").datetimepicker({
				
				format: 'DD/MM/YYYY' ,
				minDate:new Date() 
			});
		  });
		  
		  // deparure city
		  load_data('city_data');
		  load_data('gcity_data');

            function load_data(type)
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

							if(type == 'gcity_data')
							{
							$('#gcity').html(html);
						
							}
							$("#gcity").select2({
                            data: data
							});
                    }
                    })
                } ;

		</script>
		
</body>
</html>