<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{ 
	// code for cancel
if(isset($_REQUEST['bkid']))
	{
$bid=intval($_GET['bkid']);
$status=2;
$cancelby='a';
$pdate = date('Y-m-d H:i:s');
$sql = "UPDATE tblvisa SET status=:status,CancelBy=:cancelby,UpdationDate=:pdate WHERE  VisaId=:bid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_INT);
$query -> bindParam(':cancelby',$cancelby , PDO::PARAM_STR);
$query -> bindParam(':pdate',$pdate , PDO::PARAM_STR);
$query-> bindParam(':bid',$bid, PDO::PARAM_INT);
$query -> execute();

$msg="Booking Cancelled successfully";
}

 // fro confirm booking
if(isset($_REQUEST['bckid']))
	{
$bcid=intval($_GET['bckid']);
$status=1;
$cancelby='a';
$pdate = date('Y-m-d H:i:s');
$sql = "UPDATE tblvisa SET status=:status,UpdationDate=:pdate WHERE VisaId=:bcid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_INT);
$query -> bindParam(':pdate',$pdate , PDO::PARAM_STR);
$query-> bindParam(':bcid',$bcid, PDO::PARAM_INT);
$query -> execute();
$msg="Booking Confirm successfully";
}




	?>
<!DOCTYPE HTML>
<html>
<head>
<title>TMS | Admin manage Bookings</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery-2.1.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/table-style.css" />
<link rel="stylesheet" type="text/css" href="css/basictable.css" />
<script type="text/javascript" src="js/jquery.basictable.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
      $('#table').basictable();

      $('#table-breakpoint').basictable({
        breakpoint: 768
      });

      $('#table-swap-axis').basictable({
        swapAxis: true
      });

      $('#table-force-off').basictable({
        forceResponsive: false
      });

      $('#table-no-resize').basictable({
        noResize: true
      });

      $('#table-two-axis').basictable();

      $('#table-max-height').basictable({
        tableWrapper: true
      });
    });
</script>
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
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
                <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Manage Applications</li>
            </ol>
<div class="agile-grids">	
				<!-- tables -->
				<?php if($error){?><div class="errorWrap bg-danger"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap bg-success"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>Manage Application Process</h2>
					    <table id="table" class="table table-responsive text-nowrap">
						<thead>
						  <tr>
						  <th>Visa id</th>
                            <th>Name</th>
							<th>Mobile No.</th>
                            <th>Email Id</th>
                            <th>Visa Country</th>
                            <th>Visa Type </th>
                            <th>Departure Date </th>
                            <th>User Type </th>
							<th>Status </th>
							<th>Action </th>
						  </tr>
						</thead>
						<tbody>
<?php $sql = "SELECT * from tblvisa JOIN tblcountries ON tblvisa.CountryId = tblcountries.countryid
WHERE tblvisa.UserType = 'Rigistered'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>		
						  <tr>
							<td>#VP-<?php echo htmlentities($result->VisaId);?></td>
							<td><?php echo htmlentities($result->FullName);?></td>
							<td><?php echo htmlentities($result->ContactNo);?></td>
                            <td><?php echo htmlentities($result->Email);?></td>
                            <td><?php echo htmlentities($result->CountryName);?></td>
                            <td><?php echo htmlentities($result->VisaType);?></td>
                            <td><?php echo htmlentities($result->DepartureDate);?></td>
                            <td><?php echo htmlentities($result->UserType);?></td>
								
								<td><?php if($result->Status==0)
{
echo '<span class="badge badge-warning">Pending</span>';
}
if($result->Status==1)
{
echo '<span class="badge badge-success">Confirmed</span>';
}
if($result->Status==2 and  $result->CancelBy=='a')
{
echo '<span class="badge badge-primary">Canceled by you at </span><br/>' .$result->UpdationDate;
} 
if($result->Status==2 and $result->CancelBy=='u')
{
echo '<span class="badge badge-primary">Canceled by you at </span><br/>' .$result->UpdationDate;

}
?></td>

<?php if($result->status==2)
{
	?><td><span class="badge badge-danger">Cancelled</span></td>
<?php } else {?>
<td><a href="register-user-visa.php?bkid=<?php echo htmlentities($result->VisaId);?>" onclick="return confirm('Do you really want to cancel booking')" style="color: red;">Cancel</a> &nbsp; / &nbsp; <a href="register-user-visa.php?bckid=<?php echo htmlentities($result->VisaId);?>" onclick="return confirm('Do you really want to confirm booking')" style="color: #4DB321;">Confirm</a></td>
<?php }?>

						  </tr>
						 <?php $cnt=$cnt+1;} }?>
						</tbody>
					  </table>
					</div>
				  </table>

				
			</div>
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

</body>
</html>
<?php } ?>