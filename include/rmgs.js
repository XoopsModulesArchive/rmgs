// JavaScript Document

function changeFormAction(frm,act,target){
	element = xoopsGetElementById(frm);
	element.action = act;
	element.target = target;
	element.submit();	
}

function decision(message, url){
	if(confirm(message)) location.href = url;
}

/**
 * Esta funci�n permite cargar la im�gen 
 * de un template seleccionado (postales)
 */
function rmgsShowTplImage(idimg,imgdir,lista){
	cbo = xoopsGetElementById(lista);
	img = xoopsGetElementById(idimg);
	img.src = imgdir + cbo.options[cbo.selectedIndex].value + '.gif'
}
