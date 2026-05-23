<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class RefreshDrapJson extends Command
{
    protected $signature = 'drap:refresh-json';
    protected $description = 'Fetch latest DRAP products and store as JSON file';

    public function handle()
    {
        $this->info("🔄 Fetching DRAP XML data...");

        $response = Http::timeout(60)
            ->withHeaders([
                'Accept' => 'application/atom+xml',
                'Content-Type' => 'application/atom+xml',
                'User-Agent' => 'Mozilla/5.0',
                'Accept-Encoding' => 'gzip, deflate',
            ])
            ->get('https://public.dra.gov.pk/rd/ApplicationData.svc/Products');

        if (!$response->successful()) {
            $this->error("❌ HTTP Error: " . $response->status());
            return;
        }

        $xmlString = $response->body();

        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($xmlString);

        if (!$xml) {
            $this->error("❌ Failed to parse XML");
            return;
        }

        $products = [];

        foreach ($xml->entry as $entry) {

            $ns = $entry->content->children('m', true)->properties->children('d', true);

            $products[] = [
                'Id' => (string) $ns->Id,
                'RegNum' => (string) $ns->RegNum,
                'RegDate' => (string) $ns->RegDate,
                'BrandName' => (string) $ns->BrandName,
                'Composition' => (string) $ns->Composition,
                'DosageForm' => (string) $ns->DosageForm,
                'MarketAuthHolder' => (string) $ns->MarketAuthHolder,
                'IntendedTarget' => (string) $ns->IntendedTarget,
                'IsPublic' => (string) $ns->IsPublic,
                'RowVersion' => (string) $ns->RowVersion,
            ];
        }

        $filePath = storage_path('app/drap-products.json');

        file_put_contents(
            $filePath,
            json_encode(['value' => $products], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        $this->info("✅ DRAP JSON generated from XML successfully!");
        $this->info("📦 Total products: " . count($products));
    }
}