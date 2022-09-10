const username=document.getElementById('username')
var password=document.getElementById('password')
var cfpassword=document.getElementById('cfpassword')
const form=document.getElementById('form')
const dob=document.getElementById('dob')
const errorElement=document.getElementById('error')
const gender=document.getElementById('gender')
var dateString=new Date().toLocaleDateString('en-ca');

form.addEventListener('submit', (e) => {
    let messages = []
    if(password.value!==cfpassword.value) {
        messages.push('Passwords do not match')
    }
    else if(password.value.length>=8){
        let charPresentSmall=false
        let charPresentBig=false
        let numPresent=false
        let symbolPresent=false
        for(let i=0;i<password.value.length;i++){
            if(password.value.charAt(i)>='A' && password.value.charAt(i)<='Z'){
                charPresentBig=true
            }
            else if(password.value.charAt(i)>='a' && password.value.charAt(i)<='z'){
                charPresentSmall=true
            }
            else if(password.value.charAt(i)>='0' && password.value.charAt(i)<='9'){
                numPresent=true
            }
            else if(password.value.charAt(i)>=' ' && password.value.charAt(i)<='/'){
                symbolPresent=true
            }
            else{
                continue
            }
        }
        if(charPresentSmall===false || charPresentBig===false || numPresent===false || symbolPresent===false){
            messages.push("Password must contain numbers, letters of both cases and symbols")
        }

    }
    else{
        messages.push('Password must be greater than 8 characters long')
    }
    if(gender.value==="select"){
        messages.push("Please select gender")
    }
 
    var db=new Date(dob.value)
    var today=new Date()
    if(db>=today){
        messages.push("Date is invalid")
    }
    delete db;
    delete today;
    if(!ValidateEmail(document.getElementById("email"))){
        messages.push("Email is invalid")
    }
    if(messages.length>0){
        e.preventDefault()
        errorElement.innerText=messages.join(', ')
    }
    else{
        hashPass();
    }
})

function setMaxDate(obj){
    var today=new Date()
    var dateString=today.toLocaleDateString('en-ca')
    this.setAttribute("max",dateString)
}

function hashPass(){
    LoginSubmit();
    LoginSubmitConfirm();
}

function LoginSubmit(){
    var hashObj=new jsSHA("SHA-512", "TEXT", {numRounds: 1})
    hashObj.update(password.value)
    var hash=hashObj.getHash("HEX")
    password.value=hash
}

function LoginSubmitConfirm(){
    var hashObj=new jsSHA("SHA-512", "TEXT", {numRounds: 1})
    hashObj.update(cfpassword.value)
    var hash=hashObj.getHash("HEX")
    cfpassword.value=hash
}

function ValidateEmail(inputText)
{
var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
if(inputText.value.match(mailformat))
{
return true;
}
else
{
return false;
}
}