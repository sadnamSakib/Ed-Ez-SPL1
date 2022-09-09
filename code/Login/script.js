const email=document.getElementById('email')
var password=document.getElementById('password')
const form=document.getElementById('form')
const errorElement=document.getElementById('error')
// form.addEventListener('submit', (e) => {
//     let messages=[]
//     if(email.value==='' || email.value==null){
//         messages.push('Name is required')
//     }

//     if(messages.length()>0){
//         e.preventDefault()
//         errorElement.innerText = messages.join(', ')
//     }
// })


form.addEventListener('submit', (e) => {
    let messages = []
    if(password.value.length>=6 && password.value.length<=20){
        let charPresent=false
        let numPresent=false
        let symbolPresent=false
        for(let i=0;i<password.value.length;i++){
            if(password.value.charAt(i)>='A' && password.value.charAt(i)<='Z'){
                charPresent=true
            }
            else if(password.value.charAt(i)>='a' && password.value.charAt(i)<='z'){
                charPresent=true
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
        if(charPresent===false || numPresent===false || symbolPresent===false){
            messages.push("Password does not meet the constraints")
        }
        else{
            LoginSubmit()
        }

    }
    else{
        messages.push('Password size is incorrect')
    }

    if(!ValidateEmail(document.getElementById("email"))){
        messages.push("Email is invalid")
    }

    if(messages.length>0){
        e.preventDefault()
        errorElement.innerText=messages.join(', ')

    }
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