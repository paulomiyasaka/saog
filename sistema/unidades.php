<?php
include_once '../controle/auto_load.class.php';
new auto_load();
header("Content-Type: text/html; charset=UTF-8",true);

$acao = "";
//verifica passagem de acão
if(isset($_REQUEST['acao'])){

	$acao = $_REQUEST['acao'];
	
	
	
	if($acao == "cadastrar"){
		$unidades = new unidades();
		
		if(isset($_REQUEST['nome'])){
			$unidades->setNome($_REQUEST['nome']);
		}		
		if(isset($_REQUEST['tipo_trabalho'])){
			$unidades->setTrabalho($_REQUEST['tipo_trabalho']);
		}
		if(isset($_REQUEST['endereco'])){
			$unidades->setEndereco($_REQUEST['endereco']);
		}
		if(isset($_REQUEST['gerente'])){
			$unidades->setGerente($_REQUEST['gerente']);
		}
		if(isset($_REQUEST['matricula_gerente'])){
			$unidades->setMatricula($_REQUEST['matricula_gerente']);
		}
		if(isset($_REQUEST['tel_gerente'])){
			$unidades->setTelGerente($_REQUEST['tel_gerente']);
		}
		if(isset($_REQUEST['tel_gerente2'])){
			$unidades->setTelGerente2($_REQUEST['tel_gerente2']);
		}
		if(isset($_REQUEST['tel_centro'])){
			$unidades->setTelCentro($_REQUEST['tel_centro']);
		}
	
		$cadastrar = $unidades->cadastrarUnidades();

		
			//echo "CADASTRADO COM SUCESSO";
			var_dump(json_encode($cadastrar));
		
	}
	
	
	
	
//se não houver parametro unidade apresenta erro
}else{
	return false;
}






?>