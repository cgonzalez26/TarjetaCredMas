<?php //--------------------------------------- 
session_start();

class Empleado {

	protected $sTipoEmpleado = '';
	protected $sLogin = '';
	protected $idEmpleado = 0;
	protected $idEmpleadoUnidadNegocio = 0;
	protected $idUnidadNegocio = 0;
	private $aDatos;
	private $idTipoEmpleado;
	
	public function __construct( $idEmpleado = false , $idUnidadNegocio = false) {
		if(!$idEmpleado)$idEmpleado = $_SESSION['id_user'];
		$this->idEmpleado = $idEmpleado;
		$this->idUnidadNegocio = $idUnidadNegocio;
		$this->cargarDatos();	
	}
	
	private function cargarDatos() {
		GLOBAL $oMysql;
		
		$sCondiciones="WHERE Empleados.id={$this->idEmpleado} AND EmpleadosUnidadesNegocios.idUnidadNegocio={$this->idUnidadNegocio}";
		$sConsulta="call usp_getDatosEmpleado(\"$sCondiciones\")";
			
		$this->aDatos = $oMysql->consultaSel( $sConsulta, true );
		
		$this->sTipoEmpleado = $this->aDatos['sTipoEmpleado'];
		$this->sLogin = $this->aDatos['sLogin'];
		$this->idTipoEmpleado = $this->aDatos['idTipoEmpleado'];		
		$this->idEmpleadoUnidadNegocio = $this->aDatos['idEmpleadoUnidadNegocio'];		
	}
	
	
	public function __get( $sAtributo ) {
		return $this->$sAtributo;
	}
	
	public function getDatos() { return $this->aDatos; }
	
	//---------------------------------------------------------------------------------
	
	public function getNombre() { return $this->aDatos['sNombre']; }
	
	public function getSucursalNombre() { return $this->aDatos['suc_nombre'] . ' - ' . $this->aDatos['suc_num']; }
	
	
	public function getIDDep() { return $this->aDatos['id_dep']; }
	
	public function getID() { return $this->idEmpleado; }
	
	public function savePermit($sPermits,$idUnidadNegocio){
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
		
		$array = $oMysql->consultaSel("CALL usp_getPermitUser(\"$this->id_user\",\"$this->idUnidadNegocio\");");
		
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
	
	public function addRule($idPermitObject){
		Global $oMysql;						
		
			
		$ToAuditory = "Se asocio reglas (idEmpleadoUnidadNegocio,idPermisoObjeto,idUnidadNegocio) ::: ($this->idEmpleadoUnidadNegocio,$idPermitObject,$this->idUnidadNegocio) al Empleado $this->idEmpleado";
		$Set = "idEmpleadoUnidadNegocio,idPermisoObjeto,idUnidadNegocio";
		$Values = "$this->idEmpleadoUnidadNegocio,$idPermitObject,$this->idUnidadNegocio";
		
		$id = $oMysql->consultaSel("CALL usp_InsertTable(\"PermisosObjetosEmpleados\",\"$Set\",\"$Values\",\"{$_SESSION['id_user']}\",\"0\",\"$ToAuditory\");");
		
		return $id ;
	}
	
	public function removeRule($idPermitObject){
		Global $oMysql;						
			
		$ToAuditory = "Se quito regla (idPermisoObjeto,idEmpleadoUnidadNegocio) ::: ($idPermitObject,$this->idEmpleadoUnidadNegocio) al usuario $this->idEmpleado";
		$sConditions = "PermisosObjetosEmpleados.idPermisoObjeto = $idPermitObject AND PermisosObjetosEmpleados.idEmpleadoUnidadNegocio = $this->idEmpleadoUnidadNegocio";
		
		$id = $oMysql->consultaSel("CALL usp_DeleteTable(\"PermisosObjetosEmpleados\",\"$sConditions\",\"{$_SESSION['id_user']}\",\"0\",\"$ToAuditory\");");
		
		return $id ;
	}	
	
	public function setPermisosOperador($sPermisos){
		Global $oMysql;	
		$aNewRulesUsers = array();
		//echo $sPermisos;
		$aPermitObject = explode(",",$sPermisos);
		$search   = 'idPermitObject_';
		
		foreach ($aPermitObject as $PermitObject){
			$pos = strpos($PermitObject, $search);
			if ($pos !== false) { 
				$idPermit = str_replace("idPermitObject_","",$PermitObject);		
				$aNewRulesUsers[] = $idPermit; 
			}
		}
		$array = $oMysql->consultaSel("CALL usp_getPermitUser(\"$this->idEmpleado\",\"$this->idUnidadNegocio\");");
		//echo "CALL usp_getPermitUser(\"$this->idEmpleado\",\"$this->idUnidadNegocio\");";
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
	
	public function updateUser($aDatos){			
		global $oMysql;
		
		$aSet = array();
		foreach ($aDatos as $key => $value)  $aSet[]= " $key = '$value' "; 			

		$Set = implode(',',$aSet);
		
		$ToAuditory = "Actualizacion de datos de Empleado {$Set} id:::: $this->idEmpleado";
		
		$oMysql->consultaSel("CALL usp_UpdateTable(\"Empleados\",\"{$Set}\",\"Empleados.id = '{$this->idEmpleado}'\",\"{$_SESSION['id_user']}\",\"0\",\"$ToAuditory\");");		
			
		return true;		
	}
	
}
//---------------------------------------------- ?>