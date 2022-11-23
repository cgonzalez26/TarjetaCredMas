<?php //--------------------------------------- 
session_start();

class Objeto {

	protected $id = 0;
	protected $idTipoObjeto = 0;
	protected $idUnidadNegocio = 0;	
	protected $sNombre = '';
	protected $sCodigoObjeto = '';	
	protected $sUrl = '';
	protected $sClass = '';
	protected $sImage = '';	
	protected $iOrder = 0;
	protected $bItemVisible = 0;	
	
	private $aDatos;
	
	public function __construct( $idObjeto = false) {
		//if(!$idEmpleado)$idEmpleado = $_SESSION['id_user'];
		$this->id = $idObjeto;
		$this->cargarDatos();	
	}
	
	private function cargarDatos() {
		GLOBAL $oMysql;
		
		$sCondiciones=" WHERE Objeto.id={$this->id}";
		$sConsulta="call usp_getObjects(\"$sCondiciones\")";
			
		$this->aDatos = $oMysql->consultaSel( $sConsulta, true );
		
		$this->idTipoObjeto = $this->aDatos['idTipoObjeto'];
		$this->idUnidadNegocio = $this->aDatos['idUnidadNegocio'];
		$this->sNombre = $this->aDatos['sNombre'];
		$this->sCodigoObjeto = $this->aDatos['sCodigoObjeto'];
		$this->sUrl = $this->aDatos['sUrl'];
		$this->sClass = $this->aDatos['sClass'];
		$this->sImage = $this->aDatos['sImage'];
		$this->iOrder = $this->aDatos['iOrder'];
		$this->bItemVisible = $this->aDatos['bItemVisible'];
	}
	
	
	public function __get( $sAtributo ) {
		return $this->$sAtributo;
	}
	
	public function getDatos() { return $this->aDatos; }
	
	//---------------------------------------------------------------------------------
	
	public function getNombre() { return $this->aDatos['sNombre']; }
	
	public function getID() { return $this->id; }
	
	public function savePermit($sPermits){
		#$sPermit ::: userMenuLink_sTipoObjeto_idObjeto_idPermiso 		
		
		GLOBAL $oMysql;	
		
		#tengo un array con ::: idPermisoObjeto		
		$aPermitObject = explode(",",$sPermits);

		foreach ($aPermitObject as $PermitObject){
			$aNewRulesUsers[] = $PermitObject; 
		}		
		
		#Obtengo Reglas del Usuario en cuestion			
		$sConditions = " WHERE Objetos.id ={$this->id}";
		$array = $oMysql->consultaSel("CALL usp_getObjectsPermit(\"{$sConditions}\");");
		
		$aOldRulesUsers = array();				
		
		foreach( $array as $keyPermitObject ) { $aOldRulesUsers[] = $keyPermitObject['idTipoPermiso'] ; }	
		
		foreach ($aNewRulesUsers as $idRule ){
			if(!in_array($idRule,$aOldRulesUsers)){
				$idPermitUser = $this->addRule($idRule);
				$aOldRulesUsers[] = $idRule;
			}
		}
		
		foreach ($aOldRulesUsers as $idRule ){
			if(!in_array($idRule,$aNewRulesUsers)){
				$idPermitUser = $this->removeRule($idRule);
			}
		}
		
	}		
	
	public function addRule($idPermitObject){
		Global $oMysql;						
					
		$ToAuditory = "Se asocio reglas (idObjeto,idTipoPermiso) ::: ($this->id,$idPermitObject)";
		$Set = "idObjeto,idTipoPermiso";
		$Values = "$this->id,$idPermitObject";		
		$id = $oMysql->consultaSel("CALL usp_InsertTable(\"PermisosObjetos\",\"$Set\",\"$Values\",\"{$_SESSION['id_user']}\",\"0\",\"$ToAuditory\");");
		
		return $id ;
	}
	
	public function removeRule($idPermitObject){
		Global $oMysql;						
			
		$ToAuditory = "Se quito regla (idObjeto,idTipoPermiso) ::: ($this->id,$idPermitObject) ::: Usuario = {$_SESSION['id_user']}";
		$sConditions = "PermisosObjetos.idObjeto = {$this->id} AND PermisosObjetos.idTipoPermiso ={$idPermitObject}";		
		$id = $oMysql->consultaSel("CALL usp_DeleteTable(\"PermisosObjetos\",\"$sConditions\",\"{$_SESSION['id_user']}\",\"0\",\"$ToAuditory\");");
		
		return $id ;
	}	
	
		
	public function updateObjeto($aDatos){			
		global $oMysql;
		
		$aSet = array();
		foreach ($aDatos as $key => $value)  $aSet[]= " $key = '$value' "; 			

		$Set = implode(',',$aSet);
		
		$ToAuditory = "Actualizacion de datos de Objeto de Sistema {$Set} id:::: $this->idEmpleado";
		
		$oMysql->consultaSel("CALL usp_UpdateTable(\"Objetos\",\"{$Set}\",\"Objetos.id = '{$this->idEmpleado}'\",\"{$_SESSION['id_user']}\",\"0\",\"$ToAuditory\");");		
			
		return true;		
	}
	
}
//---------------------------------------------- ?>