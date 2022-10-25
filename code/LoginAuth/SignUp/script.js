const username = document.getElementById('username')
var password = document.getElementById('password')
var cfpassword = document.getElementById('cfpassword')
const form = document.getElementById('form')
const dob = document.getElementById('dob')
const errorElement = document.getElementById('error')
const errorElementEmail = document.getElementById('errorEmail')
const errorPassword = document.getElementById('passwordError')
const errorConfirmPassword = document.getElementById('confirmPasswordError')
var dateString = new Date().toLocaleDateString('en-ca');

if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }

const togglePassword = document
    .querySelector('#togglePassword');

togglePassword.addEventListener('click', () => {

    // Toggle the type attribute using
    // getAttribure() method
    const type = password
        .getAttribute('type') === 'password' ?
        'text' : 'password';

    password.setAttribute('type', type);
    this.classList.toggle('fa-eye');
});

const togglePassword2 = document
    .querySelector('#togglePassword2');

togglePassword2.addEventListener('click', () => {

    // Toggle the type attribute using
    // getAttribure() method
    const type = cfpassword
        .getAttribute('type') === 'password' ?
        'text' : 'password';

    cfpassword.setAttribute('type', type);
    this.classList.toggle('fa-eye');
});

function passwordVerification() {
    let password_message = []
    if (password.value.length >= 8) {
        let charPresentSmall = false
        let charPresentBig = false
        let numPresent = false
        let symbolPresent = false
        for (let i = 0; i < password.value.length; i++) {
            if (password.value.charAt(i) >= 'A' && password.value.charAt(i) <= 'Z') {
                charPresentBig = true
            }
            else if (password.value.charAt(i) >= 'a' && password.value.charAt(i) <= 'z') {
                charPresentSmall = true
            }
            else if (password.value.charAt(i) >= '0' && password.value.charAt(i) <= '9') {
                numPresent = true
            }
            else if ((password.value.charAt(i) >= ' ' && password.value.charAt(i) < '9') || (password.value.charAt(i) > '9' && password.value.charAt(i) < 'A') || (password.value.charAt(i) > 'Z' && password.value.charAt(i) < 'a') || (password.value.charAt(i) > 'z' && password.value.charAt(i) <= '~')) {
                symbolPresent = true
            }
            else {
                continue
            }
        }
        for(let i=0;i<password.value.length;i++){
            if(password.value.charAt(i)==='(' || password.value.charAt(i)===')' || password.value.charAt(i)==='\'' || password.value.charAt(i)==='\"' || password.value.charAt(i)===';' || password.value.charAt(i)==='='||password.value.charAt(i)==='\\'){
                messages.push('Please do not enter (,),\',\",=,;,\\ in the password input fields')
            }
        }
        if (charPresentSmall === false || charPresentBig === false || numPresent === false || symbolPresent === false) {
            password_message.push("Password must contain minimum of 8 characters which must include numbers, letters of both cases and symbols")
        }

    }
    else {
        password_message.push('Password must contain minimum of 8 characters which must include numbers, letters of both cases and symbols')
    }
    if (password_message.length > 0) {
        errorPassword.style.display = "block"
        errorPassword.innerText = password_message.join(', ')
        return true;
    }
    return false;

}

function passwordConfirmation() {

    if (password.value !== cfpassword.value) {
        errorConfirmPassword.style.display = "block"
        errorConfirmPassword.innerText = "Passwords do not match"
        return true;
    }
    else {
        return false;
    }

}

form.addEventListener('submit', (e) => {
    var db = new Date(dob.value)
    var today = new Date()
    delete db;
    delete today;
    if (!ValidateEmail(document.getElementById("email"))) {
        e.preventDefault()
        errorElement.style.display = "block"
        errorElement.innerText = "Email is invalid"
    }
    // if(messages.length>0){
    //     e.preventDefault()
    //     errorElement.innerText=messages.join(', ')
    // }
    if (passwordVerification()) {
        e.preventDefault()
    }
    if (passwordConfirmation()) {
        e.preventDefault()
    }
})

function setMaxDate(obj) {
    var today = new Date()
    var dateString = today.toLocaleDateString('en-ca')
    this.setAttribute("max", dateString)
}


function LoginSubmit() {
    var hashObj = new jsSHA("SHA-512", "TEXT", { numRounds: 1 })
    hashObj.update(password.value)
    var hash = hashObj.getHash("HEX")
    password.value = hash
}

function LoginSubmitConfirm() {
    var hashObj = new jsSHA("SHA-512", "TEXT", { numRounds: 1 })
    hashObj.update(cfpassword.value)
    var hash = hashObj.getHash("HEX")
    cfpassword.value = hash
}

function ValidateEmail(inputText) {
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (inputText.value.match(mailformat)) {
        return true;
    }
    else {
        return false;
    }
}