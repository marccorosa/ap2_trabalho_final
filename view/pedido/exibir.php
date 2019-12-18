<?php	
//arquivos de dependências
require_once '..\cabecalho_geral.php';

$usu_login=$_SESSION['login'];
$ped_numero= isset($_GET['ped_numero'])?$_GET['ped_numero']:null;
$ped_data= $_GET['ped_data'];
$ped_entregue= isset($_GET['ped_entregue'])?$_GET['ped_entregue']:null;
$valor_total=isset($_GET['valor_total'])?$_GET['valor_total']:null;

//retorna vetor com codigos dos produtos relativo ao pedido
$codigos_dos_produtos= Pedido::exibir($ped_numero);
?>

<script>
//salva pdf do pedido
function printDiv(all) {
    var printContents = document.getElementById(all).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>

<div id="all">
      <div id="heading-breadcrumbs">
        <div class="container">
          <div class="row d-flex align-items-center flex-wrap">
            <div class="col-md-7">
              <h1 class="h2">Dados do pedido</h1>
            </div>
          </div>
        </div>
      </div>
      <div id="content">
        <div class="container">
          <div class="row bar">
            <div id="basket" class="col-lg-9">			 
			 <h3>Usuário: <?php echo $usu_login; ?></h3>
			 <h3>Número do pedido: <?php echo $ped_numero; ?></h3>
			 <h3>Data de entrega: <?php echo $ped_data; ?></h3>
			 <h3>Entregue: <?php echo $ped_entregue; ?></h3>
              <div class="box mt-0 pb-0 no-horizontal-padding">      		   			  
                  <div class="table-responsive">
                    <table class="table">
                      <thead>					  
                        <tr>
                          <th>Produto</th>
                          <th>Valor</th>    						  
                        </tr>
                      </thead>
					  
                      <tbody>
					  <?php foreach($codigos_dos_produtos as $pro_codigo): $dados_produtos=Produto::listar($pro_codigo); ?>
						<?php foreach($dados_produtos as $produto): ?>
							<tr>
							  <td><?= $produto["pro_descricao"] ?></td>                         
							  <td>R$ <?= $produto["pro_valor"] ?></td>
							</tr>
						<?php endforeach; ?>
					  <?php endforeach; ?>
                      </tbody>
                    </table>
					
					<h3>Valor Total: R$  <?php echo $valor_total; ?></h3>	
					
                  </div>         								
              </div>     
				
				<div class="text-center">
					<button type="submit" class="btn-template-outlined" onclick="printDiv('content')" />Gerar PDF</button>
				</div>	
			  
            </div>          
          </div>
        </div>
      </div>  
    </div>


