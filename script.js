function validateEmail() {
  let emailInput = document.getElementById("username");
  let email = emailInput.value;

  let emailRegex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;

  if (email.match(emailRegex)) {
    document.getElementById("error-message").textContent = "";
  } else {
    document.getElementById("error-message").textContent =
      "Invalid email format";
  }
}

let form = document.querySelector("form");
form.addEventListener("submit", function (event) {
  event.preventDefault();
  validateEmail();
});


