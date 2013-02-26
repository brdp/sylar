



//																String Booster
//______________________________________________________________________________


function inizializeStringBuffer(){
	return new Array();
}
function addBuffer(aBuffer, sText) {
 aBuffer[aBuffer.length] = sText;
}
function getStringFromBuffer(aBuffer){
	return aBuffer.join("");
}

// Esempio
// aBS = inizializeStringBuffer();
// addBuffer(aBS, "pippo");
// addBuffer(aBS, "pluto");
// alert( getStringFromBuffer(aBS) );





