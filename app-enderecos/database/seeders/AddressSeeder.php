<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Libs\CsvReader;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $enable_max_to_seed = config('seeder_settings.enable_max_to_seed');
        $max_to_seed        = config('seeder_settings.max_to_seed');

        if(config('seeder_settings.seed_only_has_no_data'))
            if(Address::count())
                return;

        $file = database_path("ceps.txt");

        if(!file_exists($file))
            return;

        $delimiter  = ";";
        $reader     = new CsvReader($file);
        $csv_lines  = $reader->lineByLine(0, $delimiter);

        $i = 1;
        foreach ($csv_lines as $line)
        {
            if (!$line)
                return;

            $address['cep']         = trim($line[0] ?? null);
            $cidade_uf              = trim($line[1] ?? null);
            $address['bairro']      = trim($line[2] ?? null);
            $address['localizacao'] = trim($line[3] ?? null);

            if (!$cidade_uf || !is_string($cidade_uf))
                return;

            $cidade_uf = explode('/', $cidade_uf);

            if ( count($cidade_uf) != 2 || empty($cidade_uf) || empty($address['cep']) )
                return;

            $address['cidade']  = $cidade_uf[0] ?? \Str::random(5);
            $address['uf']      = $cidade_uf[1] ?? \Str::random(5);

            $new_address = Address::updateOrCreate([
                'cidade'      => $address['cidade'],
                'uf'          => $address['uf'],
                'localizacao' => $address['localizacao'],
            ], $address);

            if($new_address && config('seeder_settings.verbose'))
                if ($new_address)
                    echo PHP_EOL ."$i => ". implode("; ", array_values($address));

            if($enable_max_to_seed && $i >= $max_to_seed)
                return;

            $i++;
        }

        echo PHP_EOL;
    }
}
