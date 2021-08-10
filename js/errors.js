
// To show field and form submission errors

// Register
function emailTaken(){
    const error = document.querySelector('.submit-error');
    error.textContent = 'Email is already taken!';
    display(error);
}

function usernameTaken(){
    const error = document.querySelector('.submit-error');
    error.textContent = 'Username is already taken!';
    display(error);
}

// Login
function incorrectLogin(){
    const error = document.querySelector('.submit-error');
    error.textContent = "Username and/or password is incorrect.";
    display(error);
}

function incorrectPassword() {
    const error = document.querySelector('.submit-error');
    error.textContent = "The password you entered was incorrect.";
    display(error);
}

function lockedAccount(msg){
    const error = document.querySelector('.submit-error');
    error.textContent = msg;
    display(error);
}

function bankTaken(){
    const error = document.querySelector('.submit-error');
    error.textContent = "This account is already taken.";
    display(error);
}

function cantSell(){
    const error = document.querySelector('.submit-error');
    error.textContent = "You cannot sell an item that you currently do not own";
    display(error);
}

function display(error){
    error.style.display = 'block';
}

