const form = document.getElementById('form1')
form.addEventListener('submit', (e) => {
    const errorElement = document.getElementById('error')
    let messages = []
    var email = document.getElementById('email');
    if (!ValidateEmail(email.value)) {
        messages.push("Email is not in a valid format");
    }
    if (messages.length > 0) {
        e.preventDefault()
        errorElement.innerText = messages.join(', ')
    }
})

function ValidateEmail(inputText) {
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (inputText.value.match(mailformat)) {
        return true;
    } else {
        return false;
    }
}