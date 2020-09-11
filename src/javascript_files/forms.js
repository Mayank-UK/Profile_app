function regformhash(form,username,email,password,confirmpwd)
{
    if(username.value=='' || email.value=='' || password.value=='' || confirmpwd.value=='')  
    {
        alert('All the details are mandatory');
        return false;                            //return here actually don't do anything,but it terminates the script as soon as it is seen 
    }
    
    var reguser=/^\w+$/;
    if(!reguser.test(username.value))
    {
        window.alert('Enter valid username');
        return false;
    }
    
    var regemail=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(!regemail.test(email.value))
    {
        alert('enter a valid email address');
        return false;
    }
    
    var regpassword=/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/;
    if(!regpassword.test(password.value))
    {
        window.alert('Password must contain atleast 1 uppercase,1 lowecase,1 special and must be 8 characters long');
        return false;
    }
    
    if(password.value!=confirmpwd.value)
    {
        window.alert("The two passwords don't match");
        return false;
    }
    
    var secretpass=document.createElement('input');
    form.appendChild(secretpass);
    secretpass.name='p';
    secretpass.type='hidden';
    secretpass.value=hex_sha512(password.value);
    
    password.value='';
    confirmpwd.value='';
    
    form.submit();
    return false;
}

function formhash(form,email,password)
{
    if(email.value=='' || password.value=='')
    {
        window.alert('All details are mandatory');
        return false;
    }
    var regemail=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(!regemail.test(email.value))
    {
        alert('enter your valid email address');
        return false;
    }
    var secretpass=document.createElement('input');
    form.appendChild(secretpass);
    secretpass.name='p';
    secretpass.type='hidden';
    secretpass.value=hex_sha512(password.value);
    password.value='';
    form.submit();
    return true;
}