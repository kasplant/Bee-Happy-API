<?php

namespace App\Http\Controllers;

use App\Models\Weight;

class WeightController {

    public function index(): ?array {
        return Weight::getAll();
    }

    public function find(int $id): ?array {
        return Weight::find($id);
    }

    public function getAllFromHive(int $hiveId): ?array {
        return Weight::getAllFromHive($hiveId);
    }

    public function create(array $data): ?array {
        return Weight::create($data);
    }

    public function update(array $data): ?array {
        return Weight::update($data);
    }
}
