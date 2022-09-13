const form=document.getElementById('form')
form.addEventListener('submit', (e) => {
    const errorElement=document.getElementById('error')
    let messages = []
    var password=document.getElementById('password')
    var cfpassword=document.getElementById('cfpassword')
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
            else if((password.value.charAt(i)>=' ' && password.value.charAt(i)<'9') || (password.value.charAt(i)>'9' && password.value.charAt(i)<'A') || (password.value.charAt(i)>'Z' && password.value.charAt(i)<'a') || (password.value.charAt(i)>'z' && password.value.charAt(i)<='~')){
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
    if(messages.length>0){
        e.preventDefault()
        errorElement.innerText=messages.join(', ')
    }
})