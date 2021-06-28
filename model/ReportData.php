<?php

require_once('connection.php');

class ReportData
{
    private $db;
    private $query;

    public function __construct()
    {
        $this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        $this->db->set_charset('utf8');
    }

    public function result()
    {
        $cnx = mysqli_query($this->db, $this->getQuery());

        return $cnx->fetch_all();
    }

    public function result_array()
    {
        $cnx = mysqli_query($this->db, $this->getQuery());
        $array = [];
        while ($dado = $cnx->fetch_array()) {
            $array[] = $dado;
        }
        return $array;
    }

    public function setQuery($query)
    {
        $this->query = $query;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function defineQuery($key, $value)
    {
        switch ($key) {
            case 'chart-a1':
                $this->setQuery("SELECT TRUNCATE(AVG(DESEMPENHO),2)MEDIA, TRUNCATE((SELECT MIN(DESEMPENHO) FROM DESEMPENHO WHERE DESEMPENHO>0 AND ANO_MES= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 3 MONTH),'%Y-%m')),2)MENOR FROM DESEMPENHO 
                    WHERE ANO_MES = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 3 MONTH),'%Y-%m') AND PRESENCA_ID NOT IN(3,5)
                    UNION ALL
                    SELECT TRUNCATE(AVG(DESEMPENHO),2)MEDIA, TRUNCATE((SELECT MIN(DESEMPENHO) FROM DESEMPENHO WHERE DESEMPENHO>0 AND ANO_MES= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH),'%Y-%m')),2)MENOR FROM DESEMPENHO 
                    WHERE ANO_MES = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 2 MONTH),'%Y-%m') AND PRESENCA_ID NOT IN(3,5)
                    UNION ALL
                    SELECT TRUNCATE(AVG(DESEMPENHO),2)MEDIA, TRUNCATE((SELECT MIN(DESEMPENHO) FROM DESEMPENHO WHERE DESEMPENHO>0 AND ANO_MES= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH),'%Y-%m')),2)MENOR FROM DESEMPENHO 
                    WHERE ANO_MES = DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH),'%Y-%m') AND PRESENCA_ID NOT IN(3,5)
                    UNION ALL
                    SELECT TRUNCATE(AVG(DESEMPENHO),2)MEDIA, TRUNCATE((SELECT MIN(DESEMPENHO) FROM DESEMPENHO WHERE DESEMPENHO>0 AND ANO_MES= DATE_FORMAT(CURDATE(),'%Y-%m')),2)MENOR FROM DESEMPENHO 
                    WHERE ANO_MES = DATE_FORMAT(CURDATE(), '%Y-%m') AND PRESENCA_ID NOT IN(3,5);");
                break;

            case 'chart-a3':
                $this->setQuery("SELECT U.NOME, AVG(DESEMPENHO) MEDIA FROM DESEMPENHO INNER JOIN USUARIO U ON U.ID=USUARIO_ID	WHERE PRESENCA_ID NOT IN (3,5) AND ANO_MES
                ='" . $value . "' GROUP BY USUARIO_ID ORDER BY MEDIA DESC LIMIT 5;");
                break;

            case 'chart-a4':
                $this->setQuery("SELECT U.GESTOR_ID, (SELECT NOME FROM USUARIO WHERE ID IN(U.GESTOR_ID)) AS LEADER, COUNT(ID) AS TEAM,
                    (SELECT MAX(REGISTRO) AS DATA FROM DESEMPENHO WHERE USUARIO_ID IN(SELECT ID FROM USUARIO WHERE GESTOR_ID=U.GESTOR_ID)) AS CREATED_AT,
                    (SELECT COUNT(*) FROM DESEMPENHO D WHERE D.REGISTRO = CREATED_AT AND D.USUARIO_ID IN(SELECT ID FROM USUARIO WHERE GESTOR_ID=U.GESTOR_ID)) AS REGISTER
                    FROM USUARIO U WHERE GESTOR_ID IN(31,58,99,149) AND SITUACAO = 'Ativo' GROUP BY 1;");
                break;

            case 'select-sector':
                $this->setQuery("SELECT ID, NOME FROM SETOR WHERE SITUACAO = 'Ativo'");
                break;

            case 'select-turn':
                $this->setQuery("SELECT ID, NOME FROM TURNO WHERE SITUACAO = 'Ativo'");
                break;

            case 'grouped':
                $this->setQuery(
                    "SELECT U.NOME, D.USUARIO_ID AS ID, (SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$value['month']."') AS FALTA, (SELECT COUNT(*) 
                    FROM DESEMPENHO WHERE PRESENCA_ID=3 AND D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$value['month']."') AS FOLGA, (SELECT IFNULL(SUM(OCORRENCIA),0) FROM PENALIDADE WHERE D.USUARIO_ID=USUARIO_ID
                     AND ANO_MES='".$value['month']."') AS OCORRENCIA, (SELECT IFNULL(SUM(PENALIDADE_TOTAL),0) FROM PENALIDADE WHERE D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$value['month']."') AS TOTAL, 
                     TRUNCATE(B.DESEMPENHO,2) AS DESEMPENHO, CONCAT(DATE_FORMAT('".$value['month']."-01','%d/%m'),' a ".$value['date']."') AS REGISTRO FROM DESEMPENHO AS D, (SELECT USUARIO_ID, AVG(DESEMPENHO) 
                     DESEMPENHO FROM DESEMPENHO WHERE ANO_MES='".$value['month']."' AND PRESENCA_ID NOT IN (3,5) GROUP BY USUARIO_ID) AS B INNER JOIN USUARIO U ON U.ID=B.USUARIO_ID WHERE 
                     D.USUARIO_ID=B.USUARIO_ID AND ANO_MES='".$value['month']."'".$value['goal']." ".$value['turn']." ".$value['sector']." GROUP BY D.USUARIO_ID ORDER BY ".$value['order'].";"
                );
                break;
            case 'separate':
                $this->setQuery("SELECT U.NOME, D.USUARIO_ID AS ID, A.NOME AS ATIVIDADE, (SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=2 AND D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$value['month']."') AS FALTA, 
                    (SELECT COUNT(*) FROM DESEMPENHO WHERE PRESENCA_ID=3 AND D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$value['month']."') AS FOLGA, (SELECT IFNULL(SUM(OCORRENCIA),0) FROM PENALIDADE WHERE D.USUARIO_ID=
                    USUARIO_ID AND ANO_MES='".$value['month']."') AS OCORRENCIA, (SELECT IFNULL(SUM(PENALIDADE_TOTAL),0) FROM PENALIDADE WHERE D.USUARIO_ID=USUARIO_ID AND ANO_MES='".$value['month']."') AS TOTAL, 
                    TRUNCATE(B.DESEMPENHO,2) AS DESEMPENHO, CONCAT(DATE_FORMAT('".$value['month']."-01','%d/%m'),' a ".$value['date']."') AS REGISTRO FROM DESEMPENHO AS D, (SELECT USUARIO_ID, AVG(DESEMPENHO) DESEMPENHO,ATIVIDADE_ID
                     FROM DESEMPENHO WHERE ANO_MES='".$value['month']."' AND PRESENCA_ID NOT IN (3,5) GROUP BY USUARIO_ID, ATIVIDADE_ID) AS B INNER JOIN USUARIO U ON U.ID=B.USUARIO_ID INNER JOIN ATIVIDADE A ON 
                     A.ID=B.ATIVIDADE_ID WHERE D.USUARIO_ID=B.USUARIO_ID AND ANO_MES='".$value['month']."'".$value['goal']." " .$value['turn']." AND D.ATIVIDADE_ID=B.ATIVIDADE_ID ".$value['sector']." GROUP BY D.USUARIO_ID, D.ATIVIDADE_ID 
                     ORDER BY ".$value['order'].";"
                );
                break;
            case 'weight':
                $this->setQuery("SELECT OPERADOR, EMPRESA, (SELECT ROUND(DESEMPENHO, 2) FROM META_EMPRESA WHERE ANO_MES='" . $value . "') AS ALCANCADO FROM META_PESO WHERE ANO_MES='" . $value . "';");
                break;
        }
    }

    public function converterArrayToString($separator, $array)
    {
        return implode($separator, $array);
    }

    public function mountSelect($selectName)
    {
        switch ($selectName) {
            case 'sector':
                $this->defineQuery('select-sector', null);
                foreach ($this->result_array() as $values){
                    $select .= "<option value='AND SETOR_ID=" . $values["ID"] . "'>" . $values["NOME"] . "</option>";
                }
                break;
            case 'turn':
                $this->defineQuery('select-turn', null);
                foreach ($this->result_array() as $values){
                    $select .= "<option value='AND TURNO_ID=" . $values["ID"] ."'>" . $values["NOME"] . "</option>";
                }
                break;
            case 'month':
                $select =
                    "<option selected='selected' value='" . date('Y-m') . "'>". date('m/Y', strtotime('+1 months')) . "</option>
                    <option value='" . date('Y-m', strtotime('-1 months')) . "'>" . date('m/Y') ."</option>
                    <option value='" . date('Y-m', strtotime('-2 months')) . "'>" . date('m/Y', strtotime('-1 months')) . "</option>
                    <option value='" . date('Y-m', strtotime('-3 months')) . "'>" . date('m/Y', strtotime('-2 months')) . "</option>
                    <option value='" . date('Y-m', strtotime('-4 months')) . "'>" . date('m/Y', strtotime('-3 months')) . "</option>
                    <option value='" . date('Y-m', strtotime('-5 months')) . "'>" . date('m/Y', strtotime('-4 months')) . "</option>
                    <option value='" . date('Y-m', strtotime('-6 months')) . "'>" . date('m/Y', strtotime('-5 months')) . "</option>";
        }
        return $select;
    }
}

