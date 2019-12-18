

<?php	
//arquivos de dependências
require_once '..\cabecalho_geral.php';

$mensagem= "";

$pro_valor= isset($_POST['pro_valor'])?$_POST['pro_valor']:null;
$pro_descricao= isset($_POST['pro_descricao'])?$_POST['pro_descricao']:null;
$pro_codigo_barras= isset($_POST['pro_codigo_barras'])?$_POST['pro_codigo_barras']:null;
$gru_codigo = isset($_POST['gru_codigo']) ? $_POST['gru_codigo'] : null;
$pro_imagem = isset($_POST['pro_imagem']) ? $_POST['pro_imagem'] : null;
$pro_promocao = isset($_POST['pro_promocao']) ? $_POST['pro_promocao'] : null;

if (isset($_POST['Salvar'])) {
	$produto = new Produto();
	$produto->setPro_codigo_barras($pro_codigo_barras);
	$produto->setPro_descricao($pro_descricao);
	$produto->setPro_valor($pro_valor);
	$produto->setGru_codigo($gru_codigo);
	$produto->setPro_imagem($pro_imagem);
	$produto->setPro_promocao($pro_promocao);
	$resultado= $produto->incluir();
	
	if (is_array($resultado)){
		$mensagem= "Erro: ".$resultado[0].$resultado[2];
	}else{
		echo 'Item criado!';		
	}
		
}	


$grupos= Grupo::listar(null, null);
	
?>

<title>Produto</title>

  <div id="heading-breadcrumbs">
	<div class="container">
	  <div class="row d-flex align-items-center flex-wrap">
		<div class="col-md-7">
		  <h1 class="h2">Criar Produto</h1>
		</div>		
	  </div>
	</div>
  </div>

<div class="container">
  <div class="row bar">
	
	<div class="col-lg-9">            
	  <div class="row">
		<div class="col-sm-6">
		
		<form method="POST">		

		<div> <img src="../../img/<?= $pro_imagem ?>" alt="" class="img-fluid"></div>	 
		<p></p> 
		 <h3>Imagem do Produto</h3>		
			<div class="form-group">						
			  <input type='file' accept="image/*" name='pro_imagem' id='pro_imagem' value='<?= $pro_imagem ?>'>
			</div>
			<p></p> 
		  		  
		</div>			
		<div class="col-sm-6">
		  <div class="box">
			  
		  										
			<div class="sizes">
				<h3>Categoria</h3>
				<select name='gru_codigo' id='gru_codigo'  >
    		      	<?php foreach($grupos as $chave): ?>
        			<option value='<?= $chave["gru_codigo"] ?>' <?php if ($gru_codigo==$chave["gru_codigo"]) echo 'SELECTED'; ?>><?= $chave["gru_descricao"]?></option>
    	        	<?php endforeach; ?>
        		</select>	
				<p></p> 																		
			</div>	
						
						
						
			<h3>Descrição do Produto</h3>		
			<div class="form-group">						
			  <input type='text' name='pro_descricao' id='pro_descricao' class="form-control" value='<?= $pro_descricao ?>'>
			</div>
			<p></p> 	
			
			<h3>Valor</h3>		  
			<div class="form-group">						
			  <input type='text' name='pro_valor' id='pro_valor' class="form-control" value='<?= $pro_valor ?>'>
			</div>	
			<p></p> 	
			
			<h3>Promoção</h3>		  
			<div class="form-group">						
			  <input type='text' name='pro_promocao' id='pro_promocao' class="form-control" value='<?= $pro_promocao ?>'>
			</div>	
			<p></p> 
			
			<h3>Código de Barras</h3>		  
			<div class="form-group">						
			  <input type='text' name='pro_codigo_barras' id='pro_codigo_barras' class="form-control" value='<?= $pro_codigo_barras ?>'>
			</div>	
			
			<div id='mensagem'>
			   <?= $mensagem ?>
			</div>
			
			<div class="text-center">
			  <button type="submit" class="btn btn-template-outlined" name='Salvar' value='Salvar'>Salvar</button>
			</div>									
					
		  </form>
			  
		  </div>						  
		</div>				
	  </div>			  
	</div>
  </div>
</div>   
     

