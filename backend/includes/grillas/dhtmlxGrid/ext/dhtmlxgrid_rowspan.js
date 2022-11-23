//v.1.5 build 71114

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
To use this component please contact sales@dhtmlx.com to obtain license
*/
/**
*   @desc: set rowspan with specified length starting from specified cell
*   @param: rowID - row Id
*	@param: colInd - column index
*	@param: length - length of rowspan
*   @type:  public
*/
dhtmlXGridObject.prototype.setRowspan=function(rowID,colInd,length){
   var c=this.cells(rowID,colInd).cell;
   var r=this.rowsAr[rowID];

   if (c.rowSpan && c.rowSpan!=1){
		var ur=r.nextSibling;   				
		for (var i=1; i<c.rowSpan; i++){
			var tc=ur.childNodes[ur._childIndexes[c._cellIndex+1]]
			var ti=document.createElement("TD"); 
			ti.innerHTML="&nbsp;"; 
			ti._cellIndex=c._cellIndex;
			ti._clearCell=true;
			if (tc)
				tc.parentNode.insertBefore(ti,tc);
			else
				tc.parentNode.appendChild(ti);
			this._shiftIndexes(ur,c._cellIndex,-1);
	    	ur=ur.nextSibling;
	    }
    }

    c.rowSpan=length;
   
	r=r.nextSibling;
	var kids=[];
	for (var i=1; i<length; i++){
		var ct=this.cells3(r,colInd).cell;
		this._shiftIndexes(r,c._cellIndex,1);
    	ct.parentNode.removeChild(ct);
    	kids.push(r);
    	
    	r=r.nextSibling;
    }
    
    this.rowsAr[rowID]._rowSpan=this.rowsAr[rowID]._rowSpan||{};
    this.rowsAr[rowID]._rowSpan[colInd]=kids;
    
}


dhtmlXGridObject.prototype._shiftIndexes=function(r,pos,ind){
		if (!r._childIndexes){
    	r._childIndexes=new Array();
        for (var z=0; z<r.childNodes.length; z++)
            r._childIndexes[z]=z;
		}
		
		for (var z=0; z<r._childIndexes.length; z++)
			if (z>pos)
            	r._childIndexes[z]=r._childIndexes[z]-ind;
				
}

/**
*   @desc: enable rowspan in grid
*   @type:  public
*/
dhtmlXGridObject.prototype.enableRowspan=function(){
	this.enableRowspan=function(){};
	this.attachEvent("onAfterSorting",function(){
		if (this._dload) return; //can't be helped
		for (var i=1; i<this.obj.rows.length; i++)	
		  if (this.obj.rows[i]._rowSpan){
		  	var master=this.obj.rows[i];
		  	for (var kname in master._rowSpan){
			  	var row=master;
				var kids=row._rowSpan[kname];
			  	for (var j=0; j < kids.length; j++) {
			  		if(row.nextSibling)
			  			row.parentNode.insertBefore(kids[j],row.nextSibling);
			  		else 
			  			row.parentNode.appendChild(kids[j]);
			 		row=row.nextSibling;
			  	}
		    }
	  }
	  this.rowsCol=new dhtmlxArray();
	  for (var i=1; i<this.obj.rows.length; i++)	
	  	this.rowsCol.push(this.obj.rows[i]);
	  
	}) 
	
	this.attachEvent("onXLE",function(){
		var spans=this.xmlLoader.doXPath("//cell[@rowspan]");
		for (var i=0; i<spans.length; i++){
			var p=spans[i].parentNode;
			var rid=p.getAttribute("id");
			var len=spans[i].getAttribute("rowspan");
			var ind=0;
			for (var j=0; j < p.childNodes.length; j++) {
				if (p.childNodes[j].tagName=="cell"){
					if (p.childNodes[j] == spans[i])
						break;
					else
					 	ind++;
				}
			}
			
		this.setRowspan(rid,ind,len)	
		}
	})
}
