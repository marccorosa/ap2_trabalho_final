<?php	

//arquivos de dependências
require_once '..\cabecalho_geral.php';

//inicialização das variáveis
$mensagem= "";

$usu_login = isset($_POST['usu_login']) ? $_POST['usu_login'] : null;
$usu_senha = isset($_POST['usu_senha']) ? $_POST['usu_senha'] : null;
$usu_login_cadastro = isset($_POST['usu_login_cadastro']) ? $_POST['usu_login_cadastro'] : null;
$usu_senha_cadastro = isset($_POST['usu_senha_cadastro']) ? $_POST['usu_senha_cadastro'] : null;
$usu_senha_conf = isset($_POST['usu_senha_conf']) ? $_POST['usu_senha_conf'] : null;
$usu_nome = isset($_POST['usu_nome']) ? $_POST['usu_nome'] : null;
$usu_email = isset($_POST['usu_email']) ? $_POST['usu_email'] : null;

//esta verificação de botão é verificada antes de chamar o cabecalho, para funcionar o header(location)
if (isset($_POST['Login'])) {

	$resultado= Usuario::login($usu_login, $usu_senha);

	if(sizeof($resultado) == 0)   //se não retornou nada significa que a consulta sql não encontrou o usuário ou senha
	{		
		echo "<script>
		alert('Usuário ou senha inválidos');
		</script>";
	}
	else
	{		
			$_SESSION["login"] = $usu_login;  //essa variavel faz o controle de sessão
			$_SESSION['ultimaAtualizacao'] = time();
			
			//redirect usando javascript
			$page = "/pedidos/view/produto/listar.php";
			echo '<script type="text/javascript">';
			echo 'window.location.href="'.$page.'";';
			echo '</script>';
	}
}


if (isset($_POST['Salvar'])) {
    if ($usu_senha_cadastro != $usu_senha_conf) {
        $mensagem= "Erro: a senha não está igual a confirmação da senha.";
    } else {    
        $usuario = new Usuario();
        $usuario->setUsu_login($usu_login_cadastro);
        $usuario->setUsu_nome($usu_nome);
        $usuario->setUsu_email($usu_email);
        $usuario->setUsu_senha($usu_senha_cadastro);
        $resultado = $usuario->incluir();
		
			//script que exibe caixa de mensagem com confirmação de cadastro de usuario
			echo "<script>
            alert('Cadastro efetuado com sucesso!');
            </script>";
			
			//depois do cadastro automaticamente faz o login do usuário 
			$_SESSION["login"] = $usu_login_cadastro;
			$_SESSION['ultimaAtualizacao'] = time();
			
			//redirect usando javascript
			$page = "/pedidos/view/produto/listar.php";
			echo '<script type="text/javascript">';
			echo 'window.location.href="'.$page.'";';
			echo '</script>';
    
        if (is_array($resultado))
            $mensagem= "Erro: ".$resultado[0].$resultado[2];
    }
}

?>

<title>Universal - Login/Criar Conta</title>
<div id="all">   
  <div id="heading-breadcrumbs">
	<div class="container">
	  <div class="row d-flex align-items-center flex-wrap">
		<div class="col-md-7">
		  <h1 class="h2">CRIAR CONTA/LOGIN</h1>
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
				<h2 class="text-uppercase">Cadastro</h2>
				<label for="usu_login_cadastro">Login</label>
				<input type='text' name='usu_login_cadastro' id='usu_login_cadastro' class="form-control" value='<?= $usu_login_cadastro ?>'>
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
				<label for="usu_senha_cadastro">Senha</label>
				<input type='password' name='usu_senha_cadastro' class="form-control" value='<?= $usu_senha_cadastro ?>'>
			  </div>
			  <div class="form-group">
				<label for="usu_senha_conf">Cofirme a senha</label>
				<input type='password' name='usu_senha_conf' class="form-control" value='<?= $usu_senha_cadastro ?>'>
				<span class="newComer text-center"><?= $mensagem ?></span>
			  </div>
			  
			  <div class="text-center">
				<button type="submit" class="btn btn-template-outlined" name='Salvar' value='Salvar'><i class="fa fa-user-md"></i> Cadastrar</button>
			  </div>
			</form>
		  </div>
		</div>		
		
		<div class="col-lg-6">
		  <div class="box">           
			<form method="POST">
			  <div class="form-group">
				<h2 class="text-uppercase">Login</h2>
				<label for="usu_login">Login</label>
				<input type='text' name='usu_login' id='usu_login' class="form-control" value='<?= $usu_login ?>'>
			  </div>

			  <div class="form-group">
				<label for="usu_senha">Senha</label>
				<input type='password' name='usu_senha' class="form-control" value='<?= $usu_senha ?>'>
			  </div>
			  
			  <div class="text-center">
				<button type="submit" class="btn btn-template-outlined" name='Login' value='Login'><i class="fa fa-user-md"></i> Login</button>
			  </div>
			</form>
		  </div>
		</div>	
		
	  </div>
	</div>
  </div>
</div>
