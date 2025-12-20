//regx
let userPattern = /^([A-Z]|[a-z])[A-Za-z0-9_]{1,10}$/;
const namePattern = /^[a-zA-Z]+[\s]+[a-zA-Z]+$/;
const emailRegex = /^[a-zA-z]+[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
const phPattern = /^(97|98)\d{8}$/;
const passwordPattern =
  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

const fullname = document.getElementById("fullname");
const email = document.getElementById("email");
const phone = document.getElementById("phone");
const password = document.getElementById("password");
const submit = document.getElementById("submit")

fullname.addEventListener("input",function (element){
    value=element.target.value;
    if(namePattern.test(value)){
        console.log("vayooooo");
    }
    else{
        console.log("vayena");
    }
})

email.addEventListener("input",function (element){
    value=element.target.value;
    if(emailRegex.test(value)){
        console.log("vayooooo");
    }
    else{
        console.log("vayena");
    }
})

phone.addEventListener("input",function (element){
    value=element.target.value;
    if(phPattern.test(value)){
        console.log("vayooooo");
    }
    else{
        console.log("vayena");
    }
})

password.addEventListener("input",function (element){
    value=element.target.value;
    if(passwordPattern.test(value)){
        console.log("vayooooo");
    }
    else{
        console.log("vayena");
    }
})

