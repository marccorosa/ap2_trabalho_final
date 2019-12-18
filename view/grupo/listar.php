<?php	
require_once '..\cabecalho_geral.php';

$gru_descricao= isset($_POST['gru_descricao'])?$_POST['gru_descricao']:null;
$gru_ativo= isset($_POST['gru_ativo'])?$_POST['gru_ativo']:null;
$resultado= Grupo::listar($gru_descricao, $gru_ativo);

if (isset($_GET['Pesquisar'])) {
	
	$filtro_descricao = isset($_GET['filtro_descricao'])?$_GET['filtro_descricao']:null;
	$gru_ativo = isset($_GET['gru_ativo'])?$_GET['gru_ativo']:null;
		
	$resultado= Grupo::listar($filtro_descricao,$gru_ativo); 
	
}

?>

<div id="all">
      <div id="heading-breadcrumbs">
        <div class="container">
          <div class="row d-flex align-items-center flex-wrap">
            <div class="col-md-7">
              <h1 class="h2">Listar Categorias</h1>
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
						<h3 class="h4 panel-title">Categoria</h3>
						<input name="filtro_descricao" id='filtro_descricao' type="text" class="form-control">
					</div>
					
					<!-- Filtro por categoria-->
					<p></p>
					<h3 class="h4 panel-title">Ativo</h3>
					<select class="h4 panel-title" name='gru_ativo' id='gru_ativo'>
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
                          <th>Categoria</th>
                          <th>Ativo</th>    
						  <th>Alterar</th>  						  
                        </tr>
                      </thead>
					  
                      <tbody>
					  <?php foreach($resultado as $chave): ?>
                        <tr>
                          <td><?= $chave["gru_descricao"] ?></td>                         
                          <td><?= $chave["gru_ativo"] ?></td>
                          <td><a href='alterar.php?codigo=<?= $chave["gru_codigo"] ?>'><img src="../../img/editar.png" width="20" title="Alterar" /></a></td>
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


