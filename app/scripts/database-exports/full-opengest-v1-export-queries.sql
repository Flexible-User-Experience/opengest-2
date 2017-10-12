SELECT *
INTO OUTFILE '/tmp/enterprises.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\n'
FROM opengest.Empresas;

SELECT O.*, E.cif_nif
INTO OUTFILE '/tmp/operators.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\n'
FROM opengest.Operarios O
JOIN opengest.Empresas E
ON E.id = O.empresa_id;

SELECT *
INTO OUTFILE '/tmp/operators_checking_type.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\n'
FROM opengest.Tipos_revisiones_operario;

SELECT OC.*, OCT.nombre, O.dni
INTO OUTFILE '/tmp/operators_checking.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\n'
FROM opengest.Revisiones_operario OC
JOIN opengest.Tipos_revisiones_operario OCT
ON OCT.id = OC.tipos_revision_operario_id
JOIN opengest.Operarios O
ON O.id = OC.operario_id;

SELECT *
INTO OUTFILE '/tmp/operators_absence_type.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\n'
FROM opengest.Tipos_ausencias;

SELECT OA.*, OAT.nombre, O.dni
INTO OUTFILE '/tmp/operators_absence.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY '\n'
FROM opengest.Ausencias_operario OA
JOIN opengest.Tipos_ausencias OAT
ON OAT.id = OA.tipo_ausencia_id
JOIN opengest.Operarios O
ON O.id = OA.operario_id;