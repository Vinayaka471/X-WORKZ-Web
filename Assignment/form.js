function onClick() {
    alert("form is Submitted")
}
function submitForm() {
    let valu = true;
    let nameInput = document.formName.nameName.value;
    let numInput = document.formName.numberNumber.value;
    let gendInput = document.formName.Gender.value;
    let ageInput = document.formName.ageAge.value;
    let emailinput = document.formName.emailEmail.value;

  

    if (numInput.length > 10 && numInput.length < 30) {
        valu = true;
        alert("It's Matching")
    }
    else {
        valu = false;
        alert("Invalid Number")
    }
    if (nameInput.length > 6 && nameInput.length < 30) {
        valu = true;
        alert("It's Matching")
    }
    else {
        valu = false;
        alert("Name Length Not Match")
    }

    if (ageInput > 18 && ageInput < 70) {
        valu = true;
        alert("It's Matching")
    }
    else {
        valu = false;
        alert("Enter valid Age")
    }
    return valu

}