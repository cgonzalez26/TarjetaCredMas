//v.1.5 build 71114

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
To use this component please contact sales@dhtmlx.com to obtain license
*/
/*
    Limitation:
        a) Width of column in px
        b) Grid not autoresizable
        c) Initialize grid in visible state
*/

/**
*   @desc:  split grid in two parts, with separate scrolling
*   @param:  ind - index of column to split after
*   @edition: Professional
*   @type:  public
*/
dhtmlXGridObject.prototype.splitAt=function(ind){
    var z=document.createElement("DIV");
    this.entBox.appendChild(z);
    this._treeC=this.cellType._dhx_find("tree");
    this.entBox.style.position="relative";
//    document.body.appendChild(z);
    this._fake=new dhtmlXGridObject(z);
    this._fake._fake=this;
    this._fake._realfake=true;
    this._fake.imgURL=this.imgURL;
    this._fake._customSorts=this._customSorts;
	this._fake.noHeader=this.noHeader;
	this._fake._enbTts=this._enbTts;
    this._fake.fldSort=new Array();
    this._fake.selMultiRows=this.selMultiRows;
    this._fake.multiLine=this.multiLine;
    if (this.multiLine){
    	this.attachEvent("onCellChanged",this._correctRowHeight);
    	this.attachEvent("onXLE",function(){
    		this.forEachRow(function(id){
    			this._correctRowHeight(id);
			})
		});
		this.attachEvent("onResizeEnd",function(){
    		this.forEachRow(function(id){
    			this._correctRowHeight(id);
			})
		});		
    	//this._fake.attachEvent("onCellChanged",this._correctRowHeight);
    	}
    
	this._fake.loadedKidsHash=this.loadedKidsHash;
	if (this._h2) this._fake._h2=this._h2;

this._fake._dInc=this._dInc;
    var b_ha=[[],[],[],[],[],[],[]];
    var b_ar=["hdrLabels","initCellWidth","cellType","cellAlign","cellVAlign","fldSort","columnColor"];
    var b_fu=["setHeader","setInitWidths","setColTypes","setColAlign","setColVAlign","setColSorting","setColumnColor"];

    this._fake.callEvent=function(){
    		return this._fake.callEvent.apply(this._fake,arguments);
    	}
    	
    if (this._elmn)
		this._fake.enableLightMouseNavigation(true);


    if (this.__cssEven||this._cssUnEven)
        this._fake.setOnGridReconstructedHandler(function(){
            this._fixAlterCss();
        });

      this._fake._cssEven=this._cssEven;
      this._fake._cssUnEven=this._cssUnEven;
	  this._fake.isEditable=this.isEditable;
	  this._fake._edtc=this._edtc;
	  if (this._sst) this._fake.enableStableSorting(true);

	  if (this._aHead){
	  	var zh=new Array();
	  	for (var i=0; i<this._aHead.length; i++){
	   		zh[zh.length]=[this._aHead[i][0].slice(0,ind),(this._aHead[i][1]||[]).slice(0,ind)];
	   		var hc=0;
	   		for (var j=0; j<ind; j++) {
	   			if ((zh[zh.length-1][0][j]=="#rspan")||(zh[zh.length-1][0][j]=="#cspan")) continue;
	   			this.hdr.rows[i+2].childNodes[hc].innerHTML="";
	   			hc++;
   			}
   		}
		this._fake._aHead=zh;
	  }
	/*  if (this._aFoot)
	  	this._fake._aFoot=this._aFoot;*/

      this._fake._sclE=this._sclE;
      this._fake._dclE=this._dclE;
      this._fake._f2kE=this._f2kE;
      this._fake._maskArr=this._maskArr;
      this._fake._dtmask=this._dtmask;
      this._fake.combos=this.combos;
      



    var width=0;

    for (var i=0; i<ind; i++){
        for (var j=0; j<b_ar.length; j++){
            if (this[b_ar[j]])
                b_ha[j][i]=this[b_ar[j]][i];
            }
            if (_isFF) b_ha[1][i]+=2;
			if ( this.cellWidthType == "%"){
				b_ha[1][i]=Math.round(parseInt(this[b_ar[1]][i])*this.entBox.offsetWidth/100);
				width+=b_ha[1][i];
			} else
	            width+=parseInt(this[b_ar[1]][i]);
            this.setColumnHidden(i,true);
        }
     /*
    for (var j=0; j<ind; j++)
        b_ha[5][j]="na";    */


    for (var j=0; j<b_ar.length; j++){
        var str=b_ha[j].join(",");
        if (str!="");
            this._fake[b_fu[j]](str);
        }



    this._fake._drsclmn=this._drsclmn;
    var pa=this.entBox.childNodes[0];
    pa.style.left=width+"px";

	if (this.ftr){
	    this.ftr.style.left=width+"px";
	    this.ftr.style.position="relative";
		var ftrT=this.ftr.childNodes[0].rows[0];

        var ftrZ=document.createElement("TH");
        ftrT.appendChild(ftrZ);
    	ftrZ.style.width='30px';
		}

    pa.style.top=0+"px";
    pa.style.position="absolute";
    var w=this.entBox.offsetWidth-width-(_isFF?0:(this.entBox.offsetWidth-this.entBox.clientWidth))+"px";
    if (w>0) pa.style.width=w;

    z.style.width=width+"px";
    z.style.height=this.objBuf.offsetHeight;
    z.style.position="absolute";
    z.style.top="0px";
    z.style.left="0px";
	/**
    * TwelveCubes Tom Pijsel, Replaced zindex 11 by 3000011
    */
  
    z.style.zIndex=3000011;

    if (this._ecspn) this._fake._ecspn=true;

//    this._fake.setNoHeader(true);
    this._fake.init();
    this._fake.objBox.style.overflow="hidden";
    this._fake.objBox.style.overflowX="scroll";
   	this._fake._srdh=this._srdh||20;




	if (this.ftr){
		var rows=this.ftr.childNodes[0].rows;
		for (var i=1; i<rows.length; i++){
			var tftr=new Array();
			var tftrs=new Array();
			var indT=ind;
			for (var j=0; j<indT; j++){
				var s_row=rows[i].cells[j];
				tftr.push(s_row.innerHTML);
				tftrs.push(s_row.style.cssText.replace(/display/i,"ignore"));
				s_row.innerHTML="";
				if (s_row.colSpan>1){
				   for (var sp_i=1; sp_i<s_row.colSpan; sp_i++)
				   		tftr.push("#cspan");
						tftrs.push("");
						indT-=(s_row.colSpan-1);
				}

				}
			this._fake.attachFooter(tftr,tftrs);
		}
	}
   // this.entBox.childNodes[0].style.display
    /*
    this._realColumnTypes=this._fake._realColumnTypes=b_ha[2];
    for (var i=0; i<ind; i++)
        this.cellType="split_out";
        this._fake.cellType="split_in";
    */

        if (this.saveSizeToCookie){
		   this.saveSizeToCookie=function(name,cookie_param){
		   		if (this._realfake)
					return this._fake.saveSizeToCookie.apply(this._fake,arguments);

				if (!name) name=this.entBox.id;
				var z=new Array();
				if (this.cellWidthType=='px')
					var n="cellWidthPX";
				else
					var n="cellWidthPC";
				for (var i=0; i<this[n].length; i++)
					if (i<ind)
						z[i]=this._fake[n][i];
					else
						z[i]=this[n][i];
				z=z.join(",")
				this.setCookie("gridSizeA"+name,z,cookie_param);
				var z=(this.initCellWidth||(new  Array)).join(",");
				this.setCookie("gridSizeB"+name,z,cookie_param);
			    return true;
			}
		this.loadSizeFromCookie=function(name){
			if (!name) name=this.entBox.id;
			var z=this.getCookie("gridSizeB"+name);

			if (!z) return

			this.initCellWidth=z.split(",");
			var z=this.getCookie("gridSizeA"+name);
			if (this.cellWidthType=='px')
				var n="cellWidthPX";
			else
				var n="cellWidthPC";

            var summ2=0;
			if ((z)&&(z.length)){
				z=z.split(",");
				for (var i=0; i<z.length; i++)
					if (i<ind){
					   this._fake[n][i]=z[i];
					   summ2+=z[i]*1;
					   }
					else
					   this[n][i]=z[i];
			}

    		this._fake.entBox.style.width=summ2+"px";
    		this._fake.objBuf.style.width=summ2+"px";
   			var pa=this.entBox.childNodes[0];
			    pa.style.left=summ2-(_isFF?0:0)+"px";
			if (this.ftr)
	    		this.ftr.style.left=summ2-(_isFF?0:0)+"px";
    			pa.style.width=this.entBox.offsetWidth-summ2+"px";

			this.setSizes();
		    return true;
		}
		   	this._fake.onRSE=this.onRSE;
		}


			this._postRowProcessingA = this._postRowProcessing;
			this._postRowProcessing=function(r,xml){
				this._postRowProcessingA(r,xml);
				if ((r.parentNode) && (r.parentNode.tagName))	
					this._fake._postRowProcessing(this._fake.rowsAr[r.idd],xml);				
			}
			this.setCellTextStyleA=this.setCellTextStyle;
			this.setCellTextStyle=function(row_id,i,styleString){
				if  (i<ind) return this._fake.setCellTextStyle(row_id,i,styleString);
				else return this.setCellTextStyleA(row_id,i,styleString);
			}
			this.setRowTextBoldA=this.setRowTextBold;
   			this.setRowTextBold = function(row_id){
				this.setRowTextBoldA(row_id);
				this._fake.setRowTextBold(row_id);
            }
            
            this.setRowColorA=this.setRowColor;
   			this.setRowColor = function(row_id,color){
				this.setRowColorA(row_id,color);
				this._fake.setRowColor(row_id,color);
            } 
                       
			this.setRowHiddenA=this.setRowHidden;
   			this.setRowHidden = function(id,state){
				this.setRowHiddenA(id,state);
				this._fake.setRowHidden(id,state);
            }

			this.setRowTextNormalA=this.setRowTextNormal;
   			this.setRowTextNormal = function(row_id){
				this.setRowTextNormalA(row_id);
				this._fake.setRowTextNormal(row_id);
            }


			this.getChangedRows = function(){
   var res=new Array();
   for (var i=0; i<this.rowsCol.length; i++){
      var row=this.rowsCol[i];
      var cols=row.childNodes.length;
      for (var j=0; j<cols; j++)
	  	if (j>=ind){
	        if (row.childNodes[j].wasChanged) {
    	     res[res.length]=row.idd;
        	 break;
	        }}
		else{
	        if (this._fake.rowsAr[row.idd].childNodes[j].wasChanged) {
    	     res[res.length]=row.idd;
        	 break;
        }}
   }
   return res.join(this.delim);
			}
			this.setRowTextStyleA=this.setRowTextStyle;
   			this.setRowTextStyle = function(row_id,styleString){
				this.setRowTextStyleA(row_id,styleString);
				this._fake.setRowTextStyle(row_id,styleString);
            }

			this.lockRowA = this.lockRow;
			this.lockRow = function(id,mode){ this.lockRowA(id,mode); this._fake.lockRow(id,mode); }
			
			this.getColWidth = function(ind){
				if  (i<ind) return parseInt(this._fake.cellWidthPX[ind])+((_isFF)?2:0);
				else return parseInt(this.cellWidthPX[ind])+((_isFF)?2:0);
            }
			this.setColWidthA=this._fake.setColWidthA=this.setColWidth;
			this.setColWidth = function(i,value){
				if  (i<ind) this._fake.setColWidthA(i,value);
				else this.setColWidthA(i,value);
				if ((i+1)==ind) this._fake._correctSplit();
            }
			this.adjustColumnSizeA=this.adjustColumnSize;
			this.adjustColumnSize=function(aind){
				if  (aind<ind) {


					if (_isIE) this._fake.obj.style.tableLayout="";
					this._fake.adjustColumnSize(aind);
					if (_isIE) this._fake.obj.style.tableLayout="fixed";
				    this._fake._correctSplit();
					}
				else return this.adjustColumnSizeA(aind);
			}

            var zname="cells";
            this._bfs_cells=this[zname];
            this[zname]=function(){
                    if (arguments[1]<ind)
                        return this._fake.cells.apply(this._fake,arguments);
                    else
                        return this._bfs_cells.apply(this,arguments);
                    }
            
            this._bfs_setColumnHidden=this.setColumnHidden;        
            this.setColumnHidden=function(){
                    if (arguments[1]<ind)
                        return this._fake.setColumnHidden.apply(this._fake,arguments);
                    else
                        return this._bfs_setColumnHidden.apply(this,arguments);
                    }                    

            var zname="cells2";
            this._bfs_cells2=this[zname];
            this[zname]=function(){
                    if (arguments[1]<ind)
                        return this._fake.cells2.apply(this._fake,arguments);
                    else
                        return this._bfs_cells2.apply(this,arguments);
                    }

            var zname="cells3";
            this._bfs_cells3=this[zname];
            this[zname]=function(){
                    if (arguments[1]<ind){
                        arguments[0]=arguments[0].idd;
                        return this._fake.cells.apply(this._fake,arguments);
                        }
                    else
                        return this._bfs_cells3.apply(this,arguments);
                    }

            var zname="changeRowId";
            this._bfs_changeRowId=this[zname];
            this[zname]=function(){
                        this._bfs_changeRowId.apply(this,arguments);
                        this._fake.changeRowId.apply(this._fake,arguments);
            }

            if (this.collapseKids){
				//tree grid
	            this._fake["_bfs_collapseKids"]=this.collapseKids;
				this._fake["collapseKids"]=function(){
					return this._fake["collapseKids"].apply(this._fake,[this._fake.rowsAr[arguments[0].idd]]);
				}
				
	            this["_bfs_collapseKids"]=this.collapseKids;
				this["collapseKids"]=function(){
					var z=this["_bfs_collapseKids"].apply(this,arguments);
					this._fake._h2syncModel();
				}				
				
				
	            this._fake["_bfs_expandKids"]=this.expandKids;
				this._fake["expandKids"]=function(){
					return this._fake["expandKids"].apply(this._fake,[this._fake.rowsAr[arguments[0].idd]]);
				}

				this["_bfs_expandAll"]=this.expandAll;
				this["expandAll"]=function(){
					this._bfs_expandAll();
					this._fake._h2syncModel();
				}

				this["_bfs_collapseAll"]=this.collapseAll;
				this["collapseAll"]=function(){
					this._bfs_collapseAll();
					this._fake._h2syncModel();
				}								
				
	            this["_bfs_expandKids"]=this.expandKids;
				this["expandKids"]=function(){
					var z=this["_bfs_expandKids"].apply(this,arguments);
					this._fake._h2syncModel();
				}				
				
				this._fake._h2syncModel=function(){
					for (var i=0; i<this.rowsCol.length; i++)
                  		this.rowsCol[i].parentNode.removeChild(this.rowsCol[i]);
                  	this.rowsCol=new dhtmlxArray();
                  	this._renderSort(0,true);
                  	
                  	if (this._cssEven)
                  		this._fixAlterCss();
				}
				this._updateTGRState=function(a){
					return this._fake._updateTGRState(a);
				}
			}



				//split


      if (this._elmnh){
			this._setRowHoverA=this._fake._setRowHoverA=this._setRowHover;
			this._unsetRowHoverA=this._fake._unsetRowHoverA=this._unsetRowHover;
			this._setRowHover=this._fake._setRowHover=function(){
				var that=this.grid;
				that._setRowHoverA.apply(this,arguments);
				var z=(_isIE?event.srcElement:arguments[0].target);
				z=that._fake.rowsAr[that.getFirstParentOfType(z,'TD').parentNode.idd];
				if (z){
					that._fake._setRowHoverA.apply(that._fake.obj,[{target:z.childNodes[0]},arguments[1]]);
				   	}
			};
			this._unsetRowHover=this._fake._unsetRowHover=function(){
				if (arguments[1]) var that=this;
				else	var that=this.grid;
				that._unsetRowHoverA.apply(this,arguments);
				that._fake._unsetRowHoverA.apply(that._fake.obj,arguments);
			};
		  		this._fake.enableRowsHover(true,this._hvrCss);
		  		this.enableRowsHover(false);
		  		this.enableRowsHover(true,this._fake._hvrCss);
			}



            var zname="_insertRowAt";
            this._bfs_insertRowAt=this[zname];
            this[zname]=function(){
                    var x=arguments[0].cloneNode(true);
                    x._skipInsert=arguments[0]._skipInsert;
                    while (x.childNodes.length>ind)
                        x.removeChild(x.childNodes[x.childNodes.length-1]);
                        var z=0;
                        var zm=ind;
                        
                    for (var i=0; i<zm; i++){
                        x.childNodes[i].style.display="";
                        x.childNodes[i]._cellIndex=i;
                        x.childNodes[i].combo_value=arguments[0].childNodes[i].combo_value;
                        x.childNodes[i]._clearCell=arguments[0].childNodes[i]._clearCell;
                        x.childNodes[i]._cellType=arguments[0].childNodes[i]._cellType;
						x.childNodes[i]._brval=arguments[0].childNodes[i]._brval;                        


                        if(x.childNodes[i].colSpan>1) {
                            this._childIndexes=this._fake._childIndexes;
                            for (var z=1; z<x.childNodes[i].colSpan; z++)
                               x.removeChild(x.childNodes[i+z]);
                               zm--;
                            }
                        }

					if (this._h2 && this._treeC < ind){
							var row=this._h2.get[arguments[0].idd];
	                		x.imgTag=x.childNodes[this._treeC].childNodes[0].childNodes[row.level];
							x.valTag=x.childNodes[this._treeC].childNodes[0].childNodes[row.level+2];
                        	}
                    	
                        var r=this["_bfs_insertRowAt"].apply(this,arguments);
                        x.idd=arguments[0].idd;
                        x.grid=this._fake;
                        arguments[0]=x;

                        var r2=this._fake["_insertRowAt"].apply(this._fake,arguments);
                        if (r._fhd){
							r2.parentNode.removeChild(r2);
                            this._fake.rowsCol._dhx_removeAt(this._fake.rowsCol._dhx_find(r2));
							r._fhd=false;
						}

						if (this.complexCellSplit)
							for (var i=0; i<zm; i++){
								var ed=this.cells4(r.childNodes[i]);
								var ed2=this.cells4(x.childNodes[i]);
								ed2.setValue(ed.getValue());
								}
						return r;
            }

            var zname="setSizes";
            this._bfs_setSizes=this[zname];
            this[zname]=function(){
				if (this.cellWidthType == "%"){
					var z1=this.entBox.childNodes[0].offsetWidth;
					var z2=this.entBox.childNodes[1].offsetWidth;
					var width=Math.round(z1*this.entBox.offsetWidth/(z1+z2));
					this.entBox.childNodes[0].style.left=width+"px";
					this.entBox.childNodes[1].style.width=width+(_isIE?0:2)+"px";
		            this.entBox.childNodes[0].style.width=this.entBox.offsetWidth-width-(_isFF?0:(this.entBox.offsetWidth-this.entBox.clientWidth))+"px";
		            this._rec_count=(this._rec_count?this._rec_count+1:1);
					if (this._rec_count<2)
						this._fake.setColWidth(ind-1,this._fake.getColWidth(ind-1)-(_isIE?0:2));
                	this._rec_count=null;					
				}
				
				
                    	this["_bfs_setSizes"].apply(this,arguments);
                    
					if (this._notresize) return;
					var wcor=this.entBox.offsetWidth-this.entBox.clientWidth;
                    z.style.height=this.entBox.offsetHeight-wcor+"px";
                    if ((!this.noHeader) && this._fake.hdr.offsetHeight!=this.hdr.offsetHeight){
						if (this._fake._aHead){
							for (var i=0; i<=this._fake._aHead.length; i++){
								this._fake.hdr.rows[i+1].style.height=this.hdr.rows[i+1].offsetHeight+"px";
								var check=this._fake.hdr.rows[i+1].offsetHeight-this.hdr.rows[i+1].offsetHeight;
								if (check && this.hdr.rows[i+1].offsetHeight > check) this._fake.hdr.rows[i+1].style.height=this.hdr.rows[i+1].offsetHeight-check+"px";
							}
						}
						else
                       		this._fake.hdr.style.height=this.hdr.offsetHeight+"px";
                       		this._rec_count=(this._rec_count?this._rec_count+1:1);
							if (this._rec_count<2)
                        		this._fake["setSizes"].apply(this._fake,arguments);
                        	this._rec_count=null;
                        }

                    if (((this.obj.offsetWidth+1*((this.objBox.offsetHeight<=this.objBox.scrollHeight)?(_isFF?20:18):0))<=this.objBox.offsetWidth)&&(this._fake.obj.offsetWidth<=this._fake.objBox.offsetWidth))
                    {
                        this._fake.objBox.style.overflowX="hidden";
                        this.objBox.style.overflowX="hidden";
                        }
                    else
                    {
                        this._fake.objBox.style.overflowX="scroll";
                        this.objBox.style.overflowX="scroll";
                        }

					var wa=this.entBox.offsetWidth-parseInt(this.entBox.childNodes[0].style.left)-(_isFF?2:0)+"px";
				    if (wa>0) this.entBox.childNodes[0].style.width=wa;

                    this._fake.objBox.scrollTop=this.objBox.scrollTop;
                    this._fake["_bfs_setSizes"].apply(this._fake,arguments);
  				 	this._fake.entCnt.rows[1].cells[0].childNodes[0].style.top = this.entCnt.rows[1].cells[0].childNodes[0].style.top;
            }
            this._fake._bfs_setSizes=this._fake[zname];
            this._fake[zname]=function(){
                    this["_bfs_setSizes"].apply(this,arguments);
					if (this._fake._notresize) return;
                    if ((!this.noHeader) && this._fake.hdr.offsetHeight!=this.hdr.offsetHeight){
						if (this._aHead){
							for (var i=0; i<=this._aHead.length; i++){
								if (this.hdr.rows[i+1].offsetHeight<this._fake.hdr.rows[i+1].cells[0].scrollHeight)
									return this._fake.setSizes();
								this._fake.hdr.rows[i+1].style.height=this.hdr.rows[i+1].offsetHeight+"px";
								var check=this._fake.hdr.rows[i+1].offsetHeight-this.hdr.rows[i+1].offsetHeight;
								if (check) this._fake.hdr.rows[i+1].style.height=this.hdr.rows[i+1].offsetHeight-check+"px";
							}
						}
						else
                        	this._fake.hdr.style.height=this.hdr.offsetHeight+"px";
                        this._fake["setSizes"].apply(this._fake,arguments);
                        }

                    this.entCnt.rows[1].cells[0].childNodes[0].style.top = this._fake.entCnt.rows[1].cells[0].childNodes[0].style.top;

                    if (((this._fake.obj.offsetWidth+1*((this._fake.objBox.offsetHeight<=this._fake.objBox.scrollHeight)?(_isFF?20:18):0))<=this._fake.objBox.offsetWidth)&&(this.obj.offsetWidth<=this.objBox.offsetWidth))
                    {
                        this.objBox.style.overflowX="hidden";
                        this._fake.objBox.style.overflowX="hidden";
                    }
                    else{
                        this.objBox.style.overflowX="scroll";
                        this._fake.objBox.style.overflowX="scroll";
                        }


            }

            var zname="_doOnScroll";
            this._bfs__doOnScroll=this[zname];
            this[zname]=function(){
                    this._bfs__doOnScroll.apply(this,arguments);
                    this._fake.objBox.scrollTop=this.objBox.scrollTop;
                    this._fake["_doOnScroll"].apply(this._fake,arguments);
            }



            var zname="doClick";
            this._bfs_doClick=this[zname];
            this[zname]=function(){
                    this["_bfs_doClick"].apply(this,arguments);
                        if (arguments[0].tagName=="TD"){
                            var fl=(arguments[0]._cellIndex>=ind);
							if (!arguments[0].parentNode.idd) return;
                            arguments[0]=this._fake.rowsAr[arguments[0].parentNode.idd].childNodes[fl?0:arguments[0]._cellIndex];
                            this._fake["_bfs_doClick"].apply(this._fake,arguments);
                            if (this._fake.onRowSelectTime) clearTimeout(this._fake.onRowSelectTime)
                            if (fl) {
                                arguments[0].className=arguments[0].className.replace(/cellselected/g,"");
                                globalActiveDHTMLGridObject=this;
                                this._fake.cell=this.cell;                                
                                }
                            else{
                                this.objBox.scrollTop=this._fake.objBox.scrollTop;
	                            }
                        }
            }
            this._fake._bfs_doClick=this._fake[zname];
            this._fake[zname]=function(){
                    this["_bfs_doClick"].apply(this,arguments);
                        if (arguments[0].tagName=="TD"){
                            var fl=(arguments[0]._cellIndex<ind);
							if (!arguments[0].parentNode.idd) return;
                            arguments[0]=this._fake.rowsAr[arguments[0].parentNode.idd].childNodes[fl?ind:arguments[0]._cellIndex];
                            this._fake["_bfs_doClick"].apply(this._fake,arguments);
                            if (this._fake.onRowSelectTime) clearTimeout(this._fake.onRowSelectTime)
                            if (fl) {
                                arguments[0].className=arguments[0].className.replace(/cellselected/g,"");
                                globalActiveDHTMLGridObject=this;
								this._fake.cell=this.cell;                                
                                }
                        }
            }


this.moveRowUpA = this.moveRowUp;
this.moveRowUp = function(row_id){
    this._fake.moveRowUp(row_id);
    this.moveRowUpA(row_id);
}
this.moveRowDownA = this.moveRowDown;
this.moveRowDown = function(row_id){
    this._fake.moveRowDown(row_id);
    this.moveRowDownA(row_id);
}


this._fake.getUserData=function(){	return this._fake.getUserData.apply(this._fake,arguments); }
this._fake.setUserData=function(){	return this._fake.setUserData.apply(this._fake,arguments); }

this.getSortingStateA=this.getSortingState;
this.getSortingState = function(){
	var z=this.getSortingStateA();
	if (z.length!=0) return z;
	return this._fake.getSortingState();
}

this.setSortImgStateA=this._fake.setSortImgStateA=this.setSortImgState;
this.setSortImgState = function(a,b,c,d){
	((b<ind)?this._fake:this).setSortImgStateA(a,b,c,d);
	((b<ind)?this:this._fake).setSortImgStateA(false);
}


this._fake.doColResizeA = this._fake.doColResize;
this._fake.doColResize = function(ev,el,startW,x,tabW){
    a=-1;
    var z=0;
    if (arguments[1]._cellIndex==(ind-1)){
            a = this._initalSplR + (ev.clientX-x);
            if (!this._initalSplF) this._initalSplF=arguments[3]+this.objBox.scrollWidth-this.objBox.offsetWidth;
            if (this.objBox.scrollWidth==this.objBox.offsetWidth && (ev.clientX-x)>0 ){
            	arguments[3]=(this._initalSplF||arguments[3]);
            	z=this.doColResizeA.apply(this,arguments);
            } 
            window.status=this._initalSplF;
            
    	}
        //a=this.objBox.offsetWidth;//scrollWidth-this.objBox.scrollLeft;
    else{
        if (this.obj.offsetWidth<this.entBox.offsetWidth)
            a=this.obj.offsetWidth;
        	z=this.doColResizeA.apply(this,arguments);
	    }
	
	this._correctSplit(a);
    return z;
}

		this._fake.changeCursorState = function(ev){
                     var el = ev.target||ev.srcElement;
                     if(el.tagName!="TD")
                           el = this.getFirstParentOfType(el,"TD")
                           if ((el.tagName=="TD")&&(this._drsclmn)&&(!this._drsclmn[el._cellIndex])) return;
                           var check = (ev.layerX||0)+(((!_isIE)&&(ev.target.tagName=="DIV"))?el.offsetLeft:0);
                           var pos = parseInt(this.getPosition(el,this.hdrBox)); 
                           
                           if(((el.offsetWidth - (ev.offsetX||(pos-check)*-1))<10)||((this.entBox.offsetWidth - (ev.offsetX?(ev.offsetX+el.offsetLeft):0) + this.objBox.scrollLeft - check)<10)){
                              el.style.cursor = "E-resize";
                           }else
                              el.style.cursor = "default";
                       if (_isOpera) this.hdrBox.scrollLeft = this.objBox.scrollLeft;
                        }
			
		this._fake.startColResizeA = this._fake.startColResize;
		this._fake.startColResize = function(ev){
                                    var z=this.startColResizeA(ev);
                                    this._initalSplR=this.entBox.offsetWidth;
                                    this._initalSplF=null;
                                    if (this.entBox.onmousemove){
                                        var m=this.entBox.parentNode;   m._aggrid=m.grid;   m.grid=this;
                                        this.entBox.parentNode.onmousemove=this.entBox.onmousemove;
                                        this.entBox.onmousemove=null;
                                        }
                                    return z;
								}

		this._fake.stopColResizeA = this._fake.stopColResize;
		this._fake.stopColResize = function(ev){
                                    if (this.entBox.parentNode.onmousemove){
                                        var m=this.entBox.parentNode;   m.grid=m._aggrid;   m._aggrid=null;
                                        this.entBox.onmousemove=this.entBox.parentNode.onmousemove;
                                        this.entBox.parentNode.onmousemove=null;
                                        }
                                    return this.stopColResizeA(ev);
								}



this.doKeyA = this.doKey;
this._fake.doKeyA = this._fake.doKey;
this._fake.doKey=this.doKey=function(ev){
                            if (!ev) return true;
                            if (this._htkebl) return true;
    switch (ev.keyCode){
        case 9:
            if (!ev.shiftKey){
                if (this._realfake){
                    if ((this.cell)&&(this.cell._cellIndex==(ind-1))){
					   if (ev.preventDefault)
					       ev.preventDefault();
                       this._fake.selectCell(this.rowsCol._dhx_find(this.cell.parentNode),ind,false,false,true);
                       return false;
                       }
                    else
                       var z=this.doKeyA(ev);
                       globalActiveDHTMLGridObject=this;
                       return z;
                    }
                else{
                    if ((this.cell)&&(this.cell._cellIndex==(this.rowsCol[0].childNodes.length-1))){
					   if (ev.preventDefault)
					       ev.preventDefault();					
                        var z=this._fake.rowsCol[this.rowsCol._dhx_find(this.cell.parentNode)+1];
                        if (z) this._fake.selectCell(z,0,false,false,true);
                        return false;
                    }
                    else
                        return  this.doKeyA(ev);
                }
            }
            else{
                if (this._realfake){
                    if ((this.cell)&&(this.cell._cellIndex==0)){
					   if (ev.preventDefault)
					       ev.preventDefault();
                       var z=this._fake.rowsCol[this.rowsCol._dhx_find(this.cell.parentNode)-1];
                       if (z) this._fake.selectCell(z,this._fake.rowsCol[0].childNodes.length-1,false,false,true);
                       return false;
                       }
                    else
                       return this.doKeyA(ev);
                    }
                else{
                    if ((this.cell)&&(this.cell._cellIndex==ind)){
					   if (ev.preventDefault)
					       ev.preventDefault();
                        this._fake.selectCell(this.rowsCol._dhx_find(this.cell.parentNode),ind-1,false,false,true);
                        return false;
                    }
                    else
                        return  this.doKeyA(ev);
                }
            }
       break;
    }

    return  this.doKeyA(ev);
}

this.deleteRowA = this.deleteRow;
this.deleteRow=function(row_id,node){
/*	if (!this._realfake)
		this._fake.loadedKidsHash=this.loadedKidsHash;*/

    if (this.deleteRowA(row_id,node)===false) return false;
    this._fake.deleteRow(row_id);
}

this.clearAllA = this.clearAll;
this.clearAll=function(){
    this.clearAllA();
    this._fake.clearAll();
}

this._sortRowsA = this._sortRows;
this._fake._sortRowsA = this._fake._sortRows;
this._sortRows=this._fake._sortRows=function(col,type,order,ar){
    this._sortRowsA(col,type,order,ar);
   	this._fake._sortRowsA(col,type,order,ar);
	this._fake.setSortImgStateA(false);
	this._fake.fldSorted=null;
	(this._realfake?this:this._fake)._fixAlterCss();
}
this.sortTreeRowsA = this.sortTreeRows;
this._fake.sortTreeRowsA = this._fake.sortTreeRows;
this.sortTreeRows=this._fake.sortTreeRows=function(col,type,order,ar){
    this.sortTreeRowsA(col,type,order,ar);
    if (col<ind)
    	this._fake.sortTreeRowsA(col,type,order,ar);
    else
    	this._fake._h2syncModel();
	this._fake.setSortImgStateA(false);
	this._fake.fldSorted=null;
}


if (this.changePage){
    //paging



    this.changePageA=this.changePage;
    this.changePage=function(pageNum){

	this.changePageA(pageNum);
	var zsize=this.rowsBufferOutSize;
	var startRowInd = this.currentPage*zsize - zsize

	//clear grid page
	var totalRows = this._fake.obj._rowslength();

	for(var i=0;i<totalRows;i++){
		var tmpPar = this._fake.obj._rows(0).parentNode
        tmpPar.removeChild(this._fake.obj._rows(0));
	}

	for(var i=startRowInd;i<(startRowInd*1+zsize*1);i++){
					var row = this.getRowFromCollection(i);
					if (!row) continue;
					if (!this._fake.rowsAr[row.idd])
					{
	                    var x=row.cloneNode(true);
	                    while (x.childNodes.length>ind)
	                        x.removeChild(x.childNodes[x.childNodes.length-1]);
	                    for (var j=0; j<ind; j++){
	                        x.childNodes[j].style.display="";
	                        x.childNodes[j]._cellIndex=j;
	                        }

	                        x.idd=this.obj._rows(i).idd;
	                        x.grid=this._fake;
	                        this._fake["_insertRowAt"](x,-1);
					}

                  	this._fake.obj.rows[0].parentNode.appendChild(this._fake.rowsAr[row.idd]);
        }
    }


    if (this.pagingOn){
        //special sort handling
        this._sortRows=function(){
                this._sortRowsA.apply(this,arguments);
                this._fake.setSortImgStateA(false);
				for (var i=0; i<this.rowsCol.length; i++)
					if (this.rowsCol[i])
						this._fake.rowsCol[i]=this._fake.rowsAr[this.rowsCol[i].idd];                
        }
        this._fake.sortRows=function(){
            this._fake.sortRows.apply(this._fake,arguments);
            this._fake.setSortImgStateA(false);
        }
    }

}





if (this._fastAddRowSpacer){
    this._fastAddRowSpacerA=this._fastAddRowSpacer;
    this._fastAddRowSpacer=function(ind,height){
        this._fake._fastAddRowSpacer(ind,height);
        this._fake.limit=this.limit;
        return this._fastAddRowSpacerA(ind,height);
    }


    this._splitRowAtA=this._splitRowAt;
    this._splitRowAt=function(){ 
        this._fake._splitRowAt.apply(this._fake,arguments);
        this._splitRowAt=this._splitRowAtA;
        var z=this._splitRowAtA.apply(this,arguments);
        this._splitRowAt=this._splitRowAtB;
        return z;
    }
    this._splitRowAtB=this._splitRowAt;

    this._fake._askRealRows=function(){};

    this.loadXMLA=this.loadXML;
    this.loadXML=function(){
        if (this._dload){
			this._fake._dload = true;
            this._fake._dInc=this._dInc;
            this._fake._dl_start=new Array();
            this._fake.limit=this.limit;

			//this.multiLine=this._fake.multiLine=false;
            this._fake._dloadSize=Math.floor(parseInt(this.entBox.style.height)/20)+2; //rough, but will work
          	if (!this.multiLine) this._fake.obj.className+=" row20px";
            this._fake._dpref=this._dpref;
            this._dom_limit=this._fake._dom_limit=999999999;
        }
        return this.loadXMLA.apply(this,arguments);
    }

    this._addFromBufferSR=function(j){
                    if ((!this.rowsCol[j])||(this.rowsCol[j]._sRow))
                        this._splitRowAt(j);

                if (this.rowsBuffer[1][j].tagName=="row"){
                	if (this._cssEven){
                      if (j%2==1) this._fake.rowsCol[j].className=this.rowsCol[j].className=this._cssUnEven;
                      else this._fake.rowsCol[j].className=this.rowsCol[j].className=this._cssEven;
                    }
                    this.changeRowId(this.rowsCol[j].idd,this.rowsBuffer[1][j].getAttribute("id"));
                    this._fake.changeRowId(this._fake.rowsCol[j].idd,this.rowsBuffer[1][j].getAttribute("id"));
					this._fillRowFromXML(this.rowsCol[j],this.rowsBuffer[1][j],-1);                                        
                }

              this.rowsCol[j]._rLoad=false;
              this._fake.rowsCol[j]._rLoad=false;
              this.rowsBuffer[1][j]=null;
    }
}


    this._fake.combos=this.combos;
	this.setSizes();
	this.attachEvent("onXLE",function(){this._fake._correctSplit()})
	this._fake._correctSplit();
}

dhtmlXGridObject.prototype._correctSplit=function(a){
    a=a||(this.obj.scrollWidth-this.objBox.scrollLeft);
    if (a>-1)
    {
    this.entBox.style.width=a+"px";
    this.objBuf.style.width=a+"px";

    var pa=this._fake.entBox.childNodes[0];
    pa.style.left=a+"px";
  	if (this._fake.ftr)
	    this._fake.ftr.style.left=a-(_isFF?2:0)+"px";
    pa.style.width=this._fake.entBox.offsetWidth-a+"px";
    }
}
/*
dhtmlXGridObject.prototype._stopEvents=function(a){
	if (!this._pr_callEvent) this._pr_callEvent=this.callEvent;
	this.callEvent=function(){ return true; };
	
}
dhtmlXGridObject.prototype._startEvents=function(a){
	if (this._pr_callEvent) this.callEvent=this._pr_callEvent;
	this._pr_callEvent=false;
}

*/
dhtmlXGridObject.prototype._correctRowHeight=function(id,ind){
	if (!this.rowsAr[id]) return;
	var h=this.rowsAr[id].offsetHeight;
	var h2=this._fake.rowsAr[id].offsetHeight;
	if (h>h2) this._fake.rowsAr[id].style.height=h+"px";
	if (h<h2) this.rowsAr[id].style.height=h2+"px";
}
//(c)dhtmlx ltd. www.dhtmlx.com