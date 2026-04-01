<?php

namespace App\Models;

use App\Database\Database;
use Exception;
use PDOException;

class Hive {

    public static function getAll(): ?array {
        $query = "
        SELECT *
        FROM hives
        ";

        Database::query($query);
        return Database::getAll();
    }

    public static function find(int $id): ?array {
        $query = "
            SELECT *
            FROM hives
            WHERE id = :id
        ";
        Database::query($query, [
            ":id" => $id,
        ]);
        return Database::getAll();
    }

    public static function create($data): ?array {
        if ($data === null || empty($data)) {
            return null;
        }

        $query = "
        INSERT INTO hives
        (user_id, name, queen_id, weight)
        VALUES (:user_id, :name, :queen_id, :weight)
        ";
        Database::query($query, [
            ":user_id"  => $data['user_id'],
            ":name"     => $data['name'],
            ":queen_id" => $data['queen_id'],
            ":weight"   => $data['weight'] ?? null,
        ]);
        $lastID = Database::lastInsertId();

        return ['message' => 'Hive created', 'id' => $lastID] ?? [];
    }

    public static function update($data): ?array {
        if ($data['id'] === null || empty($data['id'])) {
            return ['error' => 'No id given'];
        }

        $updateableFields = ['name', 'queen_id', 'weight'];
        $setParts = [];
        $params = ['id' => $data['id'], 'updated_at' => date('Y-m-d H:i:s')];

        foreach ($updateableFields as $field) {
            if (isset($data[$field]) && !empty($data[$field])) {
                $setParts[] = "$field = :$field";
                $params[$field] = $data[$field];
            }
        }

        if (empty($setParts)) {
            return [];
        }

        $query = "
            UPDATE hives
            SET " . implode(', ', $setParts) . ", updated_at = :updated_at
            WHERE id = :id;
            SELECT ROW_COUNT()
            AS updated_rows;
        ";

        try {
            $updated = Database::query($query, $params);

            if($updated > 0) {
                return ['message' => 'Hive updated', 'id' => $data['id']];
            } else {
                throw new Exception('Hive could not be updated');
            }
        } catch (PDOException) {
            throw new Exception('Database error');
        }
    }

    public static function updateSensorData(array $data): ?array {
        if ($data['id'] === null || empty($data['id'])) {
            return ['error' => 'No id given'];
        }

        $query = "
        UPDATE hives
        SET temperature = :temp, humidity = :hum, weight = :weight
        WHERE id = :id;
        SELECT ROW_COUNT()
        AS updated_rows;
        ";

        try {
            $updated = Database::query($query, [
                ':id' => $data['id'],
                ':temp' => $data['temperature'],
                ':hum' => $data['humidity'],
                ':weight' => $data['weight'] ?? null,
            ]);

            if ($updated > 0) {
                return ['message' => 'Hive updated', 'id' => $data['id']];
            } else {
                throw new Exception('Hive could not be updated');
            }
        } catch (PDOException) {
            throw new Exception('Database error');
        }
    }
}
