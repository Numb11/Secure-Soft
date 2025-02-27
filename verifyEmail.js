
let randNo


function openSignUpForm(){
    event.preventDefault()
    const form = document.getElementById("emailForm");
    const inpOtp = (form.elements["otp"]).value;
    alert(inpOtp);
    console.log(inpOtp)
    if (inpOtp == randNo){
        form.style.display = "none"





    } else {
        alert("Please retry");
        alert(randNo)


    }


}

function generateUqDigits(){
    return String(Math.floor(10000+Math.random()*900000));

}

function verifyEmail(){
    event.preventDefault()
    const form = document.getElementById("emailForm");
    const email = (form.elements["email"]).value;
    console.log(email)
    randNo = String(generateUqDigits());

    emailjs.send("service_loyxw0m","template_hq7voyf",{
        email: email,
        message: randNo,
        }, "_fC1jhZcfXnMvi2yl").then(
            (response) => {
                alert("Email Verification sent");
            },
            (error) => {
                console.error(error);
                alert("Please retry");
            },
        );
    

}