import emailjs from 'emailjs-com';

emailjs.init({
    publicKey: "qoXAHVjirQz_eVgQlDu-I",
  });

function openSignUpForm(){
}

function generateUqDigits(){
    return Math.floor(1000+matchMedia.random()*9000);

}

function verifyEmail(){
    const info = document.getElementById("emailForm");
    let email = (info.elements["email"]).value;


    emailjs.send("service_loyxw0m","template_hq7voyf",{
        message: String(generateUqDigits),
        email: email,
        }, "_fC1jhZcfXnMvi2yl").then(
            (response) => {
                
                alert("Email Verification sent");
            },
            (error) => {
                alert("Please retry");
            },
        );
    

}