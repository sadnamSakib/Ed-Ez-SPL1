$(".sidebar ul li").on('click', function() {
    $(".sidebar ul li.active").removeClass('active');
    $(this).addClass('active');
  });
  $('.open-btn').on('click', function() {
    $('.sidebar').addClass('active');
  });
  $('.close-btn').on('click', function() {
    $('.sidebar').removeClass('active');
  });

  const togglePassword = document
            .querySelector('#togglePassword');
  
        const password = document.querySelector('#password');
  
        togglePassword.addEventListener('click', () => {
  
            // Toggle the type attribute using
            // getAttribure() method
            const type = password
                .getAttribute('type') === 'password' ?
                'text' : 'password';
                  
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
  });

var mobileNumber=document.getElementById('mobile');

form.addEventListener('submit', (e) => {
  var errorElement=document.getElementById('error')
  let messages=[]
  var number=mobileNumber.value;
  for(let i=0;i<number.length;i++){
    if(number.charAt(i)<'0' || number.charAt(i)>'9'){
      messages.push('There should only be numbers so incorrect format')
      break
    }
  }
  if(number==null || number.value==''){
    return true;
  }
  if(number.length<11){
    messages.push('Mobile number length must be greater than 11')
  }

  if(messages.length>0){
    e.preventDefault()
    errorElement.innerText=messages.join(', ')
  }

})