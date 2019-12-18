<?php
require_once '..\cabecalho_geral.php';

$mensagem= "";

$usu_login = $_SESSION["login"];

if (isset($_POST['Logoff'])) {
	
    $_SESSION["login"] = "ninguem_logado";
	//redirect usando javascript
	$page = "/pedidos/view/produto/listar.php";
	echo '<script type="text/javascript">';
	echo 'window.location.href="'.$page.'";';
	echo '</script>';
	
}

if (isset($_POST['Salvar'])) {
	$usu_login = $_SESSION["login"];
    $usu_nome = isset($_POST['usu_nome']) ? $_POST['usu_nome'] : null;
    $usu_email = isset($_POST['usu_email']) ? $_POST['usu_email'] : null;
    $usu_senha = isset($_POST['usu_senha']) ? $_POST['usu_senha'] : null;
    $usu_senha_conf = isset($_POST['usu_senha_conf']) ? $_POST['usu_senha_conf'] : null;
    
    if ($usu_senha != $usu_senha_conf) {
        $mensagem= "Erro: a senha não está igual a confirmação da senha.";
    } 
	else 
	{
		
	$usuario = new Usuario();
	$usuario->setUsu_login($usu_login);
	$usuario->setUsu_nome($usu_nome);
	$usuario->setUsu_email($usu_email);
	$usuario->setUsu_senha($usu_senha);
	$resultado= $usuario->alterar();
	$mensagem="Alterações realizadas com sucesso";
        
        if (is_array($resultado))
		{
            $mensagem= "Erro: ".$resultado[0].$resultado[2];
		}
	}
}

$resultado= Usuario::listar($usu_login);

$usu_nome= isset($resultado[0]["usu_nome"])?$resultado[0]["usu_nome"]:null;
$usu_email= isset($resultado[0]["usu_email"])?$resultado[0]["usu_email"]:null;
$usu_senha= isset($resultado[0]["usu_senha"])?$resultado[0]["usu_senha"]:null;
$usu_senha_conf= isset($resultado[0]["usu_senha_conf"])?$resultado[0]["usu_senha_conf"]:null;

?>

<title>Universal - Login/Criar Conta</title>
<div id="all">   
  <div id="heading-breadcrumbs">
	<div class="container">
	  <div class="row d-flex align-items-center flex-wrap">
		<div class="col-md-7">
		  <h1 class="h2">DADOS DO USUÁRIO</h1>
		</div>
	  </div>
	</div>
  </div>
  <div id="content">
	<div class="container">
	  <div class="row">		
		<div class="col-lg-6">
		  <div class="box">           
			<form method="POST">
			  <div class="form-group">
				<label for="usu_login">Login</label>
				<input type='text' name='usu_login' id='usu_login' class="form-control" value='<?= $usu_login ?>'>
			  </div>
			  <div class="form-group">
				<label for="usu_nome">Nome</label>
				<input type='text' name='usu_nome' id='usu_nome'  class="form-control" value='<?= $usu_nome ?>'>
			  </div>
			  <div class="form-group">
				<label for="usu_email">Email</label>
				<input type='email' name='usu_email' id='usu_email' class="form-control" value='<?= $usu_email ?>'>
			  </div>
			  <div class="form-group">
				<label for="usu_senha">Senha</label>
				<input type='password' name='usu_senha' class="form-control" value='<?= $usu_senha ?>'>
			  </div>
			  <div class="form-group">
				<label for="usu_senha_conf">Cofirme a senha</label>
				<input type='password' name='usu_senha_conf' class="form-control" value='<?= $usu_senha ?>'>
			  </div>
			  
			  <div>
				<?= $mensagem ?>
			  </div>
			  
			  <div class="text-center">
				<button type="submit" class="btn btn-template-outlined" name='Salvar' value='Salvar'><i class="fa fa-user-md"></i> salvar alterações</button>
			  </div>
			  
			</form>
			
		  </div>
		</div>		
		
		<form method="POST">			
			  <div class="col-lg-18">		  
				<div class="box">   
				<h2 class="text-center">Logoff</h2>
				  <div class="text-center">
					<button type="submit" class="btn btn-template-outlined" name='Logoff' value='Logoff'><i class="fa fa-user-md"></i> Logoff</button>
				  </div>
				</div>
			  </div>	
		</form>
		
	  </div>
	</div>
  </div>
</div>
