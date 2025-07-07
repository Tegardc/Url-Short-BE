<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShortUrlSeeder extends Seeder
{
    protected $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    private function generateRandomCode($length = 6): string
    {
        return collect(str_split($this->characters))
            ->shuffle()
            ->take($length)
            ->implode('');
    }

    public function run(): void
    {
        $batchSize = 1000;
        $total = 10000;
        $now = now();

        $allData = [];
        $existingCodes = DB::table('short_urls')->pluck('shortUrl')->toArray();
        $usedCodes = array_flip($existingCodes);

        for ($i = 0; $i < $total; $i++) {

            do {
                $code = $this->generateRandomCode(6);
            } while (isset($usedCodes[$code]));

            $usedCodes[$code] = true;

            $allData[] = [
                'originalUrl' => 'https://example.com/page/' . Str::random(10),
                'shortUrl' => $code,
                'createdAt' => $now,
            ];

            if (count($allData) >= $batchSize) {
                DB::table('short_urls')->insert($allData);
                $allData = [];
            }
        }

        if (!empty($allData)) {
            DB::table('short_urls')->insert($allData);
        }
    }
}
