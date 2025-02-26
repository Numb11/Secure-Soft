

function openSignUpForm(){
}

function generateUqDigits(){
    return String(Math.floor(1000+Math.random()*9000));

}

function verifyEmail(){
    const form = document.getElementById("emailForm");
    const email = (form.elements["email"]).value;
    console.log(email)

    emailjs.send("service_loyxw0m","template_hq7voyf",{
        email: email,
        message: String(generateUqDigits()),
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