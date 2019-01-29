SELECT *
INTO OUTFILE '/tmp/enterprises.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY "\n"
FROM opengest.Empresas;

SELECT O.*, E.cif_nif
INTO OUTFILE '/tmp/operators.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY "\n"
FROM opengest.Operarios O
JOIN opengest.Empresas E
ON E.id = O.empresa_id;

SELECT *
INTO OUTFILE '/tmp/operators_checking_type.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY "\n"
FROM opengest.Tipos_revisiones_operario;

SELECT OC.*, OCT.nombre, O.dni
INTO OUTFILE '/tmp/operators_checking.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY "\n"
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
LINES TERMINATED BY "\n"
FROM opengest.Tipos_ausencias;

SELECT OA.*, OAT.nombre, O.dni
INTO OUTFILE '/tmp/operators_absence.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY "\n"
FROM opengest.Ausencias_operario OA
JOIN opengest.Tipos_ausencias OAT
ON OAT.id = OA.tipo_ausencia_id
JOIN opengest.Operarios O
ON O.id = OA.operario_id;

SELECT *
INTO OUTFILE '/tmp/vehicles_checking_type.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY "\n"
FROM opengest.Tipos_revision;

SELECT VC.*, VCT.nombre, V.matricula
INTO OUTFILE '/tmp/vehicles_checking.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY "\n"
FROM opengest.Revisiones VC
JOIN opengest.Tipos_revision VCT
ON VCT.id = VC.tIpo_revision_id
JOIN opengest.Vehiculos V
ON V.id = VC.vehiculo_id;

SELECT LA.*
INTO OUTFILE '/tmp/enterprise_activity_lines.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY "\n"
FROM opengest.Lineas_actividad LA;

SELECT TDC.*
INTO OUTFILE '/tmp/collection_document_types.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY "\n"
FROM opengest.Tipos_documentos_cobro TDC;

SELECT EGB.*
INTO OUTFILE '/tmp/enterprise_group_bountys.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY "\n"
FROM opengest.Grupos_primas EGB;

SELECT EH.*
INTO OUTFILE '/tmp/enterprise_holidays.csv'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '\\'
LINES TERMINATED BY "\n"
FROM opengest.Dias_festivos EH;
