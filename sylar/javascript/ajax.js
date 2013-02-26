/*
 * This file is part of Sylar.
 *
 * Sylar is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Sylar is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Sylar.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @copyright Copyright Sylar Development Team
 * @license http://www.gnu.org/licenses/ GNU Public License V2.0
 * @see https://launchpad.net/sylar/
 * @see http://www.giano-solutions.com
 */
 
/**
 * Ajax Simple library
 *
 * @package Sylar
 * @version 1.0
 * @since 28/mag/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
 
/**
 * 
 * Possible value of readyState 	
 * 0	Object is uninitialized
 * 1	Request is loading
 * 2	Request is fully loaded
 * 3	Request is waiting for user interaction
 * 4	Request is complete
 *
 *
 * 
 * Possible value of status
 * 200 "Ok"
 * 301 "Moved Permanently"
 * 304 "Not Modified" (page hasn't been modified)
 * 404 "Not Found"
 * 403 "Forbidden"
 * 401 "Unauthorized" (wrong password)
 * 
 */
 
 
 /**
 * Inizializza una richiesta Ajax e ne ritorna l'oggetto attivo (o false in caso di errori)
 * Vedi sylarAjax_BackFuncExample() per implementare una funzione di ritorno
 *
 * @param string	sUrl				Url della pagina da contattare
 * @param function	fBackFunc			Funzione che l'oggetto richiamera' ad ogni cambiamento di stato della richiesta
 * @param string	sMethod				Metodo http della richiesta: get (default), post
 * @param string	bAsynchronous		se true (default), inizializza la richiesta in modo asincrono (senza bloccare il browser)
 * @param string	sPostParams			Parametri in formato param1=value1&...&param_n=value_n da utilizzare durante la richiesta
 * @param string	mBackFuncMyParam	Se esistente, verr� passato come parametro alla funzione fBackFunc
 * @param string	sReturnType			Tipo di dati che ci si aspetta XML TXT HTML o altro... Al momento non usato
 */
function sylarMakeAjaxRequest (sUrl, fBackFunc, mBackFuncMyParam, sMethod, sPostParams, bAsynchronous, sReturnType) {
	
	if (typeof(sPostParams) == 'undefined') { var sPostParams = null; }
	
	if (typeof(sMethod) == 'undefined' || sMethod.toUpperCase() != 'GET' && sMethod.toUpperCase() != 'POST') {
		var sMethod = 'GET';
		var sPostParams = null;
	}
	
	if (typeof(bAsynchronous) != 'undefined' && (bAsynchronous == false || bAsynchronous == 0 || String(bAsynchronous).toUpperCase() == 'FALSE' || bAsynchronous == '0')) { bAsynchronous = false; }
	else { bAsynchronous = true; }

	if ((typeof(fBackFunc)).toLowerCase() != 'function') {
		var fBackFunc = sylarDestroyAjaxResponse;
	}

	var ajax_request = false;
	
	// TODO 
	//if (typeof(sMethod) == 'undefined') {
		var sOverrideMimeType = "text/xml";		
	//}

	if (typeof(SYLAR_AJAX__MAKE_REQUEST__FAIL) == 'undefined') {
		SYLAR_AJAX__MAKE_REQUEST__FAIL = 'Error: Unable to execute the request.';
	}

	if (window.XMLHttpRequest) {
		// Mozilla, Safari,...
		ajax_request = new XMLHttpRequest();
		if (ajax_request.overrideMimeType) {
			// ajax_request.overrideMimeType('text/html');
			ajax_request.overrideMimeType('text/xml');
		}
	} else if (window.ActiveXObject) {
		// IE
		try {
			ajax_request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				ajax_request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) { sylarNotifyAjaxError(SYLAR_AJAX__MAKE_REQUEST__FAIL+"\n\nDetails:\n"+e); }
		}
	}

	if (!ajax_request) {
		sylarNotifyAjaxError(SYLAR_AJAX__MAKE_REQUEST__FAIL);
		return false;
	}

	if (typeof(mBackFuncMyParam) != 'undefined') {
		ajax_request.onreadystatechange = function() { fBackFunc(ajax_request, mBackFuncMyParam); }
	}
	else {
		ajax_request.onreadystatechange = function() { fBackFunc(ajax_request); }
	}
	ajax_request.open(sMethod, sUrl, bAsynchronous);
	if (sMethod.toUpperCase() == 'POST') { ajax_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); }
	ajax_request.send(sPostParams);

	return ajax_request;
}

function sylarAbortAjaxRequest(ajaxObj){
	if(ajxObj && ajxObj.readyState != 0){
		ajxObj.abort(); 
	}	
}

function sylarDestroyAjaxResponse () { return; }



function sylarNotifyAjaxError (sTxt) {
	if (sTxt) { alert(sTxt); }
}



/**
 * It replace Ajax request result in the DivId hinner HTML
 * 
 * @param Object ajax_request
 * @param String divId
 */
function sylarSimpleReplaceResult(ajax_request, divId) {
	if (ajax_request.readyState == 4) {
		if (ajax_request.status == 200) {
			document.getElementById(divId).innerHTML = "";
			document.getElementById(divId).innerHTML = ajax_request.responseText;
		} else {
			sylarNotifyAjaxError('Ajax connection problem...'+ ajax_request.status);
		}
	}
}





//														Example of BackFunctions
//______________________________________________________________________________


function sylarAjax_BackFuncExample(ajax_request, myBackParam) {
	if (ajax_request.readyState == 4) {
		if (ajax_request.status == 200) {
			var sText = ajax_request.responseText;
			// Make something with result...
			
			
			
		} else {
			sylarNotifyAjaxError('There was a problem with the Ajax request.');
		}
	}
}


function sylarAjax_BackFuncXml(ajaxR, myBackParam){
	if (ajax_request.readyState == 4) {
		if (ajax_request.status == 200) {
			var sReturnedXml = ajaxR.responseXML;
			// Make something with result...
			
			
		} else {
			sylarNotifyAjaxError('There was a problem with the Ajax request.');
		}
	}
}


