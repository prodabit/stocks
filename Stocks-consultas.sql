SELECT res.id, res.nome, ilpi.nome, ilpi.nome_abreviado
FROM residente res INNER JOIN ilpi ON ilpi.id = res.ilpi_id 
WHERE res.id = 196
WHERE res.nome LIKE '%terezinha%'

/* query para cadastrar receita_horario para os residentes que não tem */
INSERT INTO `receita_horario`(`receita_id`, `inicio_tratamento`, `fim_tratamento`, `qtde`, `horarios`, `ativo`)
SELECT rec.id, SUBSTR(rec.data_ult_atualiz,1,10) AS inicio_tratamento, NULL AS fim_tratamento, '01' AS qtde, '[{"value":"00:00"}]' AS horarios, '1' AS ativo
FROM receita rec WHERE rec.residente_id = 242

SELECT * FROM receita WHERE residente_id = 508
/* -------------------------------------------------------------------------- */
receitas 4532, 4534
SELECT * FROM mov_estoque WHERE receita_id IN (4532,4534)


SELECT * FROM residente WHERE nome LIKE 'adair%'
SELECT * FROM residente WHERE id = 189
SELECT * FROM receita_alteracao WHERE residente_id = 198

SELECT * FROM acompanhamento WHERE residente_id = 357

SELECT * FROM receita WHERE residente_id = 242
SELECT * FROM receita_horario WHERE receita_id IN (2055,2056,2057,2058,2059,4222)

SELECT * FROM receita WHERE medicamento LIKE '%VITAMINA D 7000UI%'
SELECT * FROM receita_historico WHERE receita_id = 3661
SELECT * FROM receita_horario WHERE receita_id = 3661



/* -------------------------------------------------------------------------------------------------*/
SELECT YEAR(cot.data) AS ano, MAX(cot.fech_ajustado) AS cotacao, IFNULL(tmp.valor, 0) AS valor 
FROM cotacoes `cot` 
  LEFT OUTER JOIN
  (SELECT YEAR(res.data) AS ano, res.codigo_conta, res.valor  
   FROM resultado res  INNER JOIN empresa ON empresa.id = res.empresa_id     
   WHERE res.codigo_conta = "4.01" AND empresa.cnpj = "84.429.695/0001-11") tmp ON tmp.ano = YEAR(cot.data) 
WHERE ticker = "WEGE3" AND (valor > 0 OR YEAR(NOW()) = YEAR(cot.data)) 
GROUP BY YEAR(cot.data) 
ORDER BY ano;

/* T1 -------------------------------------------------------------------------------------------------*/
SELECT YEAR(cot.data) AS ano, MAX(cot.fech_ajustado) AS cotacao, IFNULL(tmp.valor, 0) AS valor 
FROM cotacoes `cot` 
  INNER JOIN 
  (SELECT YEAR(res.data) AS ano, res.codigo_conta, res.valor  
   FROM resultado res  INNER JOIN empresa ON empresa.id = res.empresa_id     
   WHERE res.codigo_conta = "4.01" AND empresa.cnpj = "84.429.695/0001-11") tmp ON tmp.ano = YEAR(cot.data) 
WHERE ticker = "wege3" AND (valor > 0 OR YEAR(NOW()) = YEAR(cot.data)) 
GROUP BY YEAR(cot.data) 
ORDER BY ano;


SELECT DISTINCT(YEAR(DATA)) AS ano,  MAX(fech_ajustado) AS cotacao
FROM cotacoes,
	(SELECT YEAR(res.data) AS ano, res.codigo_conta, res.valor  
	 FROM resultado res  
	 WHERE res.empresa_id = 1 AND res.codigo_conta = "4.01" AND YEAR(res.data) = YEAR(cotacao.data)) tmp
WHERE ticker = 'wege3'
GROUP BY YEAR(DATA) 
ORDER BY ano;


SELECT ano, GROUP_CONCAT(codigo_conta) AS codigo_conta, GROUP_CONCAT(valor) AS valor FROM 
(SELECT DISTINCT(YEAR(DATA)) AS ano,  '000' AS codigo_conta, 'Cotacao' AS descricao, MAX(fech_ajustado) AS valor
FROM cotacoes
WHERE ticker = 'wege3'
GROUP BY YEAR(DATA) 
UNION
SELECT YEAR(res.data) AS ano, res.codigo_conta, cb.descricao, res.valor  
FROM resultado res  INNER JOIN codigo_balanco cb ON cb.codigo = res.codigo_conta
WHERE res.empresa_id = 1 AND res.codigo_conta IN('2.03', '2.08', '4.01', '6.01')
ORDER BY ano) tmp
WHERE ano >= 2010
GROUP BY ano

SELECT  GROUP_CONCAT(ano) AS ano, GROUP_CONCAT(v401) AS '4.01', GROUP_CONCAT(v203) AS '2.03', GROUP_CONCAT(v208) AS '2.08', GROUP_CONCAT(v601) AS '6.01', 
       GROUP_CONCAT(v605) AS '6.05', GROUP_CONCAT(v603) AS '6.03', GROUP_CONCAT(v307) AS '3.07', GROUP_CONCAT(v399) AS '3.99', 
       GROUP_CONCAT(v1) AS '1' FROM(
SELECT YEAR(res.data) AS ano, res.valor AS v401, res2.valor AS v203, IFNULL(res3.valor, 0) AS v208, IFNULL(res4.valor, 0) AS v601,
       IFNULL(res5.valor, 0) AS v605, IFNULL(res6.valor, 0) AS v603, IFNULL(res7.valor, 0) AS v307, IFNULL(res8.valor, 0) AS v399,
       IFNULL(res9.valor, 0) AS v1
FROM resultado res 
	LEFT OUTER JOIN resultado res2 ON res.empresa_id = res2.empresa_id AND YEAR(res.data) = YEAR(res2.data) AND res2.codigo_conta = '2.03'
	LEFT OUTER JOIN resultado res3 ON res.empresa_id = res3.empresa_id AND YEAR(res.data) = YEAR(res3.data) AND res3.codigo_conta = '2.08'
	LEFT OUTER JOIN resultado res4 ON res.empresa_id = res4.empresa_id AND YEAR(res.data) = YEAR(res4.data) AND res4.codigo_conta = '6.01'
	LEFT OUTER JOIN resultado res5 ON res.empresa_id = res5.empresa_id AND YEAR(res.data) = YEAR(res5.data) AND res5.codigo_conta = '6.05'
	LEFT OUTER JOIN resultado res6 ON res.empresa_id = res6.empresa_id AND YEAR(res.data) = YEAR(res6.data) AND res6.codigo_conta = '6.03'
	LEFT OUTER JOIN resultado res7 ON res.empresa_id = res7.empresa_id AND YEAR(res.data) = YEAR(res7.data) AND res7.codigo_conta = '3.07'
	LEFT OUTER JOIN resultado res8 ON res.empresa_id = res8.empresa_id AND YEAR(res.data) = YEAR(res8.data) AND res8.codigo_conta = '3.99'
	LEFT OUTER JOIN resultado res9 ON res.empresa_id = res9.empresa_id AND YEAR(res.data) = YEAR(res9.data) AND res9.codigo_conta = '1'	
WHERE res.empresa_id = 1 AND res.codigo_conta = '4.01') tmp

SELECT * FROM(
SELECT YEAR(res.data) AS ano, 0 AS cotacao, res.valor AS v401, res2.valor AS v203, IFNULL(res3.valor, 0) AS v208, IFNULL(res4.valor, 0) AS v601,
       IFNULL(res5.valor, 0) AS v605, IFNULL(res6.valor, 0) AS v603, IFNULL(res7.valor, 0) AS v307, IFNULL(res8.valor, 0) AS v399,
       IFNULL(res9.valor, 0) AS v1
FROM resultado res 
        INNER JOIN empresa e ON e.id = res.empresa_id
	LEFT OUTER JOIN resultado res2 ON res.empresa_id = res2.empresa_id AND YEAR(res.data) = YEAR(res2.data) AND res2.codigo_conta = '2.03'
	LEFT OUTER JOIN resultado res3 ON res.empresa_id = res3.empresa_id AND YEAR(res.data) = YEAR(res3.data) AND res3.codigo_conta = '2.08'
	LEFT OUTER JOIN resultado res4 ON res.empresa_id = res4.empresa_id AND YEAR(res.data) = YEAR(res4.data) AND res4.codigo_conta = '6.01'
	LEFT OUTER JOIN resultado res5 ON res.empresa_id = res5.empresa_id AND YEAR(res.data) = YEAR(res5.data) AND res5.codigo_conta = '6.05'
	LEFT OUTER JOIN resultado res6 ON res.empresa_id = res6.empresa_id AND YEAR(res.data) = YEAR(res6.data) AND res6.codigo_conta = '6.03'
	LEFT OUTER JOIN resultado res7 ON res.empresa_id = res7.empresa_id AND YEAR(res.data) = YEAR(res7.data) AND res7.codigo_conta = '3.07'
	LEFT OUTER JOIN resultado res8 ON res.empresa_id = res8.empresa_id AND YEAR(res.data) = YEAR(res8.data) AND res8.codigo_conta = '3.99'
	LEFT OUTER JOIN resultado res9 ON res.empresa_id = res9.empresa_id AND YEAR(res.data) = YEAR(res9.data) AND res9.codigo_conta = '1'	
WHERE res.empresa_id = 1 AND res.codigo_conta = '4.01' AND YEAR(res.data) >= 2010   
UNION
SELECT DISTINCT(YEAR(DATA)) AS ano,cotacoes.fech_ajustado AS cotacao,0,0,0,0,0,0,0,0,0
FROM cotacoes
WHERE ticker = 'wege3' AND YEAR(DATA) >= 2010   
GROUP BY YEAR(DATA) ) tmp
GROUP BY ano   
  

SELECT DISTINCT YEAR(res.data) AS ano 
FROM resultado res 
WHERE res.empresa_id = 1 AND res.codigo_conta IN('2.03', '2.08', '4.01', '6.01')
ORDER BY ano



SELECT fech_ajustado FROM cotacoes WHERE ticker = 'WEGE3' ORDER BY id DESC LIMIT 1
SELECT fech_ajustado FROM cotacoes WHERE ticker = 'WEGE3' ORDER BY DATA DESC LIMIT 1

SELECT * FROM link_arquivo_empresa WHERE cnpj = '00.416.968/0001-01'
UPDATE link_arquivo_empresa SET importado = '0' WHERE cnpj = '000.416.968/0001-01'

SELECT * FROM codigo_balanco WHERE LENGTH(codigo) < 5

SELECT * FROM resultado WHERE  codigo_conta IN('6.01','6.02','6.03')
SELECT * FROM cotacoes WHERE ticker = 'vamo3'
DELETE FROM cotacoes WHERE ticker = 'prio3'

'2.03' - patrimonio liquido
'2.08' - Patrimônio Líquido Consolidado
'4.01' - lucro liquido
'6.01' - Caixa Líquido Atividades Operacionais
'6.05' - Caixa Líquido Atividades de Investimento
'6.03' - Caixa Líquido Atividades de Financiamento
'3.07' - Resultado Antes dos Tributos sobre o Lucro
'3.99' - Lucro por Ação - (Reais / Ação)
'1' - ativo total
'2' - passivo total
'3.12' - Lucro/Prejuízo DO Período
'5.10' - Ações em Tesouraria

SELECT ano, SUM(cotacao) AS cotacao, SUM(v1) AS v1, SUM(v401) AS v401, SUM(v203) AS v203, SUM(v208) AS v208, SUM(v601) AS v601,
       SUM(v605) AS v605, SUM(v603) AS v603, SUM(v307) AS v307, SUM(v399) AS v399 
FROM ( 
        SELECT YEAR(res.data) AS ano, 0 AS cotacao, res.valor AS v1, res2.valor AS v203, IFNULL(res3.valor, 0) AS v208, IFNULL(res4.valor, 0) AS v601, 
               IFNULL(res5.valor, 0) AS v605, IFNULL(res6.valor, 0) AS v603, IFNULL(res7.valor, 0) AS v307, IFNULL(res8.valor, 0) AS v399,
               IFNULL(res9.valor, 0) AS v401 
        FROM resultado res 
                INNER JOIN empresa e ON e.id = res.empresa_id             
            LEFT OUTER JOIN resultado res2 ON e.id = res2.empresa_id AND res.data = res2.data AND res2.codigo_conta = '2.03' 
            LEFT OUTER JOIN resultado res3 ON e.id = res3.empresa_id AND res.data = res3.data AND res3.codigo_conta = '2.08' 
            LEFT OUTER JOIN resultado res4 ON e.id = res4.empresa_id AND res.data = res4.data AND res4.codigo_conta = '6.01' 
            LEFT OUTER JOIN resultado res5 ON e.id = res5.empresa_id AND res.data = res5.data AND res5.codigo_conta = '6.05' 
            LEFT OUTER JOIN resultado res6 ON e.id = res6.empresa_id AND res.data = res6.data AND res6.codigo_conta = '6.03' 
            LEFT OUTER JOIN resultado res7 ON e.id = res7.empresa_id AND res.data = res7.data AND res7.codigo_conta = '3.07' 
            LEFT OUTER JOIN resultado res8 ON e.id = res8.empresa_id AND res.data = res8.data AND res8.codigo_conta = '3.99' 
            LEFT OUTER JOIN resultado res9 ON e.id = res9.empresa_id AND res.data = res9.data AND res9.codigo_conta = '4.01' 
        WHERE e.cnpj = '02.916.265/0001-60' AND res.codigo_conta = '1' AND YEAR(res.data) >= 2010 AND MONTH(res.data) = 12
        UNION 
        SELECT DISTINCT(YEAR(DATA)) AS ano,cotacoes.fech_ajustado AS cotacao,0,0,0,0,0,0,0,0,0
        FROM cotacoes 
        WHERE ticker = 'jbss3'  AND YEAR(DATA) >= 2010 
        GROUP BY YEAR(DATA) ) tmp 
        GROUP BY ano;
        
        
        
SELECT * FROM(
SELECT MONTH(res.data) AS mes, YEAR(res.data) AS ano, res.valor
FROM resultado res INNER JOIN empresa e ON e.id = res.empresa_id                 
WHERE e.cnpj = '84.693.183/0001-68' AND res.codigo_conta = '1' AND YEAR(res.data) >= 2010 AND MONTH(res.data) = 12
UNION
SELECT IFNULL(MAX(MONTH(res.data)),0) AS mes, IFNULL(YEAR(res.data),2021) AS ano, IFNULL(res.valor,0) AS valor
FROM resultado res INNER JOIN empresa e ON e.id = res.empresa_id                 
WHERE e.cnpj = '10.629.105/0001-68' /*AND res.codigo_conta = '1'*/ AND YEAR(res.data) = 2021
GROUP BY ano, valor) tmp
ORDER BY ano, mes

SELECT DISTINCT(YEAR(DATA)) AS ano, fech_ajustado AS cotacao 
FROM cotacoes 
WHERE ticker = 'WEGE3' AND `data` >= '2010-01-01' GROUP BY YEAR(DATA) ORDER BY DATA DESC;

Weg : 84.429.695/0001-11
Shul: 84.693.183/0001-68
SELECT * FROM resultado WHERE empresa_id = 22 AND codigo_conta = '4.01' AND MONTH(DATA) = 12

SELECT * FROM empresa WHERE cnpj = '60.840.055/0001-31'


SELECT YEAR(DATA) AS ano, qtde_on, qtde_pn, qtde_total, qtde_tesouraria
FROM qtde_acoes_empresa
WHERE empresa_id = 3

resultado res INNER JOIN empresa e ON e.id = res.empresa_id             
WHERE e.cnpj = '84.429.695/0001-11' AND res.codigo_conta = '4.01' AND YEAR(res.data) >= 2010 AND MONTH(res.data) = 12

SELECT resultado FROM 


SELECT * FROM link_arquivo_empresa WHERE cnpj = '60.840.055/0001-31'
UPDATE link_arquivo_empresa SET importado = '0' WHERE cnpj = '84.429.695/0001-11'

SELECT * FROM resultado WHERE empresa_id = 14 AND codigo_conta = '4.01'


SELECT id, ilpi_id, ativo, nome, COUNT(nome) FROM residente
GROUP BY nome HAVING COUNT(nome) > 1

SELECT * FROM residente WHERE nome LIKE '%assump%'

DELETE FROM produto
DELETE FROM procard
UPDATE instituto_dias.produto SET sincronizado = '0'
UPDATE instituto_dias.procard SET sincronizado = '0'


SELECT id, codigo,descricao, nutri_id FROM produto


     SELECT rv.id, rv.data AS data_hora_venda, rv.id_movimento, 
            rv.vendedor AS usuario, rv.subtotal AS total_produtos, rv.desconto, rv.acrescimo, 
            rv.total AS total_final, rv.cancelado, IFNULL(prv.procard_id,0) AS id_procard 
     FROM recibo_venda rv 
     	INNER JOIN procard_recibo_venda prv ON rv.id = prv.recibo_venda_id 
     WHERE rv.sincronizado = '0' 
     ORDER BY rv.id DESC 
     LIMIT 50
     
UPDATE procard SET senha = '8baaceef28469346c1ec0bd5cbed8f86:F8rts8wFhSJ2ti4hUEES4CQLlN9I3SOM'     



SELECT 	`id`, 
	`numero`, 
	`saldo`, 
	`data_cadastro`, 
	`ultimo_acesso`, 
	`data_sincronismo`, 
	`senha`, 
	`acessos`, 
	`status`, 
	`classe`, 
	`usuario`, 
	`email`
	 
	FROM 
	`procardwebv4`.`procard` 
	LIMIT 0, 1000;
	
UPDATE recreando.produto SET sincronizado = '0';
UPDATE recreando.procard SET sincronizado = '0';
UPDATE recreando.nfce_cabecalho SET sincronizado = '0';
UPDATE recreando.produtos_recibo SET sincronizado = '0';
UPDATE recreando.procard_recarga SET sincronizado = '0';

UPDATE autopam.produto SET sincronizado = '1';

DELETE FROM procard_recarga;
DELETE FROM venda_detalhe;
DELETE FROM venda_cabecalho;
DELETE FROM procard;
DELETE FROM produto;

Cab: 3,4,6,7,11
Prod: 21,26,31,5,31,22,30,29,22


SELECT rv.id, CONCAT(rv.data_emissao, ' ', rv.hora_emissao) AS data_hora_venda, rv.id_movimento, 
             usr.nome AS usuario, rv.total_produtos, rv.desconto, rv.acrescimo, 
             rv.total_nf AS total_final, rv.cancelada AS cancelado, prv.procard_id AS id_procard 
      FROM nfce_cabecalho rv 
     	INNER JOIN procard_recibo_venda prv ON rv.id = prv.recibo_venda_id 
       INNER JOIN usuario usr ON usr.id = rv.id_usuario 
      WHERE rv.sincronizado = '0'
      LIMIT 100


SELECT COUNT(*) FROM recibo_venda rv INNER JOIN procard_recibo_venda prv ON prv.recibo_venda_id = rv.id
WHERE rv.sincronizado = '0'


SELECT ar.id, ar.data, ilpi.nome_abreviado AS ilpi, res.nome AS residente, ar.medicamento, ar.horario, ar.observacao, ar.profissional, ar.tipo_profissional, 'AR' AS modulo, '' AS campo_alterado
FROM receita_alteracao ar
	INNER JOIN residente res ON res.id = ar.residente_id
	INNER JOIN ilpi ON res.ilpi_id = ilpi.id
UNION 

SELECT h.receita_id, h.data, ilpi.nome_abreviado AS ilpi, res.nome AS residente, rec.medicamento, '' AS horario, '' AS observacao, usr.nome AS profissional, usr.tipo_usuario AS tipo_profissional, 'REC' AS modulo,
       CONCAT('Campo: ', h.campo, ' |Ant: ',h.valor_antigo, ' |Novo: ', h.valor_novo) AS campo_alterado	
FROM receita rec
	INNER JOIN receita_historico h ON h.receita_id = rec.id
	INNER JOIN residente res ON res.id = rec.residente_id
	INNER JOIN ilpi ON ilpi.id = res.ilpi_id
	INNER JOIN usuario usr ON usr.id = h.usuario_id
WHERE usr.tipo_usuario <> 'TEC'	
ORDER BY DATA DESC	







