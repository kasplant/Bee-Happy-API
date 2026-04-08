<?php

return [
    // Get data
    'GET' => [
        'hives' => [App\Http\Controllers\HiveController::class, 'index'],
        'hive' => [App\Http\Controllers\HiveController::class, 'find'],

        'queens' => [App\Http\Controllers\QueenController::class, 'index'],
        'queen' => [App\Http\Controllers\QueenController::class, 'find'],

        'inspections' => [App\Http\Controllers\InspectionController::class, 'index'],
        'inspection' => [App\Http\Controllers\InspectionController::class, 'find'],
        'hive-inspections' => [App\Http\Controllers\InspectionController::class, 'getAllFromHive'],
        'weights' => [App\Http\Controllers\WeightController::class, 'index'],
        'weight' => [App\Http\Controllers\WeightController::class, 'find'],
        'hive-weights' => [App\Http\Controllers\WeightController::class, 'getAllFromHive'],

        'seed' => [App\Seeder\Seed::class, 'seed'],
    ],
    // Create
    'POST' => [
        'hive' => [App\Http\Controllers\HiveController::class, 'create'],
        'queen' => [App\Http\Controllers\QueenController::class, 'create'],
        'inspection' => [App\Http\Controllers\InspectionController::class, 'create'],
        'weight' => [App\Http\Controllers\WeightController::class, 'create'],
    ],
    // Update
    'PATCH' => [
        'hive' => [App\Http\Controllers\HiveController::class, 'update'],
        'inspection' => [App\Http\Controllers\InspectionController::class, 'update'],
        'queen' => [App\Http\Controllers\QueenController::class, 'update'],
        'weight' => [App\Http\Controllers\WeightController::class, 'update'],
        'sensor' => [App\Http\Controllers\HiveController::class, 'updateSensorData'],
    ],
    'DELETE' => [
    ],

];
