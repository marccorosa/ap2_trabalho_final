
<?php	
//arquivos de dependências
require_once '..\cabecalho_geral.php';


$resultado= Produto::listar(); //pesquisa por parâmetro utilizando as variáveis inicializadas

$gru_codigo = isset($_GET['gru_codigo']) ? $_GET['gru_codigo'] : null;
$grupos= Grupo::listar();


if (($_SESSION["login"]=="ninguem_logado") OR ($_SESSION["login"]!="admin")){
	$pagina_produto="exibir";       				//variavel que controla qual pagina o usuario sera direcionado conforme seu tipo de usuario
}
if ($_SESSION["login"]=="admin"){
	$pagina_produto="alterar";       		
}


//condição de pressionar o botão Pesquisar
if (isset($_GET['Pesquisar'])) {
	
	//armazena valor dos campos HTML dos filtros em variáveis
	$gru_codigo = isset($_GET['gru_codigo']) ? $_GET['gru_codigo'] : null;
	$filtro_valor_max = isset($_GET['filtro_valor_max']) ? $_GET['filtro_valor_max'] : null;
	$filtro_descricao = isset($_GET['filtro_descricao']) ? $_GET['filtro_descricao'] : null;
		
	//atribui a variavel $resultado ao resultado da busca, sendo enviado os valores dos filtros por parâmetro	
	$resultado= Produto::listar(null,$filtro_descricao,$gru_codigo,$filtro_valor_max); //pesquisa por parâmetro utilizando as variáveis inicializadas	
	
}

?>

<title>Universal - Loja</title>	
<div id="all">
  <!-- Header com o nome da seção do site-->
  <div id="heading-breadcrumbs">
	<div class="container">
	  <div class="row d-flex align-items-center flex-wrap">
		<div class="col-md-7">
		  <h1 class="h2">Loja</h1>
		</div>
		<div class="col-md-5">
		</div>
	  </div>
	</div>
  </div>
  
  <div id="content">		  
	<div class="container">
	  <div class="row bar">
		<div class="col-md-3">
		  <!-- Filtros-->
		  <form method="GET">
			  <div class="panel panel-default sidebar-menu">
				<div class="panel-heading">
				  <h3 class="h4 panel-title">Filtros</h3>
				</div>
				<div class="panel-body">
				  <ul name='categorias' id='categorias' class="nav nav-pills flex-column text-sm category-menu">	
				  
					<!-- Filtro por nome-->
					<div class="form-group">
						<h3 class="h4 panel-title">Nome</h3>
						<input name="filtro_descricao" type="text" class="form-control">
					</div>
					
					<!-- Filtro por categoria-->
					<p></p>
					<h3 class="h4 panel-title">Categoria</h3>
					<select class="h4 panel-title" name='gru_codigo' id='gru_codigo'>
						<option value=0>Tudo</option>
						<!-- itera dentro de cada valor no vetor de grupos, que são as categorias de produtos-->
						<?php foreach($grupos as $chave): ?>
						<!-- utilizando o codigo de categorias como indice de cada option do select, printa o nome de cada categoria dentro de cada option -->
						<option value='<?= $chave["gru_codigo"] ?>' <?php if ($gru_codigo==$chave["gru_codigo"]) echo 'SELECTED'; ?>><?= $chave["gru_descricao"]?></option>					
						<?php endforeach; ?>
					</select>		
					
					<!-- Filtro por valor -->
					<p></p>
					<div class="form-group">
						<h3 class="h4 panel-title">Valor Máximo</h3>
						<input name="filtro_valor_max" type="text" class="form-control">
					</div>
					
				  </ul>
				</div>
				
				<!--Botão pesquisar-->
				<p></p>
				<div class="text-center">
					<button type="submit" class="btn-template-outlined" name='Pesquisar' value='Pesquisar'> Pesquisar</button>
				</div>		
					
			  </div>	  
			</form>
		</div>
		<div class="col-md-9">        
		  <div class="row products products-big">	
		  
		  	<!--Exibição dos produtos-->
			<?php foreach($resultado as $chave): ?>    	 <!--itera sobre cada produto no banco de dados, obedecendo aos filtros-->
				 <div class="col-lg-4 col-md-6">
				   <div class="product">
				     <p>
					 <a href="/pedidos/view/produto/<?php echo $pagina_produto?>.php?codigo=<?= $chave["pro_codigo"] ?>">
					 <div class="image" ><img src="../../img/<?= $chave["pro_imagem"] ?>" alt="" class="img-fluid image1"></div>
					 </a>
					 </p>
					 <div class="text">
					   <h3 class="h5">					
						<!--nomeia os produtos e define destino do usuario ao clicar no produto conforme tipo de usuario-->	
					   <a href="/pedidos/view/produto/<?php echo $pagina_produto?>.php?codigo=<?= $chave["pro_codigo"] ?>"><?= $chave["pro_descricao"] ?>  
					   </h3>   
					   <p class="price"><a>R$ <?= $chave["pro_valor"] ?></a></p>									 <!--preço de cada produto-->
					 </div>					 
					 
				   </div>
			 	 </div>
			<?php endforeach; ?>	
			
		  </div>		  
		</div>
	  </div>
	</div>
  </div>      
</div>

<?php
	require_once '..\rodape_geral.php';
?>