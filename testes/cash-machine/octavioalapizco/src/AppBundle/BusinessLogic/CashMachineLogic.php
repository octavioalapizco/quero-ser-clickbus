<?php
namespace AppBundle\BusinessLogic;
use AppBundle\Exception\NotAvailableException;

class CashMachineLogic{
	public function validar($cantidad){
		if ( !is_numeric($cantidad) ){
			throw new \InvalidArgumentException('La cantidad debe ser un numero');
		}
		
		$cantidad = floatval($cantidad);
		
		if ($cantidad<=0) throw new \InvalidArgumentException('La cantidad debe ser mayor a 0');
		
		if ($cantidad<10) throw new NotAvailableException('La cantidad debe ser múltiplo de 10');
		
		if ($cantidad!==floor($cantidad)) throw new NotAvailableException('La Cantidad no debe contener decimales');
		
		$esMultiplo = ($cantidad%10)===0;
		if (!$esMultiplo) throw new NotAvailableException('La cantidad debe ser múltiplo de 10');
		return $esMultiplo;
		
		
	}
	
	public function getBilletes($cantidad){
		$this->validar($cantidad);
		
		$disponibles=array(100,50,20,10);
		$restante=$cantidad;
		$entregados=array();
		foreach($disponibles as $billete){
			
			$cantidadEnBillete=$restante/$billete;
			if ($cantidadEnBillete>=1){
				$entregados[]=array('denominacion'=>$billete,'cantidad'=>floor($cantidadEnBillete)) ;
				$restante=$restante % $billete;
			}
			
		}
		return $entregados;
	}
}
?>