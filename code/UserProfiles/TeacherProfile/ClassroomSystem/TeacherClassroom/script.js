if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}

// Close the dropdown if the user clicks outside of it
window.addEventListener('dblclick',function(event) {
  if (!event.target.matches('.dropbtn')) {
    close_dropdown();
  }
});

function close_dropdown(){
  var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
}

const quizForm=document.getElementById('quizForm');
const assignmentForm=document.getElementById('assignmentForm');

quizForm.addEventListener('submit',(e) =>{
  let messages=[];
  const startTime=document.getElementById('quizStart');
  const endTime=document.getElementById('quizEnd');
  const marks=document.getElementById('quizMarks');
  const quizName=document.getElementById('quizName');
  if(startTime.value===null){
    messages.push('Start Time must be entered for quiz');
  }
  if(endTime.value===null){
    messages.push('end Time must be entered for quiz');
  }
  if(marks.value===null){
    messages.push('Marks must be entered for quiz');
  }
  if(quizName.value===null){
    messages.push('quiz must have a question');
  }
  if(messages.length>0){
    e.preventDefault();
    error.document.display='block';
    const error=document.getElementById('error');
    error.innerText=messages.join(', ');
  }
});