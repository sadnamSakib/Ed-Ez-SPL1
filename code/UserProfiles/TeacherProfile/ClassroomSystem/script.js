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

const addCourse=document.getElementById('addCourse');

addCourse.addEventListener('submit',(e)=>{
  let messages=[];
  const courseName=document.getElementById('courseName').value;
  const courseCode=document.getElementById('courseCode').value;
  const semester=document.getElementById('semester').value;
  if(semester.length>2){
    messages.push('Semester must be less than 20');
  }
  if(semester.length==0){
    messages.push('Semester must not be empty');
  }
  for(let i=0;i<semester.length;i++){
    if(semester.charAt(i)<'0' || semester.charAt(i)>'9'){
      messages.push('Semester must be numeric');
      break;
    }
  }
  if(courseName.length==0){
    messages.push('Course name must not be empty');
  }

  if(courseCode.length==0){
    messages.push('Course code must not be empty');
  }

  if(messages.length>0){
    e.preventDefault();
    const error=document.getElementById('error');
    error.setAttribute('style','display:block;color:red');
    error.innerText=messages.join('\n');
    
  }

})
