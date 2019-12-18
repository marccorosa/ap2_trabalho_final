<?php	
	
//arquivos de dependências
require_once '..\cabecalho_geral.php';
$mensagem= "";

//verifica qual o tipo de usuario para saber qual pagina o usuario sera redirecionado caso clique em um produto
if ($_SESSION["login"]!="admin"){
	$pagina_produto="exibir";       //variavel que controla qual pagina o usuario sera direcionado conforme seu tipo de usuario
}
if ($_SESSION["login"]=="admin"){
	$pagina_produto="alterar";       		
}

//inicializa variavel de valor total do pedido
if(!isset($valor_total)){
	$valor_total = 0;
}

//vetor que contem codigos dos produtos que estão no carrinho
if(isset($_SESSION["carrinho"])){
	$vetor_carrinho=$_SESSION["carrinho"];
}

if (isset($_POST['Finalizar'])) {
	//se tem algo no carrinho
	if (isset($_SESSION['carrinho'])) {
		$usu_login = $_SESSION["login"] ;
		$ped_entregue = "N";
		$ped_data=isset($_POST['ped_data'])?$_POST['ped_data']:null;
		$valor_total=isset($_POST['valor_total'])?$_POST['valor_total']:null;
		
		$pedido = new Pedido();
		$pedido->setUsu_login($usu_login);
		$pedido->setPed_entregue($ped_entregue);
		$pedido->setPed_data($ped_data);
		$pedido->setValor_total($valor_total);
		
		$resultado= $pedido->incluir();
		
		//insere dados na tabela item_pedido
		$item_pedido= Pedido::listar_ultimo($usu_login);
		foreach ($_SESSION["carrinho"] as $chave){
			$ped_numero=$item_pedido;
			$pro_codigo=$chave;
			
			$pedido = new Pedido();
			$pedido->setPed_numero($ped_numero);
			$pedido->setPro_codigo($pro_codigo);
					
			$resultado_item_pedido= $pedido->incluir_item_pedido();
			
		}
		
		//erros sbore a inserção na tabela item_pedido
		if (is_array($resultado_item_pedido)){
			$mensagem= "Erro: ".$resultado_item_pedido[0].$resultado_item_pedido[2];
		}else{
			$mensagem= 'Pedido criado!';		
		}
		
		//erros sbore a inserção na tabela pedido
		if (is_array($resultado)){
			$mensagem= "Erro: ".$resultado[0].$resultado[2];
		}else{
			$mensagem= 'Pedido criado!';		
		}
		
		//exclui dados do vetor do carrinho
		$_SESSION["carrinho"]=null;
		
		//script que exibe caixa de mensagem com confirmação de compra
		echo "<script>
            alert('Pedido realizado com sucesso!');
            </script>";
		
		//script para recarregar a pagina
		$page = "/pedidos/view/pedido/incluir.php";
		echo '<script type="text/javascript">';
		echo 'window.location.href="'.$page.'";';
		echo '</script>';	
		
	}
}

//exclui um produto do carrinho, caso seu botão correspondente seja apertado
if(isset($_SESSION["carrinho"])){
	foreach ($_SESSION["carrinho"] as $value) {
		if (isset($_POST[$value])) {     //verifica se o botão de excluir com o nome $value foi apertado
			$_SESSION["carrinho"] = array_diff($_SESSION["carrinho"], [$value]); 
			//script para recarregar a pagina
			$page = "/pedidos/view/pedido/incluir.php";
			echo '<script type="text/javascript">';
			echo 'window.location.href="'.$page.'";';
			echo '</script>';
			
			$valor_total=0;
		}
	}
}
?>

    <div id="all">
      <div id="heading-breadcrumbs">
        <div class="container">
          <div class="row d-flex align-items-center flex-wrap">           
              <h1 class="h2">Carrinho de compras</h1>           
          </div>
        </div>
      </div>
      <div id="content">
        <div class="container">
          <div class="row bar">
            <div id="basket" class="col-lg-9">
              <div class="box mt-0 pb-0 no-horizontal-padding">
                <form method="POST">
                    <table class="table">
                      <thead>
                        <tr>
                          <th >Produto</th>
                          <th>Preço da unidade</th>
						  <th>Excluir</th>
                        </tr>
                      </thead>
                      <tbody>		
						<?php if(isset($_SESSION["carrinho"])){ ?>   <!--verifica se tem items no carrinho-->
							<?php foreach($vetor_carrinho as $pro_codigo): $resultado= Produto::listar($pro_codigo) ?>						 
								<?php foreach($resultado as $chave): ?>    	 <!--itera sobre cada produto no banco de dados-->
									<tr>						
										<td><a href="/pedidos/view/produto/<?php echo $pagina_produto?>.php?codigo=<?= $chave["pro_codigo"] ?>"><?= $chave["pro_descricao"] ?></a></td>
										<td><a>R$ <?= $chave["pro_valor"]; $valor_total=$valor_total+$chave["pro_valor"] ?></a></td>    									
										<td><button name="<?=$chave["pro_codigo"];?>" ><i class="fa fa-trash-o"></i></button></td>									
									</tr>
								<?php endforeach; ?>							
							<?php endforeach; ?>							
						<?php } ?>	
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>Total</th>
                          <th>R$ <?=$valor_total?></th>
						  <input name="valor_total" type="hidden" value=<?=$valor_total?>></input><!--hidden input para passar valor total-->
						  
                        </tr>
                      </tfoot>
                    </table>
					<div class="form-group">	
						<a>Data de entrega:</a>
						<input name="ped_data" type="date">
					</div>                  
					<div class="box-footer d-flex justify-content-between align-items-center">
                    <div class="left-col"><a href="/pedidos/view/produto/listar.php" class="btn btn-secondary mt-0"><i class="fa fa-chevron-left"></i> Continue comprando</a></div>                				
					<div class="right-col">
					  <button value="Finalizar" name="Finalizar" type="submit" class="btn btn-template-outlined">Finalizar pedido</button>
					</div>
				</form>	
                  </div>
                
              </div>       
			  
            </div>        
          </div>
        </div>
      </div>      
    </div>

