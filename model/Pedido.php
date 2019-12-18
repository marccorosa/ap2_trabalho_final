<?php 
class Pedido
{
	private $ped_numero;
	private $usu_login;
    private $ped_entregue;
	private $ped_data;
	private $pro_codigo;
	private $valor_total;

	public function getPed_numero()
    {
        return $this->ped_numero;
    }
	
	public function getUsu_login()
    {
        return $this->usu_login;
    }
	
	public function getPed_entregue()
    {
        return $this->ped_entregue;
    }
	
	public function getPed_data()
    {
        return $this->ped_data;
    }
	
	public function getPro_codigo()
    {
        return $this->pro_codigo;
    }
	
	public function getValor_total()
    {
        return $this->valor_total;
    }
		
	public function setPro_codigo($pro_codigo)
    {
        $this->pro_codigo = $pro_codigo;
    }
	
	public function setUsu_login($usu_login)
    {
        $this->usu_login = $usu_login;
    }
	
	public function setPed_numero($ped_numero)
    {
        $this->ped_numero = $ped_numero;
    }
	
	public function setPed_entregue($ped_entregue)
    {
        $this->ped_entregue = $ped_entregue;
    }
	
	public function setPed_data($ped_data)
    {
        $this->ped_data = $ped_data;
    }
	
	public function setValor_total($valor_total)
    {
        $this->valor_total = $valor_total;
    }

    public function incluir()
    {
    	$conexao = Database::connect();
    	$stm = $conexao->prepare("INSERT INTO pedido (usu_login, ped_entregue, ped_data, valor_total) ".
    						                 "VALUES (:usu_login,:ped_entregue,:ped_data,:valor_total) ");													 
		$stm->bindValue(':usu_login', $this->getUsu_login());									 
    	$stm->bindValue(':ped_entregue', $this->getPed_entregue());
		$stm->bindValue(':ped_data', $this->getPed_data());
		$stm->bindValue(':valor_total', $this->getValor_total());
		if (!$stm->execute())
			return $stm->errorInfo();
    }
	
	public function incluir_item_pedido()
    {
    	$conexao = Database::connect();
    	$stm = $conexao->prepare("INSERT INTO item_pedido (ped_numero, pro_codigo) ".
    						                 "VALUES (:ped_numero,:pro_codigo) ");													 
		$stm->bindValue(':ped_numero', $this->getPed_numero());									 
    	$stm->bindValue(':pro_codigo', $this->getPro_codigo());
		if (!$stm->execute())
			return $stm->errorInfo();
    }
	
	public static function listar($usu_login=null,$ped_entregue=null)
    {
        $conexao = Database::connect();
        $sql ="SELECT ped_numero, ".
				"usu_login, ".
				"ped_data, ".
				"ped_entregue, ".
				"valor_total ".
                "FROM pedido ".
                "WHERE 1 ";

		 if ($usu_login)
            $sql.="AND usu_login=:usu_login";
		if ($ped_entregue)
            $sql.="AND ped_entregue=:ped_entregue";
                
        $stm= $conexao->prepare($sql);

		if ($usu_login)
            $stm->bindValue(':usu_login', $usu_login);
		if ($ped_entregue)
            $stm->bindValue(':ped_entregue', $ped_entregue);
		
        if (!$stm->execute())
            return $stm->errorInfo();
            
        $pedidos= array();
        while ($resultado= $stm->fetch(PDO::FETCH_ASSOC))
        {
            $pedidos[]= array("ped_numero" => $resultado['ped_numero'],
									"usu_login" => $resultado['usu_login'],
									"ped_data" => $resultado['ped_data'],
									"valor_total" => $resultado['valor_total'],
									"ped_entregue" => $resultado['ped_entregue']);
        }
        return $pedidos;
    }
	
	public static function listar_ultimo($usu_login=null)
    {
        $conexao = Database::connect();
        $sql ="SELECT ped_numero, ".
				"usu_login ".
                "FROM pedido ".
                "WHERE 1 ";

		 if ($usu_login)
            $sql.="AND usu_login=:usu_login";
                
        $stm= $conexao->prepare($sql);

		if ($usu_login)
            $stm->bindValue(':usu_login', $usu_login);
		
        if (!$stm->execute())
            return $stm->errorInfo();
            
        $pedidos= array();
        while ($resultado= $stm->fetch(PDO::FETCH_ASSOC))
        {
            $pedidos = $resultado['ped_numero'];
        }
        return $pedidos;
    }
	
	//retorna vetor com codigos dos produtos relativo ao pedido
	public static function exibir($ped_numero)
    {
        $conexao = Database::connect();
        $sql ="SELECT ped_numero, ".
				"pro_codigo ".
                "FROM item_pedido ".
                "WHERE 1 ";

		 if ($ped_numero)
            $sql.="AND ped_numero=:ped_numero";
                
        $stm= $conexao->prepare($sql);

		if ($ped_numero)
            $stm->bindValue(':ped_numero', $ped_numero);
		
        if (!$stm->execute())
            return $stm->errorInfo();
            
        $pedidos= array();
        while ($resultado= $stm->fetch(PDO::FETCH_ASSOC))
        {
            $pedidos[]= $resultado['pro_codigo'];
        }
        return $pedidos;
    }
	
	
}
