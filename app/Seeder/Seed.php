<?php

namespace App\Seeder;

use App\Database\Database;
use App\Models\Hive;
use App\Models\Queen;
use App\Models\Inspection;

class Seed {

    public function seed(): void {
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
}
