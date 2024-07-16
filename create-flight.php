<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
if(isset($_POST['submit']))
{
$pname=$_POST['pname'];	
// $dcity=$_POST['dcity'];
// $gcity=$_POST['gcity'];
// $tcategory=$_POST['tcategory'];	
// $pprice = $_POST['pprice'];
// $ddate=$_POST['ddate'];
// $dtime=$_POST['dtime'];
// $adate=$_POST['adate'];	
// $atime=$_POST['atime'];
// $pimage=$_FILES["logoimage"]["name"];
// move_uploaded_file($_FILES["logoimage"]["tmp_name"],"planeimages/".$_FILES["logoimage"]["name"]);
$sql="INSERT INTO tblflights(FlightName) VALUES(:pname)";
$query = $dbh->prepare($sql);
$query->bindParam(':pname',$pname,PDO::PARAM_STR);
// $query->bindParam(':dcity',$dcity,PDO::PARAM_STR);
// $query->bindParam(':gcity',$gcity,PDO::PARAM_STR);
// $query->bindParam(':tcategory',$tcategory,PDO::PARAM_STR);
// $query->bindParam(':pprice',$pprice,PDO::PARAM_STR);
// $query->bindParam(':ddate',$ddate,PDO::PARAM_STR);
// $query->bindParam(':dtime',$dtime,PDO::PARAM_STR);
// $query->bindParam(':adate',$adate,PDO::PARAM_STR);
// $query->bindParam(':atime',$atime,PDO::PARAM_STR);
// $query->bindParam(':pimage',$pimage,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Plane Added Successfully";
}
else 
{
$error="Something went wrong. Please try again";
}

}
// departure city
$sqlquery = "SELECT tblcities.CityId,tblcities.CityName,tblcountries.countryid,tblcountries.CountryName FROM tblcities JOIN tblcountries on tblcities.countryid = tblcountries.countryid
WHERE tblcountries.CountryName = 'pakistan'
ORDER BY tblcities.CityName ASC" ;
  $queryresult = $dbh->prepare($sqlquery);
  $queryresult->execute();
  $resultset=$queryresult->fetchAll();

// going city
  $sqlquery1 = "SELECT CityId,CityName FROM tblcities ORDER BY CityName ASC" ;
  $queryresult1 = $dbh->prepare($sqlquery1);
  $queryresult1->execute();
  $resultset1=$queryresult1->fetchAll();

	?>
<!DOCTYPE HTML>
<html>
<head>
<title>TMS | Admin Package Creation</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Pooled Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />
<script src="../js/jquery-1.12.0.min.js"></script>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet"> 
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
<link href="css/bootstrap-datetimepicker.css" rel='stylesheet' type='text/css'>
<link href="css/bootstrap-datetimepicker.min.css" rel='stylesheet' type='text/css'>
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
   <div class="page-container">
   <!--/content-inner-->
<div class="left-content">
	   <div class="mother-grid-inner">
              <!--header start here-->
<?php include('includes/header.php');?>
							
				     <div class="clearfix"> </div>	
				</div>
<!--heder end here-->
	<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Add Plane </li>
            </ol>
		<!--grid-->
 	<div class="grid-form">
 
<!---->
  <div class="grid-form1">
  	       <h3>Add Flight</h3>
  	        	  <?php if($error){?><div class="errorWrap bg-danger"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap bg-success"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
  	         <div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" name="package" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Plane Name</label>
									<div class="col-sm-4">
										<input type="text" class="form-control1" name="pname" id="pname" placeholder="Plane Name" required>
									</div>
								</div>
			

								<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<button type="submit" name="submit" class="btn-primary btn">Create</button>

				<button type="reset" class="btn-inverse btn">Reset</button>
			</div>
		</div>
						
					
						
						
						
					</div>
					
					</form>

     
      

      
      <div class="panel-footer">
		
	 </div>
    </form>
  </div>
 	</div>
 	<!--//grid-->

<!-- script-for sticky-nav -->
		<script>
		$(document).ready(function() {
			 var navoffeset=$(".header-main").offset().top;
			 $(window).scroll(function(){
				var scrollpos=$(window).scrollTop(); 
				if(scrollpos >=navoffeset){
					$(".header-main").addClass("fixed");
				}else{
					$(".header-main").removeClass("fixed");
				}
			 });
			 
		});
		</script>
		<!-- /script-for sticky-nav -->
<!--inner block start here-->
<div class="inner-block">

</div>
<!--inner block end here-->
<!--copy rights start here-->
<?php include('includes/footer.php');?>
<!--COPY rights end here-->
</div>
</div>
  <!--//content-inner-->
		<!--/sidebar-menu-->
					<?php include('includes/sidebarmenu.php');?>
							  <div class="clearfix"></div>		
							</div>
							<script>
							var toggle = true;
										
							$(".sidebar-icon").click(function() {                
							  if (toggle)
							  {
								$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
								$("#menu span").css({"position":"absolute"});
							  }
							  else
							  {
								$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
								setTimeout(function() {
								  $("#menu span").css({"position":"relative"});
								}, 400);
							  }
											
											toggle = !toggle;
										});
							</script>
<!--js -->
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
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
			$(".time").datetimepicker({
				
				format: 'LT'
			});

          });
        </script>
</body>
</html>
<?php } ?>