//v.1.5 build 71114

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
To use this component please contact sales@dhtmlx.com to obtain license
*/
/**
*   @desc: add new column to the grid
*   @param: ind - index of column
*   @param: header - header content of column
*   @param: type - type of column
*   @param: width - width of column
*   @param: sort - sort type of column
*   @param: align - align of column
*   @param: valign - vertical align of column
*   @param: hidden - hidden state of column
*   @param: columnColor - background color of column
*   @type: public
*   @edition: Professional
*   @topic: 0
*/
dhtmlXGridObject.prototype.insertColumn=function(ind,header,type,width,sort,align,valign,hidden,columnColor){
	ind=parseInt(ind);
	if (ind>this._cCount) ind=this._cCount;
	if (!this._cMod) this._cMod=this._cCount;
	this._processAllArrays(this._cCount,ind-1,[(header||"&nbsp;"),(width||100),(type||"ed"),(align||"left"),(valign||""),(sort||"na"),(columnColor||""),(hidden||false),this._cMod,(width||100)]);
	this._processAllRows("_addColInRow",ind);

	if (typeof(header)=="object")
		for (var i=1; i < this.hdr.rows.length; i++) {
			if (header[i-1]=="#rspan"){
         		var pind=i-1;
         		var found=false;
         		var pz=null;
         		while(!found){
            		var pz=this.hdr.rows[pind];
            		for (var j=0; j<pz.cells.length; j++)
               			if (pz.cells[j]._cellIndex==ind) {
                  			found=j;
                  			break;
		      		}
            		pind--;
	        	}
	        this.hdr.rows[pind+1].cells[j].rowSpan=(this.hdr.rows[pind].cells[j].rowSpan||1)+1;
			}
			else				
			this.setHeaderCol(ind,(header[i-1]||"&nbsp;"),i);
		}
	else
		this.setHeaderCol(ind,(header||"&nbsp;"));
	this.hdr.rows[0].cells[ind]
	this._cCount++;
	this._cMod++;
	this.setSizes();
}
/**
*   @desc: delete column
*   @param: ind - index of column
*   @type: public
*   @edition: Professional
*   @topic: 0
*/
dhtmlXGridObject.prototype.deleteColumn=function(ind){
	ind=parseInt(ind);
	if (this._cCount==0) return;
	if (!this._cMod) this._cMod=this._cCount;
	if (ind>=this._cCount) return;
	this._processAllArrays(ind,this._cCount-1,[null,null,null,null,null,null,null,null,null,null,null]);
	this._processAllRows("_deleteColInRow",ind);
	this._cCount--;
	this.setSizes();

}

/**
*   @desc: call method for all rows in all collections
*   @type: private
*   @topic: 0
*/
dhtmlXGridObject.prototype._processAllRows = function(method,oldInd,newInd){
    var z=this.obj.rows.length;
    for (var i=0; i<z; i++)
		this[method](this.obj.rows[i],oldInd,newInd,i);

	var z=this.hdr.rows.length;
    for (var i=0; i<z; i++)
		this[method](this.hdr.rows[i],oldInd,newInd,i);
		
	if (this.ftr){
		var z=this.ftr.firstChild.rows.length;
	    for (var i=0; i<z; i++)
			this[method](this.ftr.firstChild.rows[i],oldInd,newInd,i);
	}

	this.forEachRow(function(id){
		if (!this.rowsAr[id].parentNode || !this.rowsAr[id].parentNode.tagName)
			this[method](this.rowsAr[id],oldInd,newInd,-1);
	});			
	

	var z=this.rowsBuffer[1].length;
    for (var i=0; i<z; i++)
		if ((this.rowsBuffer[1][i])&&(this.rowsBuffer[1][i].tagName=="TR"))
			this[method](this.rowsBuffer[1][i],oldInd,newInd,-1);
}

/**
*   @desc: shift data in all arrays
*   @type: private
*   @topic: 0
*/
dhtmlXGridObject.prototype._processAllArrays = function(oldInd,newInd,vals){
	var ars=["hdrLabels","initCellWidth","cellType","cellAlign","cellVAlign","fldSort","columnColor","_hrrar","_c_order"];
	if (this.cellWidthPX.length) ars.push("cellWidthPX");
	if (this.cellWidthPC.length) ars.push("cellWidthPC");
    if (this._mCols) ars[ars.length]="_mCols";
    ars.push("combos");
    if (this._customSorts) ars.push("_customSorts");
    var mode=(oldInd<=newInd);

	if (!this._c_order) {
		this._c_order=new Array();
		var l=this._cCount;
		for (var i=0; i<l; i++)
			this._c_order[i]=i;
	}

	for (var i=0; i<ars.length; i++)
		{
			var t=this[ars[i]];
			if (t){
				if (mode){
					var val=t[oldInd];
					for (var j=oldInd; j<newInd; j++)
						t[j]=t[j+1];
					t[newInd]=val;
				} else {
					var val=t[oldInd];
					for (var j=oldInd; j>(newInd+1); j--)
						t[j]=t[j-1];
					t[newInd+1]=val;
				}
				if (vals)
					t[newInd+(mode?0:1)]=vals[i];
			}
		}
}


/**
*   @desc: moves column of specified index to new position
*   @param: oldInd - current index of column
*   @param: newInd - new index of column
*   @type: public
*   @edition: Professional
*   @topic: 0
*/
dhtmlXGridObject.prototype.moveColumn = function(oldInd,newInd){
	newInd--;
    oldInd=parseInt(oldInd); newInd=parseInt(newInd);
	if (newInd<oldInd) var tInd=newInd+1;
	else var tInd=newInd;
	

	if (!this.callEvent("onBeforeCMove",[oldInd,tInd]))  return false;
	if (oldInd==tInd) return;

	
	//replace data
	this.editStop();
    this._processAllRows("_moveColInRow",oldInd,newInd);
    this._processAllArrays(oldInd,newInd);

	//sorting image
	if (this.fldSorted)
		this.setSortImgPos(this.fldSorted._cellIndex);

  /*	for (var i=0; i<this.hdrLabels.length; i++)
		this._c_revers[this._c_order[i]]=i;*/
	this.callEvent("onAfterCMove",[oldInd,tInd]);
};


/**
*   @desc: swap columns in collection
*   @param: cols - collection of collumns
*   @type: private
*   @topic: 0
*/
dhtmlXGridObject.prototype._swapColumns = function(cols){
	var z=new Array();
	for (var i=0; i<this._cCount; i++){
		var n=cols[this._c_order[i]];
		if (typeof(n)=="undefined") n="";
		z[i]=n;
		}
	return z;
}

/**
*   @desc: move data in the row
*   @param: row - row object
*   @param: oldInd - current index of column
*   @param: newInd - new index of column
*   @type: private
*   @topic: 0
*/
dhtmlXGridObject.prototype._moveColInRow = function(row,oldInd,newInd){


	var c=row.childNodes[oldInd];
	var ci=row.childNodes[newInd+1];
	if (!c) return;
	if (ci)
		row.insertBefore(c,ci);
	else
		row.appendChild(c);

	for (var i=0; i<row.childNodes.length; i++)
		row.childNodes[i]._cellIndex=row.childNodes[i]._cellIndexS=i;

};
/**
*   @desc: add column in row
*   @param: row - row object
*   @param: ind - current index of column
*   @type: private
*   @topic: 0
*/
dhtmlXGridObject.prototype._addColInRow = function(row,ind,old,mod){
	var c=row.childNodes[ind];
	var z=document.createElement((mod)?"TD":"TH");
	z.style.width=this.cellWidthPX[ind];
	if (c)
		row.insertBefore(z,c);
	else
		row.appendChild(z);

	for (var i=ind; i<row.childNodes.length; i++)
		row.childNodes[i]._cellIndex=row.childNodes[i]._cellIndexS=i;

	if (row.idd || typeof(row.idd)!="undefined"){
		this.cells3(row,ind).setValue("");
		z.align=this.cellAlign[ind];
		z.style.verticalAlign=this.cellVAlign[ind];
		z.bgColor=this.columnColor[ind];
		}
	else if (z.tagName=="TD") z.innerHTML="&nbsp;";
};
/**
*   @desc: delete columns from row
*   @param: row - row object
*   @param: ind - current index of column
*   @type: private
*   @topic: 0
*/
dhtmlXGridObject.prototype._deleteColInRow = function(row,ind){
	var c=row.childNodes[ind];
	if (c)
		row.removeChild(c);

	for (var i=ind; i<row.childNodes.length; i++)
		row.childNodes[i]._cellIndex=row.childNodes[i]._cellIndexS=i;
};

/**
*   @desc: enable move column functionality
*   @param: mode - enable/disable
*   @param: columns - list of true/false values, optional
*   @type: public
*   @edition: Professional
*   @topic: 0
*/
dhtmlXGridObject.prototype.enableColumnMove = function(mode,columns){
	this._mCol=convertStringToBoolean(mode);
	if (typeof(columns)!="undefined")
		this._mCols=columns.split(",");
	if (!this._mmevTrue){
		dhtmlxEvent(this.hdr,"mousedown",this._startColumnMove);
		dhtmlxEvent(document.body,"mousemove",this._onColumnMove);
		dhtmlxEvent(document.body,"mouseup",this._stopColumnMove);
		this._mmevTrue=true;
	}
};

dhtmlXGridObject.prototype._startColumnMove = function(e){
	e=e||event;
	var el = e.target||e.srcElement;
//	var grid=globalActiveDHTMLGridObject;
	   	var zel=el;
	   	while(zel.tagName!="TABLE") zel=zel.parentNode;
		var grid=zel.grid;
		if (!grid) return; //somehow grid not found
		grid.setActive();

	el = grid.getFirstParentOfType(el,"TD")
    if(el.style.cursor!="default") return true;
	if ((grid)&&(!grid._colInMove)){
		if ((!grid._mCols)||(grid._mCols[el._cellIndex]=="true"))
	    	grid._colInMove=el._cellIndex+1;
	}
	return true;
};
dhtmlXGridObject.prototype._onColumnMove = function(e){
	e=e||event;
	var grid=window.globalActiveDHTMLGridObject;
	if ((grid)&&(grid._colInMove)){
    	if (typeof(grid._colInMove)!="object"){
        	var z=document.createElement("DIV");
			z._aIndex=(grid._colInMove-1);
			z._bIndex=null;
			z.innerHTML=grid.getHeaderCol(z._aIndex);
			z.className="dhx_dragColDiv";
			z.style.position="absolute";
			document.body.appendChild(z);
            grid._colInMove=z;
		}
		var cor=grid.getPosition(document.body);
		cor[0]+=(document.body.scrollLeft||0);
		cor[1]+=(document.body.scrollTop||0);		
		
		
		grid._colInMove.style.left=e.clientX+cor[0]+8+"px";
		grid._colInMove.style.top=e.clientY+cor[1]+8+"px";
		
        var el = e.target||e.srcElement;
		while ((el)&&(typeof(el._cellIndexS)=="undefined"))
			el=el.parentNode;

		if (grid._colInMove._oldHe){
			grid._colInMove._oldHe.className=grid._colInMove._oldHe.className.replace(/columnTarget(L|R)/g,"");
			grid._colInMove._oldHe=null;
			grid._colInMove._bIndex=null;
			}
		if (el) {
			if (grid.hdr.rows[1]._childIndexes)
				var he=grid.hdr.rows[1].cells[grid.hdr.rows[1]._childIndexes[el._cellIndexS]];
			else
				var he=grid.hdr.rows[1].cells[el._cellIndexS];
			var z=e.clientX-(getAbsoluteLeft(he)-grid.hdrBox.scrollLeft);
            if (z/he.offsetWidth>0.5){
				he.className+=" columnTargetR";
				grid._colInMove._bIndex=el._cellIndexS;
				}
			else {
				he.className+=" columnTargetL";
				grid._colInMove._bIndex=el._cellIndexS-1;
			}
			if (he.offsetLeft<(grid.objBox.scrollLeft+20))
				grid.objBox.scrollLeft=Math.max(0,he.offsetLeft-20);
				
			if ((he.offsetLeft+he.offsetWidth-grid.objBox.scrollLeft)>(grid.entBox.offsetWidth-20))
				grid.objBox.scrollLeft=Math.min(grid.objBox.scrollLeft+he.offsetWidth+20,grid.objBox.scrollWidth-grid.objBox.offsetWidth);	
				
            grid._colInMove._oldHe=he;
		}
	}
	return true;
};
dhtmlXGridObject.prototype._stopColumnMove = function(e){
	e=e||event;
	var grid=window.globalActiveDHTMLGridObject;
	if ((grid)&&(grid._colInMove)){
		if (typeof(grid._colInMove)=="object"){
			grid._colInMove.parentNode.removeChild(grid._colInMove);
			if (grid._colInMove._bIndex!=null)
				grid.moveColumn(grid._colInMove._aIndex,grid._colInMove._bIndex+1);

			if (grid._colInMove._oldHe)
				grid._colInMove._oldHe.className=grid._colInMove._oldHe.className.replace(/columnTarget(L|R)/g,"");
			grid._colInMove._oldHe=null;
			grid._colInMove.grid=null;
			}
        grid._colInMove=0;
	}
	return true;
};


/**
*     @desc: set function called on start of column moving operation
*     @param: func - event handling function
*     @type: deprecated
*     @edition: Professional
*     @topic: 10
*     @event:  onBeforeCMove
*     @eventdesc: event called on start of column moving operation
*     @eventparam: index of moved column
*     @eventparam: index of new position
*     @eventreturns: if event returns false - the moving denied
*/
   dhtmlXGridObject.prototype.setOnBeforeColumnMove=function(func){
            this.attachEvent("onBeforeCMove",func);
        };

/**
*     @desc: set function called after column moved
*     @param: func - event handling function
*     @type: deprecated
*     @edition: Professional
*     @topic: 10
*     @event:  onAfterCMove
*     @eventdesc: event called after  column moved
*     @eventparam: index of moved column
*     @eventparam: index of new position
*/
   dhtmlXGridObject.prototype.setOnAfterColumnMove=function(func){
            this.attachEvent("onAfterCMove",func);
        };


//(c)dhtmlx ltd. www.dhtmlx.com

