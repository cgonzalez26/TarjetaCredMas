//v.1.5 build 71114

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
To use this component please contact sales@dhtmlx.com to obtain license
*/
dhtmlXGridObject.prototype.attachHeaderA=dhtmlXGridObject.prototype.attachHeader;
dhtmlXGridObject.prototype.attachHeader=function()
{
	this.attachHeaderA.apply(this,arguments);
	this.formAutoSubmit();
	if (typeof(this.FormSubmitOnlyChanged)=="undefined")
		this.submitOnlyChanged(true);
		
	if (typeof(this._submitAR)=="undefined")
		this.submitAddedRows(true);
		
	var that=this;
	
	this._added_rows=[];
	this._deleted_rows=[];
	
	this.attachEvent("onRowAdded",function(id){ 
		that._added_rows.push(id);
		that.forEachCell(id,function(a){ a.cell.wasChanged=true; })
		return true;
	});
	this.attachEvent("onBeforeRowDeleted",function(id){
		that._deleted_rows.push(id);
		return true;
	});
	
	this.attachHeader=this.attachHeaderA;
}

dhtmlXGridObject.prototype.formAutoSubmit = function()
{
	this.parentForm = this.detectParentFormPresent();
	if (this.parentForm === false) {
		return false;
	}
	if (this.formEventAttached)
		return;
    this.formInputs = new Array();
	var self = this;
	dhtmlxEvent(this.parentForm, 'submit', function() {self.parentFormOnSubmit();});
	this.formEventAttached = true;
}

dhtmlXGridObject.prototype.parentFormOnSubmit = function()
{
	this.formCreateInputCollection();
}

/**
*   @desc: include only changed rows in form submit
*   @type: public
*   @param: mode - {boolean}  enable|disable mode
*   @topic: 0
*/
dhtmlXGridObject.prototype.submitOnlyChanged = function(mode)
{
	this.FormSubmitOnlyChanged = convertStringToBoolean(mode);
}

/**
*   @desc: include additional data with info about which rows was added and which deleted, enabled by default
*   @type: public
*   @param: mode - {boolean}  enable|disable mode
*   @topic: 0
*/
dhtmlXGridObject.prototype.submitAddedRows = function(mode)
{
	this._submitAR = convertStringToBoolean(mode);
}




/**
*   @desc: include only selected rows in form submit
*   @type: public
*   @param: mode - {boolean}  enable|disable mode
*   @topic: 0
*/
dhtmlXGridObject.prototype.submitOnlySelected = function(mode)
{
	this.FormSubmitOnlySelected = convertStringToBoolean(mode);
}


/**
*   @desc: include only  row's IDS in form submit
*   @type: public
*   @param: mode - {boolean}  enable|disable mode
*   @topic: 0
*/
dhtmlXGridObject.prototype.submitOnlyRowID = function(mode)
{
	this.FormSubmitOnlyRowID = convertStringToBoolean(mode);
}


dhtmlXGridObject.prototype._createInput = function(name,value){
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name =(this.entBox.id||'dhtmlXGrid')+'_'+name;
    input.value = value;
    this.parentForm.appendChild(input);
    this.formInputs.push(input);
}

dhtmlXGridObject.prototype._createInputRow = function(r){ 
	for (var j=0; j<this._cCount; j++){
		var foo_cell = this.cells3(r, j);
		if ((!this.FormSubmitOnlyChanged) || foo_cell.wasChanged())
			this._createInput(r.idd+'_'+j,foo_cell.getValue());
	}
}


dhtmlXGridObject.prototype.formCreateInputCollection = function()
{
	if (this.parentForm == false) {
		return false;
	}
	for (var i=0; i<this.formInputs.length; i++) {
		this.parentForm.removeChild(this.formInputs[i]);
	}
    this.formInputs = new Array();
    
    if (this.FormSubmitOnlySelected){
    	//submit selected
    	if (this.FormSubmitOnlyRowID)
    		this._createInput("selected",this.getSelectedId());
    	else
    		for(var i=0;i<this.selectedRows.length;i++)
    			this._createInputRow(this.selectedRows[i]);
    	}
    else{
    	//submit all
    		if (this._submitAR){
    			if (this._added_rows.length)
    				this._createInput("rowsadded",this._added_rows.join(","));
    			if (this._deleted_rows.length)
    				this._createInput("rowsdeleted",this._deleted_rows.join(","));
	    		}
    		this.forEachRow(function(id){
    			this._createInputRow(this.rowsAr[id]);
			})
    		
    	}
}

dhtmlXGridObject.prototype.detectParentFormPresent = function()
{
	var parentForm = false;
	var parent = this.entBox;
	while(parent != document.body) {
		if (parent.tagName.toLowerCase() == 'form') {
			parentForm = parent;
			break;
		} else {
        	parent = parent.parentNode;
		}
	}
	return parentForm;
}
//(c)dhtmlx ltd. www.dhtmlx.com
