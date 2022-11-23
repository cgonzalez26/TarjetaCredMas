//v.1.5 build 71114

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
To use this component please contact sales@dhtmlx.com to obtain license
*/

		/**
		*	@desc: enable/disable sorting in Smart Rendering mode (can be used only for static smart rendering )
		*	@type: public
		*   @edition: professional
		*	@param: mode - true/false to enable/disable 
		*	@topic: 0
		*/
 dhtmlXGridObject.prototype.enableSmartRenderingSorting = function(mode){ 
 	this._srndsort=convertStringToBoolean(mode);
 }
		/**
		*	@desc: enable/disable Smart Rendering mode (only visible content is rendered)
		*	@type: public
		*	@before_init: 1
		*	@param: mode - true/false to enable/disable 
		*	@param: totalRows - max count of rows, optional
		*	@param: bufferSize - size of buffer, autodect by default
		*	@param: renderSize - size of rows rendered at one time, optional, by default equal to view size
		*	@topic: 0
		*/
 dhtmlXGridObject.prototype.enableSmartRendering = function(mode,totalRows,bufferSize,renderSize){ 
            this._dload=convertStringToBoolean(mode)
            //need to be called only once
            this.attachEvent("onBeforeSorting",function(){return this._srndsort;});
			if (!this._dload) {
				this.xmlLoader = new dtmlXMLLoaderObject(this.doLoadDetails,window,true,this.no_cashe);
			    window.clearTimeout(this._dLoadTimer);
                if (this.deleteRow_WSRD){
	    	        this.deleteRow=this.deleteRow_WSRD;
	            	this._insertRowAt=this._insertRowAt_WSRD;
//#__pro_feature:21092006{
//#smart_render_static:20092006{	            	
	            	this.sortRows=this.sortRows_WSRD;
//#}
//#}	            	
					this._initDrF=false;
				}
				return;
			}
			if (!this._srdh) this._srdh=20;

			if (!this.deleteRow_WSRD){
	            this.deleteRow_WSRD=this.deleteRow;
    	        this.deleteRow=this.deleteRow_WSRDA;

        	    this._insertRowAt_WSRD=this._insertRowAt;
            	this._insertRowAt=this._insertRowAt_WSRDA;
            	
//#__pro_feature:21092006{
//#smart_render_static:20092006{           

            	this.sortRows_WSRD=this.sortRows;
            	this.sortRows=function(col,type,order){	
						order=(order||"asc").toLowerCase();
                        var self=this;
                        var arrTS=new Array();
                        var temp=this.rowsCol;
                        
                        for (var i=0; i<this.rowsCol.length; i++)
                        	if ( this.rowsCol[i] && !this.rowsBuffer[1][i]) {
                        			this.rowsBuffer[1][i]=this.rowsCol[i];
                        			this.rowsBuffer[0][i]=this.rowsCol[i].idd;
		                        }
                        			
                  		var a=this.rowsBuffer[1];
                  		
						function getFirstChild(node){
							var z=node.firstChild;
							while (z && z.tagName!="cell" && z.tagName!="TD")
								z=z.nextSibling;
								return (z.firstChild?z.firstChild.data:"")
							}
							
						//the code below made in such ugly manner , because IE doesn't threat XML nodes as normal objects	
	                        for (var i=0; i<a.length; i++){
	                        	a[i]={obj:a[i], idd:(a[i].idd||a[i].getAttribute("id"))};
	                        	arrTS[a[i].idd]=getFirstChild(a[i].obj);
	                        }
	                        
                            
                         var z=(new Date()).valueOf();
                         
                     	 if(type=='cus')
                     	 	a.sort(function(a,b){return self._customSorts[col](arrTS[a.idd],arrTS[b.idd],order,a.idd,b.idd);});
                         else if(type=='str')
                     		a.sort(function(a,b){ if(order=="asc") return arrTS[a.idd]>arrTS[b.idd]?1:-1; else return arrTS[a.idd]<arrTS[b.idd]?1:-1; });
                  		else if(type=='int') a.sort(function(a,b){
                                       var aVal = parseFloat(arrTS[a.idd]); aVal=isNaN(aVal)?-99999999999999:aVal;
                                       var bVal = parseFloat(arrTS[b.idd]); bVal=isNaN(bVal)?-99999999999999:bVal;
                                       if(order=="asc") return aVal-bVal;  else return bVal-aVal; });
                  		else if(type=='date') a.sort(function(a,b){
                                       var aVal = Date.parse(arrTS[a.idd])||(Date.parse("01/01/1900"));
                                       var bVal = Date.parse(arrTS[b.idd])||(Date.parse("01/01/1900"));
                                       if(order=="asc") return aVal-bVal; else return bVal-aVal; });
                var z2=(new Date()).valueOf();
                
                  for (var i=0; i<a.length; i++)
	              	a[i]=a[i].obj;
                 
                 for(var i=0;i<this.rowsCol.length;i++)
						this.rowsCol[i].parentNode.removeChild(this.rowsCol[i]);
				 this.rowsCol=new dhtmlxArray();
				 for(var i=0;i<a.length;i++)
				 	this.rowsBuffer[0][i]=(a[i].idd||a[i].getAttribute("id"));
				
				 this._fastAddRowSpacer(0,this.limit*this._srdh);		
				 this._askRealRows(0);
            	}
//#}
//#}                   
                   }

            this._dInc=12;
            this._dl_start=new Array();
            this._limitC=this.limit=totalRows;

            this.multiLine=false;
            this._dloadSize=Math.floor(parseInt(this.entBox.offsetHeight)/this._srdh)+2; //rough, but will work
			this.renderSize=renderSize;
          	this.obj.className+=" row20px";
//#__pro_feature:21092006{
//#smart_render_static:20092006{
            this._dpref=bufferSize||this._dloadSize;
//#}
//#}
            if (this.hdr.childNodes[1])
                this._initD();
            else
                this._initDrF=true;

		}

/**
*	@desc: return data about current view for Smart Rendering mode
*	@type: public
*	@returns: array [ start index, view size, total rows]
*	@topic: 0
*/
 dhtmlXGridObject.prototype.getStateOfView = function(){
 		if (!this._srdh) this._srdh=20;
 		return [
            Math.floor(this.objBox.scrollTop/this._srdh),
			Math.ceil(parseInt(this.objBox.offsetHeight)/this._srdh),
			this.limit
			];
		}
/**
*	@desc: set height which will be used in smart rendering mode for row calculation, function need to be used if you use custom skin for grid which changes default row height
*	@type: public
	@param: {int} height - awaited height of row
*	@returns: void
*	@topic: 0
*/		
dhtmlXGridObject.prototype.setAwaitedRowHeight = function(height) {
	this._srdh=parseInt(height);
};

/**
*   @desc:  init smart rendering view
*   @type:  private
*/

 dhtmlXGridObject.prototype._initD = function(){
            if (this.limit)
                this._fastAddRowSpacer(0,this.limit*this._srdh);


            this._initDrF=false;
            }


		/**
		*	@desc: enable/disable DOM limit
		*	@type: private
		*	@before_init: 1
		*	@param: url - url to xml feed
		*	@param: limit - maximum number of row in table
		*	@topic: 0
		*/
 dhtmlXGridObject.prototype.enableDOMLimit = function(mode,limit){
    if (!convertStringToBoolean(mode)) return;
    this._dom_limit=limit||1000;
 }

//#__pro_feature:21092006{
//#smart_render_static:20092006{

/**
*   @desc:  check how much rows must be prefetched
*   @type:  private
*/
 dhtmlXGridObject.prototype._checkPref=function(start, direction){
 	if (_isKHTML) return start;
    var i=1;
    for (i; i<=this._dpref; i++)
        if (((i*direction+start)<0)||((i*direction+start)>this.limit)||(this.rowsCol[i*direction+start])||(this.rowsBuffer[i*direction+start])) break;
    return start+(i-1)*direction;
 }
 //#}
 //#}

//#__pro_feature:21092006{
//#smart_render_static:20092006{
/**
*   @desc:  remove not used rows from DOM
*   @type:  private
*/
 dhtmlXGridObject.prototype._simplifyDom=function(a,b,c){
    var count=0;

    for (var i=0; i<this.obj._rowslength(); i++)
        if ((i<a)||(i>b)){
            var z=this.obj._rows(i);
            if ((!z._rLoad)&&(!z._sRow)){

                if ((z.previousSibling)&&((z.previousSibling._sRow)||(z.previousSibling._rLoad)))
                    {
                        //split
                        var ind=this.rowsCol._dhx_find(z);
                        var zprev=z.previousSibling;


                        this.rowsBuffer[1][ind]=z;

                        zprev._sRow=true;
                        z.parentNode.removeChild(z);
                        this.rowsAr[this.rowsCol[ind].idd]=null;
                        this.rowsCol[ind]=null;

                        this._fixHeight(zprev,-this._srdh);
                        i--;
                    } else
                if ((z.nextSibling)&&((z.nextSibling._sRow)||(z.nextSibling._rLoad)))
                    {
                        //split
                        var ind=this.rowsCol._dhx_find(z);
                        var zprev=z.nextSibling;


                        this.rowsBuffer[1][ind]=z;

                        zprev._sRow=true;
                        z.parentNode.removeChild(z);
                        this.rowsAr[this.rowsCol[ind].idd]=null;
                        this.rowsCol[ind]=null;

                        this._fixHeight(zprev,-this._srdh);
                        i--;
                    }
                else{
                        var ind=this.rowsCol._dhx_find(z);
                        this.rowsBuffer[1][ind]=z;
                        //mark as separator

                        var id='temp_dLoad_'+this._dInc;
                        this._dInc++;
                        var zn=this._fastAddRow(id,ind,true,ind);

                        z.parentNode.removeChild(z);
                        zn._sRow=true;
                        this._fixHeight(zn,0);

                    }
                if (this.obj._rowslength()<=this._dom_limit) return;
                }
        }
 }
//#}
//#}
/**
*   @desc:  add row from buffer in SRND view
*   @type:  private
*/
 dhtmlXGridObject.prototype._addFromBufferSR=function(j){
                    if ((!this.rowsCol[j])||(this.rowsCol[j]._sRow))
                        this._splitRowAt(j);
                   else
                    if ((this.rowsBuffer[1][j])&&(this.rowsBuffer[1][j].tagName=="TR")){
                        this.rowsCol[j].parentNode.insertBefore(this.rowsBuffer[1][j],this.rowsCol[j]);
                        this.rowsCol[j].parentNode.removeChild(this.rowsCol[j]);
                        this.rowsCol[j].grid=null;
                        this.rowsCol[j]=this.rowsBuffer[1][j];
                    }


                if (this.rowsBuffer[1][j].tagName=="row"){
                    if (this._cssEven){
                      if (j%2==1) this.rowsCol[j].className=this._cssUnEven;
                      else this.rowsCol[j].className=this._cssEven;
                    }
                    this.changeRowId(this.rowsCol[j].idd,this.rowsBuffer[1][j].getAttribute("id"));
                    this._fillRowFromXML(this.rowsCol[j],this.rowsBuffer[1][j],-1);
                }
                else {
                    this.rowsAr[this.rowsBuffer[1][j].idd]=this.rowsBuffer[1][j];
                    this.rowsBuffer[1][j]._sRow=this.rowsBuffer[1][j]._rLoad=false;
                    }



                    this.rowsCol[j]._rLoad=false;
                    this.rowsBuffer[1][j]=null;
}

/**
*   @desc:  check if rows must be added, load XML if necessary
*   @type:  private
*/
 dhtmlXGridObject.prototype._askRealRows=function(pos,afterCall){
 		if ((this.renderSize)&&(this.renderSize>this._dloadSize))
	 		var cdload=this.renderSize;
		else
			var cdload=this._dloadSize;
        if (!this.limit){
                  this._dl_start[0]=[0,cdload];
                  this.xmlLoader = new dtmlXMLLoaderObject(this._askRealRows2,this);
                  this.xmlLoader.waitCall=afterCall;
                  this.callEvent("onXLS",[this]);
				  if (this._dloadStr)
				      this.xmlLoader.loadXMLString(this._dloadStr);
				  else
	                  this.xmlLoader.loadXML(this._dload+((this._dload.indexOf("?")!=-1)?"&":"?")+"posStart="+0+"&sn="+(new Date()).valueOf());
                  return true;
                  }
        var gi=pos||Math.floor(this.objBox.scrollTop/this._srdh);
        if ((this._dom_limit)&&(this.obj._rowslength()>this._dom_limit))
            {
//#__pro_feature:21092006{
//#smart_render_static:20092006{
            this._simplifyDom(gi,gi+cdload);
//#}
//#}
            }
        //check if data required
        if (gi>(this.limit-cdload)) gi=this.limit-cdload;
		if (gi<0) gi=0;

        var size=gi+cdload;
        if (size>this.limit) size=this.limit;

        for (var j=gi; j<size; j++)
            if ((!this.rowsCol[j])||(this.rowsCol[j]._rLoad)||(this.rowsCol[j]._sRow)) {
                if (this.rowsBuffer[1][j])
                {
                    this._addFromBufferSR(j);
                }
                else
                {
//#__pro_feature:21092006{
//#smart_render_static:20092006{
                  if (this._dpref)   {              	
                      start=this._checkPref(j,-1);
                      count=this._checkPref(size,1)-start;
                  }
                  else
//#}
//#}
                  { count=size-j; start=j; }
                  this._dl_start[start]=[gi-start,size-gi];
                  this.xmlLoader = new dtmlXMLLoaderObject(this._askRealRows2,this);

			      this.xmlLoader.waitCall=afterCall;
			      this.callEvent("onXLS",[this]);
                  this.xmlLoader.loadXML(this._dload+((this._dload.indexOf("?")!=-1)?"&":"?")+"posStart="+start+"&count="+count+"&sn="+(new Date()).valueOf());
                  return;
                }
             }
             if (afterCall) afterCall();
    }


     dhtmlXGridObject.prototype._askRealRows2=function(obj,xml,c,d,e){
        var top=e.getXMLTopNode("rows");
		var inmd=obj._initDrF;

        if (inmd) {

            //#config_from_xml:20092006{
	            obj._parseHead(top);
				if (obj.limit && obj.rowsCol.length) inmd=false;
            //#}

            }

        var rows=e.doXPath("//rows/row",top);
		var z_t=top.getAttribute("total_count");
        if ((z_t)&&(!obj._limitC)){
			obj._limitC=obj.limit=parseInt(z_t);
//			obj._fastAddRowSpacer(0,obj.limit*obj._srdh);
			}


        if (inmd) obj._initD();



        var j=parseInt(top.getAttribute("pos"))||0;
        var llim=(obj._dl_start[j]||[0])[0];
        var tlim=llim+(obj._dl_start[j]||[0,rows.length])[1];

//#__pro_feature:21092006{
//#smart_render_static:20092006{
        if (!obj.limit) {
             obj.limit=rows.length;
             obj._fastAddRowSpacer(0,obj.limit*obj._srdh);
             if  (obj._ahgr) window.setTimeout(function(){obj._askRealRows();},1);
             }
//#}
//#}

        for (var i=0; i<rows.length; i++){
//#__pro_feature:21092006{
//#smart_render_static:20092006{
            if ((i<llim)||(i>tlim))
            {
                obj.rowsBuffer[1][j+i]=rows[i];
                obj.rowsBuffer[0][j+i]=rows[i].getAttribute("id");
            }
            else
//#}
//#}
            {
			  obj.rowsBuffer[0][j+i]=null;
              if ((!obj.rowsCol[i+j])||(obj.rowsCol[i+j]._sRow))
                  obj._splitRowAt(i+j);

              if (obj.rowsCol[i+j]._rLoad){
                  //set value
                if (obj._cssEven){ 
                  if ((j+i)%2==1) obj.rowsCol[i+j].className=obj._cssUnEven;
                  else obj.rowsCol[i+j].className=obj._cssEven;
                  if (obj._fake) obj._fake.rowsCol[i+j].className=obj.rowsCol[i+j].className;
                }
                  obj.changeRowId(obj.rowsCol[i+j].idd,rows[i].getAttribute("id"));
                  obj._fillRowFromXML(obj.rowsCol[i+j],rows[i],-1);
                  obj.rowsCol[i+j]._rLoad=false;
                  if (obj._fake) obj._fake.rowsCol[i+j]._rLoad=false;
              }
            }
        }
        obj.callEvent("onXLE",[this,tlim-llim]);
    }
/**
*   @desc:  split fake row, to create a real one
*   @type:  private
*/
     dhtmlXGridObject.prototype._splitRowAt=function(ind){
        var id='temp_dLoad_'+this._dInc;
        this._dInc++;
        var z=this.rowsCol[ind];
        if (!z)
        {
            //middle
            var ind2=this._findSParent(ind);


            var delta=ind2[1]-(ind-ind2[0])*this._srdh;
            this._fixHeight(this.rowsCol[ind2[0]],delta);


            var z2=this._fastAddRow(id,ind,true,ind2[0])
            z2._sRow=true;

            this._fixHeight(z2,-1*((ind2[1]-(ind-ind2[0])*this._srdh)-this._srdh));
            return this._splitRowAt(ind);
        }
        else
        if (z._sRow){
            //first
            if ((this.rowsBuffer[1][ind])&&(this.rowsBuffer[1][ind].tagName=="TR"))
                (this._fastAddRow(id,ind,true,null,this.rowsBuffer[1][ind]))._rLoad=false;
            else
                (this._fastAddRow(id,ind,true))._rLoad=true;
                
            if ((!z.style.height)||(parseInt(z.style.height)==this._srdh))
            	z.parentNode.removeChild(z);
        	else{
            	this.rowsCol[ind+1]=z;
            	this._fixHeight(z,this._srdh);
            }
            if (ind==0) this.setSizes();
        }

    }
/**
*   @desc:  find a fake row, related to index in question
*   @type:  private
*/
     dhtmlXGridObject.prototype._findSParent=function(ind){
        for (var i=ind-1; i>=0; i--){
            if (this.rowsCol[i]) {
            return [i,(parseInt(this.rowsCol[i].style.height))];
            }
            }
    }
/**
*   @desc:  change height of fake row
*   @type:  private
*/
     dhtmlXGridObject.prototype._fixHeight=function(z,delta){
        var x=parseInt(z.style.height||this._srdh)-delta;
        if (x==this._srdh) { z._sRow=false; z._rLoad=true; }

        z.style.height=x+"px";
        var n=z.childNodes.length;
        for (var i=0; i<n; i++)
            z.childNodes[i].style.height=x+"px";
    }
/**
*   @desc:  add a fake row
*   @type:  private
*/
     dhtmlXGridObject.prototype._fastAddRowSpacer=function(ind,height){      	
         var id='temp_dLoad_'+this._dInc;
         this._dInc++;

        var z=this._fastAddRow(id,ind);
        z.style.height=height+"px";
        var n=z.childNodes.length;
        for (var i=0; i<n; i++)
            z.childNodes[i].style.height=height+"px";

        z._sRow=true;
    }


/**
*   @desc:  add a row placeholder ( nearly same as real row but without data )
*   @type:  private
*/
     dhtmlXGridObject.prototype._fastAddRow=function(id,ind,nonshift,ind2,z){
        var z=z||this._prepareRow(id);


        if (((ind2)||(ind2=="0"))&&(this.rowsCol[ind2].nextSibling))
            this.rowsCol[ind2].parentNode.insertBefore(z,this.rowsCol[ind2].nextSibling);
        else
        {
        if ((ind==this.limit)||(this.obj._rowslength()==0)||(!this.rowsCol[ind])){
            if (_isKHTML)
                this.obj.appendChild(z);
            else{
                if (!this.obj.firstChild)
                    this.obj.appendChild(document.createElement("TBODY"));
                this.obj.childNodes[0].appendChild(z);
                }
             }
        else
            this.rowsCol[ind2||ind].parentNode.insertBefore(z,this.rowsCol[ind]);
        }


        this.rowsAr[id] = z;
        if (!nonshift)
            this.rowsCol._dhx_insertAt(ind,z);
        else
            this.rowsCol[ind]=z;

        return z;
    };



/**
*   @desc:  replace original add row functionality in Smart rendering mode
*   @type:  private
*/
dhtmlXGridObject.prototype._insertRowAt_WSRDA = function(r,ind,skip){
                            if (ind<0) ind=this.rowsBuffer[0].length;
							if ((arguments.length<2)||(ind===window.undefined))
								ind = this.rowsBuffer[0].length//getRowsNum();
							else{
								if(ind>this.rowsBuffer[0].length)
									ind = this.rowsBuffer[0].length;
							}

                            var ind2=this.rowsBuffer[0][ind]||(this.rowsCol[ind]?this.rowsCol[ind].idd:null);
                            if (ind2) this.getRowById(ind2); //draw


                            if (!skip)
                            if (ind==this.rowsBuffer[0].length){
                                if (_isKHTML)
                                    this.obj.appendChild(r);
                                else{
                                    this.obj.firstChild.appendChild(r);
                                    }
                                this.rowsBuffer[0][ind]=r.idd;
                                this.rowsBuffer[1][ind]=null;
                                ind2=ind;
                                }
                            else
                                {
                                if (!this.rowsCol[ind])
                                    ind2=(this._findSParent(ind)[0]);
                                else ind2=ind;
                                this.rowsCol[ind2].parentNode.insertBefore(r,this.rowsCol[ind2]);
                                this.rowsBuffer[0]._dhx_insertAt(ind,r.idd);
                                this.rowsBuffer[1]._dhx_insertAt(ind,null);
                                }

                            this.limit+=1;
							this.rowsAr[r.idd] = r;
							this.rowsCol._dhx_insertAt(ind2,r);

                            if (this._cssEven){
                                if (ind%2==1) r.className+=" "+this._cssUnEven;
                                else r.className+=" "+this._cssEven;

                                if (ind!=(this.rowsCol.length-1))
                                    this._fixAlterCss(ind+1);
                            }

						   	this.doOnRowAdded(r);
                            if ((this.math_req)&&(!this._parsing_)){
                                for(var i=0;i<this.hdr.rows[0].cells.length;i++)
                                   this._checkSCL(r.childNodes[i]);
                                this.math_req=false;
                            }
                            return r;
    }
/**
*   @desc:  replace original delete row functionality in Smart rendering mode
*   @type:  private
*/
dhtmlXGridObject.prototype.deleteRow_WSRDA = function(row_id,node){
                                var ind=-1;
                                var fixind=null;
                                if (this.rowsAr[row_id]){
                                    ind=this.rowsCol._dhx_find(this.rowsAr[row_id]);
									if (this.deleteRow_WSRD(row_id,node)==false) return false;
                                }
                                if (ind<0){
                                    var ind=this.rowsBuffer[0]._dhx_find(row_id);
                                    if (ind>-1) fixind=this.rowsCol[this._findSParent(ind)[0]];
                                    }

                                if (ind>-1)
                                {
                                    this.rowsBuffer[0]._dhx_delAt(ind);
                                    this.rowsBuffer[1]._dhx_delAt(ind);
                                    this.limit-=1;
                                    if (fixind) this._fixHeight(fixind,this._srdh);
                                }
                            return true;
						}
						//(c)dhtmlx ltd. www.dhtmlx.com