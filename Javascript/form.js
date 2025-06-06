function validate() {
    let val = true;
    let names = document.formname.nameName.value;
    let ages = document.formname.ageAge.value;
    let email = document.formname.emailEmail.value;
    let password = document.formname.passwordPassword.value;
    let confirmPassword = document.formname.confirmConfirm.value;


    if (names.length > 20) {
        val = false;
        alert('Form not submitted because name exceeds 20 characters.');
    }


    if (ages < 18) {
        val = false;
        alert('Form not submitted because age is less than 18.');
    }

 
    if (!email.includes("@") || !email.includes(".")) {
        val = false;
        alert('Form not submitted because email is not valid.');
    }

    
    if (password.length > 20) {
        val = false;
        alert('Form not submitted because password exceeds 20 characters.');
    }


    if (password !== confirmPassword) {
        val = false;
        alert('Form not submitted because passwords do not match.');
    }

    const course1 = document.formname.course1.checked;
    const course2 = document.formname.course2.checked;
    const course3 = document.formname.course3.checked;

    if (!course1 && !course2 && !course3) {
        val = false;
        alert('Form not submitted because no course was selected.');
    }

   
    if (val === true) {
        alert('Form submitted successfully!');
    }

    return val;
}
