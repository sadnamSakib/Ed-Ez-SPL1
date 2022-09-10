const email=document.getElementById('email')
var password=document.getElementById('password')
const form=document.getElementById('form')
const errorElement=document.getElementById('error')

form.addEventListener('submit', (e) => {
    let messages = []
    if(email.value==='' || email.value==null){
        messages.push("Please enter your email");
    }
    if(password.value==='' || password.value==null){
        messages.push('Please enter your password');
    }
    
    if(!ValidateEmail(document.getElementById("email"))){
        messages.push("Email is invalid")
    }

    if(messages.length>0){
        e.preventDefault()
        errorElement.innerText=messages.join(', ')

    }
    LoginSubmit();
})

function LoginSubmit(){
    var hashObj=new jsSHA("SHA-512", "TEXT", {numRounds: 1})
    hashObj.update(password.value)
    var hash=hashObj.getHash("HEX")
    password.value=hash
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