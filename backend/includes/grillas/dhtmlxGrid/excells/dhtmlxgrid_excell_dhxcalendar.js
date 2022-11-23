function eXcell_dhxCalendar(cell){
	if (cell){
      this.cell = cell;
      this.grid = this.cell.parentNode.grid;
                    if (!window._grid_calendarA) {
                    		var z=document.createElement("DIV");
                    		//z.style.position="absolute";
                    		document.body.insertBefore(z,document.body.firstChild);
                    		window._grid_calendarA=new dhtmlxCalendarObject(z,false, {isYearEditable :true} );
                    		_grid_calendarA.loadUserLanguage('en-us');
                    		_grid_calendarA.setYearsRange(1900, 2100);
                    		
                    		_grid_calendarA.draw();
                    		_grid_calendarA.hide();
                    		_grid_calendarA.setSkin("yahoolike");
                    		var sgrid=this.grid;
                    		_grid_calendarA.setOnClickHandler(function(){
                    			this._last_operation_calendar=true;
                    			window.setTimeout(function(){sgrid.editStop()},1);
                    			return true;
                			});
                    		
							var zFunc=function(e){ (e||event).cancelBubble=true;  }
							dhtmlxEvent(_grid_calendarA.entObj,"click",zFunc);                    		
	                    }      
	}
}
eXcell_dhxCalendar.prototype = new eXcell;

	eXcell_dhxCalendar.prototype.edit = function(){

                        var arPos = this.grid.getPosition(this.cell);
						_grid_calendarA.setPosition(arPos[1],arPos[0]);
						_grid_calendarA._last_operation_calendar=false;						

	                    _grid_calendarA.show();
					//var arPos = this.grid.getPosition(this.cell);
                    //var pval=this._date2str2(this.cell.val||new Date());
                    //window._grid_calendar.render(arPos[0],arPos[1]+this.cell.offsetHeight,this,pval);
                    this.cell._cediton=true;
                    this.val=this.cell.val;
                   // alert(this.cell.val);
                    _grid_calendarA.setDate(this.val);
                    _grid_calendarA.draw();
				}
	eXcell_dhxCalendar.prototype.getDate = function(){	
		if (this.cell.val) return this.cell.val;
		return null;
	}
	
	eXcell_dhxCalendar.prototype.getValue = function(){
		return this.cell.innerHTML.toString()._dhx_trim()
	}

	eXcell_dhxCalendar.prototype.detach = function(){   
					if (!window._grid_calendarA) return;
					_grid_calendarA.hide();
                    if (this.cell._cediton) this.cell._cediton=false;
                    else return;
                    if (_grid_calendarA._last_operation_calendar){
                    	var z1=_grid_calendarA.getFormatedDate((this.grid._dtmask||"%d/%m/%Y"));
                    	var z2=_grid_calendarA.getDate();
                    	this.cell.val=new Date(z2);
    					this.setCValue(z1,z2);
						return (this.cell.val.valueOf())!=(this.val.valueOf());
					}
					return false;
				}

								
	eXcell_dhxCalendar.prototype.setValue = function(val){

                        this.cell.val=new Date(_grid_calendarA.setFormatedDate((this.grid._dtmask||"%d/%m/%Y"),val.toString()));
						if(!val || val.toString()._dhx_trim()==""){
							val="&nbsp";
							this.cell._clearCell=true;
                            this.cell.val=new Date();							
							}
						else
							this.cell._clearCell=false;

                        if ((this.cell.val=="NaN")||(this.cell.val=="Invalid Date")){
                            this.cell.val=new Date();
                            this.setCValue("&nbsp;",0);
                        }
                        else
    						this.setCValue(val.toString(),this.cell.val);
				}


function eXcell_dhxCalendarA(cell){
	if (cell){
      this.cell = cell;
      this.grid = this.cell.parentNode.grid;
                    if (!window._grid_calendarA) {
                    		
                    		var z=document.createElement("DIV");
                    		//z.style.position="absolute";
                    		document.body.insertBefore(z,document.body.firstChild);
                    		window._grid_calendarA=new dhtmlxCalendarObject(z,false, {isYearEditable :true} );
                    		_grid_calendarA.loadUserLanguage('en-us');
                    		_grid_calendarA.setYearsRange(1900, 2100);
                    		
                    		_grid_calendarA.draw();
                    		_grid_calendarA.hide();
                    		_grid_calendarA.setSkin("yahoolike");
                    		var sgrid=this.grid;
                    		_grid_calendarA.setOnClickHandler(function(){
                    			this._last_operation_calendar=true;
                    			window.setTimeout(function(){sgrid.editStop()},1);
                    			return true;
                			});
                    		
							var zFunc=function(e){ (e||event).cancelBubble=true;  }
							dhtmlxEvent(_grid_calendarA.entObj,"click",zFunc);                    		
	                    }      
	}
}
eXcell_dhxCalendarA.prototype = new eXcell;

	eXcell_dhxCalendarA.prototype.edit = function(){
	                    _grid_calendarA.setPosition(this.cell);
	                    _grid_calendarA.show();
	                    _grid_calendarA._last_operation_calendar=false;
					//var arPos = this.grid.getPosition(this.cell);
                    //var pval=this._date2str2(this.cell.val||new Date());
                    //window._grid_calendar.render(arPos[0],arPos[1]+this.cell.offsetHeight,this,pval);
                    this.cell._cediton=true;
                    this.val=this.cell.val;
                   // alert(this.cell.val);
                    _grid_calendarA.setDate(this.val);
                    _grid_calendarA.draw();
                    

					this.cell.atag=((!this.grid.multiLine)&&(_isKHTML||_isMacOS||_isFF))?"INPUT":"TEXTAREA";
					
					this.obj = document.createElement(this.cell.atag);
					this.obj.style.height = (this.cell.offsetHeight-(_isIE?4:2))+"px";
                    this.obj.className="dhx_combo_edit";
				   	this.obj.wrap = "soft";
					this.obj.style.textAlign = this.cell.align;
					this.obj.onclick = function(e){(e||event).cancelBubble = true}
					this.obj.onmousedown = function(e){(e||event).cancelBubble = true}
					this.obj.value = this.getValue();
					this.cell.innerHTML = "";
					this.cell.appendChild(this.obj);
				  	if (_isFF) {
						this.obj.style.overflow="visible";
						if ((this.grid.multiLine)&&(this.obj.offsetHeight>=18)&&(this.obj.offsetHeight<40)){
							this.obj.style.height="36px";
							this.obj.style.overflow="scroll";
						}
					}
                    this.obj.onselectstart=function(e){  if (!e) e=event; e.cancelBubble=true; return true;  };
					this.obj.focus()
  					this.obj.focus()
				                    
				}
				
	eXcell_dhxCalendarA.prototype.getDate = function(){	
		if (this.cell.val) return this.cell.val;
		return null;
	}
	
	eXcell_dhxCalendarA.prototype.getValue = function(){
		return this.cell.innerHTML.toString()._dhx_trim()
	}

	eXcell_dhxCalendarA.prototype.detach = function(){   
					if (!window._grid_calendarA) return;
					_grid_calendarA.hide();
                    if (this.cell._cediton) this.cell._cediton=false;
                    else return;
                    if (_grid_calendarA._last_operation_calendar){
                    	_grid_calendarA._last_operation_calendar=false;
                    	var z1=_grid_calendarA.getFormatedDate(this.grid._dtmask||"%d/%m/%Y");
                    	var z2=_grid_calendarA.getDate();
                    	this.cell.val=new Date(z2);
    					this.setCValue(z1,z2);
						return (this.cell.val.valueOf())!=(this.val.valueOf());
					}
						this.setValue(this.obj.value);
						return (this.cell.val.valueOf())!=(this.val.valueOf());
				}
eXcell_dhxCalendarA.prototype.setValue = function(val){

                        this.cell.val=new Date(_grid_calendarA.setFormatedDate((this.grid._dtmask||"%d/%m/%Y"),val.toString()));
						if(!val || val.toString()._dhx_trim()==""){
							val="&nbsp";
							this.cell._clearCell=true;
                            this.cell.val=new Date();							
							}
						else
							this.cell._clearCell=false;

                        if ((this.cell.val=="NaN")||(this.cell.val=="Invalid Date")){
                            this.cell.val=new Date();
                            this.setCValue("&nbsp;",0);
                        }
                        else
    						this.setCValue(val.toString(),this.cell.val);
				}
