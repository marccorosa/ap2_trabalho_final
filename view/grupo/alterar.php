<?php	
//arquivos de dependências
require_once '..\cabecalho_geral.php';

$mensagem= "";

if (isset($_POST['Salvar'])) {
    $gru_codigo= isset($_POST['gru_codigo'])?$_POST['gru_codigo']:null;
    $gru_descricao= isset($_POST['gru_descricao'])?$_POST['gru_descricao']:null;
    $gru_ativo= isset($_POST['gru_ativo'])?$_POST['gru_ativo']:null;
    
    $grupo= new Grupo();
    $grupo->setGru_codigo($gru_codigo);
    $grupo->setGru_descricao($gru_descricao);
    $grupo->setGru_ativo($gru_ativo);
    $resultado= $grupo->alterar();
    
    if (is_array($resultado))
        $mensagem= "Erro: ".$resultado[0].$resultado[2];
	
}	

$gru_codigo= isset($_GET['codigo'])?$_GET['codigo']:null;
$resultado= Grupo::listar($gru_codigo);

$gru_descricao= isset($resultado[0]["gru_descricao"])?$resultado[0]["gru_descricao"]:null;
$gru_ativo= isset($resultado[0]["gru_ativo"])?$resultado[0]["gru_ativo"]:null;
?> 

<title>Universal - Categoria de Produto</title>
<div id="all">   
  <div id="heading-breadcrumbs">
	<div class="container">
	  <div class="row d-flex align-items-center flex-wrap">
		<div class="col-md-7">
		  <h1 class="h2">ALTERAR CATEGORIAS DE PRODUTOS</h1>
		</div>
	  </div>
	</div>
  </div>

	<div class="container">
	  <div class="row">		
		<div class="col-lg-6">
		  <div class="box">           
			<form method="POST">
			  <input type='hidden' name='gru_codigo' id='gru_codigo' value="<?= $gru_codigo ?>"><br />
			  <div class="row">
			   <div class="col-lg-6">
			  <h5 class="text-uppercase">Descrição</h5>
			  <input type='text' name='gru_descricao' id='gru_descricao' value='<?= $gru_descricao ?>'>
			  </div>
			  <div class="col-lg-6">
			  <h5 class="text-uppercase">Ativa</h5>             
			  <select class="h4 panel-title" name='gru_ativo' id='gru_ativo'>
        			<option value='S' <?php if ($gru_ativo=='S') echo 'SELECTED'; ?>>Sim</option>
        			<option value='N' <?php if ($gru_ativo=='N') echo 'SELECTED'; ?>>Não</option>
        		</select>
			  </div>
			  </div>
						  		  
			  <div>
				<?= $mensagem ?>
			  </div>
			  
			  <p></p>
			  <div class="text-center">
				<button type="submit" class="btn btn-template-outlined" name='Salvar' value='Salvar'> Salvar</button>
			  </div>
			  <p></p>
			  
			  
			</form>
			<div class="text-center">
				<a href="/pedidos/view/grupo/listar.php"> Voltar</a>
			</div>
		  </div>
		</div>				
	  </div>	  
	</div>

</div>
