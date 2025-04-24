function onClick(){
    alert("Sumitted")
}
function submitForm()
{
    let value=true;

    let nameId = document.formName.nameName.value;
    let numberId = document.formName.numberNumber.value;
    let emailId = document.formName.emailEmail.value;
    let genderId = document.formName.gender.value;
    let checkId = document.formName.checkName.value;
    let message = "Form Submitted Successfully!\n" +
                  "Name: " + nameId + "\n" +
                  "Number: " + numberId + "\n" +
                  "Email: " + emailId + "\n"+ "Gender: "+genderId+
                  "\n"+ checkId+"";

    alert(message);
    return value;
}
function clearForm(){
    
}