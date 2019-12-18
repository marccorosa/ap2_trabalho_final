<?php	
require_once '..\cabecalho_geral.php';
$mensagem= "";

$pro_codigo= isset($_GET['codigo'])?$_GET['codigo']:null;  // obtem o codigo do produto

//ao clicar no botão adicionar ao carrinho
if (isset($_POST['Carrinho'])) {
	
	//inicializa vetor do carrinho, caso ja não esteja inicializado
	if(!isset($_SESSION["carrinho"])){
		$_SESSION["carrinho"]=array();
	}
	
	//faz um push com o codigo do produto em um vetor global, para saber quais produtos estão no carrinho de compras
	if (in_array($pro_codigo, $_SESSION["carrinho"])){   //se o produto ja esta no carrinho
		echo "<script>
            alert('Só é permitido uma unidade por pedido!');
            </script>";
	}
	else{
		array_push($_SESSION["carrinho"], $pro_codigo);  //adicona item ao vetor do carrinho
		
		//alert box adicionado ao carrinho
		echo "<script>
            alert('Item adicionado ao carrinho!');
            </script>";
	}
		
}

//salvar alterações
if (isset($_POST['Salvar'])) {
	$pro_codigo= isset($_POST['pro_codigo'])?$_POST['pro_codigo']:null;
    $pro_descricao= isset($_POST['pro_descricao'])?$_POST['pro_descricao']:null;
	$pro_codigo_barras= isset($_POST['pro_codigo_barras'])?$_POST['pro_codigo_barras']:null;
	$pro_valor= isset($_POST['pro_valor'])?$_POST['pro_valor']:null;
	$gru_codigo= isset($_POST['gru_codigo'])?$_POST['gru_codigo']:null;
	$pro_imagem= isset($_POST['pro_imagem'])?$_POST['pro_imagem']:null;
	$pro_promocao= isset($_POST['pro_promocao'])?$_POST['pro_promocao']:null;
		
		
if(($pro_descricao!=null) && ($pro_codigo_barras!=null) && ($pro_valor!=null)){
	$produto = new Produto();
	$produto->setPro_codigo($pro_codigo);
	$produto->setPro_descricao($pro_descricao);
	$produto->setPro_codigo_barras($pro_codigo_barras);
	$produto->setPro_valor($pro_valor);
	$produto->setGru_codigo($gru_codigo);
	$produto->setPro_imagem($pro_imagem);
	$produto->setPro_promocao($pro_promocao);
	$resultado= $produto->alterar();
	
	$mensagem = "Alterações salvas com sucesso!";
}
else{
	$mensagem = "Erro ao salvar alterações";
}

}	

$resultado= Produto::listar($pro_codigo,null,null,null);  //armazena dados do produto em um vetor, usando o codigo do produto como paramentro

$pro_descricao= isset($resultado[0]["pro_descricao"])?$resultado[0]["pro_descricao"]:null;
$pro_codigo_barras= isset($resultado[0]["pro_codigo_barras"])?$resultado[0]["pro_codigo_barras"]:null;
$pro_valor= isset($resultado[0]["pro_valor"])?$resultado[0]["pro_valor"]:null;
$gru_codigo= isset($resultado[0]["gru_codigo"])?$resultado[0]["gru_codigo"]:null;
$pro_imagem= isset($resultado[0]["pro_imagem"])?$resultado[0]["pro_imagem"]:null;
$pro_promocao= isset($resultado[0]["pro_promocao"])?$resultado[0]["pro_promocao"]:null;

$grupos= Grupo::listar();

?>

<title>Produto</title>

  <div id="heading-breadcrumbs">
	<div class="container">
	  <div class="row d-flex align-items-center flex-wrap">
		<div class="col-md-7">
		  <h1 class="h2">Alterar dados de Produto</h1>
		</div>		
	  </div>
	</div>
  </div>

<div class="container">
  <div class="row bar">
	<!-- LEFT COLUMN _____________-->
	<div class="col-lg-9">            
	  <div class="row">
		<div class="col-sm-6">
		
		<form method="POST">
		<div> <img src="../../img/<?= $pro_imagem ?>" alt="" class="img-fluid"></div>
		<p></p> 
		 <h3>Imagem do Produto</h3>		
			<div class="form-group">						
			  <input type='file' name='pro_imagem' id='pro_imagem' value="<?= $pro_imagem ?>">
			</div>
			<p></p> 
		
		</div>			
		<div class="col-sm-6">
		  <div class="box">
			  
		  			
			<input type='hidden' name='pro_codigo' id='pro_codigo' value="<?= $pro_codigo ?>"><br />
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
			
			<h3>Código de Barras</h3>		  
			<div class="form-group">						
			  <input type='text' name='pro_codigo_barras' id='pro_codigo_barras' class="form-control" value='<?= $pro_codigo_barras ?>'>
			  <span class="newComer text-center"><?= $mensagem ?></span>
			</div>	
			
			<div class="text-center">
			  <button type="submit" class="btn btn-template-outlined" name='Salvar' value='Salvar'>Salvar</button>
			</div>		
			
			<p></p>
			<div class="text-center">
			  <button type="submit" class="btn btn-template-outlined" name='Carrinho' value='Carrinho'>Adicionar ao Carrinho</button>
			</div>		
					
		  </form>
			  
		  </div>						  
		</div>				
	  </div>			  
	</div>
  </div>
</div>   
     

