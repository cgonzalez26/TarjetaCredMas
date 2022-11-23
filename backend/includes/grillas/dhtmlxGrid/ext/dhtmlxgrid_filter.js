//v.1.5 build 71114

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
To use this component please contact sales@dhtmlx.com to obtain license
*/
//please beware that function started from _in_header_ must not be obfuscated



/**
*   @desc: filter grid by mask
*   @type: public
*   @param: column - {number} zero based index of column
*   @param: value - {string} filtering mask
*   @param: preserve - {bool} filter current or initial state ( false by default )
*	@edition: Professional
*   @topic: 0
*/
dhtmlXGridObject.prototype.filterBy=function(column, value, preserve){
		if (this.pagingOn) return this.filterByPaging(column, value, preserve);
		if (this._dload) return this.filterBySRND(column, value, preserve);
		if (this._srowsCol){
			if (!preserve)
				this.rowsCol=dhtmlxArray([].concat(this._srowsCol));
		} else
			this._srowsCol=[].concat(this.rowsCol);	//backup copy
	
		
	if (!this.rowsCol.length) return;
	var d=true;

	if (typeof(column)=="object")
		for (var j=0; j<value.length; j++)
			this._filterA(column[j],value[j]);
	else
			this._filterA(column,value);
	
	//redraw grid
	
	var p=this.obj.parentNode; 
//	p.removeChild(this.obj); //operation outside DOM is much faster
	var pp=this.obj.rows[0].parentNode; //safari way
	for (var i=this.obj.rows.length-1; i>0; i--)
		pp.removeChild(this.obj.rows[i]);
		
	for (var i=0; i<this.rowsCol.length; i++)		
		pp.appendChild(this.rowsCol[i]);
		
	p.appendChild(this.obj); //put back in DOM	
	this.callEvent("onGridReconstructed",[])
}
dhtmlXGridObject.prototype._filterA=function(column,value){ 
	if (value=="") return;
	var d=true;
	if (typeof(value)=="function") d=false;
	else value=(value||"").toString().toLowerCase();
	
	if (!this.rowsCol.length) return;
	var e=this.cells3(this.rowsCol[0],column);
	//caching exCell, as result we lost collspans 
	for (var i=this.rowsCol.length-1; i>=0; i--){
		e.cell=this.rowsCol[i].childNodes[column];
		if (d?(e.getValue().toLowerCase().indexOf(value)==-1):(!value(e.getValue()))){
			this.rowsCol.splice(i,1);//filter row
		}
		
	}
}
dhtmlXGridObject.prototype.filterBySRND=function(column, value, preserve){
		for (var i=0; i<this.rowsCol.length; i++)
    	if ( this.rowsCol[i] && !this.rowsBuffer[1][i]) {
        	this.rowsBuffer[1][i]=this.rowsCol[i];
            this.rowsBuffer[0][i]=this.rowsCol[i].idd;
        }
	this._filterBy_core(column, value, preserve);
	//redraw grid
	for(var i=this.rowsCol.length-1;i>=0;i--)
		if (this.rowsCol[i])
    		this.rowsCol[i].parentNode.removeChild(this.rowsCol[i]);
	this.rowsCol=new dhtmlxArray();
	this.limit=this.rowsBuffer[0].length;
    this._fastAddRowSpacer(0,this.limit*this._srdh);      
    if (this.limit)
    	this._askRealRows(0);
}
dhtmlXGridObject.prototype._filterBy_core=function(column, value, preserve){
	if (this._srowsBuf){
			if (!preserve){
				this.rowsBuffer=[dhtmlxArray([].concat(this._srowsBuf[0])),dhtmlxArray([].concat(this._srowsBuf[1]))];
			}
		} else{
			this._srowsBuf=[[].concat(this.rowsBuffer[0]),[].concat(this.rowsBuffer[1])];
		}
	
	if (!this.rowsBuffer[0].length) return;
	
		if (typeof(column)=="object" )
		for (var j=0; j<value.length; j++)
				this._filterB(column[j],value[j]);
		else	this._filterB(column,value);
}
dhtmlXGridObject.prototype._filterB=function(column,value){
	if (value=="") return;
	
	var d=true;
	if (typeof(value)=="function") d=false;
	else value=(value||"").toString().toLowerCase();
	
	var e=null;
	//caching exCell, as result we lost collspans 
	for (var i=this.rowsBuffer[0].length-1; i>=0; i--){
		if (this.rowsBuffer[1][i].idd){
			if (!e) e=this.cells3(this.rowsBuffer[1][i],column);
			e.cell=this.rowsBuffer[1][i].childNodes[column];
			var val=e.getValue();
		} else {
			var val=this.rowsBuffer[1][i].getElementsByTagName("cell")[column];
			if (val && val.firstChild) val=val.firstChild.data;
			else val="";
		}
		if (d?(val.toLowerCase().indexOf(value)==-1):(!value(val))){
			this.rowsBuffer[0].splice(i,1);//filter row
			this.rowsBuffer[1].splice(i,1);
		}
		
	}
}
dhtmlXGridObject.prototype.filterByPaging=function(column, value, preserve){
		var a0=[]; var a1=[];
		for (var i=0; i<this.rowsCol.length; i++){
			a0.push(this.rowsCol[i].idd);
			a1.push(this.rowsCol[i]);
		}
    	this.rowsBuffer[1]=dhtmlxArray(a1.concat(this.rowsBuffer[1]));
        this.rowsBuffer[0]=dhtmlxArray(a0.concat(this.rowsBuffer[0]));
        
		this._filterBy_core(column, value, preserve);
		
	//redraw grid

	for(var i=this.rowsCol.length-1;i>=0;i--)
		if (this.rowsCol[i].parentNode)
    		this.rowsCol[i].parentNode.removeChild(this.rowsCol[i]);
	this.rowsCol=new dhtmlxArray();
	this.limit=this.rowsBuffer[0].length;
	this.changePage(1);
}

/**
*   @desc: get all possible values in column
*   @type: public
*   @param: column - {number} zero based index of column
*   @returns: {array} array of all possible values in column
*	@edition: Professional
*   @topic: 0
*/
dhtmlXGridObject.prototype.collectValues=function(column){
	var c={}; var f=[];
	if (this.rowsCol.length)
	var e=this.cells3(this.rowsCol[0],column);
	for (var i=0; i<this.rowsCol.length; i++){
		e.cell=this.rowsCol[i].childNodes[column];
		var val=e.getValue();
		if (val) c[val]=true;
	}
	
	for (var i=this.rowsBuffer[0].length-1; i>=0; i--){
		if (!this.rowsBuffer[1][i]) continue;
		if (this.rowsBuffer[1][i].idd){
			e.cell=this.rowsBuffer[1][i].childNodes[column];
			var val=e.getValue();
			if (val) c[val]=true;
		} else {
			var val=this.rowsBuffer[1][i].getElementsByTagName("cell")[column];
			if (val && val.firstChild){
				val=val.firstChild.data;
				if (val) c[val]=true;
			}
		}
	}
	
	for (d in c) 
		if (c[d]===true) f.push(d);
	
	return f.sort();		
	
}

dhtmlXGridObject.prototype.filterByAll=function(){
	var a=[];
	var b=[];
	for (var i=0; i<this.filters.length; i++){
		a.push(this.filters[i][0]._filter?this.filters[i][0]._filter():this.filters[i][0].value);
		b.push(this.filters[i][1]);
	}
	this.filterBy(b,a);
	if (this._cssEven) this._fixAlterCss();
	this.callEvent("onFilterEnd",[this.filters]);
}

/**
*   @desc: create a filter from any input element (text filter), select (dropdown) or DIV (combobox based on dhtmlxCombo)
*   @type: public
*   @param: id - {string|object} input id or input html object
*   @param: column - {number} index of column
*   @param: preserve - {bool} filter current state or initial one ( false by default )
*	@edition: Professional
*   @topic: 0
*/
dhtmlXGridObject.prototype.makeFilter=function(id,column,preserve){
	if (!this.filters) this.filters=[];
	if (typeof(id)!="object")
		id=document.getElementById(id);
	if(!id) return;
	var self=this;
	
	id.style.width = "90%";
		
	if (id.tagName=='SELECT'){
		this.filters.push([id,column]);
		this._loadSelectOptins(id,column);
		id.onchange=function(){
			self.filterByAll();
		}
		if(_isIE)
			id.style.marginTop="1px";
	} 
	else if (id.tagName=='INPUT'){
		this.filters.push([id,column]);
		id.value='';
		id.onkeydown=function(){
			if (this._timer) window.clearTimeout(this._timer);
			this._timer=window.setTimeout(function(){
				self.filterByAll();
			},500);
		};
	}
	else if (id.tagName=='DIV' && id.className=="combo"){
		this.filters.push([id,column]);
		id.style.padding="0px";id.style.margin="0px";
		if (!window.dhx_globalImgPath) window.dhx_globalImgPath=this.imgURL;
		var z=new dhtmlXCombo(id,"_filter","90%");
		z.enableFilteringMode(true);
		id.combo=z;
		id.value="";
		
		this._loadComboOptins(id,column);
		z.attachEvent("onBlur",function(){
			id.value=z.getSelectedValue();
			self.filterByAll();
		});
	}
	if (id.parentNode)
		id.parentNode.className+=" filter";
}

/**
*   @desc: create a search box (set selection to the row with found value) from any input
*   @type: public
*   @param: id - {string|object} input id or input html object
*   @param: column - {number} index of column
*	@edition: Professional
*   @topic: 0
*/
dhtmlXGridObject.prototype.makeSearch=function(id,column){
	if (typeof(id)!="object")
		id=document.getElementById(id);
	if(!id) return;
	var self=this;
		
	if (id.tagName=='INPUT'){
		id.onkeypress=function(){
			if (this._timer) window.clearTimeout(this._timer);
			this._timer=window.setTimeout(function(){
				if (id.value=="") return;
				var z=self.findCell(id.value,column);
				if (z.length)
					self.selectRow(z[0][0])
			},500);
		};
	}
	if (id.parentNode)
		id.parentNode.className+=" filter";
}
	
dhtmlXGridObject.prototype._loadSelectOptins=function(t,c){ 
		var l=this.collectValues(c);
		t.innerHTML="";
		t.options[0]=new Option("","");
		for (var i=0; i<l.length; i++)
			t.options[t.options.length]=new Option(l[i],l[i]);
}
dhtmlXGridObject.prototype._loadComboOptins=function(t,c){ 
	var l=this.collectValues(c);
		t.combo.clearAll();
		t.combo.render(false);
		t.combo.addOption("","");
		for (var i=0; i<l.length; i++)
			t.combo.addOption(l[i],l[i]);
		t.combo.render(true);
}

/**
*   @desc: refresh filtering ( can be used if data in grid changed and filters need to be updated )
*   @type: public
*	@edition: Professional
*   @topic: 0
*/
dhtmlXGridObject.prototype.refreshFilters=function(){
	for (var i=0; i<this.filters.length; i++){
		switch(this.filters[i][0].tagName.toLowerCase()){
			case "input":
				break;
			case "select":
				this._loadSelectOptins.apply(this,this.filters[i]);
				break;
			case "div":
				this._loadComboOptins.apply(this,this.filters[i]);
				break;
		}
	}
}

dhtmlXGridObject.prototype._filters_ready=function(fl,code){
	this.attachEvent("onXLE",this.refreshFilters);
	this.attachEvent("onClearAll",function(){ this._srowsCol=null; });
	this._filters_ready=function(){};
}

dhtmlXGridObject.prototype._in_header_text_filter=function(t,i){
	t.innerHTML="<input type='text' style='width:98%; font-size:8pt; font-family:Tahoma; -moz-user-select:text; '>";
	t.onclick=t.onmousedown = function(e){ (e||event).cancelBubble=true; return true; }
	t.onselectstart=function(){ return (event.cancelBubble=true); }
	this.makeFilter(t.firstChild,i);
	this._filters_ready();
}

dhtmlXGridObject.prototype._in_header_select_filter=function(t,i){
	t.innerHTML="<select style='width:98%; font-size:8pt; font-family:Tahoma;'></select>";
	t.onclick=function(e){ (e||event).cancelBubble=true; return false; }
	this.makeFilter(t.firstChild,i);
	this._filters_ready();
}

dhtmlXGridObject.prototype._in_header_combo_filter=function(t,i){
	t.innerHTML="<div style='width:100%; padding-left:2px; overflow:hidden; font-size:8pt; font-family:Tahoma; -moz-user-select:text;' class='combo'></div>";
	t.onselectstart=function(){ return (event.cancelBubble=true); }
	t.onclick=function(e){ (e||event).cancelBubble=true; return false; }
	this.makeFilter(t.firstChild,i);
	this._filters_ready();
}

dhtmlXGridObject.prototype._in_header_text_search=function(t,i){
	t.innerHTML="<input type='text' style='width:98%; font-size:8pt; font-family:Tahoma; -moz-user-select:text;'>";
	t.onclick= t.onmousedown = function(e){ (e||event).cancelBubble=true; return true; }
	t.onselectstart=function(){ return (event.cancelBubble=true); }
	this.makeSearch(t.firstChild,i);
}

dhtmlXGridObject.prototype._in_header_numeric_filter=function(t,i){
	this._in_header_text_filter.call(this,t,i);
	t.firstChild._filter=function(){
		var v=this.value;
		
		var r; var op="=="; var num=parseFloat(v.replace("=","")); var num2=null;
		
		if (v){
			if (v.indexOf("..")!=-1){
				v=v.split("..");
				num=parseFloat(v[0]);
				num2=parseFloat(v[1]);
				return function(v){
					if (v>=num && v<=num2) return true;
					return false;
					}
			}
			r=v.match(/>|>=|<=|</)
			if (r) {
				op=r[0];
				num=parseFloat(v.replace(op,""));
			}
			return Function("v"," if (v "+op+" "+num+" ) return true; return false;");
		}
	};
}

dhtmlXGridObject.prototype._in_header_master_checkbox=function(t,i){
	t.innerHTML="<input type='checkbox' />";
	var self=this;
	t.firstChild.onclick=function(){
		var val=this.checked?1:0;
		self.forEachRow(function(id){
			this.cells(id,i).setValue(val);
		});
	}
}

dhtmlXGridObject.prototype._in_header_stat_total=function(t,i,c){
	var calck=function(){
		var summ=0;
		for (var j=0; j<this.rowsCol.length; j++)
			summ+=parseFloat(this.cells2(j,i).getValue());
		return summ;
	}
	this._stat_in_header(t,calck,i,c,c);
}
dhtmlXGridObject.prototype._in_header_stat_multi_total=function(t,i,c){
	var cols=c[1].split(":"); c[1]="";
	var calck=function(){
		var summ=0;
		for (var j=0; j<this.rowsCol.length; j++)
			summ+=parseFloat(this.cells2(j,cols[0]).getValue())*parseFloat(this.cells2(j,cols[1]).getValue());
		return Math.round(summ*100)/100;
	}
	this._stat_in_header(t,calck,i,c,c);
}
dhtmlXGridObject.prototype._in_header_stat_max=function(t,i,c){
	var calck=function(){
		var summ=-999999999;
		if (this.getRowsNum()==0) return "";
		for (var j=0; j<this.rowsCol.length; j++)
			summ=Math.max(summ,parseFloat(this.cells2(j,i).getValue()));
		
		return summ;
	}
	this._stat_in_header(t,calck,i,c);
}
dhtmlXGridObject.prototype._in_header_stat_min=function(t,i,c){
	var calck=function(){
		var summ=999999999;
		if (this.getRowsNum()==0) return "";
		for (var j=0; j<this.rowsCol.length; j++)
			summ=Math.min(summ,parseFloat(this.cells2(j,i).getValue()));
		return summ;
	}
	this._stat_in_header(t,calck,i,c);
}
dhtmlXGridObject.prototype._in_header_stat_average=function(t,i,c){
	var calck=function(){
		var summ=0; var count=0;
		for (var j=0; j<this.rowsCol.length; j++){
			summ+=parseFloat(this.cells2(j,i).getValue());
			count++;
		}
		return Math.round(summ/count*100)/100;
	}
	this._stat_in_header(t,calck,i,c);
}
dhtmlXGridObject.prototype._in_header_stat_count=function(t,i,c){
	var calck=function(){
		return this.getRowsNum();
	}
	this._stat_in_header(t,calck,i,c);
}

dhtmlXGridObject.prototype._stat_in_header=function(t,calck,i,c){
	var that=this;
	var f=function(){
		this.dma(true)
		t.innerHTML=(c[0]?c[0]:"")+calck.call(this)+(c[1]?c[1]:"");
		this.dma(false)
	}
	this.attachEvent("onGridReconstructed",f);
	this.attachEvent("onXLE",f);
	this.attachEvent("onFilterEnd",f);
	this.attachEvent("onEditCell",function(stage,id,ind){
		if (stage==2 && ind==i) f.call(this);
		return true;
		});
}



//(c)dhtmlx ltd. www.dhtmlx.com