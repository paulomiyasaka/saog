  <?php
include_once '../controle/auto_load.class.php';
new auto_load();
$funcoes = new funcoes();
$funcoes->charset();
session_start();
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <title>Listar Plantões - SAOG</title>
 <!-- Required meta tags -->
    <link rel="shortcut icon" href="http://correios.com.br/++theme++correios.site.tema/images/favicon.ico" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/style.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
  <script src="../js/script.js"></script>
 
    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
  <script>
    $(document).ready(function(){

      if (typeof(Storage) !== 'undefined') {
        if(localStorage.getItem("matricula") == null){        
          //alert(localStorage.getItem("nome"));
          window.location.href = "../index.php";
        }
      }else {
        alert('Utilize um destes navegadores: Google Chrome ou Mozilla Firefox.');
      }

    });
    

    
  
  </script>
    
  
  </head>

  <body>

  
      
<?php
			include_once 'navbar.php';
  ?>
  

	<div class="container">
		
		<?php
			$plantao = new plantao();
			$plantao->botaoCadastrarPlantao();
		?>

	


		<?php 
		
		$plantao->plantaoPassado();
	

		?>

	




	<!-- MODAL PARA CONFIRMAR INSCRIÇÃO -->


		<!-- Modal -->
		<div class="modal fade" id="modalInscreverMotorista" tabindex="-1" role="dialog" aria-labelledby="modalInscreverTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h3 class="modal-title" id="modalInscreverLongTitle">Confirmar inscrição</h3>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <h3>Deseja confirmar cadastro no plantão?</h3>
	  
		        	<hr>	        	
		        	
			  		<label class="custom-control-label"><h4>Você tem interesse em dirigir veículos dos Correios?</h4></label>
			  		<br>
			  		<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" id="inlineCheckbox1" name="motor" value="0" checked>
					  <label class="form-check-label" for="inlineCheckbox1"> NÃO </label>
					</div>
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" id="inlineCheckbox1" name="motor" value="1">
					  <label class="form-check-label" for="inlineCheckbox1"> SIM </label>
					</div>
			  		
				</div>


		

		        
		      <div class="modal-footer">		      	
		      	<button id="inscrever_plantao" type="button" class="btn btn-success" onclick="inscreverPlantao();">Confirmar</button>
		        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>		        
		      </div>
		    </div>
		  </div>
		</div>


		<!-- Modal -->
		<div class="modal fade" id="modalInscreverTratamento" tabindex="-1" role="dialog" aria-labelledby="modalInscreverTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h3 class="modal-title" id="modalInscreverLongTitle">Confirmar inscrição</h3>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <h3>Deseja confirmar cadastro no plantão?</h3>
	  				
				</div>
	        
		      <div class="modal-footer">		      	
		      	<button id="inscrever_plantao" type="button" class="btn btn-success" onclick="inscreverPlantao();">Confirmar</button>
		        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>		        
		      </div>
		    </div>
		  </div>
		</div>









		<div class="modal fade" id="modalCancelInscrever" tabindex="-1" role="dialog" aria-labelledby="modalCancelInscreverTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h3 class="modal-title" id="modalCancelInscreverLongTitle">Confirmar cancelamento</h3>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <h3>Deseja confirmar o cancelamento da inscrição neste plantão?</h3>
		      </div>
		      <div class="modal-footer">		      	
		      	<button id="cancelar_inscrever_plantao" type="button" class="btn btn-success" onclick="cancelarInscreverPlantao();">Confirmar</button>
		        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>		        
		      </div>
		    </div>
		  </div>
		</div>

				<!-- Modal
		<div class="modal fade" id="modalInscritos" tabindex="-1" role="dialog" aria-labelledby="modalInscritosLongTitle" aria-hidden="true">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h3 class="modal-title" id="modalInscritosLongTitle">Inscritos no plantão:</h3>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>

		      <div class="modal-body">
		       
		      		<table class="table">
					  <thead>
					    <tr>
					      <th scope="col" class="text-center">#</th>
					      <th scope="col" class="text-center">Nome</th>
					      <th scope="col" class="text-center">Lotação</th>
					    </tr>
					  </thead>
					  <tbody>
					  	
					  </tbody>
					</table>

		      </div>

		      <div class="modal-footer">
		        <button id="btn_imprimir" type="button" class="btn btn-primary" onclick="imprimirInscritos();">Imprimir</button>
		        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>	
		      </div>
		    </div>
		  </div>
		</div>

		-->

		<!-- MODAL CADASTRAR UNIDADE -->

		<!-- Modal -->
		<div class="modal fade" id="modalUnidade" tabindex="-1" role="dialog" aria-labelledby="examplemodalUnidade" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h2 class="modal-title" id="examplemodalUnidade">Cadastrar Unidade</h2>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        	<div class="container-fluid">
		
		<form>
		  <div class="form-group">
			<label for="nome_unidade">Nome da Unidade</label>
			<input type="text" name="nome_unidade" class="form-control" id="nome_unidade" placeholder="Nome da Unidade">
		  </div>
		  
		  <div class="input-group mb-3">
		  <div class="input-group-prepend">
			<label class="input-group-text" for="tipo_trabalho">Tipo do Trabalho</label>
		  </div>
		  <select class="custom-select" id="tipo_trabalho" name="tipo_trabalho" style="height: 35px; width: 100%">
			<option value="0" selected>Escolha Tipo do Trabalho</option>
			<option value="Tratamento">Tratamento</option>
			<option value="Distribuição">Distribuição</option>
		  </select>
		</div>
		  
		  <div class="form-group">
			<label for="endereco">Endereço da Unidade</label>
			<input type="text" name="endereco" class="form-control" id="endereco" placeholder="Endereço da Unidade">
		  </div>
		  <div class="form-group">
			<label for="gerente">Gerente</label>
			<input type="text" name="gerente" class="form-control" id="gerente" placeholder="Gerente">
		  </div>
		  <div class="form-group">
			<label for="matricula_gerente">Matrícula do Gerente:</label>
			<input type="text" name="matricula_gerente" class="form-control" id="matricula_gerente" placeholder="Matrícula do Gerente">
		  </div>
		  <div class="form-group">
			<label for="tel_gerente">Telefone do Gerente: (61) </label>
			<input type="text" name="tel_gerente" class="form-control" id="tel_gerente" placeholder="Telefone do Gerente">
		  </div>
		  <div class="form-group">
			<label for="tel_gerente2">Telefone 2 do Gerente: (61) </label>
			<input type="text" name="tel_gerente2" class="form-control" id="tel_gerente2" placeholder="Telefone 2 do Gerente">
		  </div>
		  <div class="form-group">
			<label for="tel_centro">Telefone do Centro: (61) </label>
			<input type="text" name="tel_centro" class="form-control" id="tel_centro" placeholder="Telefone do Centro">
		  </div>
		  <input type="hidden" name="acao" value="cadastrar">
		</form>
		
	</div>
		      </div>
		      <d<div class="modal-footer">
		      	<button id="btn_cadastrar_unidade" type="submit" class="btn btn-success" onclick="cadastrarUnidade();">Cadastrar</button>		        
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
		      </div>
		    </div>
		  </div>

<!-- ALERTA CADASTRO OK -->
<div id="modalCadastroOK" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
<div id="cadastroOK" class="alert alert-success" role="alert">
  <h2 class="alert-heading text-center">Sucesso!</h2>
  <h4>Registro efetuado com sucesso.</h4>
</div>
</div>
</div>
</div>

<!-- ALERTA CADASTRO ERROR -->
<div id="modalCadastroError" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
<div id="cadastroError" class="alert alert-danger" role="alert">
  <h2 class="alert-heading text-center">Erro!</h2>
  <h4>Algo deu errado ao tentar efetuar o cadastro.<br>Verifique os seus dados e tente novamente!</h4>
</div>
</div>
</div>
</div>



	<!-- MODAL CADASTRAR PLANTAO -->

		<div class="modal fade" id="modalPlantao" tabindex="-1" role="dialog" aria-labelledby="cadastrarPlantao" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h2 class="modal-title text-center" id="cadastrarPlantao">Cadastrar Plantão</h2>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>


    <div class="modal-body">		
		<div class="container-fluid">
	
		<div class="row">
			<div class="col">
			<form>
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
					<label class="input-group-text" for="tipo_trabalho">Unidade e Tipo de Trabalho</label>
				  </div>
				  <select class="custom-select" id="id_unidade" name="id_unidade"  style="height: 35px; width: 100%" required>
				<option value="0" selected>Escolha a Unidade</option>
				
			<?php
				$plantao = new plantao();
				$plantao->listarUnidadesPlantao();				
			?> 
			  </select>
			</div>
			</div>
		</div>
		
		  <div class="row">
		  <div class="col">
		  <div class="form-group">
			<label for="data_inicio">Data Inicial:</label>
			<input type="date" name="data_inicio" class="form-control" id="data_inicio" placeholder="Data Inicial - dd/mm/yyyy" required>
		  </div>
		  </div>
		  
		  
		  <div class="col">
		  <div class="form-group">
			<label for="hora_inicio">Hora de Início:</label>
			<select class="form-control" style="height: 35px;" id="hora_inicio" name="hora_inicio" required>
			  <?php $plantao->gerarHorario(); ?>			  
			</select>
		  </div>
		  </div>
		  </div>
		  
		  <div class="row">
		  <div class="col">
		  <div class="form-group">
			<label for="data_final">Data Final:</label>
			<input type="date" name="data_final" class="form-control" id="data_final" placeholder="Data Final - dd/mm/yyyy" required>
		  </div>
		  </div>
		  
		  <div class="col">
		  <div class="form-group">
			<label for="hora_final">Hora do Término:</label>
			<select class="form-control" style="height: 35px;" id="hora_final" name="hora_final" required>
			  <?php $plantao->gerarHorario(); ?>	
			</select>
		  </div>
		  </div>
		  </div>
		  
		  <div class="row">
		  <div class="col">
		  <div class="form-group">
			<label for="vagas">Quantidade de Vagas Total</label>
			<input type="text" name="vagas" class="form-control" id="vagas" placeholder="Quantidade de Vagas" required>
		  </div> 
		</div>
		  <div class="col">
		  	<div class="form-group">
		  		<label class="custom-control-label">Precisará de motoristas?</label>
		  		<br>
		  		<div class="form-check form-check-inline">
				  <input class="form-check-input" type="radio" name="motorista" id="exampleRadios1" value="0" checked>
				  <label class="form-check-label" for="exampleRadios1">
				    NÃO
				  </label>
				</div>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="radio" name="motorista" id="exampleRadios2" value="1">
				  <label class="form-check-label" for="exampleRadios2">
				    SIM
				  </label>
				</div>	 		

		  	</div>		  	
			 </div>
			  </div>

		</form>
		
	</div>
		</div>
		      <div class="modal-footer">
		      	<button id="btn_cadastrar_plantao" type="submit" class="btn btn-success" onclick="cadastrarPlantao();">Cadastrar</button>
		        
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
		      </div>
		    </div>
		  </div>
		</div>
	
	</div>

	
</body>
</html>