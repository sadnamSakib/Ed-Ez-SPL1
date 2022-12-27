if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}
// JavaScript code
function search_resources() {
    let input = document.getElementById('searchbar').value
    input=input.toLowerCase();
    let x = document.getElementsByClassName('saved-resources');
    let y = document.getElementsByClassName('saved');
    
    for (i = 0; i < x.length; i++) {
        if (!x[i].innerHTML.toLowerCase().includes(input)) {
            x[i].style.display="none";
            y[i].style.display="none";
        }
        else {
            x[i].style.display="block";	
            y[i].style.display="block";			
        }
    }
}

