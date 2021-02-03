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

    public function defineQuery($key)
    {
        switch ($key) {
            case 'chart-a4':
                $this->setQuery("SELECT U.GESTOR_ID, (SELECT NOME FROM USUARIO WHERE ID IN(U.GESTOR_ID)) AS LEADER, COUNT(ID) AS TEAM,
                    (SELECT MAX(REGISTRO) AS DATA FROM DESEMPENHO WHERE USUARIO_ID IN(SELECT ID FROM USUARIO WHERE GESTOR_ID=U.GESTOR_ID)) AS CREATED_AT,
                    (SELECT COUNT(*) FROM DESEMPENHO D WHERE D.REGISTRO = CREATED_AT AND D.USUARIO_ID IN(SELECT ID FROM USUARIO WHERE GESTOR_ID=U.GESTOR_ID)) AS REGISTER
                    FROM USUARIO U WHERE GESTOR_ID IN(31,58,99,149) AND SITUACAO = 'Ativo' GROUP BY 1;");
                break;
        }
    }
}

