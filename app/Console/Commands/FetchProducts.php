<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Status;

class FetchProducts extends Command
{
    protected $signature = 'app:fetch-products';
    protected $description = 'Fetch products from FastPrint API';

    public function handle()
    {
        $serverTime = Carbon::now()->addHours(7);

        try {
            $head = Http::head('https://recruitment.fastprint.co.id/tes/api_tes_programmer');
            $dateHeader = $head->header('Date');
            if ($dateHeader) {
                $serverTime = Carbon::parse($dateHeader)->setTimezone('Asia/Jakarta');
            } else {
                 $serverTime = Carbon::now('Asia/Jakarta');
            }
        } catch (\Exception $e) {
            $serverTime = Carbon::now('Asia/Jakarta');
        }

        $this->info("Time used for Auth: " . $serverTime->toDateTimeString());

        $username = 'tesprogrammer' . $serverTime->format('dmy') . 'C' . $serverTime->format('H');
        $password = md5('bisacoding-' . $serverTime->format('d-m-y'));

        $this->info("Fetching data...");
        $response = Http::asForm()->post('https://recruitment.fastprint.co.id/tes/api_tes_programmer', [
            'username' => $username,
            'password' => $password
        ]);

        if ($response->failed()) {
            $this->error("Request Failed: " . $response->status());
            return;
        }

        $body = $response->json();
        if (isset($body['error']) && $body['error'] != 0) {
            $this->error("API Error: " . ($body['ket'] ?? 'Unknown'));
            return;
        }

        $items = $body['data'] ?? [];
        $this->info("Found " . count($items) . " items. Processing...");

        $bar = $this->output->createProgressBar(count($items));
        $bar->start();

        foreach ($items as $item) {
            $status = Status::firstOrCreate(
                ['nama_status' => $item['status']]
            );

            $kategori = Kategori::firstOrCreate(
                ['nama_kategori' => $item['kategori']]
            );

            $harga = is_numeric($item['harga']) ? $item['harga'] : 0;

            Produk::updateOrCreate(
                ['id_produk' => $item['id_produk']],
                [
                    'nama_produk' => $item['nama_produk'],
                    'harga' => $harga,
                    'kategori_id' => $kategori->id_kategori,
                    'status_id' => $status->id_status,
                ]
            );

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Data fetch completed.");

        try {
            $maxId = Produk::max('id_produk');
            if ($maxId) {
                \DB::statement("SELECT setval('produk_id_produk_seq', $maxId)");
            }
        } catch (\Exception $e) {
            $this->warn("Could not update sequence: " . $e->getMessage());
        }
    }
}
