<?php

/**
 * @copyright  Copyright (c) 2025 Code Chip (https://codechip.com.br)
 * @author     Will <willvix@outlook.com>
 * @Link       https://github.com/code-chip
 */

namespace App\Repository;

use App\Database\Connection;
use PDO;

class AuthRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function checkLogin(array $input): mixed
    {
        $stmt = $this->db->prepare("SELECT ID, NOME, CARGO_ID, GESTOR_ID, PERMISSAO_ID, MATRICULA 
            FROM USUARIO 
            WHERE LOGIN = :user AND SENHA=md5(:password) AND SITUACAO <> 'Desligado'");
        $stmt->execute([
            ':user' => $input['user'], 
            ':password' => $input['password']
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
    }
}
