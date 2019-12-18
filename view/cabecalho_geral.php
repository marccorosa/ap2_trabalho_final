<!-- Dependências dos estilos-->
<?php
require_once '..\Session.php';
require_once '..\..\model\Produto.php';
require_once '..\..\model\Grupo.php';
require_once '..\..\model\Usuario.php';
require_once '..\..\model\Pedido.php';
require_once '..\..\database\Database.php';

?>

<!-- Dependências dos estilos-->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="all,follow">
<!-- Bootstrap CSS-->
<link rel="stylesheet" href="/pedidos/vendor/bootstrap/css/bootstrap.min.css">
<!-- Font Awesome CSS-->
<link rel="stylesheet" href="/pedidos/vendor/font-awesome/css/font-awesome.min.css">
<!-- Bootstrap Select-->
<link rel="stylesheet" href="/pedidos/vendor/bootstrap-select/css/bootstrap-select.min.css">
<!-- owl carousel-->
<link rel="stylesheet" href="/pedidos/vendor/owl.carousel/assets/owl.carousel.css">
<link rel="stylesheet" href="/pedidos/vendor/owl.carousel/assets/owl.theme.default.css">
<!-- theme stylesheet-->
<link rel="stylesheet" href="/pedidos/css/style.default.css" id="theme-stylesheet">
<!-- Custom stylesheet - for your changes-->
<link rel="stylesheet" href="/pedidos/css/custom.css">
<!-- Javascript files-->
<script src="/pedidos/vendor/jquery/jquery.min.js"></script>
<script src="/pedidos/vendor/popper.js/umd/popper.min.js"></script>
<script src="/pedidos/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/pedidos/vendor/jquery.cookie/jquery.cookie.js"></script>
<script src="/pedidos/vendor/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="/pedidos/vendor/jquery.counterup/jquery.counterup.min.js"></script>
<script src="/pedidos/vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="/pedidos/vendor/owl.carousel2.thumbs/owl.carousel2.thumbs.min.js"></script>
<script src="/pedidos/js/jquery.parallax-1.1.3.js"></script>
<script src="/pedidos/vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="/pedidos/vendor/jquery.scrollto/jquery.scrollTo.min.js"></script>
<script src="/pedidos/js/front.js"></script>	

<style>
.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    padding: 12px 16px;
    z-index: 1;
}

.dropdown:hover .dropdown-content {
    display: block;
}
</style>
     
	 <div id="all">
      
	  <!-- Top bar-->
      <div class="top-bar">
        <div class="container">
          <div class="row d-flex align-items-center">
            <div class="col-md-6 d-md-block d-none">
			
			  <!-- Exibe qual usuario esta atualmente logado -->
              <p><?php if($_SESSION["login"]=="ninguem_logado"){echo "";}else {echo "Bem vindo, ". $_SESSION["login"];} ?></p>
            </div>
            <div class="col-md-6">
              <div class="d-flex justify-content-md-end justify-content-between">
                <ul class="list-inline contact-info d-block d-md-none">
                  <li class="list-inline-item"><a href="#"><i class="fa fa-phone"></i></a></li>
                  <li class="list-inline-item"><a href="#"><i class="fa fa-envelope"></i></a></li>
                </ul>
				
				<!-- ========== Cabeçalho superior, botão de Login. Se ninguem estiver logado ==================-->	
				<?php 
				if($_SESSION["login"] == "ninguem_logado"){	
					echo '<div class="login"><a href="/pedidos/view/usuario/incluir.php" class="signup-btn"><i class=" fa fa-sign-in"></i><span class="d-none d-md-inline-block">Login</span></a><a href="/pedidos/view/usuario/incluir.php" class="signup-btn"><i class="fa fa-user"></i><span class="d-none d-md-inline-block">Criar Conta</span></a></div>';           
				};
				?>
				
				<!-- ========== Cabeçalho superior, botão de Logoff. Se admin ou usuário comum estiver logado ==================-->	
				<?php 
				if(($_SESSION["login"] == "admin") OR ($_SESSION["login"] != "ninguem_logado") ){		
					echo '<div class="login"><a href="/pedidos/view/usuario/alterar.php" class="signup-btn"><i class=" fa fa-sign-in"></i><span class="d-none d-md-inline-block">Logoff</span></a><a href="/pedidos/view/usuario/incluir.php" class="signup-btn"><i class="fa fa-user"></i><span class="d-none d-md-inline-block">Criar Conta</span></a></div>';           
				};
				?>
				
			  </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Top bar end-->
      <!-- Login Modal-->
      <div id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modalLabel" aria-hidden="true" class="modal fade">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 id="login-modalLabel" class="modal-title">Login do usuário</h4>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
          </div>
        </div>
      </div>
      <!-- Login modal end-->
      <!-- Navbar Start-->
        <div id="navbar" role="navigation" class="navbar navbar-expand-lg">
          <div class="container"><a href="/pedidos/view/produto/listar.php" class="navbar-brand home"><img src="/pedidos/img/logo.png" alt="Universal logo" class="d-none d-md-inline-block"><img src="/pedidos/img/logo-small.png" alt="Universal logo" class="d-inline-block d-md-none"><span class="sr-only">Universal - go to homepage</span></a>
            <div id="navigation" class="navbar-collapse collapse">
              <ul class="nav navbar-nav ml-auto">
				<!-- ========== Loja botão ==================-->
				<li class="nav-item"><a href="/pedidos/view/produto/listar.php">Loja <b class="caret"></b></a></li>		    
				<!-- ========== Loja botão fim==================-->				
                
				
				<!-- ========== Se for admnistrador ==================-->	
				<?php 
				if($_SESSION["login"] == "admin"){					
					//<!-- ========== Cliente dropdown ==================-->			
					echo '<li class="dropdown"><a class="dropdown-toggle">Cliente</a>';
					  echo '<ul class="dropdown-content">';
							echo '<li class="dropdown-item"><a href="/pedidos/view/usuario/alterar.php" class="nav-link">Dados do usuário</a></li>';
							echo '<li class="dropdown-item"><a href="/pedidos/view/pedido/listar.php" class="nav-link">Pedidos</a></li>';
							echo '<li class="dropdown-item"><a href="/pedidos/view/pedido/incluir.php" class="nav-link">Carrinho de compras</a></li>';
					  echo '</ul>';
					 echo '</li>';
					//<!-- ========== Cliente dropdown fim ==================-->
					//<!-- ========== Admin dropdown ==================-->
					echo '<li class="dropdown"><a  class="dropdown-toggle">Admin</a>';
					  echo '<ul class="dropdown-content">';
							echo '<li class="dropdown-item"><a href="/pedidos/view/grupo/incluir.php" class="nav-link">Criar categorias</a></li>';
							echo '<li class="dropdown-item"><a href="/pedidos/view/grupo/listar.php" class="nav-link">Listar categorias</a></li>';
							echo '<li class="dropdown-item"><a href="/pedidos/view/grupo/alterar.php" class="nav-link">Alterar categorias</a></li>';
							echo '<li class="dropdown-item"><a href="/pedidos/view/produto/incluir.php" class="nav-link">Criar produto</a></li>';
					  echo '</ul>';
					echo '</li>';
					//<!-- ========== Admin dropdown fim ==================-->							
				};
				?>
				
				<!-- ========== Se for usuario comum ==================-->	
				<?php 
				if(($_SESSION["login"] != "admin") && ($_SESSION["login"] != "ninguem_logado") ){				
					//<!-- ========== Cliente dropdown ==================-->			
					echo '<li class="dropdown"><a class="dropdown-toggle">Cliente</a>';
					  echo '<ul class="dropdown-content">';
							echo '<li class="dropdown-item"><a href="/pedidos/view/usuario/alterar.php" class="nav-link">Dados do usuário</a></li>';
							echo '<li class="dropdown-item"><a href="/pedidos/view/pedido/listar.php" class="nav-link">Pedidos</a></li>';
							echo '<li class="dropdown-item"><a href="/pedidos/view/pedido/incluir.php" class="nav-link">Carrinho de compras</a></li>';
					  echo '</ul>';
					 echo '</li>';
					//<!-- ========== Cliente dropdown fim ==================-->							
				};
				?>
				
              </ul>
            </div>
          </div>
        </div>
 
    </div>
