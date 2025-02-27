<!DOCTYPE html>
<html>
    

<head>
<title> FakeBook </title>
<link rel = "stylesheet" href="log-in.css">
<script src="verifyEmail.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>

<script type="text/javascript"> emailjs.init('_fC1jhZcfXnMvi2yl')</script>


<link rel="icon" href="favi.png">
</head>

<body>
    <h1 id = "bannerText"> Sign-Up </h1>
    <div class = "signUpFormArea">

        <form action="" id="emailForm">
            <label for="email">Email: </label> <br>
            <input type = "email" placeholder = "Enter Email" name="email"><br>
            <br>
            <button type = "button" id = "verButt" onclick= "verifyEmail()" >Send verification email </button>

            <br>
            <br>

            <label for = "otp"> Unique No.: </label> <br>
            <input type = "text" placeholder = "Enter OTP" name = "otp"> <br>

            <br>
            
            <button type = "button" id = "OtpButt" onclick = "openSignUpForm()"> Verify email </button> <br>

            <br>

            <label> <a href="index.php">Log-in here!</a> </label>

        <br></br>

        </form>

        <form action = "" id = ""
    </div>


</body>
</html>