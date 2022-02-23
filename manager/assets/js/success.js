let x = document.getElementById("message_success");
x.className = "show";
setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);

