//v.1.5 build 71114

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
To use this component please contact sales@dhtmlx.com to obtain license
*/
dhtmlXGridObject.prototype.unGroup=function(){ 
	if (!this._groups) return;
	this._dndProblematic=false;
	if (typeof(this._gIndex)!="undefined") { 
		var b=this._groups_get();	
		this.rowsCol=new dhtmlxArray(0);
	
		for (var i=0; i<b.length; i++){
			var gr=b[i]._cntr;
			for (var j=0; j<gr._childs.length; j++){
				this.obj.firstChild.appendChild(gr._childs[j]);
				gr._childs[j].style.display='';
				this.rowsCol.push(gr._childs[j]);
			}
		}
		this._temp_par.appendChild(this.obj);	
		
	}
	delete this._groups;
	delete this._gIndex;	
	if (this.__sortRowsBG)
		this.sortRows=this.__sortRowsBG;
}
/**
*	@desc: group grid content by values of specified column
*	@param: ind - column index to group by
*	@edition: Professional
*	@type: public
*/
dhtmlXGridObject.prototype.groupBy=function(ind){
	
	if (this._groups) this.unGroup();
	this._dndProblematic=true;
	this._groups=[];
	this._gIndex=ind;
	
	
	//keyboard commands
	this._nextRow=function(ind,dir){
		var r=this.rowsCol[ind+dir];
		if (r && ( r.style.display=="none" || r._cntr)) return this._nextRow(ind+dir,dir);
		return r;	
	}
	this._key_events.k38_0_0=function(){
		if (this.editor && this.editor.combo)
			this.editor.shiftPrev();
		else{
			var rowInd = this.row.rowIndex;
			if (!rowInd) return;
			var nrow=this._nextRow(rowInd-1,-1);
			if (nrow)
        		this.selectCell(nrow,this.cell._cellIndex,true);
		}
	}
	
	if (!this.__sortRowsBG){
		this.attachEvent("onClearAll",function(){ this.unGroup(); });
		this.attachEvent("onBeforeRowDeleted",function(id){ 
			if (!this.rowsAr[id]) return true;
			var z=this._groups[this.cells(id,this._gIndex).getValue()];
			this._dec_group(z);
			return true;
			});
		this.attachEvent("onCheckbox",function(id,index,value){
			this.callEvent("onEditCell",[2,id,index,(value?1:0),(value?0:1)]);
		});
		this.attachEvent("onEditCell",function(stage,id,ind,val,oldval){
			if (stage==2 && val!=oldval && ind==this._gIndex){
				this._dec_group(this._groups[oldval]);
				var r=this.rowsAr[id];
				var i=this.rowsCol._dhx_find(r)
				var ni=this._inc_group(val);
				var n=this.rowsCol[ni];
				var p=r.parentNode;
				var o=r.rowIndex;
				
				p.removeChild(r);
				if (n)
					p.insertBefore(r,n);
				else
					p.appendChild(r);
				this.rowsCol._dhx_insertAt(ni,r);
				if (ni<i) i++;
				this.rowsCol._dhx_delAt(i,r);
				this._fixAlterCss();
				}
			return true;
			})
	}
	this.__sortRowsBG=this.sortRows;
	this.sortRows=function(col,type,order){
		if (col!=this._gIndex)
			return this._sortInGroup(col,type,order);
		else
			return this._sortByGroup(col,type,order);
	}
	this._key_events.k13_1_0=this._key_events.k13_0_1=function(){};
	
	this._groupExisting();	
}

dhtmlXGridObject.prototype._inc_group=function(val){
	if (!this._groups[val]){ 
		this._groups[val]={text:val,row:this._addPseudoRow(),count:0,state:"minus"}; }
	var z=this._groups[val];
	z.row._cntr=z;
		
	 
	var ind=this.rowsCol._dhx_find(z.row)+z.count+1;
	z.count++;
	this._updateGroupView(z);
	return ind;
		
}
dhtmlXGridObject.prototype._dec_group=function(z){
	if (!z) return;
	z.count--;
	if (z.count==0){
		z.row.parentNode.removeChild(z.row);
		this.rowsCol._dhx_delAt(this.rowsCol._dhx_find(z.row));
		delete this._groups[z.text];
	}
	else
		this._updateGroupView(z);
	return true;	
	}
dhtmlXGridObject.prototype._insertRowAt_gA=dhtmlXGridObject.prototype._insertRowAt;
dhtmlXGridObject.prototype._insertRowAt=function(r,ind,skip){
	if (typeof(this._groups)!="undefined"){
		var val=this.cells4(r.childNodes[this._gIndex]).getValue();
		if (!val) val=" ";
		ind=this._inc_group(val);		
	}
	return this._insertRowAt_gA(r,ind,skip);
}

dhtmlXGridObject.prototype._updateGroupView=function(z){
	var html="<img style='margin-bottom:-4px' src='"+this.imgURL+z.state+".gif'> ";
	if (this.customGroupFormat) html+=this.customGroupFormat(z.text,z.count);
	else html+=z.text+" ( "+z.count+" ) ";
	z.row.firstChild.innerHTML=html;
}
dhtmlXGridObject.prototype._addPseudoRow=function(skip){
	var r=document.createElement("TR");
	var t=document.createElement("TD");
	r.appendChild(t);
	t.style.cssText="vertical-align:middle; font-family:Tahoma; font-size:10pt; font-weight:bold; height:30px;  border:0px;  border-bottom: 2px solid navy; ";
	t.colSpan=this._cCount;
	
	var that=this;
	t.onclick=function(e){ that._switchGroupState(that.getFirstParentOfType(this,"TR")); (e||event).cancelBubble="true"; }
	t.ondblclick=function(e){ (e||event).cancelBubble="true"; }
	
	if (!skip){
		if (_isKHTML)
			this.obj.appendChild(r)
		else
			this.obj.firstChild.appendChild(r)
		this.rowsCol.push(r);
	}
	return r;
}
dhtmlXGridObject.prototype._sortInGroup=function(col,type,order){
	var b=this._groups_get();
	b.reverse();

	for (var i=0; i<b.length; i++){
		var c=b[i]._cntr._childs; var a={};
		for (var j=0; j<c.length; j++)
			a[c[j].idd]=this.cells3(c[j],col).getValue();
		this._sortCore(col,type,order,a,c);
	}
	
	//add|delete|edit|ungroup
	this._groups_put(b);
	this.setSizes();
	this.callEvent("onGridReconstructed",[])
}

dhtmlXGridObject.prototype._sortByGroup=function(col,type,order){ 
	var b=this._groups_get();
	var a=[];
	for (var i=0; i<b.length; i++){
		b[i].idd="_sort_"+i;
		a["_sort_"+i]=b[i]._cntr.text;
	}
	this._sortCore(col,type,order,a,b);
	//add|delete|edit|ungroup
	this._groups_put(b);
	this.setSizes();
}
dhtmlXGridObject.prototype._groups_get=function(){
	var b=[];
	this._temp_par=this.obj.parentNode;
	this._temp_par.removeChild(this.obj);
	var a=[];
	for (var i=this.getRowsNum()-1; i>=0; i--){
		if (this.rowsCol[i]._cntr){
			this.rowsCol[i]._cntr._childs=a;
			a=[];
			b.push(this.rowsCol[i]);
		} else a.push(this.rowsCol[i]);
		this.rowsCol[i].parentNode.removeChild(this.rowsCol[i]);
	}
  return b;
}

dhtmlXGridObject.prototype._groups_put=function(b){ 
	this.rowsCol=new dhtmlxArray(0);
	for (var i=0; i<b.length; i++){
		var gr=b[i]._cntr;
		this.obj.firstChild.appendChild(gr.row);
		this.rowsCol.push(gr.row)
		gr.row.idd=null;
		for (var j=0; j<gr._childs.length; j++){
			this.obj.firstChild.appendChild(gr._childs[j]);
			this.rowsCol.push(gr._childs[j])
		}
		delete gr._childs;
	}
	this._temp_par.appendChild(this.obj);
}
dhtmlXGridObject.prototype._groupExisting=function(b){ 
	if (!this.getRowsNum()) return;
	var b=[];
	this._temp_par=this.obj.parentNode;
	this._temp_par.removeChild(this.obj);
	var a=[];
	
	for (var i=this.getRowsNum()-1; i>=0; i--){
		var val=this.cells4(this.rowsCol[i].childNodes[this._gIndex]).getValue();
		if (!val) val=" ";
		
		if (!this._groups[val]){
			this._groups[val]={text:val,row:this._addPseudoRow(true),count:0,state:"minus"};
			var z=this._groups[val];
			z.row._cntr=z;
			this._groups[val]._childs=[];
			b.push(z.row)
		}
		
		this._groups[val].count++;
		this._groups[val]._childs.push(this.rowsCol[i]);
		this.rowsCol[i].parentNode.removeChild(this.rowsCol[i]);
	}
	
  for (var i=0; i<b.length; i++)
 	this._updateGroupView(b[i]._cntr)
  this._groups_put(b);
  this.callEvent("onGridReconstructed",[])
}

dhtmlXGridObject.prototype._switchGroupState=function(row){
	var z=row._cntr;
	
	var ind=this.rowsCol._dhx_find(z.row)+1;
	z.state=z.state=="minus"?"plus":"minus";
	var st=z.state=="plus"?"none":"";
	
	while(this.rowsCol[ind] && !this.rowsCol[ind]._cntr){
		this.rowsCol[ind].style.display=st;
		ind++;
	}

	this._updateGroupView(z);
	this.setSizes();
}
/**
*	@desc: expand group of rows
*	@param: val - value to use to determine what group to expand (in other words this should be value common for all of them)
*	@edition: Professional
*	@type: public
*/
dhtmlXGridObject.prototype.expandGroup=function(val){
	if (this._groups[val].state=="plus");
		this._switchGroupState(this._groups[val].row);
}
/**
*	@desc: collapse group of rows
*	@param: val - value to use to determine what group to collapse (in other words this should be value common for all of them)
*	@edition: Professional
*	@type: public
*/
dhtmlXGridObject.prototype.collapseGroup=function(val){
	if (this._groups[val].state=="minus");
		this._switchGroupState(this._groups[val].row);
}
/**
*	@desc: expand all groups
*	@edition: Professional
*	@type: public
*/
dhtmlXGridObject.prototype.expandAllGroups=function(){
	for(var i in this._groups)
		if (this._groups[i] && this._groups[i].state=="plus")
			this._switchGroupState(this._groups[i].row);
}
/**
*	@desc: collapse all groups
*	@edition: Professional
*	@type: public
*/
dhtmlXGridObject.prototype.collapseAllGroups=function(){
	for(var i in this._groups)
		if (this._groups[i] && this._groups[i].state=="minus")
			this._switchGroupState(this._groups[i].row);
}

//(c)dhtmlx ltd. www.dhtmlx.com