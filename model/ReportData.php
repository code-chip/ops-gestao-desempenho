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

    public function result(){
        $cnx = mysqli_query($this->db, $this->getQuery());
        return $cnx->fetch_all();
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

        }
    }
}

