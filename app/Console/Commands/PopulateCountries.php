<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Services\CountryService;
use Illuminate\Console\Command;

class PopulateCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:populate_countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate countries table from  https://restcountries.com/v2/regionalbloc/eu';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $countryService = new CountryService();
        //  dd($countryService->get_country_name('BE'));
        //   $countries =  $this->get_countries();
        //    $this->save($countries);
    }

    private function get_countries()
    {
        $url = "https://restcountries.com/v2/regionalbloc/eu";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array());
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0, //set to 2 on prod
            CURLOPT_SSL_VERIFYPEER => 0 //set to 2 on prod
        ]);
        $data = curl_exec($ch);
        $data = json_decode($data);
        $err = curl_error($ch);  //if you need
        if (!empty($err)) {
            dd($err);
        }
        curl_close($ch);
        return $data;
    }

    private function save($countries)
    {
        foreach ($countries as $country) {
            $name = $country->name;
            $code = $country->alpha2Code;
            $dial_code = $country->callingCodes[0];
            $cntry = new Country([
                'name' => trim($name),
                'code' => trim($code),
                'phone_code' => trim($dial_code),
            ]);
            $cntry->save();
        }
    }
}
