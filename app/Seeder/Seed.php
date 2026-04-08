<?php

namespace App\Seeder;

use App\Database\Database;
use App\Models\Hive;
use App\Models\Queen;
use App\Models\Inspection;
use App\Models\Weight;

class Seed {

    public function seed(): array {
        $this->clearTables();

        $sql = "
        INSERT INTO users
        (firstname, lastname, email, password)
        VALUES (:first, :last, :email, :pass)
        ";
        Database::query($sql, [
            ":first" => "admin",
            ":last" => "admin",
            ":email" => "admin@mail.com",
            ":pass" => password_hash("root", PASSWORD_DEFAULT),
        ]);

        $this->seedQueen();
        $this->seedHive();
        $this->seedInspection();
        $this->seedWeight();

        return [
            'message' => 'Database reseeded',
            'seeded' => [
                'users' => 1,
                'queens' => 1,
                'hives' => 10,
                'inspections' => 10,
                'weights' => 10,
            ],
        ];
    }

    public function reseed(): void {
        $this->seed();
        header('Location: /', true, 302);
        exit;
    }

    private function seedHive(): void {
        $data = [
            "user_id" => 1,
            "name" => "Hive",
            "queen_id" => 1,
            "weight" => 35,
        ];

        for ($i=0; $i < 10; $i++) {
            Hive::create($data);
        }
    }

    private function seedQueen(): void {
        $data = [
            "race" => "None",
            "origin" => "None",
            "birth_year" => 2026,
            "fertilization_site" => "None",
            "clipped" => 0,
        ];
        Queen::create($data);
    }

    private function seedInspection(): void {
        $data = [
            "user_id" => 1,
            "hive_id" => 1,
            "queen_id" => 1,
            "date" => date('Y-m-d H:i:s'),
            "behaviour" => "Good",
            "queen_seen" => 0,
            "honeycomb_count" => 12,
            "windows_occupied" => 12,
            "BRIAS" => "Yes",
            "BRIAS_healthy" => "Yes",
            "invested_swarm_cells" => 12,
            "stock_food" => 200,
            "pollen" => 20,
            "mite_fall" => 20,
        ];

        for ($i=0; $i < 10; $i++) {
            Inspection::create($data);
        }

    }

    private function seedWeight(): void {
        $weight = 35.0;
        for ($i = 0; $i < 10; $i++) {
            Weight::create([
                "hive_id" => 1,
                "weight" => $weight,
                "recorded_at" => date('Y-m-d H:i:s', strtotime("-{$i} days")),
            ]);
            $weight += 0.5;
        }
    }

    private function clearTables(): void {
        Database::query('SET FOREIGN_KEY_CHECKS = 0');
        Database::query('TRUNCATE TABLE hive_weights');
        Database::query('TRUNCATE TABLE inspections');
        Database::query('TRUNCATE TABLE hives');
        Database::query('TRUNCATE TABLE queens');
        Database::query('TRUNCATE TABLE users');
        Database::query('SET FOREIGN_KEY_CHECKS = 1');
    }
}
