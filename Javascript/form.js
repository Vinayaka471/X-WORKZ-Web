function validate() {
    let val = true;
    let names = document.formname.nameName.value;
    let ages = document.formname.ageAge.value;
    let email = document.formname.emailEmail.value;
    let password = document.formname.passwordPassword.value;
    let confirmPassword = document.formname.confirmConfirm.value;


    const gender=document.querySelector('input[name="gender"]:checked');
    const course=document.querySelector('input[name="course"]:checked');
    const course1=Array.from(num).map(e=>e.value)


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

  

    if (!course1 && !course2 && !course3) {
        val = false;
        alert('Form not submitted because no course was selected.');
    }

    if(!gender) {
        console.log(gender)
        val=false;
        alert('Please select gender')
    }

    if(course){


        val=false;
        alert('Please select course')
    }
    console.log(course1);
    alert('stop here')
    return val;
   
    if (val === false) {
        alert('Form not submitted ');
    }
    else{
        alert('Form Submitted Successully')
    }

    return val;
}
