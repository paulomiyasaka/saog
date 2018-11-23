<?php
include_once '../controle/auto_load.class.php';
new auto_load();
header("Content-Type: text/html; charset=UTF-8",true);

$acao = "";
//verifica passagem de acão
if(isset($_REQUEST['acao'])){

	$acao = $_REQUEST['acao'];
	
	
	
	if($acao == "cadastrar"){
		$distritos = new distritos();
		
		if(isset($_REQUEST['numero_distrito'])){
			$distritos->setNumeroDistrito($_REQUEST['numero_distrito']);
		}		
		if(isset($_REQUEST['id_unidade'])){
			$distritos->setIdUnidade($_REQUEST['id_unidade']);
		}
		if(isset($_REQUEST['roteiros'])){
			$distritos->setRoteiros($_REQUEST['roteiros']);
		}
	
		$cadastrar = $distritos->cadastrarDistritos();

		
			//echo "CADASTRADO COM SUCESSO";
			var_dump(json_encode($cadastrar));
		
	}else if($acao == "consultar"){

		$distritos = new distritos();		
				
		if(isset($_POST['id_unidade'])){
			$distritos->setIdUnidade($_POST['id_unidade']);
			
		}	
		$consultar = $distritos->listarDistritos();

		
			//var_dump(json_encode($consultar));
		//var_dump($consultar);
		echo $consultar;
		
	}else if($acao == "roteiros"){

		$distritos = new distritos();		
				
		if(isset($_POST['id_distrito'])){
			$distritos->setIdDistrito($_POST['id_distrito']);
			
		}	
		$consultar = $distritos->listarRoteiros();

		
			//var_dump(json_encode($consultar));
		//var_dump($consultar);
		echo $consultar;
		
	}
	
	
	
	
	
//se não houver parametro unidade apresenta erro
}else{
	return false;
}






?>