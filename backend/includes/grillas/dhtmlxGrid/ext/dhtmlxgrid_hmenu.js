//v.1.5 build 71114

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
To use this component please contact sales@dhtmlx.com to obtain license
*/
/**
*	@desc: enable pop up menu which allows hidding/showing columns
*	@edition: Professional
*	@type: public
*/
dhtmlXGridObject.prototype.enableHeaderMenu=function()
{
	var that=this;
	this.attachEvent("onInit",function(){
    	if (_isMacOS)
			this.hdr.oncontextmenu = new Function("e","return this.grid._doHContClick(e||window.event);");   
		else{
			this.startColResizeA=this.startColResize;
			this.startColResize=function(e){
					if (e.button==2)
						return this._doHContClick(e)
					return this.startColResizeA(e);
			}
		}
		this._chm_ooc=this.obj.onclick;
		this._chm_hoc=this.hdr.onclick;
		this.hdr.onclick=function(e){
			if (e && e.button==2) return false;
			that._showHContext(false);	
			return that._chm_hoc.apply(this,arguments)
		}
		this.obj.onclick=function(){
			that._showHContext(false);	
			return that._chm_ooc.apply(this,arguments)
		}
	    	
	});
	dhtmlxEvent(document.body,"click",function(){
		that._showHContext(false);
	})
	if (this.hdr) this.callEvent("onInit",[]);
}

dhtmlXGridObject.prototype._doHContClick=function(ev)
{
		this._createHContext();
		this._showHContext(true,ev.clientX,ev.clientY);
        ev[_isIE?"srcElement":"target"].oncontextmenu = function(e){ (e||event).cancelBubble=true; return false; };
		
		ev.cancelBubble=true;
		if (ev.preventDefault) ev.preventDefault();
    	return false;
}

dhtmlXGridObject.prototype._createHContext=function()
{
	if (this._hContext) return this._hContext;
	
	var d = document.createElement("DIV");
	d.oncontextmenu = function(e){ (e||event).cancelBubble=true; return false; };
	d.onclick=function(e){
		(e||event).cancelBubble=true;
		return true;
		}
	d.className="dhx_header_cmenu";
	d.style.width=d.style.height="5px";
	d.style.display="none";
	var a=[];
	for (var i=0; i<this.hdr.rows[1].cells.length; i++){
		var c=this.hdr.rows[1].cells[i];
		if (c.firstChild && c.firstChild.tagName=="DIV") c=c.firstChild;
		a.push("<div class='dhx_header_cmenu_item'><input type='checkbox' column='"+i+"' checked='true' />"+c.innerHTML+"</div>");
	}
	d.innerHTML=a.join("");

	var that=this;	
	var f=function(){
    	var c=this.getAttribute("column");
		that.setColumnHidden(c,!this.checked);
		if(this.checked && that.getColWidth(c)==0) 
			that.adjustColumnSize(c);
	}
	for (var i=0; i<d.childNodes.length; i++)
		d.childNodes[i].firstChild.onclick=f;
	
	document.body.insertBefore(d,document.body.firstChild);
	this._hContext=d;
	
	d.style.position="absolute";
	d.style.visibility='hidden';
	d.style.overflow="auto";
	d.style.display='block';
	
		d.style.width=d.scrollWidth+"px";
		d.style.height=d.scrollHeight+"px";
		d.style.width=d.scrollWidth+8+"px";
		d.style.height=d.scrollHeight+4+"px";
		d.style.overflow="hidden";
		d.style.visibility='visible';
		
}
dhtmlXGridObject.prototype._updateHContext=function()
{
	for (var i=0; i<this._hContext.childNodes.length; i++){
		var c=this._hContext.childNodes[i].firstChild;
		var col=c.getAttribute("column");
		if (this.isColumnHidden(col) || (this.getColWidth(col)==0))
			c.checked=false;
	}	
}

dhtmlXGridObject.prototype._showHContext=function(mode,x,y)
{
	if (mode && this.enableColumnMove)  this._createHContext=null;
    this._createHContext();
	this._hContext.style.display=(mode?'block':'none');
	if (mode){
		this._updateHContext(true);
		this._hContext.style.left=x+"px";
		this._hContext.style.top=y+"px";
	}
	
}
//(c)dhtmlx ltd. www.dhtmlx.com
