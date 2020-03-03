function MostrarLejasLibres(str){  
var xmlhttp;     
if (str==""){    
    document.getElementById("lejaslibres").innerHTML="";   
    return;  
} /*Asumiendo que el select de la estación destino se llama Lista_Destino, si la cadena de Lista_Origen es vacía, también lo será Lista_Destino */ 
if(window.XMLHttpRequest)  {
    xmlhttp=new XMLHttpRequest();
  // code for IE7+, Firefox, Chrome, Opera, Safari    xmlhttp=new XMLHttpRequest();  /* Creamos el objeto request para conexiones http,  compatible con los navegadores descritos*/   
} else{
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  // code for IE6, IE5   xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");  /*Como el explorer va por su cuenta, el objeto es un ActiveX */   
}

xmlhttp.onreadystatechange=function(){ 
 
  if(xmlhttp.readyState==4 && xmlhttp.status==200){ 
    document.getElementById("lejaslibres").innerHTML=xmlhttp.responseText;
        /*Seleccionamos el elemento que recibirá el flujo de datos*/    
    }   
}  
xmlhttp.open("GET","AjaxLejas.php?estanteriasDisponibles="+str,true);
 /*Mandamos al PHP encargado de traer los datos, el valor de referencia */  
 xmlhttp.send(); 
}

function MostrarHuecosLibres(str){  
var xmlhttp;     
if (str==""){    
    document.getElementById("huecoslibres").innerHTML="";   
    return;  
} /*Asumiendo que el select de la estación destino se llama Lista_Destino, si la cadena de Lista_Origen es vacía, también lo será Lista_Destino */ 
if(window.XMLHttpRequest)  {
    xmlhttp=new XMLHttpRequest();
  // code for IE7+, Firefox, Chrome, Opera, Safari    xmlhttp=new XMLHttpRequest();  /* Creamos el objeto request para conexiones http,  compatible con los navegadores descritos*/   
} else{
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  // code for IE6, IE5   xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");  /*Como el explorer va por su cuenta, el objeto es un ActiveX */   
}

xmlhttp.onreadystatechange=function(){ 
 
  if(xmlhttp.readyState==4 && xmlhttp.status==200){ 
    document.getElementById("huecoslibres").innerHTML=xmlhttp.responseText;
        /*Seleccionamos el elemento que recibirá el flujo de datos*/    
    }   
}  
xmlhttp.open("GET","AjaxHuecos.php?pasillosDisponibles="+str,true);
 /*Mandamos al PHP encargado de traer los datos, el valor de referencia */  
 xmlhttp.send();  
}