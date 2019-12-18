<?php 
class Usuario
{
    private $usu_login;
    private $usu_nome;
    private $Usu_email;
    private $usu_senha;
    private $gru_codigo;
    private $usu_data_atualizacao;
    private $usu_ativo;
    
    public function getUsu_login()
    {
        return $this->usu_login;
    }

    public function getUsu_nome()
    {
        return $this->usu_nome;
    }

    public function getUsu_email()
    {
        return $this->Usu_email;
    }

    public function getUsu_senha()
    {
        return $this->usu_senha;
    }

    public function setUsu_login($usu_login)
    {
        $this->usu_login = $usu_login;
    }

    public function setUsu_nome($usu_nome)
    {
        $this->usu_nome = $usu_nome;
    }

    public function setUsu_email($Usu_email)
    {
        $this->Usu_email = $Usu_email;
    }

    public function setUsu_senha($usu_senha)
    {
        $this->usu_senha = $usu_senha;
    }

	public static function login($login, $senha)
    {       
            $conexao = Database::connect();
            $sql = "SELECT usu_login, ".
                        "usu_nome, ".
                        "usu_email, ".
                        "usu_senha ".
                    "FROM usuario ". 
                    "WHERE usu_login=:usu_login ";
                    
            $stm= $conexao->prepare($sql);

            $stm->bindValue(':usu_login', $login);
            if (!$stm->execute())
                return $stm->errorInfo();
                
            $usuarios = array();
            while ($resultado= $stm->fetch(PDO::FETCH_ASSOC)){
                $usuarios[]= array("usu_login" => $resultado['usu_login'],
                                   "usu_nome" => $resultado['usu_nome'],
                                   "usu_senha" => $resultado['usu_senha'],
                                   "usu_email" => $resultado['usu_email']);
                }
				
			
			//se há algo no vetor usuários significa que a consulta sql encontrou o usuario no banco de dados. Tambem confere se a senha digitada confere com a do banco.
			if ((sizeof($usuarios) > 0) && password_verify($senha, $usuarios[0]['usu_senha']))
			{
				unset($usuarios[0]['usu_senha']);
			}
			else
			{
				$usuarios = array();
			}
			
            return $usuarios;
			       
    }
	
    public function incluir()
    {
		$hashed_password = password_hash($this->getUsu_senha(), PASSWORD_DEFAULT);
    	$conexao = Database::connect();
    	$stm = $conexao->prepare("INSERT INTO usuario (usu_login, usu_nome, usu_email, usu_senha) ".
    						                 "VALUES (:usu_login,:usu_nome,:usu_email,:usu_senha) ");
    	$stm->bindValue(':usu_login', $this->getUsu_login());
		$stm->bindValue(':usu_nome', $this->getUsu_nome());
		$stm->bindValue(':usu_email', $this->getUsu_email());
		$stm->bindValue(':usu_senha', $hashed_password);
		if (!$stm->execute())
			return $stm->errorInfo();
    }

    public function alterar()
    {
    	$conexao = Database::connect();
    	$stm = $conexao->prepare("UPDATE usuario SET ".
	                                    "usu_nome=:usu_nome, ". 
                                	    "usu_email=:usu_email, ".
                                	    "usu_senha=:usu_senha ". 
	                              "WHERE usu_login=:usu_login");			
									  
		$stm->bindValue(':usu_login', $this->getUsu_login());								  
        $stm->bindValue(':usu_nome', $this->getUsu_nome());
        $stm->bindValue(':usu_email', $this->getUsu_email());
		
		$hashed_password = password_hash($this->getUsu_senha(), PASSWORD_DEFAULT);
        $stm->bindValue(':usu_senha', $hashed_password);

        if (!$stm->execute())
            return $stm->errorInfo();

    }

    public static function listar($usu_login=null) 
	{
        $conexao = Database::connect();
    	$sql = "SELECT usu_login, ".
				 "usu_nome, ". 
				 "usu_email, ". 
				 "usu_senha ". 
			     "FROM usuario ".
				 "WHERE 1 ";
				 			
		if ($usu_login)
            $sql.="AND usu_login LIKE :usu_login ";			
		
        $stm= $conexao->prepare($sql);
         
		 if ($usu_login)
            $stm->bindValue(':usu_login', $usu_login);	

        if (!$stm->execute())
            return $stm->errorInfo();  

        $usuarios = array();
        while ($resultado= $stm->fetch(PDO::FETCH_ASSOC))
		{
            $usuarios[]= array("usu_login" => $resultado['usu_login'],
									  "usu_nome" => $resultado['usu_nome'],								  
									  "usu_email" => $resultado['usu_email'],
									  "usu_senha" => $resultado['usu_senha']);
        }
        return $usuarios;
    }
    
}
