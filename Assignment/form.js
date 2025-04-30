function onClick() {
  document.getElementById('nameId').innerHTML='min 3 letter max 20 letetr';

  let dothis=document.getElementsByClassName('numberClass')[0].innerHTML='skanda';

  document.getElementsByName('nameName')[0].innerHTML='Helloooo';

  document.getElementsByTagName('tagName')[0].innerHTML='Sagar';

}



function submitForm() {
  let val = true;

  let nameInput = document.formName.nameName.value;
  let ageInput = document.formName.ageAge.value;
  let numberInput = document.formName.numberNumber.value;

  if (nameInput.length < 3 || nameInput.length > 20) {
      val = false;
      setError("Name must be between 3 and 20 characters.");
  }

  if (numberInput.length != 10) {
      val = false;
      setError("Number must be exactly 10 digits.");
  }

  if (ageInput < 18) {
      val = false;
      setError("Age must be 18 or above.");
  }

  if (!val) return false; // Stop submission if errors exist

  let emailId = document.formName.emailEmail.value;
  let genderId = document.formName.gender.value;
  let passwordId = document.formName.passwardPassward.value;
  let confirmId = document.formName.correctCorrect.value;

  if (passwordId !== confirmId) {
      setError("Passwords do not match.");
      return false;
  }

  let message = "Form Submitted Successfully!\n" +
      "Name: " + nameInput + "\n" +
      "Number: " + numberInput + "\n" +
      "Email: " + emailId + "\n" +
      "Gender: " + genderId + "\n" +
      "Password: " + passwordId + "\n" +
      "Confirm Password: " + confirmId + "\n" +
      "Age: " + ageInput;

  alert(message);
  return true;
}
function setError(message) {
  alert("Error: " + message);
}