var xmlHttpRequest;
function init(){
	if(window.XMLHttpRequest){
		xmlHttpRequest = new XMLHttpRequest();
	} else {
		alert("sorry,IE6 doesn't be supported!");
	}
	
	if(!xmlHttpRequest){
		alert("create XMLHttpRequest error");
		return "error";
	}
}

function reqSyncGet(url,paramstr){
	init();
	var param = "";
	var tokens = paramstr.split(",");
	for(var token in tokens){
		param += tokens[token].split("|")[0] + "=";
		param += tokens[token].split("|")[1] + "&";
	}
	xmlHttpRequest.open("GET",url+"?"+ param,false);
	xmlHttpRequest.send();

	return xmlHttpRequest.responseText;
}
function reqAsyncGet(){
	init();
	xmlHttpRequest.onreadystatechange = function(){
		if(xmlHttpRequest.readyState == 4 && xmlHttpRequest.status == 200 ){
			return xmlHttpRequest.responseText;
		}		
	};
	xmlHttpRequest.open("GET","",true);
	xmlHttpRequest.send();
}
