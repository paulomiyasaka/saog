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
    <title>Inscritos no Plantão - SAOG</title>
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

  $id_plantao = null;
  $matricula = null;
  $id_unidade = null;
  $turno_inicio = null;
  $turno_final = null;
  $vagas = null;
  $motorista = null;
  $nome = null;
  $trabalho = null;
  $data = null;
  $presenca = false;

  if(isset($_REQUEST['p'])){
    
  	$id_plantao = base64_decode($_REQUEST['p']);
  	$matricula = $_SESSION['matricula']; 
    $plantao = new plantao();
    $dados = $plantao->dadosPlantao($id_plantao);
    foreach ($dados as $row) {
      $id_unidade = $row->id_unidade;
      $turno_inicio = $row->turno_inicio;
      $turno_final = $row->turno_final;
      $funcoes = new funcoes();
      $data = $funcoes->exibirDataPlantao($row->turno_inicio, $row->turno_final);
      $vagas = $row->vagas;
      $motorista = $row->motorista;
      if($motorista){
        $motorista = "Motorizada";
      }else{
        $motorista = "Não Motorizada";
      }
      $status = $row->status;      
      $dados = $plantao->dadosUnidade($id_unidade);
      foreach ($dados as $key) {
        $nome = $key->nome;
        $trabalho = $key->trabalho;
      }

      
      if(strtotime($turno_final) < time()){
          $presenca = $plantao->presencaStatus($id_plantao);
      }

      $msg_trabalho = "";
      if($trabalho == "tratamento" || $trabalho == "Tratamento" || $trabalho == "TRATAMENTO"){
         $msg_trabalho = "Atividade de ".$trabalho;
      }else{
        $msg_trabalho = "Atividade de ".$trabalho. " " . $motorista; 
      }

    }
    
    

  }else{
  	echo "<script>window.location.href='logout.php'</script>";
  }

  ?>
  
<?php
      include_once 'navbar.php';
  ?>

<div class="container">
<div class="row justify-content-center">
  <div class="col-8">
    <h2 class="text-center">Plantão no <?php echo $nome?></h2>
    <br>
    <h3 class="text-center"><?php echo $data?></h3>
</div>
</div>

<br>
<div class="row justify-content-center">
  <div class="col-6">
    <h3 class="text-center"><?php echo ucwords($msg_trabalho); ?></h3>
  </div>  
  </div>  
 
<br><br>  
<div class="row justify-content-center">
  <?php
  if($presenca){
    echo "<div class=\"col\">";  
  }else{
    echo "<div class=\"col-10\">";
  }
  ?>
	
<table class="table table-striped table-responsive-lg text-center">
  <thead>
    <tr>
      <th class="text-center" scope="col"></th>
      <?php
      //if($motorista == 'SIM'){
        echo "<th class=\"text-center\" scope=\"col\">Escolha</th>";  
      //}
      
      if($presenca){
        //echo "<th class=\"text-center\" scope=\"col\"></th>";
        //echo "<th class=\"text-center\" scope=\"col\"></th>";
        $inicio = new DateTime($turno_inicio);
        $inicio->format("Y-m-d H:i:s");
        $final = new DateTime($turno_final);
        $final->format("Y-m-d H:i:s");
        $jornada = $inicio->diff($final);
        $jornada = $jornada->h;
        if($jornada >= 8){
          echo "<th class=\"text-center\" scope=\"col\">Entrada</th>";
          echo "<th class=\"text-center\" scope=\"col\">Saída</th>";
          echo "<th class=\"text-center\" scope=\"col\">Entrada</th>";
          echo "<th class=\"text-center\" scope=\"col\">Saída</th>";

        }else{
          echo "<th class=\"text-center\" scope=\"col\">Entrada</th>";
          echo "<th class=\"text-center\" scope=\"col\">Saída</th>";
        }

        
        //echo "<th class=\"text-center\" scope=\"col\"></th>";  
      }
      ?>
      
      <th class="text-center" scope="col">Nome</th>
      <th class="text-center" scope="col">Lotação</th>
      <!--
      <th scope="col">Presença</th>
  -->
    </tr>
  </thead>
  <tbody>
  	<?php

  		
  		$plantao->verInscritos($id_plantao);

  	?>
    
  </tbody>
</table>



</div>
</div>

<?php
$presenca_registrada = $plantao->presencaRegistrada($id_plantao);
if($presenca && !$presenca_registrada){

echo "<br><br><br>
  <div class=\"row justify-content-center\">
  <div class=\"col-8 text-center\">
    <span class=\"d-inline-block\" tabindex=\"0\" data-toggle=\"tooltip\" title=\"Salvar Presenças.\">
    <button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#modalPresenca\">Salvar Presenças</button>
  </span>
</div>
</div>";

}else{
  /*
  echo "<br><div class=\"row justify-content-center\">
  <div class=\"col-8 text-center\">
    <h2 class=\"text-dark\">Este plantão foi concluído.</h2><br><br>
  </div>
  </div>";
  */

}
?>
<br><br>
<div class="row justify-content-center">
    <div class="col-md-auto text-center text-secundary">
        <h4>Legenda:</h4>
    </div>
</div>
 <br><br>
  <div class="row justify-content-center">
    <div class="col-md-auto text-center text-secundary">
      <i class="material-icons">title</i><h4>Tratamento</h4>
    </div>
    <div class="col-md-auto text-center text-secundary">
      <i class="material-icons">local_shipping</i><h4>Distribuição</h4>
    </div>
    <div class="col-md-auto text-center text-secundary">
      <i class="material-icons">directions_walk</i><h4> Auxiliar na Distribuição</h4>
    </div>
    <div class="col-md-auto text-center text-secundary">
      <i class="material-icons">check</i><h4> Presente no Plantão</h4>
    </div>
    <div class="col-md-auto text-center text-secundary">
      <i class="material-icons">clear</i><h4> Falta no Plantão</h4>
    </div>
  </div>

</div>
<br><br><br>



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

<!-- Modal -->
    <div class="modal fade" id="modalPresenca" tabindex="-1" role="dialog" aria-labelledby="modalPresencaTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="modalPresencaLongTitle">Confirmar Presença</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h3 class="text-center">Deseja confirmar o efetivo deste plantão?</h3>           
            <h4 class="text-danger text-center"><b>OBS: Ao confirmar o efetivo, os registros não poderão ser trocados.</b></h4>           
        </div>
            
          <div class="modal-footer">            
            <button id="btn_presenca" type="button" class="btn btn-success" <?php echo "onclick=\"arrayPresenca()\""; ?> >Confirmar</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>            
          </div>
        </div>
      </div>
    </div>


</body>
</html>