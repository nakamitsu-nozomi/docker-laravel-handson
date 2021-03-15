<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportPostalCodeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:postal_code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import postal-code';

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
        \App\PostalCode::truncate();
        // CSVファイルの文字コード変換
        $csv_path = storage_path('app/csv/KEN_ALL.CSV');
        $converted_csv_path = storage_path('app/csv/postal_code_utf8.csv');
        file_put_contents(
            $converted_csv_path,
            mb_convert_encoding(
                file_get_contents($csv_path),
                'UTF-8',
                'SJIS-win'
            )
        );

        // CSVから郵便データを取得してDBへ保存
        $file = new \SplFileObject($converted_csv_path);
        $file->setFlags(\SplFileObject::READ_CSV);

        foreach ($file as $row) {

            if (!is_null($row[0])) {

                \App\PostalCode::create([
                    'first_code' => intval(substr($row[2], 0, 3)),
                    'last_code' => intval(substr($row[2], 3, 4)),
                    'prefecture' => $row[6],
                    'city' => $row[7],
                    'address' => (str_contains($row[8], '（')) ? current(explode('（', $row[8])) : $row[8]
                ]);
            }
        }
    }
}
