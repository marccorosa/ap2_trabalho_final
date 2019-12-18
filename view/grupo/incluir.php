<?php	
//arquivos de dependências
require_once '..\cabecalho_geral.php';

$mensagem= "";

$gru_descricao= isset($_POST['gru_descricao'])?$_POST['gru_descricao']:null;
$gru_ativo="S";

$grupos= Grupo::listar();

if (isset($_POST['Salvar'])) {
    $grupo= new Grupo();
    $grupo->setGru_descricao($gru_descricao);
	$grupo->setGru_ativo($gru_ativo);
    $resultado= $grupo->incluir();

    if (is_array($resultado))
        $mensagem= "Erro: ".$resultado[0].$resultado[2];
}

?>

<title>Universal - Categoria de Produto</title>
<div id="all">   
  <div id="heading-breadcrumbs">
	<div class="container">
	  <div class="row d-flex align-items-center flex-wrap">
		<div class="col-md-7">
		  <h1 class="h2">CRIAR CATEGORIAS DE PRODUTOS</h1>
		</div>
	  </div>
	</div>
  </div>

	<div class="container">
	  <div class="row">		
		<div class="col-lg-6">
		  <div class="box">           
			<form method="POST">
			  <div class="form-group">
				<h5 class="text-uppercase">NOME DA CATEGORIA</h5>
				<input type='text' name='gru_descricao' id='gru_descricao' class="form-control" value='<?= $gru_descricao ?>'>
			  </div>
			  
			  <div>
				<?= $mensagem ?>
			  </div>
			  
			  <div class="text-center">
				<button type="submit" class="btn btn-template-outlined" name='Salvar' value='Salvar'> Salvar</button>
			  </div>
			</form>
		  </div>
		</div>				
	  </div>	  
	</div>

</div>
