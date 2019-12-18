<?php	
//arquivos de dependências
require_once '..\cabecalho_geral.php';

$usu_login=$_SESSION["login"];

if($usu_login=="admin"){
	$resultado= Pedido::listar();
}
else{
	$resultado= Pedido::listar($usu_login,null);
}

//condição de pressionar o botão Pesquisar
if (isset($_GET['Pesquisar'])) {
	
	//armazena valor dos campos HTML dos filtros em variáveis
	$login_usuario = isset($_GET['login_usuario']) ? $_GET['login_usuario'] : null;
	$ped_entregue = isset($_GET['ped_entregue']) ? $_GET['ped_entregue'] : null;
		
	//atribui a variavel $resultado ao resultado da busca, sendo enviado os valores dos filtros por parâmetro	
	$resultado= Pedido::listar($login_usuario,$ped_entregue); //pesquisa por parâmetro utilizando as variáveis inicializadas	
	
}


?>

<div id="all">
      <div id="heading-breadcrumbs">
        <div class="container">
          <div class="row d-flex align-items-center flex-wrap">
            <div class="col-md-7">
              <h1 class="h2">Listar Pedidos</h1>
            </div>
          </div>
        </div>
      </div>
      <div id="content">
        <div class="container">
          <div class="row bar">
		  
		  <!---------------------------- Filtros------------------------------>
		  <div class="col-md-3">
		  <form method="GET">
			  <div class="panel panel-default sidebar-menu">
				<div class="panel-heading">
				  <h3 class="h4 panel-title">Filtros</h3>
				</div>
				<div class="panel-body">
				  <ul name='categorias' id='categorias' class="nav nav-pills flex-column text-sm category-menu">	
				  
					<!-- Filtro por nome-->
					<div class="form-group">
						<h3 class="h4 panel-title">Usuário</h3>
						<input name="login_usuario" type="text" class="form-control">
					</div>
					
					<!-- Filtro por categoria-->
					<p></p>
					<h3 class="h4 panel-title">Entregue</h3>
					<select class="h4 panel-title" name='ped_entregue' id='ped_entregue'>
						<option value="">Tudo</option>
						<option value="N">NÂO</option>
						<option value="S">SIM</option>
					</select>						
					
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
		<!---------------------------- Filtros, FIM----------------------------->
		
            <div id="basket" class="col-lg-9">
              <div class="box mt-0 pb-0 no-horizontal-padding">           
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
					  
                        <tr>
						  <th>Usuário</th>	
                          <th>Data</th>
                          <th>Entregue</th>    
						  <th>Valor Total</th>  
						  <th>Página do Pedido</th>  						  
                        </tr>
                      </thead>
					  
                      <tbody>
					  <?php foreach($resultado as $chave): ?>
                        <tr>
						  <td><?= $chave["usu_login"] ?></td>  
                          <td><?= $chave["ped_data"] ?></td>                         
                          <td><?= $chave["ped_entregue"] ?></td>
						  <td>R$ <?= $chave["valor_total"] ?></td>
                          <td><a href='exibir.php?ped_numero=<?= $chave["ped_numero"] ?>&ped_data=<?= $chave["ped_data"] ?>&ped_entregue=<?= $chave["ped_entregue"] ?>&valor_total=<?= $chave["valor_total"] ?>'><img src="../../img/imprimir.png" width="20" title="Exibir" /></a></td>
                        </tr>
						<?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>              
              </div>              
            </div>          
          </div>
        </div>
      </div>  
    </div>


