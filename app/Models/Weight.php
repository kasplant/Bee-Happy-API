<?php

namespace App\Models;

use App\Database\Database;
use Exception;
use PDOException;

class Weight {

    public static function getAll(): ?array {
        $query = "
        SELECT *
        FROM hive_weights
        ";

        Database::query($query);
        return Database::getAll();
    }

    public static function find(int $id): ?array {
        $query = "
            SELECT *
            FROM hive_weights
            WHERE id = :id
        ";
        Database::query($query, [
            ":id" => $id,
        ]);
        return Database::getAll();
    }

    public static function getAllFromHive(int $hiveId): ?array {
        $query = "
            SELECT *
            FROM hive_weights
            WHERE hive_id = :hive_id
            ORDER BY recorded_at DESC
        ";
        Database::query($query, [
            ":hive_id" => $hiveId,
        ]);
        return Database::getAll();
    }

    public static function create($data): ?array {
        if ($data === null || empty($data)) {
            return null;
        }

        $query = "
        INSERT INTO hive_weights (
            hive_id,
            weight,
            recorded_at
        )
        VALUES (
            :hive_id,
            :weight,
            :recorded_at
        )
        ";
        Database::query($query, [
            ":hive_id" => $data['hive_id'],
            ":weight" => $data['weight'],
            ":recorded_at" => $data['recorded_at'] ?? date('Y-m-d H:i:s'),
        ]);
        $lastID = Database::lastInsertId();

        return ['message' => 'Weight record created', 'id' => $lastID] ?? [];
    }

    public static function update($data): ?array {
        if ($data['id'] === null || empty($data['id'])) {
            return ['error' => 'No id given'];
        }

        $updateableFields = ['hive_id', 'weight', 'recorded_at'];
        $setParts = [];
        $params = ['id' => $data['id'], 'updated_at' => date('Y-m-d H:i:s')];

        foreach ($updateableFields as $field) {
            if (array_key_exists($field, $data) && $data[$field] !== null) {
                $setParts[] = "$field = :$field";
                $params[$field] = $data[$field];
            }
        }

        if (empty($setParts)) {
            return [];
        }

        $query = "
            UPDATE hive_weights
            SET " . implode(', ', $setParts) . ", updated_at = :updated_at
            WHERE id = :id;
            SELECT ROW_COUNT()
            AS updated_rows;
        ";

        try {
            $updated = Database::query($query, $params);

            if ($updated > 0) {
                return ['message' => 'Weight record updated', 'id' => $data['id']];
            } else {
                throw new Exception('Weight record could not be updated');
            }
        } catch (PDOException) {
            throw new Exception('Database error');
        }
    }
}
