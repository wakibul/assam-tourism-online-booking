<?php
ob_start();
include('../include/random.php'); //salt is included in the login.php file
$salt=$_SESSION['nonce']; //stored in a variable
$webUrl= "http://localhost/assambooking/";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Assam Tourism || Admin Section</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  
<script LANGUAGE="javascript" src="js/trimfunction.js"></script>
<script LANGUAGE="javascript" src="js/check.js"></script>
<script LANGUAGE="javascript" src="js/overlib_mini.js"></script>
<script language="javascript" src="js/md5.js"></script>
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<style>
.bdr{
border:1px solid #FF0000;
}
</style>
<script type="text/javascript">
var jQuery_1_7 = $.noConflict(true);
</script>
<SCRIPT type="text/javascript">
jQuery_1_7(document).ready(function(){
jQuery_1_7("#txtBtn").click(function() { 
var usr = encodeURIComponent(jQuery_1_7("#txtuser").val());
var pass = encodeURIComponent(jQuery_1_7("#txtpass").val());
var selCity = encodeURIComponent(jQuery_1_7("#selCity").val());
if(usr=="")
{
	jQuery_1_7("#logStatus").html("Please enter the username!");	
	jQuery_1_7("#logStatus").addClass("alert-error");
	return false;
}
else if(pass=="")
{
	jQuery_1_7("#logStatus").html('Please enter the password');
	jQuery_1_7("#logStatus").addClass("alert-error");
	return false;
}
else if(selCity=="")
{
	jQuery_1_7("#logStatus").html('Please select the location');
	jQuery_1_7("#logStatus").addClass("alert-error");
	return false;
}
else {
		var cd = $('#randm').val(); //php variable stored in a JS variable nonce
		//alert(cd);
		var abc=$('#txtpass').val();
		//alert(abc);
		var abc=hex_md5(abc);
		var abc = abc+cd;
		var abc = hex_md5(abc);
		//alert(abc);
		$('#txtpass').val(abc);
		jQuery_1_7("#logStatus").removeClass("alert-error");
		jQuery_1_7("#logStatus").html("<img src='../images/loader_seq.gif'>");
		jQuery_1_7.ajax
		({  
		type: "POST",  
		url: "login_check.php",  
		data: "txtuser="+ usr + "&txtpass="+ $('#txtpass').val()+"&selCity="+selCity, 
		success: function(msg){  
		//alert(msg);
			if(jQuery.trim(msg)=="1")
			{
				window.location='<?php echo $webUrl;?>/dashboard';
				
			}
			else
			{
				jQuery_1_7('#txtpass').val('');
				jQuery_1_7('#txtpass').addClass('bdr');
				jQuery_1_7('#logStatus').addClass('alert-error');
				jQuery_1_7("#logStatus").html(msg);
				setTimeout(function(){$('#logStatus').fadeOut();}, 6000);
			}
		 } 
	  }); 
	}
});
});
//-->
</SCRIPT>  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<form id="login">
<div class="login-box">
  <div class="login-logo">
   <b>Admin Section</b>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="User name" name="txtuser" id="txtuser" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" id="txtpass" name="txtpass" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <select class="form-control" required name="selCity" id="selCity">
              <option value="">Select City</option>
              <option value="1">Guwahati</option>
              <option value="2">Kaziranga</option>
              <option value="3">Tezpur</option>
              </select>
            </label>
             
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="button" id="txtBtn" class="btn btn-primary btn-block btn-flat">Sign In</button>
          <input type="hidden" name="randm" id="randm" value = "<?php echo $salt;?>">
        </div>
        <div class="row">
            <div class="col-xs-8" align="center">
            <div id="logStatus"></div>
            </div>
        </div>
        <!-- /.col -->
      </div>
   
  </div>
  <!-- /.login-box-body -->
</div>
</form>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
