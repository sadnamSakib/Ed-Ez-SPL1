const togglePassword3 = document
.querySelector('#togglePassword3');

togglePassword3.addEventListener('click', () => {

// Toggle the type attribute using
// getAttribure() method
const type = opassword
    .getAttribute('type') === 'password' ?
    'text' : 'password';
      
    opassword.setAttribute('type', type);
this.classList.toggle('fa-eye');
});

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
                    for(let i=0;i<password.value.length;i++){
                        if(password.value.charAt(i)==='(' || password.value.charAt(i)===')' || password.value.charAt(i)==='\'' || password.value.charAt(i)==='\"' || password.value.charAt(i)===';' || password.value.charAt(i)==='='||password.value.charAt(i)==='\\'){
                            messages.push('Please do not enter (,),\',\",=,;,\\ in the password input fields')
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