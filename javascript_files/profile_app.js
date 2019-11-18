function edit()
{
    document.getElementsByClassName('header-div-2-form-input-2')[0].style.display="block";
    document.getElementsByClassName('main-div-button-1')[0].style.display="none";
    document.getElementsByClassName('main-div-button-2')[0].style.display="block";
    var input=document.getElementsByClassName('main-div-div-div-input');
    for(var i=0;i<input.length;i++)
    {
        input[i].removeAttribute("readonly");
    }
}

function save()
{
    document.getElementsByClassName('header-div-2-form-input-2')[0].style.display="none"
    document.getElementsByClassName('main-div-button-1')[0].style.display="block";
    document.getElementsByClassName('main-div-button-2')[0].style.display="none";
    var input=document.getElementsByClassName('main-div-div-div-input');
    for(var i=0;i<input.length;i++)
    {
        input[i].setAttribute("readonly","");
    }
    
    if(document.getElementsByClassName('header-div-2-form-input-1')[0].files[0])
    {
        document.getElementsByClassName('header-div-2-form')[0].submit();
    }
    
    var oname=oName;
    var name=document.getElementsByClassName('main-div-div-div-input-1')[0].value;
    var email=document.getElementsByClassName('main-div-div-div-input-2')[0].value;
    var education=document.getElementsByClassName('main-div-div-div-input-3')[0].value;
    var company=document.getElementsByClassName('main-div-div-div-input-4')[0].value;
    var url=document.getElementsByClassName('main-div-div-div-input-5')[0].value;
    var bio=document.getElementsByClassName('main-div-div-div-input-6')[0].value;
    var quote=document.getElementsByClassName('main-div-div-div-input-7')[0].value;
    var location=document.getElementsByClassName('main-div-div-div-input-8')[0].value;
    
    var data=
    JSON.stringify({"oname":oname,"name":name,"email":email,"education":education,"company":company,"url":url,"bio":bio,"quote":quote,"location":location});
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST","php_files/profile_members_db_1.php",true);
    xhttp.send(data);
}

function search()
{
    document.getElementsByClassName('header-nav-input')[0].addEventListener('keyup',function(e){compute_search(e);},false);
    function compute_search(e)
    {
        if(e.keyCode==13 && !e.shiftKey)
        {   
            var container=document.getElementsByClassName("main-div")[0];
            var name=document.getElementsByClassName('header-nav-input')[0].value;
            
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4 && this.status == 200)
                {
                    container.innerHTML="";
                    var usernames=JSON.parse(this.responseText);
                    for(var i=0;i<usernames.length;i++)
                    {
                        container.innerHTML+=
                        "<div class='main-div-div-div-search' onClick='retreive_profile(this.children[1].innerHTML)'>"+"<img class='search_img'>"+"</img>"+"<p>"+usernames[i].name+"</p>"+"<p>"+usernames[i].email+"</p>"+"<p>"+usernames[i].location+"</p>"+"</div>"+
                        "<style>"+
                            ".main-div-div-div-search:nth-child(1){margin-top: 100px;}"+
                            ".main-div-div-div-search{width: 100%;height: 100px;box-shadow: 0px 0px 5px silver;margin: 10px 0;cursor: pointer}"+
                            ".main-div-div-div-search img{width: 120px;height: 100%;float: left;}"+
                            ".main-div-div-div-search p{width:60%;float: left;padding: 5.5px 5%;overflow-x: auto;}"+
                        "</style>";
                        if(usernames[i].img===null)
                        {
                            document.getElementsByClassName('search_img')[i].src="img_files/Batman.jpg";
                        }
                        else
                        {
                            document.getElementsByClassName('search_img')[i].src=usernames[i].img;
                        }
                    }
                }
            };
            var data=JSON.stringify({"name":name});
            xhttp.open("POST","php_files/profile_members_db_2.php",true);
            xhttp.send(data);
        }
    }
}
search();

function previewImage()
{
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementsByClassName('header-div-2-form-input-1')[0].files[0]);

    oFReader.onload = function (oFREvent)
    {
        document.getElementsByClassName("header-div-2-img")[0].src = oFREvent.target.result;
    };
}

var retain_ui=document.getElementsByClassName('main-div-div')[0];

function retreive_profile(value)
{
    var container=document.getElementsByClassName("main-div")[0];
    var name=value;
    searchValue=name;
            
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            container.innerHTML="";
            container.appendChild(retain_ui);
            document.getElementsByClassName('main-div-div-div')[0].style="margin-top: 100px";
            
            var quot=document.getElementsByClassName('header-div-1')[0];
            quot.innerHTML="";
            
            var profile_image=document.getElementsByClassName('header-div-2-img')[0];
            var parent=profile_image.parentElement;
            parent.removeChild(profile_image);
            
            var input=document.getElementsByClassName('main-div-div-div-input');
            for(var i=0;i<input.length;i++)
            {
                input[i].value="";
            }
            var name=document.getElementsByClassName('main-div-div-div-input-1')[0];
            var email=document.getElementsByClassName('main-div-div-div-input-2')[0];
            var education=document.getElementsByClassName('main-div-div-div-input-3')[0];
            var company=document.getElementsByClassName('main-div-div-div-input-4')[0];
            var url=document.getElementsByClassName('main-div-div-div-input-5')[0];
            var bio=document.getElementsByClassName('main-div-div-div-input-6')[0];
            var quote=document.getElementsByClassName('main-div-div-div-input-7')[0];
            var location=document.getElementsByClassName('main-div-div-div-input-8')[0];
            var img_path="";
            
            var user_profile=JSON.parse(this.responseText);
            
            name.value=user_profile.name;
            email.value=user_profile.email;
            education.value=user_profile.education;
            company.value=user_profile.company;
            url.value=user_profile.url;
            bio.value=user_profile.bio;
            quote.value=user_profile.quote;
            location.value=user_profile.location;
            img_path=user_profile.img;
            
            quot.innerHTML="&quot"+user_profile.quote+"&quot";
            
            var image=document.createElement('img');
            if(img_path===null)
            {
                image.src="img_files/Batman.jpg";
            }
            else
            {
                image.src=img_path;
            }
            image.style="width: 150px;height: 130px;";
            image.className="header-div-2-img";
            parent.appendChild(image);
        }
    };
    var data=JSON.stringify({"name":name});
    xhttp.open("POST","php_files/profile_members_db_3.php",true);
    xhttp.send(data);
}