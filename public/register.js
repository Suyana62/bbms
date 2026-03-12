//regx
let userPattern = /^([A-Z]|[a-z])[A-Za-z0-9_]{1,10}$/;
const namePattern = /^[a-zA-Z]+[\s]+[a-zA-Z]+$/;
const emailRegex = /^[a-zA-z]+[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
const phPattern = /^[0-9]{9,10}$/;
const passwordPattern =
  /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

const fullname = document.getElementById("fullname");
const email = document.getElementById("email");
const phone = document.getElementById("phone");
const password = document.getElementById("password");
const confirmPassword = document.getElementById("confirmPassword");
const submit = document.getElementById("submit");
const errorFullName = document.getElementById("errorFullName");
const errorEmail = document.getElementById("errorEmail");
const errorPhone = document.getElementById("errorPhone");
const errorPassword = document.getElementById("errorPassword");

fullname.addEventListener("input", function (element) {
  value = element.target.value;
  if (value.length > 0) {
    if (namePattern.test(value)) {
      errorFullName.innerText = "";
    } else {
      errorFullName.innerText =
        "Full name must contain at least two words with letters only.";
    }
  } else {
    errorFullName.innerText = "";
  }
});

email.addEventListener("input", function (element) {
  value = element.target.value;
  if (value.length > 0) {
    if (emailRegex.test(value)) {
      errorEmail.innerText = "";
    } else {
      errorEmail.innerText = "Please enter a valid email address.";
    }
  } else {
    errorEmail.innerText = "";
  }
});

phone.addEventListener("input", function (element) {
  value = element.target.value;
  if (value.length > 0) {
    if (phPattern.test(value)) {
      errorPhone.innerText = "";
    } else {
      errorPhone.innerText =
        "Phone number must be 9-10 digits.";
    }
  } else {
    errorPhone.innerText = "";
  }
});

password.addEventListener("input", validatePassword);

confirmPassword.addEventListener("input", validatePassword);

function validatePassword() {
  let value1 = password.value;
  let value2 = confirmPassword.value;
  if (value1.length > 0 && value2.length > 0) {
    if (value1 == value2) {
      if (passwordPattern.test(value1)) {
        errorPassword.innerText = "";
      } else {
        errorPassword.innerText =
          "Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one digit, and one special character.";
      }
    } else {
      errorPassword.innerText = "Passwords do not match.";
    }
  } else {
    errorPassword.innerText = "";
  }
}

function togglePassword() {
  const pwd = document.getElementById("password");
  const cpwd = document.getElementById("confirmPassword");
  pwd.type = pwd.type === "password" ? "text" : "password";
  cpwd.type = cpwd.type === "password" ? "text" : "password";
}
