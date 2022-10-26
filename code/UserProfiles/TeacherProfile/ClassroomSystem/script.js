const addCourse=document.getElementById('addCourse');
if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}
addCourse.addEventListener('submit',(e)=>{
  let messages=[];
  const courseName=document.getElementById('courseName').value;
  const courseCode=document.getElementById('courseCode').value;
  const semester=document.getElementById('semester').value;
  if(semester==="0"){
    messages.push('Semester cannot be empty');
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
