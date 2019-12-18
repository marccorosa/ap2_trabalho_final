<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    if (isset($_SESSION['login']))
    {
		if(($_SESSION["login"] != "ninguem_logado") AND ($_SESSION["login"] != "admin"))
		{
			//Variável com o horário atual
			$time = time();
			//Tempo de timeout em minutos
			$timeout = 20;  
			
			//inicializa a variavel ultimaAtualizacao
			if (!isset($_SESSION['ultimaAtualizacao']))
			{
				$_SESSION['ultimaAtualizacao']=0;			
			}
			
			//Tempo inativo, em segundos
			$secondsInactive = $time - $_SESSION['ultimaAtualizacao'];
			
			//Converte o tempo de timeout para segundos
			$timeoutSeconds = $timeout * 60; 
			
			//Se o tempo inativo for maior ou igual ao tempo estipulado, encerra a sessão e volta para a tela de login
			//Senão, atualiza o tempo de última atividade
			if ($secondsInactive >= $timeoutSeconds)
			{
				session_unset();
				session_destroy();
				//redirect usando javascript
				$page = "/pedidos/view/produto/listar.php";
				echo '<script type="text/javascript">';
				echo 'window.location.href="'.$page.'";';
				echo '</script>';
				exit();
			}else
			{
				$_SESSION['ultimaAtualizacao'] = $time;
			}
		}
    }else
	{
		//se ninguem esta logado no sistema 
		$_SESSION["login"] = "ninguem_logado";
	}
?>