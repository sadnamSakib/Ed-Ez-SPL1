if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
  // JavaScript code
  function search_resources() {
      let input = document.getElementById('searchbar').value
      input=input.toLowerCase();
      let x = document.getElementsByClassName('saved-resources');
      
      for (i = 0; i < x.length; i++) {
          if (!x[i].innerHTML.toLowerCase().includes(input)) {
              x[i].style.display="none";
          }
          else {
              x[i].style.display="block";				
          }
      }
  }
  const selectElement = document.querySelector('#classroom');
  const optionElements = selectElement.querySelectorAll('option');
  
  optionElements.forEach(option => {
    option.addEventListener('click', () => {
      option.selected = !option.selected;
    });
  });
  
  const radioButton = document.querySelector('#inlineRadio2');
  const radioButton2 = document.querySelector('#inlineRadio1');
  const dropdownMenu = document.querySelector('#classroom');
  
  radioButton.addEventListener('click', () => {
    if(radioButton.checked) {
      dropdownMenu.style.display = 'block';
    } else {
      dropdownMenu.style.display = 'none';
    }
  });
  
  radioButton2.addEventListener('click', () => {
      if(radioButton2.checked) {
        dropdownMenu.style.display = 'none';
      }
    });
  
  