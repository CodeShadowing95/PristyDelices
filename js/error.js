let error = document.getElementById("message_error");
error.className = "show";
setTimeout(function(){ error.className = error.className.replace("show", ""); }, 6000);