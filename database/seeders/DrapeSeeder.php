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
            $this->command->error("❌ JSON file not found");
            return;
        }

        $data = json_decode(file_get_contents($filePath), true);

        if (!isset($data['value'])) {
            $this->command->error("❌ Invalid JSON");
            return;
        }

        // 🔥 CACHE ALL MANUFACTURERS FIRST (huge speed boost)
        $manufacturers = Manufacturer::all()->keyBy('name');

        $productsToInsert = [];
        $now = now();

        foreach ($data['value'] as $item) {

            $manufacturerName = trim($item['MarketAuthHolder'] ?? $item['Mnufacturer'] ?? '');
            $productName = trim($item['BrandName'] ?? '');

            if (!$manufacturerName || !$productName) {
                continue;
            }

            // normalize
            $manufacturerName = ucwords(strtolower($manufacturerName));

            // 🔥 avoid query per loop
            if (!isset($manufacturers[$manufacturerName])) {
                $manufacturers[$manufacturerName] = Manufacturer::create([
                    'name' => $manufacturerName
                ]);
            }

            $manufacturerId = $manufacturers[$manufacturerName]->id;

            $productsToInsert[] = [
                'name' => $productName,
                'fk_manufacturer_id' => $manufacturerId,
                'generic' => trim($item['Composition'] ?? ''),
                'description' => $item['DosageForm'] ?? null,
                'remarks' => $item['RegNum'] ?? null,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // 🔥 BULK INSERT IN CHUNKS (FAST)
        foreach (array_chunk($productsToInsert, 1000) as $chunk) {
            Product::upsert(
                $chunk,
                ['name', 'remarks'], // unique key
                ['fk_manufacturer_id', 'generic', 'description', 'status', 'updated_at']
            );
        }

        $this->command->info("✅ DRAP seeding completed fast!");
        $this->command->info("📦 Total processed: " . count($productsToInsert));
    }

}
