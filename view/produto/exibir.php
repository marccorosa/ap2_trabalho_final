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
		$mensagem = "Só é permitido uma unidade por pedido!";
	}
	else{
		array_push($_SESSION["carrinho"], $pro_codigo); 
		$mensagem = 'Item adicionado ao carrinho';
	}
		
}

$resultado= Produto::listar($pro_codigo,null,null,null);  //armazena dados do produto em um vetor, usando o codigo do produto como paramentro

$pro_descricao= isset($resultado[0]["pro_descricao"])?$resultado[0]["pro_descricao"]:null;
$pro_codigo_barras= isset($resultado[0]["pro_codigo_barras"])?$resultado[0]["pro_codigo_barras"]:null;
$pro_valor= isset($resultado[0]["pro_valor"])?$resultado[0]["pro_valor"]:null;
$gru_codigo= isset($resultado[0]["gru_codigo"])?$resultado[0]["gru_codigo"]:null;
$pro_imagem= isset($resultado[0]["pro_imagem"])?$resultado[0]["pro_imagem"]:null;
$pro_promocao= isset($resultado[0]["pro_promocao"])?$resultado[0]["pro_promocao"]:null;

//função que retorna dados do grupo do produto selecionado
$grupos= Grupo::listar($gru_codigo);

//retorna descrição do grupo
$gru_descricao=$grupos[0]["gru_descricao"];


?>

<title>Produto</title>

  <div id="heading-breadcrumbs">
	<div class="container">
	  <div class="row d-flex align-items-center flex-wrap">
		<div class="col-md-7">
		  <h1 class="h2">Dados do Produto</h1>
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

		<div> <img src="../../img/<?= $pro_imagem ?>" alt="" class="img-fluid"></div>
		  					  		  
		</div>			
		<div class="col-sm-6">
		  <div class="box">
			  
		  <form method="POST">			
			<input type='hidden' name='pro_codigo' id='pro_codigo' value="<?= $pro_codigo ?>"><br />

			<h3>Descrição do Produto</h3>											
			<a name='pro_descricao' id='pro_descricao'><?= $pro_descricao ?></a>				
			<p></p> 
			
			<h3>Categoria</h3>											
			<a name='gru_descricao' id='gru_descricao'><?= $gru_descricao ?></a>				
			<p></p> 
								
			<h3>Valor</h3>		  					
			<a name='pro_valor' id='pro_valor'>R$ <?= $pro_valor ?></a>
			<p></p> 	
			
			<h3>Promoção</h3>		  					
			<a name='pro_promocao' id='pro_promocao'><?= $pro_promocao ?></a>
			<p></p> 
			
			<h3>Código de Barras</h3>		  					
			<a name='pro_codigo_barras' id='pro_codigo_barras'><?= $pro_codigo_barras ?></a>
			<p></p> 
			
						  
		  </div>				
				  
		    <div class="text-center">
		       <?php if($_SESSION["login"]!="ninguem_logado"): ?> 
			   <?php echo "<button type='submit' class='btn btn-template-outlined' name='Carrinho' value='Carrinho'>Adicionar ao Carrinho</button>"; ?>
			   <?php endif; ?>		   			   
		    </div>
			<p></p> 
			<span class="newComer text-center"><?= $mensagem ?></span>
		  </form>		 
		  
		</div>		
		
	  </div>			  
	</div>
  </div>
</div>   
     

