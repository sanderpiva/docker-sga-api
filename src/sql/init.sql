CREATE DATABASE IF NOT EXISTS `gerenciamento_academico_completo` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `gerenciamento_academico_completo`;

CREATE TABLE IF NOT EXISTS `turma` (
  `id_turma` int(11) NOT NULL AUTO_INCREMENT,
  `codigoTurma` varchar(45) NOT NULL,
  `nomeTurma` varchar(45) NOT NULL,
  PRIMARY KEY (`id_turma`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

INSERT INTO `turma` (`id_turma`, `codigoTurma`, `nomeTurma`) VALUES
	(1, '6S_A', '6 serie A'),
	(2, '6S_B', '6 serie B'),
	(9, '8S_C', '8 serie C'),
	(13, '6S_F', '6 serie F'),
	(15, '6S_Za', '6 serie Za'),
	(16, '6S_G', '6 serie G');

CREATE TABLE IF NOT EXISTS `professor` (
  `id_professor` int(11) NOT NULL AUTO_INCREMENT,
  `registroProfessor` varchar(100) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `telefone` varchar(45) NOT NULL,
  `senha` varchar(255) NOT NULL,
  PRIMARY KEY (`id_professor`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

INSERT INTO `professor` (`id_professor`, `registroProfessor`, `nome`, `email`, `endereco`, `telefone`, `senha`) VALUES
	(16, 'mat123mjjss', 'Rita Moses', 'rita@gmail.com', 'Rua 3300', '(35) 3295-1099', '$2y$10$h7Aj2I2FrGzbp4TGy5a1feYwZtwZOE100jjNirsQernRMqannT0c2'),
	(23, 'Port15ase3', 'Jose Dias dos Santos', 'jose@gmail.com', 'Rua das Neves 333', '(35) 3333-9999', '$2y$10$plPZH7s5xYjmzAuHwFWo..Jto2Pn9ISrFzsrRKoq/53z.ZQanxPZq'),
	(24, 'HIST123', 'João História', 'joao@gmail.com', 'Rua das 78 Centro Machado MG', '(35) 3295-7433', '$2y$10$bXMc9rzoAEnNYidrviWjLubjnb8zrPh5aUZfXMJZOAnp8lNK6XfKS'),
	(25, 'Geo789', 'Hilda Carla', 'hilda@gmail.com', 'Rua das 8 Centro Machado MG', '(35) 3295-7447', '$2y$10$WDbWlO1yBjvTu0AHl8H8m.6d1Tu80A.9LrpBrbD6D72Ffb5nS3BkW'),
	(26, 'IR456a', 'Lia Silva Rocha', 'lia@gmail.com', 'Rua das 89 Centro Machado MG', '(35) 3295-7447', '$2y$10$ydousNBi9PFx5ZCc8NopgeUJ5PXtg7Ow8vWrq//2u5G5Ky8pCVwZm'),
	(27, 'EA1234', 'Maria Rita Silas', 'maria@gmail.com', 'Rua das 18 Centro Machado MG', '(35) 3295-7400', '$2y$10$91fD5A7m/AZrFcHYXqQ/3u6hBxmqrwPxlHetwaupp5PJMgnWG6Sny'),
	(30, 'Mat7123A', 'Lia dos Santos Sá', 'liasa@gmail.com', 'Rua das Neves 330', '(35) 3295-1880', '$2y$10$dN.qWU0K1XnTdeA2FIVPNeq7bdqVArH/YoM5LOjfPCskps8uxZwJm'),
	(31, 'Mat789Q', 'Emilia Sanches Rocha', 'emilia@gmail.com', 'Rua das 819 Centro Machado MG', '(35) 3295-7410', '$2y$10$e8wmIUZQWmJuxz9kzJaAneNH/U0Q5Bi2n/gyL4dOUZexT64e/uR7y'),
	(32, 'HIS7899', 'Joana Silva', 'joana@gmail.com', 'Rua das 818 Centro Machado MG', '(35) 3295-7410', '$2y$10$BYF62.3rAldi2btUxkxT6OvLP/ysheZMTOHeHu6hnGruKOrtibtgK'),
	(33, 'Geo1asS', 'Silvana Rocha', 'silvana@gmail.com', 'Rua das 28 Centro Machado MG', '(35) 3295-7470', '$2y$10$1rpLSmM6MQ0jQblXGQqVxuKGNiPj0tAerF2vQGNbGlT0ZnFSus0P6'),
	(34, 'Mat123Abcc', 'Luis Slias', 'luissilas@gmail.com', 'Rua das Neves 333', '(35) 3295-1010', '$2y$10$4tM3FP3afSYWwSQXvdKsxOb6T/J/d/xhx7KJ8LcOhGiTOJ7RRuSsC'),
	(35, 'Mata234', 'Lia Silas Moreira', 'liasilas@gmail.com', 'Rua das Neves 3332', '(35) 3295-1044', '$2y$10$k1uaWGQrr2bf83.ljppBGuceyVuYAXF8XpK6YjwRGP6XOOskZdcg2'),
	(37, 'Fis154sss', 'Fuvio Maia', 'fuvio@gmail.com', 'Rua das 80 Centro Machado MG', '(35) 3295-7400', '$2y$10$.XCjnR2VKTvfTK3c0FnNN.tjTQnk9MSav34WJwgWEkZ/YwgD6ACg.'),
	(41, 'Mzx12jk8', 'Lo Santos Santos', 'los@gmail.com', 'Rua das Neves 3332', '(35) 3295-1888', '$2y$10$H901DX9iBror2CoF4O729.IsV36o4byzRB8zojQofOCZw92qoREm.'),
	(42, 'Mzx12ddd', 'Lucas Seixas', 'lucaseixas@gmail.com', 'Rua 3378', '(35) 3295-1888', '$2y$10$R2HgYDEdz2Gayxt61nbI2uiJSj1O91DrOZXb6MZC/C5S3PSkOmvo6');

CREATE TABLE IF NOT EXISTS `disciplina` (
  `id_disciplina` int(11) NOT NULL AUTO_INCREMENT,
  `codigoDisciplina` varchar(100) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `carga_horaria` varchar(700) NOT NULL,
  `professor` varchar(100) NOT NULL,
  `descricao` varchar(700) NOT NULL,
  `semestre_periodo` varchar(150) NOT NULL,
  `Professor_id_professor` int(11) NOT NULL,
  `Turma_id_turma` int(11) NOT NULL,
  PRIMARY KEY (`id_disciplina`,`Professor_id_professor`),
  KEY `fk_Disciplina_Professor1_idx` (`Professor_id_professor`),
  KEY `fk_Turma1_idx` (`Turma_id_turma`),
  CONSTRAINT `fk_Disciplina_Professor1` FOREIGN KEY (`Professor_id_professor`) REFERENCES `professor` (`id_professor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Turma1` FOREIGN KEY (`Turma_id_turma`) REFERENCES `turma` (`id_turma`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

INSERT INTO `disciplina` (`id_disciplina`, `codigoDisciplina`, `nome`, `carga_horaria`, `professor`, `descricao`, `semestre_periodo`, `Professor_id_professor`, `Turma_id_turma`) VALUES
	(5, 'Mat', 'Matematica', '65', 'Rita Moses', 'A matematica do ensino basico preocupa-se em ensinar A, B e C', '8S_C', 16, 9),
	(6, 'Port234', 'Portugues', '65', 'Jose Dias dos Santos', 'A lingua portugues eh uma das materias que envolve o poder de analisar e descrever contextos, bem como estudar sua sixtaxe e semantica', '6S_A', 23, 1),
	(7, 'hit12334', 'Historia', '60', 'Joao Historia', 'A Historia eh a ciencia que estuda o passado das civilizações e tal', '6S_B', 24, 2),
	(8, 'ea123A', 'Inglês', '60', 'Maria Rita Silas', 'A lingua inglesa eh fala em varios paises do mundo e seu conhecimento abrange inumeras metodologias', '6S_B', 27, 2),
	(9, 'Filo1234', 'Filosofia', '60', 'Lia Silva Rocha', 'A filosofia é a ciencia que estuda todas as ciencias, ela é a mãe de todas, requer analise economica e politica', '6S_B', 26, 2),
	(10, 'GEOgraFia12A', 'GeografiaS', '60', 'Silvana Rocha', 'A Geografia é uma ciencia que estuda diversos casos, entre eles a politica e economia dos paises', '6S_A', 33, 1),
	(11, 'geo12aq', 'Geografia', '50', 'Hilda Carla', 'A Geografisssssa é uma ciencia que estuda diversos casos, entre eles a politica e economia dos paises', '8S_C', 25, 9);



CREATE TABLE IF NOT EXISTS `aluno` (
  `id_aluno` int(11) NOT NULL AUTO_INCREMENT,
  `matricula` varchar(100) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(700) NOT NULL,
  `email` varchar(100) NOT NULL,
  `data_nascimento` date NOT NULL,
  `endereco` varchar(150) NOT NULL,
  `cidade` varchar(45) NOT NULL,
  `telefone` varchar(45) NOT NULL,
  `Turma_id_turma` int(11) NOT NULL,
  `senha` varchar(255) NOT NULL,
  PRIMARY KEY (`id_aluno`,`Turma_id_turma`),
  KEY `fk_Aluno_Turma1_idx` (`Turma_id_turma`),
  CONSTRAINT `fk_Aluno_Turma1` FOREIGN KEY (`Turma_id_turma`) REFERENCES `turma` (`id_turma`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;


INSERT INTO `aluno` (`id_aluno`, `matricula`, `nome`, `cpf`, `email`, `data_nascimento`, `endereco`, `cidade`, `telefone`, `Turma_id_turma`, `senha`) VALUES
	(12, 'IRas7890', 'Monica Alves Correias', '88810011129', 'monica@gmail.com', '2016-02-24', 'Rua das Neves 70', 'Machado', '(35) 3295-7833', 1, '$2y$10$ZpCvbiXaJDOBjME8quQuvuNVQVRPYDrVK3ohYw1u8MBi9gKQI2NTq'),
	(13, 'IR900errT', 'Isis Dias Lobo Alfa', '11100022200', 'isis@gmail.com', '1997-06-11', 'Rua das Hortas 99', 'Machado', '(35) 3295-7800', 9, '$2y$10$6C43E.j8Op.7404a02khxO1mF178doDwDU821cbNN8kj3BCTozSou'),
	(16, 'IR234cdf', 'Luma Silva Teles', '11100022231', 'luma@gmail.com', '2025-05-10', 'Rua das Neves 120008', 'Machado MG', '(35) 3295-7700', 2, '$2y$10$5uVKE6IVIzsUFCq9DP4zPumE0jnZWm0GuLHRNpg7fSGIuQyK9rwLe'),
	(17, 'IRa789q', 'Lotus Ferrari', '11100022000', 'lotus@gmail.com', '2025-05-16', 'Rua das Neves 120', 'Machado', '(35) 3295-7777', 9, '$2y$10$20wnrYpYic9MviBsnfnWI.zp/O7Zo29kV/YmmMf1zSUXcvU3blG3u'),
	(18, 'IR10azs2', 'Tales Moreira Rocha', '11122233320', 'tales@gmail.com', '2025-05-16', 'Rua 19, Praça Antonio Carlos', 'Machado MG', '(35) 3929-9990', 9, '$2y$10$9NfxyEsyg6Onh/6KbNg7kewUhabWNEKAiErxhrCIvX5/a.qvmRjJq'),
	(19, 'IRopQ123', 'Janaina Rita Reis', '11111111100', 'janaina@gmail.com', '2025-05-21', 'Rua 29, Praça Antonio Carlos', 'Machado MG', '(35) 3929-9987', 2, '$2y$10$k1CFHiUloQ0HpHRUdXWyw.HJIjR1DX91IQYunryjzcixyyWL0pxKK'),
	(21, 'IR1078Acvf4', 'Rose Miller Santos', '11100022233', 'rose@gmail.com', '2025-06-11', 'Rua das Neves 120', 'Machado', '(35) 3295-7801', 1, '$2y$10$fgYHSZH8/pYPwRaMVEqACOteVYWVCLgPCMlZ9YYAK.ZdNXvIHVvvi'),
	(22, 'IR1078Axxxx', 'Juliao Ferroso', '11100022233', 'juliao@gmail.com', '2025-06-19', 'Rua das Neves 122', 'Machado', '(35) 3295-7877', 1, '$2y$10$n.3lysqKs4io.j4FGc7pAe7SRywe726WEYptG.0SH9.lFU0cv49gy'),
	(23, 'Ir123f', 'Luis Luis Luz', '12312312345', 'luis@gmail.com', '2025-06-03', 'Rua 90, Praça Antonio Carlos Centro', 'Machado MG', '(35) 3929-9997', 1, '$2y$10$QHdTVhLtwE4StPztl0ygAumtS/hoGYlobnuRss0Dntw96VSQVRjYW');

CREATE TABLE IF NOT EXISTS `conteudo` (
  `id_conteudo` int(11) NOT NULL AUTO_INCREMENT,
  `codigoConteudo` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descricao` varchar(700) NOT NULL,
  `data_postagem` date NOT NULL,
  `professor` varchar(100) NOT NULL,
  `disciplina` varchar(45) NOT NULL,
  `tipo_conteudo` varchar(45) NOT NULL,
  `Disciplina_id_disciplina` int(11) NOT NULL,
  PRIMARY KEY (`id_conteudo`,`Disciplina_id_disciplina`),
  KEY `fk_Conteudo_Disciplina1_idx` (`Disciplina_id_disciplina`),
  CONSTRAINT `fk_Conteudo_Disciplina1` FOREIGN KEY (`Disciplina_id_disciplina`) REFERENCES `disciplina` (`id_disciplina`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO `conteudo` (`id_conteudo`, `codigoConteudo`, `titulo`, `descricao`, `data_postagem`, `professor`, `disciplina`, `tipo_conteudo`, `Disciplina_id_disciplina`) VALUES
	(9, 'm78912334', 'A progressao geometrica', 'Uma Progressão Geométrica (PG) é uma sequência numérica em que cada termo, a partir do segundo, é obtido multiplicando o termo anterior por uma constante chamada razão.\r\nPor exemplo, a sequência 2, 6, 18, 54... é uma PG com razão 3. As PGs são úteis para modelar situações com crescimento ou decrescimento exponencial.\r\n', '2025-05-16', 'Rita Moses', 'Matematica', 'Aula numero 1', 5),
	(11, 'hist456', 'A historia do Brasil colonial', 'A historia do Brasil colonial e como os senhores de engenho fundaram', '2025-05-30', 'Joao Historia', 'Historia', 'Aula numero 20', 7),
	(13, 'matA5687', 'A progressao aritmetica', 'Uma Progressão Aritmética (PA) é uma sequência numérica em que cada termo, a partir do segundo, é obtido somando uma constante chamada razão ao termo anterior\r\nPor exemplo, a sequência 2, 5, 8, 11... é uma PA com razão 3. As PAs são úteis para modelar situações em que há um crescimento ou decrescimento linear.\r\n        ', '2025-05-20', 'Rita Moses', 'Matematica', 'multipla-escolha', 5),
	(14, 'matza345', 'A equação do primeiro grau2', 'A equação do primeiro grau é um dos assuntos mais pertinentes da matemática pois esyuda casos do cotidiano', '2025-05-01', 'Rita Moses', 'Matematica', 'Aula 5', 5);


CREATE TABLE IF NOT EXISTS `prova` (
  `id_prova` int(11) NOT NULL AUTO_INCREMENT,
  `codigoProva` varchar(100) NOT NULL,
  `tipo_prova` varchar(100) NOT NULL,
  `disciplina` varchar(700) NOT NULL,
  `conteudo` varchar(100) NOT NULL,
  `data_prova` date NOT NULL,
  `professor` varchar(100) NOT NULL,
  `Disciplina_id_disciplina` int(11) NOT NULL,
  `Disciplina_Professor_id_professor` int(11) NOT NULL,
  PRIMARY KEY (`id_prova`,`Disciplina_id_disciplina`,`Disciplina_Professor_id_professor`),
  KEY `fk_Prova_Disciplina1_idx` (`Disciplina_id_disciplina`,`Disciplina_Professor_id_professor`),
  CONSTRAINT `fk_Prova_Disciplina1` FOREIGN KEY (`Disciplina_id_disciplina`, `Disciplina_Professor_id_professor`) REFERENCES `disciplina` (`id_disciplina`, `Professor_id_professor`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

INSERT INTO `prova` (`id_prova`, `codigoProva`, `tipo_prova`, `disciplina`, `conteudo`, `data_prova`, `professor`, `Disciplina_id_disciplina`, `Disciplina_Professor_id_professor`) VALUES
	(7, 'mat12355555', 'multipla escolha', 'Matematica', 'PA progressao aritmetica e seus efeitos aplicados', '2025-05-15', 'Rita Moses', 5, 16),
	(8, 'ppot5678', 'multipla escolha', 'Portugues', 'Concordancia verbal e nominal e todos os conjuntos correlacionados', '2025-05-07', 'Jose Dias dos Santos', 6, 23),
	(9, 'phist456', 'multipla escolha', 'Historia', 'A historia do Brasil colonial e os engenhos de cafe no estado de minas', '2025-05-16', 'Joao Historia', 7, 24),
	(11, 'pgeo12a', 'multipla escolha', 'Geografia', 'A economia do Japão e suas caracterisiticas', '2025-05-06', 'Silvana Rocha', 10, 33),
	(12, 'pgeo7812', 'multipla escolha', 'Geografia', 'A economia da França e suas caracterisiticas', '2025-05-21', 'Hilda Carla', 11, 25);

CREATE TABLE IF NOT EXISTS `questoes` (
  `id_questao` int(11) NOT NULL AUTO_INCREMENT,
  `codigoQuestao` varchar(100) NOT NULL,
  `descricao` varchar(700) NOT NULL,
  `tipo_prova` varchar(100) NOT NULL,
  `Prova_id_prova` int(11) NOT NULL,
  `Prova_Disciplina_id_disciplina` int(11) NOT NULL,
  `Prova_Disciplina_Professor_id_professor` int(11) NOT NULL,
  PRIMARY KEY (`id_questao`,`Prova_id_prova`,`Prova_Disciplina_id_disciplina`,`Prova_Disciplina_Professor_id_professor`),
  KEY `fk_Questoes_Prova1_idx` (`Prova_id_prova`,`Prova_Disciplina_id_disciplina`,`Prova_Disciplina_Professor_id_professor`),
  CONSTRAINT `fk_Questoes_Prova1` FOREIGN KEY (`Prova_id_prova`, `Prova_Disciplina_id_disciplina`, `Prova_Disciplina_Professor_id_professor`) REFERENCES `prova` (`id_prova`, `Disciplina_id_disciplina`, `Disciplina_Professor_id_professor`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

INSERT INTO `questoes` (`id_questao`, `codigoQuestao`, `descricao`, `tipo_prova`, `Prova_id_prova`, `Prova_Disciplina_id_disciplina`, `Prova_Disciplina_Professor_id_professor`) VALUES
	(14, 'pmatNovo', 'O termo geral da PA é assim definido pela fórmula: an = a1 + (n-1) *r. Isso está certo?', 'multipla escolha', 7, 5, 16),
	(15, 'qport568', 'A oração "Eles come carne" em termo de concordância verbal está correta?', 'multipla escolha', 8, 6, 23),
	(16, 'qhis345', 'O cafe é conhecido como o ouro verde do Brasil e sustentou a economia brasileira durante muitos séculos. Certo?', 'multipla escolha', 9, 7, 24),
	(17, 'qgeo1ad', 'A ecConoSSSmiAa do Japão teve influencia das guerras Indo Asiaticas. Certo?', 'multipla escolha', 11, 10, 33),
	(19, 'qgeoza34', 'A economia do Japão teve influencia de outras nacoes. Certo?', 'multipla escolha', 11, 10, 33),
	(20, 'qgeo456', 'A economia da França teve influencia de outras nacoes. Certo?', 'multipla escolha', 12, 11, 25);

CREATE TABLE IF NOT EXISTS `respostas` (
  `id_respostas` int(11) NOT NULL AUTO_INCREMENT,
  `codigoRespostas` varchar(100) NOT NULL,
  `respostaDada` varchar(45) NOT NULL,
  `acertou` varchar(45) NOT NULL,
  `nota` float NOT NULL,
  `Questoes_id_questao` int(11) NOT NULL,
  `Questoes_Prova_id_prova` int(11) NOT NULL,
  `Questoes_Prova_Disciplina_id_disciplina` int(11) NOT NULL,
  `Questoes_Prova_Disciplina_Professor_id_professor` int(11) NOT NULL,
  `Aluno_id_aluno` int(11) NOT NULL,
  PRIMARY KEY (`id_respostas`,`Questoes_id_questao`,`Questoes_Prova_id_prova`,`Questoes_Prova_Disciplina_id_disciplina`,`Questoes_Prova_Disciplina_Professor_id_professor`),
  KEY `fk_Respostas_Questoes1_idx` (`Questoes_id_questao`,`Questoes_Prova_id_prova`,`Questoes_Prova_Disciplina_id_disciplina`,`Questoes_Prova_Disciplina_Professor_id_professor`),
  KEY `Aluno_id_aluno` (`Aluno_id_aluno`),
  CONSTRAINT `fk_Respostas_Questoes1` FOREIGN KEY (`Questoes_id_questao`, `Questoes_Prova_id_prova`, `Questoes_Prova_Disciplina_id_disciplina`, `Questoes_Prova_Disciplina_Professor_id_professor`) REFERENCES `questoes` (`id_questao`, `Prova_id_prova`, `Prova_Disciplina_id_disciplina`, `Prova_Disciplina_Professor_id_professor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `respostas_ibfk_1` FOREIGN KEY (`Aluno_id_aluno`) REFERENCES `aluno` (`id_aluno`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

INSERT INTO `respostas` (`id_respostas`, `codigoRespostas`, `respostaDada`, `acertou`, `nota`, `Questoes_id_questao`, `Questoes_Prova_id_prova`, `Questoes_Prova_Disciplina_id_disciplina`, `Questoes_Prova_Disciplina_Professor_id_professor`, `Aluno_id_aluno`) VALUES
	(29, 'rqpot567', 'a', '0', 0, 15, 8, 6, 23, 13),
	(31, 'rgeoq123', 'a', '1', 1, 17, 11, 10, 33, 13),
	(34, 'rq1cvg', 'a', '1', 1, 16, 9, 7, 24, 17);


CREATE TABLE IF NOT EXISTS `matricula` (
  `Aluno_id_aluno` int(11) NOT NULL,
  `Disciplina_id_disciplina` int(11) NOT NULL,
  PRIMARY KEY (`Aluno_id_aluno`,`Disciplina_id_disciplina`),
  KEY `fk_Aluno_has_Disciplina_Disciplina1_idx` (`Disciplina_id_disciplina`),
  KEY `fk_Aluno_has_Disciplina_Aluno_idx` (`Aluno_id_aluno`),
  CONSTRAINT `fk_Aluno_has_Disciplina_Aluno` FOREIGN KEY (`Aluno_id_aluno`) REFERENCES `aluno` (`id_aluno`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Aluno_has_Disciplina_Disciplina1` FOREIGN KEY (`Disciplina_id_disciplina`) REFERENCES `disciplina` (`id_disciplina`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `matricula` (`Aluno_id_aluno`, `Disciplina_id_disciplina`) VALUES
	(12, 5),
	(13, 5),
	(17, 5),
	(12, 6),
	(13, 6),
	(17, 6),
	(16, 7),
	(19, 7),
	(12, 8),
	(19, 8),
	(16, 9),
	(13, 10),
	(16, 10),
	(18, 11);

CREATE TABLE IF NOT EXISTS `tabeladados` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `q1` varchar(1) NOT NULL,
  `q2` varchar(1) NOT NULL,
  `q3` varchar(1) NOT NULL,
  `q4` varchar(1) NOT NULL,
  `nota` double NOT NULL,
  `turma` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `tabeladados` (`id`, `nome`, `email`, `q1`, `q2`, `q3`, `q4`, `nota`, `turma`) VALUES
	(1, 'Rui', 'rui@gmail.com', 'a', 'b', 'c', 'd', 2, '6 serie B'),
	(2, 'Janaina Rita Reis', 'janaina@gmail.com', 'b', 'b', 'c', 'd', 7.5, '6 serie B'),
	(3, 'Tales Moreira Rocha', 'tales@gmail.com', 'a', 'd', 'd', 'a', 2.5, '8 serie C');


