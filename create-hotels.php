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
$dcountry=$_POST['dcountry'];	
$dcity=$_POST['dcity'];
$hname=$_POST['hname'];
$hprice=$_POST['hprice'];
$hfeature =$_POST['hfeature'];
$himage=$_FILES["himage"]["name"];
move_uploaded_file($_FILES["himage"]["tmp_name"],"countryimages/hotelsimages/".$_FILES["himage"]["name"]);
$sql="INSERT INTO tblhotels(HotelName,StayPrice,HotelFeature,HotelImage,CountryId,CityId) VALUES(:hname,:hprice,:hfeature,:himage,:dcountry,:dcity)";
$query = $dbh->prepare($sql);
$query->bindParam(':hname',$hname,PDO::PARAM_STR);
$query->bindParam(':hprice',$hprice,PDO::PARAM_STR);
$query->bindParam(':hfeature',$hfeature,PDO::PARAM_STR);
$query->bindParam(':himage',$himage,PDO::PARAM_STR);
$query->bindParam(':dcountry',$dcountry,PDO::PARAM_INT);
$query->bindParam(':dcity',$dcity,PDO::PARAM_INT);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Hotel Created Successfully";
}
else 
{
$error="Something went wrong. Please try again";
}

}
$sqlquery = "SELECT countryid,CountryName FROM tblcountries ORDER by CountryName ASC" ;
  $queryresult = $dbh->prepare($sqlquery);
  $queryresult->execute();
  $resultset=$queryresult->fetchAll();
	?>
<!DOCTYPE HTML>
<html>
<head>
<title>TMS | Admin Hotel Creation</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Pooled Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery-2.1.4.min.js"></script>
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
                <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Create Hotel </li>
            </ol>
		<!--grid-->
 	<div class="grid-form">
 
<!---->
  <div class="grid-form1">
  	       <h3>Create Hotel</h3>
  	        	  <?php if($error){?><div class="errorWrap bg-danger"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap bg-success"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
  	         <div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" name="package" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Select Country</label>
									<div class="col-sm-4">
                                 <select class="form-control1" name="dcountry" id="dcountry" required> 
									 <option selected disabled>Select Country</option>                              
                                        <?php foreach($resultset as $country): ?>
											<option value="<?= $country['countryid']; ?>"><?= $country['CountryName']; ?></option>
										<?php endforeach; ?>
                                 </select>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Select City</label>
									<div class="col-sm-4">
                                 <select class="form-control1" name="dcity" id="dcity" required> 
									 <option selected disabled>Select City</option>                              
                                        
                                 </select>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Hotel Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="hname" id="hname" placeholder=" Hotel In City" required>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Stay Price Per Day Pkr</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="hprice" id="hprice" placeholder=" Price Pkr" required>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Hotel Feature</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="hfeature" id="hfeature" placeholder=" Features Eg-free Breaskfast, Wifi.." required>
									</div>
								</div>		
															
<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Hotel Image</label>
									<div class="col-sm-8">
										<input type="file" name="himage" id="himage" required>
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
   
   
   <script type="text/javascript">
          $(document).ready(function(){
			$("#dcountry").change(function(){
        var deptid = $(this).val();
        $.ajax({
            url: 'get-cities.php',
            type: 'post',
            data: {depart:deptid},
            dataType: 'json',
            success:function(response){

                var len = response.length;

                $("#dcity").empty();
                for( var i = 0; i<len; i++){
                    var id = response[i]['CityId'];
                    var name = response[i]['CityName'];
                    
                    $("#dcity").append("<option value='"+id+"'>"+name+"</option>");

                }
            }
        });
    });

          });
        </script>

</body>
</html>
<?php } ?>