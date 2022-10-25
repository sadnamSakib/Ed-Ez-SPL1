const email=document.getElementById('email')
var password=document.getElementById('password')
const form=document.getElementById('form')
const errorElement=document.getElementById('error')

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

form.addEventListener('submit', (e) => {
    let messages = []
    if(email.value==='' || email.value==null){
        messages.push("Please enter your email");
    }
    if(password.value==='' || password.value==null){
        messages.push('Please enter your password');
    }

    for(let i=0;i<password.value.length;i++){
        if(password.value.charAt(i)==='(' || password.value.charAt(i)===')' || password.value.charAt(i)==='\'' || password.value.charAt(i)==='\"' || password.value.charAt(i)===';' || password.value.charAt(i)==='='||password.value.charAt(i)==='\\'){
            messages.push('Please do not enter (,),\',\",=,;,\\ in the password input fields')
        }
    }
    
    if(!ValidateEmail(document.getElementById("email"))){
        messages.push("Email is invalid")
    }

    if(messages.length>0){
        e.preventDefault()
        errorElement.innerText=messages.join(', ')

    }
})

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