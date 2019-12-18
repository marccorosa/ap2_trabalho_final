-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 09-Ago-2018 às 17:48
-- Versão do servidor: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pedidos_unifin`
--

--
-- Estrutura da tabela `grupo`
--

CREATE TABLE `grupo` (
  `gru_codigo` int(11) NOT NULL,
  `gru_descricao` varchar(80) NOT NULL,
  `gru_ativo` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `grupo`
--

INSERT INTO `grupo` (`gru_codigo`, `gru_descricao`, `gru_ativo`) VALUES
(1, 'Acessorios', 'S'),
(2, 'Eletronicos', 'S'),
(3, 'Vestuario', 'S');



-- --------------------------------------------------------
--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `usu_login` varchar(11) NOT NULL,
  `usu_nome` varchar(100) NOT NULL,
  `usu_email` varchar(100) NOT NULL,
  `usu_senha` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `pro_codigo` int(11) NOT NULL,
  `pro_codigo_barras` char(13) NOT NULL,
  `pro_descricao` varchar(100) NOT NULL,
  `pro_valor` float(4) NOT NULL,
  `gru_codigo` int(11) NOT NULL,
  `pro_promocao` char(1) NOT NULL,
  `pro_imagem` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`pro_codigo`, `pro_codigo_barras`, `pro_descricao`, `pro_valor`, `gru_codigo`,`pro_promocao`,`pro_imagem`) VALUES
(1, 'codigobarra1', 'Mochila', '89.99', 1, 'S', "mochila.jpg"),
(2, 'codigobarra2', 'Smartphone', '599.99', 2,'S', "telefone.jpg"),
(3, 'codigobarra3', 'Camisa Cinza', '44.99', 3, 'N',"camisa_cinza.jpg"),
(4, 'codigobarra4', 'Camisa Verde', '49.99', 3, 'N', "camisa_verde.jpg");

-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Estrutura da tabela `pedido`
--

CREATE TABLE `pedido` (
  `ped_numero` int(11) NOT NULL,
  `usu_login` varchar(11) NOT NULL,
  `ped_data` DATE NOT NULL,
  `ped_entregue` char(1) NOT NULL,
  `valor_total` float(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Estrutura da tabela `item_pedido`
--

CREATE TABLE `item_pedido` (
  `ped_numero` int(11) NOT NULL,
  `pro_codigo` int(11) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Indexes for dumped tables
--


--
-- Indexes for table `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`gru_codigo`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usu_login`),
  ADD UNIQUE KEY `usu_email_UNIQUE` (`usu_email`);
  
 --
-- Indexes for table `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`pro_codigo`),
  ADD KEY `fk_PRODUTO_GRUPO_idx` (`gru_codigo`);

  --
-- Indexes for table `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`ped_numero`),
  ADD KEY `fk_usu_login_idx` (`usu_login`);
  
  --
-- Indexes for table `item_pedido`
--
ALTER TABLE `item_pedido`
  ADD PRIMARY KEY (`ped_numero`, `pro_codigo`),
  ADD KEY `fk_ITEM_PEDIDO_PEDIDO1_idx` (`ped_numero`),
  ADD KEY `fk_ITEM_PEDIDO_PRODUTO1_idx` (`pro_codigo`); 
  
--
-- AUTO_INCREMENT for dumped tables
--



--
-- AUTO_INCREMENT for table `grupo`
--
ALTER TABLE `grupo`
  MODIFY `gru_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
  
--
-- AUTO_INCREMENT for table `produto`
--
ALTER TABLE `produto`
  MODIFY `pro_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
  
  
--
-- AUTO_INCREMENT for table `pedido`
--
ALTER TABLE `pedido`
  MODIFY `ped_numero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;  

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `produto`
--

ALTER TABLE `produto`
  ADD CONSTRAINT `fk_PRODUTO_GRUPO` FOREIGN KEY (`gru_codigo`) REFERENCES `grupo` (`gru_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;


--
-- Limitadores para a tabela `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_usu_login` FOREIGN KEY (`usu_login`) REFERENCES `usuario` (`usu_login`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

--
-- Limitadores para a tabela `item_pedido`
--
ALTER TABLE `item_pedido`
  ADD CONSTRAINT `fk_ITEM_PEDIDO_PEDIDO1` FOREIGN KEY (`ped_numero`) REFERENCES `pedido` (`ped_numero`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ITEM_PEDIDO_PRODUTO1` FOREIGN KEY (`pro_codigo`) REFERENCES `produto` (`pro_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
