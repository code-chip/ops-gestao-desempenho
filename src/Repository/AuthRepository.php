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
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;

        // $stmt = $this->db->query("SELECT * FROM coupons");
        // return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function postLoginNotifications(): mixed
    {
        $stmt = $this->db->prepare(
            "SELECT DATE_FORMAT(DATA_HORA, '%Y-%m-%d %H:%i') AS FORMATTED_DATA, TIMESTAMPDIFF(DAY, DATA_HORA, CURDATE()) AS DAYS,
                (SELECT COUNT(1) FROM FEEDBACK WHERE DESTINATARIO_ID = :userId AND SITUACAO = 'Aprovado') AS FEEDBACK,
                (SELECT COUNT(1) FROM SOLICITACAO WHERE DESTINATARIO_ID = :userId AND SITUACAO = 'Enviado') AS SOLICITACAO,
                (SELECT COUNT(1) FROM FEEDBACK WHERE SITUACAO = 'Enviado') AS WAIT,
                (SELECT MAX(ACESSO_TOTAL) FROM ACESSO WHERE USUARIO_ID = :userId) AS ACESSOS
            FROM ACESSO_HISTORICO 
            WHERE USUARIO_ID = :userId
            ORDER BY DATA_HORA DESC
            LIMIT 1 OFFSET 1"
        );
        $stmt->execute([':userId' => $_SESSION['userId']]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare("INSERT INTO coupons (code, discount, min_value, expires_at) VALUES (:code, :discount, :min_value, :expires_at)");
        $stmt->execute([
            ':code' => $data['code'],
            ':discount' => $data['discount'],
            ':min_value' => $data['min_value'],
            ':expires_at' => $data['expires_at'],
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function getByCode(string $code): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM coupons WHERE code = :code");
        $stmt->execute([':code' => $code]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
