<?php //--------------------------------------- 
session_start();

class Usuario {

	protected $sTipoUsuario = '';
	protected $sLogin = '';
	protected $id_user = 0;
	private $aDatos;
	private $id_tuser;
	
	public function __construct( $id_user = false ) {
		
		if(!$id_user)$id_user = $_SESSION['id_user'];
		$this->id_user = $id_user;
		$this->cargarDatos();	
	}
	
	
	
	private function cargarDatos() {
		
		GLOBAL $oMysql;
		
		$sCondiciones="where user.id_user={$this->id_user}";
		$sConsulta="call usp_getDatosUsuario(\"$sCondiciones\")";
			
		$this->aDatos = $oMysql->consultaSel( $sConsulta, true );
		
		$this->sTipoUsuario =$this->aDatos['sTipoUsuario'];
		$this->sLogin=$this->aDatos['login'];
		$this->id_tuser=$this->aDatos['id_tuser'];
	
	}
	
	
	public function __get( $sAtributo ) {
		
		return $this->$sAtributo;
	}
	
	
	public function getDatos() { return $this->aDatos; }
	
	//---------------------------------------------------------------------------------
	
	public function getNombre() { return $this->aDatos['usuario']; }
	
	public function getSucursalNombre() { return $this->aDatos['suc_nombre'] . ' - ' . $this->aDatos['suc_num']; }
	
	public function getDependienteNombre() { return $this->aDatos['dep_apodo'] . ' - ' . $this->aDatos['dep_num']; }
	
	
	public function getIDDep() { return $this->aDatos['id_dep']; }
	
	public function getID() { return $this->id_user; }
	
	public function savePermit($sPermits){
		#$sPermit ::: userMenuLink_sTipoObjeto_idObjeto_idPermiso 		
		
		GLOBAL $oMysql;	
		
		#tengo un array con ::: idPermisoObjeto		
		$aPermitObject = explode(",",$sPermits);

		$search   = 'idPermitObject_';

		foreach ($aPermitObject as $PermitObject){
			$pos = strpos($PermitObject, $search);
			if ($pos !== false) { 
				$idPermit = str_replace("idPermitObject_","",$PermitObject);		
				$aNewRulesUsers[] = $idPermit; 
			}
		}		
		
		#Obtengo Reglas del Usuario en cuestion			
		
		$array = $oMysql->consultaSel("CALL usp_getPermitUser(\"$this->id_user\");");
		
		$aOldRulesUsers = array();				
		
		foreach( $array as $keyPermitObject ) { $aOldRulesUsers[] = $keyPermitObject['ID_PERMIT_OBJECT'] ; }	
		
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
	
	public function addRule($idPermitObject,$idUnidadNegocio){
		Global $oMysql;						
		
			
		$ToAuditory = "Se asocio reglas (idPermisoObjeto,idUsuario,idUnidadNegocio) ::: ($idTypePermit,$idObject,$this->id_user,$idUnidadNegocio) al usuario $this->id_user";
		$Set = "idPermisoObjeto,idUsuario,idUnidadNegocio";
		$Values = "$idPermitObject,$this->id_user,$idUnidadNegocio";
		
		$id = $oMysql->consultaSel("CALL usp_InsertTable(\"PermisosObjetosEmpleados\",\"$Set\",\"$Values\",\"{$_SESSION['ID_USER']}\",\"0\",\"$ToAuditory\");");
		
		return $id ;
	}
	
	public function removeRule($idPermitObject){
		Global $oMysql;						
		
			
		$ToAuditory = "Se quito regla (idPermisoObjeto,idUsuario) ::: ($idPermitObject,$this->id_user) al usuario $this->id_user";
		$sConditions = "PermisosObjetosEmpleados.idPermisoObjeto = $idPermitObject AND PermisosObjetosEmpleados.idUsuario = '$this->id_user'";
		
		$id = $oMysql->consultaSel("CALL usp_DeleteTable(\"PermisosObjetosEmpleados\",\"$sConditions\",\"{$_SESSION['id_user']}\",\"0\",\"$ToAuditory\");");
		
		return $id ;
	}	
	
	public function setPermisosOperador($sPermisos,$idUnidadNegocio){
		Global $oMysql;	
		
		$aNewRulesUsers = array();
		#tengo un array con ::: idPermisoObjeto		
		$iTipo=false;
				
		if(!$iTipo){
			$aNewRulesUsers = explode(',',$sPermisos);	
		}
		else{	
			$aPermitObject = explode(",",$sPermisos);
			$search   = 'idPermitObject_';
			foreach ($aPermitObject as $PermitObject){
				$pos = strpos($PermitObject, $search);
				if ($pos !== false) { 
					$idPermit = str_replace("idPermitObject_","",$PermitObject);		
					$aNewRulesUsers[] = $idPermit; 
				}
			}
		}
		
		$array = $oMysql->consultaSel("CALL usp_getPermitUser(\"$this->id_user\",\"$idUnidadNegocio\");");
		
		$aOldRulesUsers = array();				
		
		foreach( $array as $keyPermitObject ) { $aOldRulesUsers[] = $keyPermitObject['ID_PERMIT_OBJECT'] ; }	
		
		foreach ($aNewRulesUsers as $idRule ){
			if(!in_array($idRule,$aOldRulesUsers)){
				$idPermitUser = $this->addRule($idRule, $idUnidadNegocio);
				$aOldRulesUsers[] = $idRule;
			}
		}
		
		foreach ($aOldRulesUsers as $idRule ){
			if(!in_array($idRule,$aNewRulesUsers)){
				$idPermitUser = $this->removeRule($idRule);
			}
		}		
	}
	
	public function updateUser($aDatos){			
		global $oMysql;
		
		$aSet = array();
		foreach ($aDatos as $key => $value)  $aSet[]= " $key = '$value' "; 			

		$Set = implode(',',$aSet);
		
		$ToAuditory = "Actualizacion de datos de usuario {$Set} id:::: $this->id_user";
		
		$oMysql->consultaSel("CALL usp_UpdateTableV2(\"user\",\"{$Set}\",\"user.id_user = '{$this->id_user}'\",\"{$_SESSION['id_user']}\",\"0\",\"$ToAuditory\");");		
			
		return true;		
	}
	
}
//---------------------------------------------- ?>