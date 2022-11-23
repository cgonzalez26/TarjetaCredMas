//v.1.5 build 71114

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
To use this component please contact sales@dhtmlx.com to obtain license
*/
/**
*	@desc: cell with support for math formulas
*	@param: cell - cell object
*	@type:  private
*   @edition: Professional
*/
function eXcell_math(cell){
	try{
		this.cell = cell;
		this.grid = this.cell.parentNode.grid;
	}catch(er){}

	this.isDisabled=function(){
		if (this.grid._strangeParams[this.cell._cellIndex]){
    				var z=eval("new eXcell_"+this.grid._strangeParams[this.cell._cellIndex]+"(this.cell)");
                    return z.isDisabled();
                }
		return false;
	}
/**
*	@desc: edit cell
*	@type:  private
*   @edition: Professional
*/
	this.edit = function(){
					this.val = this.getValue();
                    if ((this.cell._val.indexOf("=")==0)&&(!this.grid._mathEdit)) return false;
					this.obj = document.createElement("TEXTAREA");
					this.obj.style.width = "100%";
					this.obj.style.height = (this.cell.offsetHeight-4)+"px";
					this.obj.style.border = "0px";
					this.obj.style.margin = "0px";
					this.obj.style.padding = "0px";
					this.obj.style.overflow = "hidden";
					this.obj.style.fontSize = "12px";
					this.obj.style.fontFamily = "Arial";
					this.obj.wrap = "soft";
					this.obj.style.textAlign = this.cell.align;
					this.obj.onclick = function(e){(e||event).cancelBubble = true}

					this.obj.value = this.cell._val;
					this.cell.innerHTML = "";
					this.cell.appendChild(this.obj);
                    this.obj.onselectstart=function(e){  if (!e) e=event; e.cancelBubble=true; return true;  };
					this.obj.focus()
					this.obj.focus()
				}
/**
*	@desc: get cell value
*   @returns: cell value
*	@type:  private
*   @edition: Professional
*/
	this.getValue = function(){
		//this.grid.editStop();
        if (this.grid._strangeParams[this.cell._cellIndex]){
            var d=this.cell;
            var z=eval("new eXcell_"+(this.grid._strangeParams[this.cell._cellIndex])+"(d)");
            return z.getValue();
           } else return this.cell.innerHTML.toString()._dhx_trim();

    }
/**
*	@desc: set cell value, by using calculations and specified editor
*	@param: val - new value
*	@type:  private
*   @edition: Professional
*/
	this.setValueA = function(val){
                if (this.grid._strangeParams[this.cell._cellIndex]){
    				var z=eval("new eXcell_"+this.grid._strangeParams[this.cell._cellIndex]+"(this.cell)");
                    z.setValue(typeof(val)=="undefined"?"":val);
                }
                else
                    this.setCValue(this.grid._calcSCL(cell)||"0");
    }
/**
*	@desc: set cell formula
*	@param: val - new value
*	@type:  private
*   @edition: Professional
*/
	this.setValue = function(val){
        this.cell._val=val;
        this.cell._code=this.grid._compileSCL(val,this.cell);
		this.setValueA(this.grid._calcSCL(cell));
        this.grid._checkSCL(this.cell);
	}
/**
*	@desc: remove cell's editor
*	@type:  private
*   @edition: Professional
*/
	this.detach = function(){  if ((this.cell._val.indexOf("=")==0)&&(!this.grid._mathEdit)) return false;
					this.setValue(this.obj.value);
					return this.val!=this.getValue();
				}
}
eXcell_math.prototype = new eXcell;




dhtmlXGridCellObject.prototype.setValueA=dhtmlXGridCellObject.prototype.setValue;
eXcell_price.prototype.setValueA=eXcell_price.prototype.setValue;
eXcell_dyn.prototype.setValueA=eXcell_dyn.prototype.setValue;
eXcell_ch.prototype.setValueA=eXcell_ch.prototype.setValue;
eXcell_ra.prototype.setValueA=eXcell_ra.prototype.setValue;
eXcell_cp.prototype.setValueA=eXcell_cp.prototype.setValue;
eXcell_co.prototype.setValueA=eXcell_co.prototype.setValue;
eXcell_txt.prototype.setValueA=eXcell_txt.prototype.setValue;
//#__pro_feature:21092006{
//#data_format:12052006{
eXcell_edn.prototype.setValueA=eXcell_edn.prototype.setValue;
//#}
//#}

/**
*	@desc: wrapper for set value routines
*	@param: val - new value
*	@type:  private
*   @edition: Professional
*/
eXcell_math.prototype._NsetValue=function (val){
            this.setValueA(val);
            this.grid._checkSCL(this.cell);
            }


dhtmlXGridCellObject.prototype.setValue=eXcell_math.prototype._NsetValue;
eXcell_price.prototype.setValue=eXcell_math.prototype._NsetValue;
eXcell_dyn.prototype.setValue=eXcell_math.prototype._NsetValue;
eXcell_ch.prototype.setValue=eXcell_math.prototype._NsetValue;
eXcell_ra.prototype.setValue=eXcell_math.prototype._NsetValue;
eXcell_cp.prototype.setValue=eXcell_math.prototype._NsetValue;
eXcell_co.prototype.setValue=eXcell_math.prototype._NsetValue;
eXcell_txt.prototype.setValue=eXcell_math.prototype._NsetValue;
//#__pro_feature:21092006{
//#data_format:12052006{
eXcell_edn.prototype.setValue=eXcell_math.prototype._NsetValue;
//#}
//#}

/**
*	@desc: check if math cell require linking
*	@param: cell - math cell
*	@type:  private
*   @edition: Professional
*/
dhtmlXGridObject.prototype._checkSCL=function(cell,pRow){
	if (!cell) return;
    if (!this.math_off)
    {
    if (cell._SCL){
          for (var i=0; i<cell._SCL.length; i++)
            if (cell._SCL[i]){
                if (this._strangeParams[cell._SCL[i]._cellIndex]){
    				var z=eval("new eXcell_"+this._strangeParams[cell._SCL[i]._cellIndex]+"(cell._SCL[i])");
					val=this._calcSCL(cell._SCL[i]);
					z.setValue(typeof(val)=="undefined"?"":val);
                }
                else
                    cell._SCL[i].innerHTML=this._calcSCL(cell._SCL[i]);
                this._checkSCL(cell._SCL[i]);
                }
    }


          if (this._math_summ && this._math_summ[cell._cellIndex])
          {
          	//summ initiated
                pRow=pRow||this._h2.get[cell.parentNode.idd].parent;
                if (!pRow) return;
                pRow=this.rowsAr[pRow.id]; 
                if (!pRow) return;
                if (this._strangeParams[cell._cellIndex]){
    				var z=eval("new eXcell_"+this._strangeParams[cell._cellIndex]+"(pRow.childNodes[cell._cellIndex])");
					var val=this._calcSCL(pRow.childNodes[cell._cellIndex]);
                    z.setValue(typeof(val)=="undefined"?"":val);
                }
                else
                  	pRow.childNodes[cell._cellIndex].innerHTML=this._calcSCL(pRow.childNodes[cell._cellIndex]);
	            	this._checkSCL(pRow.childNodes[cell._cellIndex]);
	        }
    }
    else  this.math_req=true;
}
dhtmlXGridObject.prototype._recalc_summ=function(x){
	for (var i=0; i<this._math_summ.length; i++)
		if (this._math_summ[i]) this._checkSCL(this.rowsAr[x.id].childNodes[i],x);
}
/**
*	@desc: enable/disable rounding while math calculations
*	@param: digits - set hom many digits must be rounded, set 0 for disabling
*	@type:  public
*   @edition: Professional
*/
dhtmlXGridObject.prototype.setMathRound=function(digits){
	this._roundDl=digits;
    this._roundD=Math.pow(10,digits);
}

/**
*	@desc: enable/disable editing of math cells
*	@param: status - true/false
*	@type:  public
*   @edition: Professional
*/
dhtmlXGridObject.prototype.enableMathEditing=function(status){
    this._mathEdit=convertStringToBoolean(status);
}

/**
*	@desc: enable/disable serialization of math formulas
*	@param: status - true/false
*	@type:  public
*   @edition: Professional
*/
dhtmlXGridObject.prototype.enableMathSerialization=function(status){
    this._mathSerialization=convertStringToBoolean(status);
}

/**
*	@desc: calculate value of math cell
*	@param: cell - math cell
*	@returns: cell value
*	@type:  private
*   @edition: Professional
*/
dhtmlXGridObject.prototype._calcSCL=function(cell){
    if (!cell._code) return "";
    try{
        var agrid=this;
        if (!this._roundD)  {
            var z=eval(cell._code);
            return z;       }
        else
            {
            var z=eval(cell._code);
            z=Math.round(z*this._roundD).toString();
            if (this._roundDl>0){
            	var n=z.length-this._roundDl;
            	return (z.substring(0,n)+"."+z.substring(n,z.length));
            } else return z;
            }
    }
    catch(e){
        return ("#SCL");
    }
}

dhtmlXGridObject.prototype._countTotal=function(row,cel){
		  var b=0;
          var z=this._h2.get[row];
          for (var i=0; i<z.childs.length; i++)
            b=b*1+this.cells(z.childs[i].id,cel).getValue()*1;
          return b;
}

/**
*	@desc: compile pseudo code to correct javascript
*	@param: code - pseudo code
*	@param: cell - math cell
*	@returns: valid js code
*	@type:  private
*   @edition: Professional
*/
dhtmlXGridObject.prototype._compileSCL=function(code,cell){
        if (!code) return "";
        code=code.toString();
        if (code.indexOf("=")!=0) {
            this._reLink(new Array(),cell,0);
            return code;
        }
        
        var linked=null;
        code=code.replace("=","");
        if (code.indexOf("sum")!=-1){
            code=code.replace("sum","(agrid._countTotal('"+cell.parentNode.idd+"',"+cell._cellIndex+"))");
            if (!this._math_summ) this._math_summ=[];
            this._math_summ[cell._cellIndex]=true;
            return code;
            }
        if (code.indexOf("[[")!=-1){
          var test = /(\[\[([^\,]*)\,([^\]]*)]\])/g;
          var agrid=this;
          linked=linked||(new Array());
          code=code.replace(test,
              function ($0,$1,$2,$3){
                  if ($2=="-")
                      $2=cell.parentNode.idd;
                  if ($2.indexOf("#")==0)
                      $2=agrid.getRowId($2.replace("#",""));
                      linked[linked.length]=[$2,$3];
                  return "(agrid.cells(\""+$2+"\","+$3+").getValue()*1)";
              }
          );
        }
        
        if (code.indexOf(":")!=-1){ 
          var test = /:(\w+)/g;
          var agrid=this;
          var id=cell.parentNode.idd;
          linked=linked||(new Array());
          code=code.replace(test,
              function ($0,$1,$2,$3){
                  linked[linked.length]=[id,agrid.getColIndexById($1)];
                  return '(agrid.cells("'+id+'",agrid.getColIndexById("'+$1+'")).getValue()*1)';
              }
          );
        }
        else{
          var test = /c([0-9]+)/g;
          var agrid=this;
          var id=cell.parentNode.idd;
          linked=linked||(new Array());
          code=code.replace(test,
              function ($0,$1,$2,$3){
                  linked[linked.length]=[id,$1];
                  return "(agrid.cells(\""+id+"\","+$1+").getValue()*1)";
              }
          );
        }
        
        this._reLink(linked,cell,0);
        return code;
    }

/**
*	@desc: link math cells to it source cells after incorrect attempt
*	@type:  private
*   @edition: Professional
*/
dhtmlXGridObject.prototype._laterLink=function(){
    var a=window._SCL_later;
    window._SCL_later=new Array();
    window._SCL_later_timer=null;

    for (var i=0; i<a.length; i++){
        (a[i][2])._reLink(a[i][0],a[i][1],a[i][3]);
                if ((a[i][2])._strangeParams[a[i][1]._cellIndex]){
    				var z=eval("new eXcell_"+(a[i][2])._strangeParams[a[i][1]._cellIndex]+"(a[i][1])");
					var val=(a[i][2])._calcSCL(a[i][1]);
					z.setValue(typeof(val)=="undefined"?"":val);
                }
                else
                    a[i][1].innerHTML=(a[i][2])._calcSCL(a[i][1]);
        (a[i][2])._checkSCL(a[i][1]);
        }
    if (a[0] && window._SCL_later.length==0)
    	a[0][2].callEvent("onMathEnd",[])
}


/**
*	@desc: link math cells to it source cells
*	@param: ar - array of nodes for linking
*	@param: cell - math cell
*	@type:  private
*   @edition: Professional
*/
dhtmlXGridObject.prototype._reLink=function(ar,cell,count){
		if (count>5) return; //drop as unreachable
        if (cell._alink){
            for (var i=0; i<cell._alink.length; i++)
                (cell._alink[i][0])._SCL[cell._alink[i][1]]=null;
            }

        cell._alink=new Array();
        for ( var i=0; i<ar.length; i++)
            {
            var a=this.getRowById(ar[i][0]);
            if (!a) {
                if (!window._SCL_later) window._SCL_later=new Array();
                window._SCL_later.grid=this;
                window._SCL_later[window._SCL_later.length]=[ar,cell,this,count+1];
                if (!window._SCL_later_timer)
                    window._SCL_later_timer=window.setTimeout(this._laterLink,300);
                    return 0;
                    }
            var b=a.childNodes[ar[i][1]];
            if (!b._SCL) b._SCL=new Array();
            cell._alink[i]=[b,b._SCL.length];
            b._SCL[b._SCL.length]=cell;
            }
    }

if (_isKHTML){
// replace callback support for safari.
 (function(){
   var default_replace = String.prototype.replace;
   String.prototype.replace = function(search,replace){
 // replace is not function
 if(typeof replace != "function"){
 return default_replace.apply(this,arguments)
 }
 var str = "" + this;
 var callback = replace;
 // search string is not RegExp
 if(!(search instanceof RegExp)){
 var idx = str.indexOf(search);
 return (
 idx == -1 ? str :
 default_replace.apply(str,[search,callback(search, idx, str)])
 )
 }
 var reg = search;
 var result = [];
 var lastidx = reg.lastIndex;
 var re;
 while((re = reg.exec(str)) != null){
 var idx  = re.index;
 var args = re.concat(idx, str);
 result.push(
 str.slice(lastidx,idx),
 callback.apply(null,args).toString()
 );
 if(!reg.global){
 lastidx += RegExp.lastMatch.length;
 break
 }else{
 lastidx = reg.lastIndex;
 }
 }
 result.push(str.slice(lastidx));
 return result.join("")
   }
 })();
 }
//(c)dhtmlx ltd. www.dhtmlx.com