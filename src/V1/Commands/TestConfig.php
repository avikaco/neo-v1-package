<?php
namespace Ax\Neo\V1\Commands;

use Illuminate\Console\Command;

class TestConfig extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'neo:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test NEO package configuration.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dbConnectionName = env('DB_NEO_CONFIG', 'mysql');
        $hash1234 = 'G210jpq2xWtHfkChoM2DAA==';
        
        $this->line('');
        $this->line('Test NEO Hash:');
        if (\Hash::make(1234) === $hash1234) {
            $this->info('[OK] Hash password berhasil.');
        } else {
            $this->error('[GAGAL] Hash password gagal!');
            $this->line('Todo:');
            $this->line('1. Comment baris "Illuminate\Hashing\HashServiceProvider::class" di file config/app.php bagian providers.');
            $this->line('2. Tambahkan "Ax\\Neo\\V1\\Auth\\HasherProvider," dibawahnya.');
        }
        
        // cek database connection
        $dbError = false;
        $this->line('');
        $this->line('Test database connection, using connection name: ' . $dbConnectionName);
        try {
            \DB::connection($dbConnectionName)->statement('SHOW TABLES');
        } catch (\Exception $e) {
            $this->error('[GAGAL] Konfigurasi database NEO salah! ' . $e->getMessage());
        }
        if ($dbError === false) {
            $this->info('[OK] Berhasil terhubung dengan NEO database.');
        }
        // TODO cek bisa login gak
        // TODO cek apakah mau login pakai social media? jika ya pastikan table user punya field email
        // cek aplication id dan secret key facebook & gmail.
        
        $this->line('');
    }
}
