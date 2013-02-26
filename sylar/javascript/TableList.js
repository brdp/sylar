
/* Array that contains the TableList objects list */
var sylar_PageTables = new Array();



/*
 * Init Ajax TableList and base properties
 */
function sylar_InitTableList(tlId, divId, urlBase){
	tl = new sylar_TableList(tlId);
	tl.setBaseAjaxUrl(urlBase);
	tl.setDefaultDivId(divId);
	tl.pushTableInList();
}


/*
 * Reload Ajax TableList from server and replace in the html dom DIV 
 */
function sylar_ReloadTableList(tlId, sNewUrl){
	var oTL = sylar_PageTables[tlId];
	var sUrl = oTL.getBaseAjaxUrl();
	
	if(typeof(sNewUrl) != 'undefined' && sNewUrl != null && sNewUrl != ""){
		sUrl = sNewUrl;
	}
	
	
	if(typeof(oTL) != 'undefined' && oTL != null){
		sylarMakeAjaxRequest ( sUrl, sylarSimpleReplaceResult, oTL.getDefaultDivId() );
	}else{
		alert('Table List'+ tlId +' not Found in the page!');
	}	
}




/*
 * Table list Manager
 */
function sylar_TableList(sTableID){

	//
	// Private Properties
	//
	this.sId = sTableID;			// Table ID
	
	this.iPages = 1;				// Total Pages
	this.iPage = 1;					// Current Page
	this.iPageStep = 30;			// Page elements step
	this.iColumnOrder = null;		// Column Order
	this.iOrderType = "ASC";		// ASC or DESC
	
	this.sBaseAjaxUrl = null;		// Base url for Ajax Call
	this.defaultDivId = null;		// Default html Div in which show tha table List content


	//
	// Setter and Getter
	//
	this.setId = sylar_TableList_setId;
	this.getId = sylar_TableList_getId;
	
	this.setCurrentPage = sylar_TableList_setCurrentPage;
	this.getCurrentPage = sylar_TableList_getCurrentPage;
	
	this.setTotalPages = sylar_TableList_setTotalPages;
	this.getTotalPages = sylar_TableList_getTotalPages;	
	
	this.setStepPages = sylar_TableList_setStepPages;
	this.getStepPages = sylar_TableList_getStepPages;	
	
	this.setBaseAjaxUrl = sylar_TableList_setBaseAjaxUrl;
	this.getBaseAjaxUrl = sylar_TableList_getBaseAjaxUrl;	
	
	this.setDefaultDivId = sylar_TableList_setDefaultDivId;
	this.getDefaultDivId = sylar_TableList_getDefaultDivId;		
		
	
	//
	// Public Method
	//
	this.goNextPage = sylar_TableList_goNextPage;
	this.goPreviousPage = sylar_TableList_goPreviousPage;
	this.goFirstPage = sylar_TableList_goFirstPage;
	this.goLastPage = sylar_TableList_goLastPage;
	this.refreshPagination = sylar_TableList_refreshPagination;
	
	this.pushTableInList = sylar_TableList_pushTableInList;	
	
}






//
// Setter and Getter
// 

function sylar_TableList_setId(sTableID){
	this.sId = sTableID;
}
function sylar_TableList_getId(){
	return this.sId;
}

function sylar_TableList_setCurrentPage(iPage){
	this.iPage = iPage;
}
function sylar_TableList_getCurrentPage(){
	return this.iPage;
}

function sylar_TableList_setTotalPages(iPages){
	this.iPages = iPages;
}
function sylar_TableList_getTotalPages(){
	return this.iPages;
}

function sylar_TableList_setStepPages(iStep){
	this.iPageStep = iStep;
}
function sylar_TableList_getStepPages(){
	return this.iPageStep;
}

function sylar_TableList_setBaseAjaxUrl(sUrl){
	this.sBaseAjaxUrl = sUrl;
}
function sylar_TableList_getBaseAjaxUrl(){
	return this.sBaseAjaxUrl;
}

function sylar_TableList_setDefaultDivId(sDivId){
	this.defaultDivId = sDivId;
}
function sylar_TableList_getDefaultDivId(){
	return this.defaultDivId;
}







//
// Go next page
// 
function sylar_TableList_goNextPage(){	
	this.setCurrentPage(this.getCurrentPage()+1);

	//	alert("Table: "+ sylar_PageTables[this.getId()].getId() +" Go Next Page!");

	sylar_ReloadTableList(this.getId(), this.getBaseAjaxUrl() +"&pg="+ this.getCurrentPage());
}

//
// Go previous page
// 
function sylar_TableList_goPreviousPage(){	
	if( this.getCurrentPage() > 1){
		this.setCurrentPage(this.getCurrentPage()-1);
	}else{
		this.setCurrentPage(1);
	}
	
	//alert("Table: "+ sylar_PageTables[this.getId()].getId() +" Go Previous Page!");
	sylar_ReloadTableList(this.getId(), this.getBaseAjaxUrl() +"&pg="+ this.getCurrentPage());
}

//
// Go first page
// 
function sylar_TableList_goFirstPage(){	
	this.setCurrentPage(1);
	sylar_ReloadTableList(this.getId(), this.getBaseAjaxUrl() +"&pg="+ this.getCurrentPage());
}

//
// Go last page
// 
function sylar_TableList_goLastPage(){	
	this.setCurrentPage(this.getTotalPages());
	//alert("Table: "+ sylar_PageTables[this.getId()].getId() +" Go Last Page!");
	sylar_ReloadTableList(this.getId(), this.getBaseAjaxUrl() +"&pg="+ this.getCurrentPage());
}


//
// Refresh Client pagination
//
function sylar_TableList_refreshPagination(pgTot, pgCur, pgStep){
	this.setCurrentPage(pgCur);
	this.setStepPages(pgStep);
	this.setTotalPages(pgTot);
}


//
// Add the table in the list
// 
function sylar_TableList_pushTableInList(){
	// Push data and overwrite if exists
	//
	sylar_PageTables[this.getId()] = this;
	
}

	
