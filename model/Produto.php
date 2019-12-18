<?php 
class Produto
{
	private $pro_codigo;
	private $pro_codigo_barras;
    private $pro_descricao;
    private $pro_valor;
	private $pro_imagem;
	private $gru_codigo;

	public function getPro_codigo()
    {
        return $this->pro_codigo;
    }
	
    public function getPro_descricao()
    {
        return $this->pro_descricao;
    }
	
	public function getPro_valor()
    {
        return $this->pro_valor;
    }
	
	public function getGru_codigo()
    {
        return $this->gru_codigo;
    }
		
	public function getPro_promocao()
    {
        return $this->pro_promocao;
    }
	
	public function getPro_imagem()
    {
        return $this->pro_imagem;
    }
		
	public function setPro_codigo($pro_codigo)
    {
        $this->pro_codigo = $pro_codigo;
    }
	
	public function getPro_codigo_barras()
    {
        return $this->pro_codigo_barras;
    }
	
    public function setPro_descricao($pro_descricao)
    {
        $this->pro_descricao = $pro_descricao;
    }

    public function setPro_valor($pro_valor)
    {
        $this->pro_valor = $pro_valor;
    }

    public function setPro_codigo_barras($pro_codigo_barras)
    {
        $this->pro_codigo_barras = $pro_codigo_barras;
    }
	
	public function setPro_promocao($pro_promocao)
    {
        $this->pro_promocao = $pro_promocao;
    }
	
	public function setGru_codigo($gru_codigo)
    {
        $this->gru_codigo = $gru_codigo;
    }
		
	public function setPro_imagem($pro_imagem)
    {
        $this->pro_imagem = $pro_imagem;
    }

    public function incluir()
    {
    	$conexao = Database::connect();
    	$stm = $conexao->prepare("INSERT INTO produto (pro_codigo_barras, pro_descricao, pro_valor, gru_codigo, pro_promocao, pro_imagem) ".
    						                 "VALUES (:pro_codigo_barras,:pro_descricao,:pro_valor,:gru_codigo,:pro_promocao,:pro_imagem) ");													 
		$stm->bindValue(':pro_codigo_barras', $this->getPro_codigo_barras());									 
    	$stm->bindValue(':pro_descricao', $this->getPro_descricao());
		$stm->bindValue(':pro_valor', $this->getPro_valor());
		$stm->bindValue(':gru_codigo', $this->getGru_codigo());
		$stm->bindValue(':pro_promocao', $this->getPro_promocao());
		$stm->bindValue(':pro_imagem', $this->getPro_imagem());
		if (!$stm->execute())
			return $stm->errorInfo();
    }

    public function alterar()
    {
    	$conexao = Database::connect();
    	$stm = $conexao->prepare("UPDATE produto SET ".
	                                    "pro_descricao=:pro_descricao, ". 
                                	    "pro_valor=:pro_valor, ".
										"pro_codigo_barras=:pro_codigo_barras, ".
                                	    "gru_codigo=:gru_codigo, ". 
										"pro_promocao=:pro_promocao, ". 
										"pro_imagem=:pro_imagem ". 
	                              "WHERE pro_codigo=:pro_codigo");
		$stm->bindValue(':pro_codigo', $this->getPro_codigo());						  
        $stm->bindValue(':pro_descricao', $this->getPro_descricao());
        $stm->bindValue(':pro_valor', $this->getPro_valor());
        $stm->bindValue(':pro_codigo_barras', $this->getPro_codigo_barras());
        $stm->bindValue(':gru_codigo', $this->getGru_codigo());
		$stm->bindValue(':pro_promocao', $this->getPro_promocao());
		$stm->bindValue(':pro_imagem', $this->getPro_imagem());
        if (!$stm->execute())
            return $stm->errorInfo();

    }

    public static function listar($pro_codigo=null,$pro_descricao=null,$gru_codigo=null,$pro_valor=null) 
	{
        $conexao = Database::connect();
    	$sql = "SELECT pro_codigo, ".
				 "pro_descricao, ". 
				 "pro_valor, ". 
				 "pro_codigo_barras, ". 			 
				 "gru_codigo, ". 
				 "pro_promocao, ". 
				 "pro_imagem ". 
			     "FROM produto ".
				 "WHERE 1";
				 		
		if ($pro_codigo)
            $sql.=" AND pro_codigo=:pro_codigo ";				
        if ($pro_descricao)
            $sql.=" AND pro_descricao LIKE :pro_descricao ";
		if ($pro_valor)
            $sql.=" AND pro_valor<=:pro_valor ";
		if ($gru_codigo)
            $sql.=" AND gru_codigo=:gru_codigo ";
		
        $stm= $conexao->prepare($sql);
         
		if ($pro_codigo)
            $stm->bindValue(':pro_codigo', $pro_codigo);
        if ($pro_descricao)
            $stm->bindValue(':pro_descricao', "%".$pro_descricao."%");
		if ($pro_valor)
            $stm->bindValue(':pro_valor', $pro_valor);
		if ($gru_codigo)
            $stm->bindValue(':gru_codigo', $gru_codigo);

        if (!$stm->execute())
            return $stm->errorInfo();  

        $produtos = array();
        while ($resultado= $stm->fetch(PDO::FETCH_ASSOC))
		{
            $produtos[]= array("pro_codigo" => $resultado['pro_codigo'],
									  "pro_descricao" => $resultado['pro_descricao'],								  
									  "pro_valor" => $resultado['pro_valor'],
									  "pro_codigo_barras" => $resultado['pro_codigo_barras'],
									  "gru_codigo" => $resultado['gru_codigo'],
									  "pro_promocao" => $resultado['pro_promocao'],
									  "pro_imagem" => $resultado['pro_imagem']);
        }
        return $produtos;
    }	
	
}
