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
        
        // check is java installed
        $javaVersion = exec('java -version');
        if (preg_match('/java version/i', $javaVersion) === false) {
            $this->error('[GAGAL] Java belum ter-install! Download Java di https://java.com/en/download/');
        } elseif (\Hash::make(1234) === $hash1234) {
            $this->info('[OK] Hash password berhasil.');
        } else {
            $this->error('[GAGAL] Hash password gagal!');
            $this->line('Todo:');
            $this->line('1. Comment baris "Illuminate\Hashing\HashServiceProvider::class" di file config/app.php bagian providers.');
            $this->line('2. Tambahkan "Ax\\Neo\\V1\\Auth\\HasherProvider," dibawahnya.');
        }
        
        // cek database connection
        $this->line('');
        $this->line('Test database connection, using connection name: ' . $dbConnectionName);
        try {
            \DB::connection($dbConnectionName)->statement('SHOW TABLES');
            
            $this->info('[OK] Berhasil terhubung dengan database.');
            $countUserHasPassword1234 = DB::table('user')->where([
                'password' => $hash1234
            ])->count();
            if ($countUserHasPassword1234 > 0) {} else {
                $this->error('[WARN] Cek lagi setting DB ke NEO!');
            }
        } catch (\Exception $e) {
            $this->error('[GAGAL] Konfigurasi terhubung dengan database NEO!');
            $this->error($e->getMessage());
        }
        
        // TODO cek bisa login gak
        // TODO cek apakah mau login pakai social media? jika ya pastikan table user punya field email
        // cek aplication id dan secret key facebook & gmail.
        
        $this->line('');
    }
}
