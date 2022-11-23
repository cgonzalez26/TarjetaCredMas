//v.1.5 build 71114

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
To use this component please contact sales@dhtmlx.com to obtain license
*/
/**
*	@desc: integration with dhtmlxCombo editor
*	@returns: dhtmlxGrid cell editor object
*	@type: public
*/
function eXcell_combo(cell){
		try{
			this.cell = cell;
			this.grid = this.cell.parentNode.grid;
			
		}catch(er){}
				
		/**
		*	@desc: method called by grid to start editing
		*/
	this.edit = function(){
		
		
		val = this.getValue();  
		if(val == "&nbsp;") val="";
		this.cell.innerHTML="";
		dhx_globalImgPath="../../../dhtmlXCombo/codebase/imgs/";
		this.obj = new dhtmlXCombo(this.cell,"combo",this.cell.offsetWidth-2);
		this.obj.DOMelem.className+=" fake_editable";
		grid = this.grid;
		this.obj.DOMelem.onselectstart=function(){event.cancelBubble=true; return true;};
		this.obj.DOMelem.onkeydown=function(ev){ ev=ev||window.event; if (ev.keyCode!=9) ev.cancelBubble=true; if (ev.keyCode==13) grid.editStop();};
		this.obj.DOMelem.style.border = "0px";
		this.obj.DOMelem.style.height = "18px";	
		
		
		this.obj.openSelect();
		
		if((this.cell._filter == true)&&(this.cell._auto==false)) this.obj.enableFilteringMode(true);
		
		if((this.cell._editable == false)&&(this.cell._filter == false)&&(this.cell._auto == false)) {
				this.obj.DOMelem_input.readOnly = true;
				this.obj.DOMelem.onkeyup=function(ev){ 
					ev=ev||window.event; 
					if (ev.keyCode!=9) ev.cancelBubble=true;
					this.nextOptionIndex = -1; 
					if(ev.keyCode >= 65 && ev.keyCode <= 90){
						for(var i=0; i<(this.combo.optionsArr.length < 70)?this.combo.optionsArr.length:70; i++){
								var text = this.combo.optionsArr[i].text;
								if(text.toUpperCase().indexOf(String.fromCharCode(ev.keyCode)) == 0){
								this.nextOptionIndex = i;
								break;
							}
						}
						ev.cancelBubble=true;
					}
					if(this.nextOptionIndex != -1)	this.combo.selectOption(this.nextOptionIndex);
						
				}
				
		}
		
		if(this.cell._url == false){
			this.options = [];
			this.options = this.getOptionsArr();
			for (var i=0; i < this.options.length; i++){
				if(this.options[i].tagName =="option"){
					this.obj.addOption(i,this.options[i].firstChild.data);
				}
			}
			
			
			if((this.obj.getOptionByLabel(val))&&(this.cell._filter == false))
				this.obj.selectOption(this.obj.getIndexByValue(this.obj.getOptionByLabel(val).value));
			else this.obj.setComboText(val);
		}
		else if(this.cell._url){
				if(this.cell._auto == false){
					this.obj.loadXML(this.cell._url, function(){
						if ((val||"").toString()._dhx_trim()=="") value = "";
							else value = val;
						if(this.mainObject.getOptionByLabel(value)) 
							this.mainObject.selectOption(this.mainObject.getIndexByValue(this.mainObject.getOptionByLabel(value).value));
						else this.mainObject.setComboText(value);
					});
				}
				else{
				//debugger;
					this.obj.enableFilteringMode(true,this.cell._url,this.cell._cache,this.cell._sub)
					this.obj.setComboValue(val);
					this.cell.onkeypress=function(e){ (e||event).cancelBubble=true; return true; }
				}
			}
			
			
			
 
	}
	this.selectComboOption = function(val,obj){
		obj.selectOption(obj.getIndexByValue(obj.getOptionByLabel(val).value));
	}
	
		/**
		*	@desc: get real value of the cell
		*/
		
	this.getValue = function(val){
		//if (this.cell._cval) return this.cell._cval;
		return this.cell.innerHTML.toString();
	}
		/**
		*	@desc: set formated value to the cell
		*/
	
	
	
	this.setValue = function(val){
		
			
			
			for(var i= 0; i < this.cell.parentNode.childNodes.length; i++){
				this.cell.parentNode.childNodes[i].tabIndex = 0;
			}
			
			if (typeof(val)!="object"){
						this.optArr = [];
						this.cell._url = false;
						this.cell._filter = false;
						this.cell._cache = false;
						this.cell._auto = false;
						this.cell._sub = false; 
						this.cell._editable = true; 
						this.optArr = this.getOptionsArr();
						for (var i=0; i < this.optArr.length; i++){
							switch(this.optArr[i].tagName){
								case "option":
									value = this.optArr[i].getAttribute("value");
									if(value == val)
									  val = this.optArr[i].firstChild.data;
									break;
								case "editable":
									if(convertStringToBoolean(this.optArr[i].firstChild.data)==false){
										this.cell._editable = false; 
									}
									else this.cell._editable = true;
									break;
								case "source":								
									this.cell._url = this.optArr[i].firstChild.data; 
									this.loader=new dtmlXMLLoaderObject(function(a,b,c,d,loader){this.cells=loader.doXPath("//option");for ( var i=0; i<this.cells.length; i++){value = this.cells[i].getAttribute("value");if(value == val) {val = this.cells[i].firstChild.data; this.cell.innerHTML = val; }}});
									this.loader.cell = this.cell;
									this.loader.loadXML(this.cell._url);
									break;
					
								case "filter":
									if(convertStringToBoolean(this.optArr[i].firstChild.data))
										this.cell._filter = true;
									break;
								case "auto":
									if(convertStringToBoolean(this.optArr[i].firstChild.data))
										this.cell._auto = true;
									break;
					
								case "cache":
									if(convertStringToBoolean(this.optArr[i].firstChild.data))
										this.cell._cache = true;
									break;
					
								case "sub":
									if(convertStringToBoolean(this.optArr[i].firstChild.data))
										this.cell._sub = true;
									break;
								
					
							}
						}						
				}			
					
				if ((val||"").toString()._dhx_trim()=="")
					val=null
                if (val!==null)
 				    this.setCValue(val);
                else
                    this.setCValue("&nbsp;",val);
				this.setCValue(val);
				
	}
	
	
	
	this._getXML = function(src,val){

		
	}

	
	this.getOptionsArr = function(){
			columns = this.grid.xmlLoader.doXPath("//column");
			optCol = columns[this.cell._cellIndex].childNodes;
			return optCol;
	}
	
	

	                         
		/**
		*	@desc: this method called by grid to close editor
		*/
	this.detach = function(){
	
		
		
		if (!this.obj.getComboText() || this.obj.getComboText().toString()._dhx_trim()==""){
			this.setCValue("&nbsp;");
    	}
		else this.setCValue(this.obj.getComboText(),this.obj.getActualValue())
		this.cell._cval=this.obj.getActualValue();
		this.obj.closeAll();
		
		this.val = val;
		return val!=this.getValue()
		
		
	}
}
eXcell_combo.prototype = new eXcell;
//(c)dhtmlx ltd. www.dhtmlx.com