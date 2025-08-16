<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Manufacturer;
use App\Models\Product;

class DrapeSeeder extends Seeder
{
    public function run()
    {
        $filePath = storage_path('app/drap-products.json');

        if (!file_exists($filePath)) {
            $this->command->error("❌ JSON file not found at: $filePath");
            return;
        }

        $json = file_get_contents($filePath);
        $data = json_decode($json, true);

        if (empty($data) || !isset($data['value'])) {
            $this->command->error("❌ Invalid or empty JSON file.");
            return;
        }

        foreach ($data['value'] as $item) {
            // Get manufacturer from MarketAuthHolder (fallback if Mnufacturer is null)
            $manufacturerName = trim($item['MarketAuthHolder'] ?? $item['Mnufacturer'] ?? '');
            $productName = trim($item['BrandName'] ?? '');
            $genericName = trim($item['Composition'] ?? '');

            if (!$manufacturerName || !$productName) {
                continue;
            }

            // 1️⃣ Insert or get manufacturer
            $manufacturer = Manufacturer::firstOrCreate(['name' => $manufacturerName]);

            // 2️⃣ Insert or update product
            Product::updateOrCreate(
                ['name' => $productName, 'fk_manufacturer_id' => $manufacturer->id],
                [
                    'generic' => $genericName,
                    'drug_class' => null, // No direct mapping in JSON
                    'description' => $item['DosageForm'] ?? null,
                    'pack_size' => null, // No pack size field in JSON
                    'status' => 1,
                    'remarks' => $item['RegNum'] ?? null,
                ]
            );
        }

        $this->command->info('✅ DRAP data imported from local JSON successfully.');
    }
}
