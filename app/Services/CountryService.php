<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class CountryService extends Model
{

    public function get_country_name($country_code)
    {
        $url = "https://restcountries.com/v2/alpha/" . $country_code;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array());
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0, //set to 2 on prod
            CURLOPT_SSL_VERIFYPEER => 0 //set to 2 on prod
        ]);
        $data = curl_exec($ch);
        $data = json_decode($data);

        curl_close($ch);

        return $data->name;
    }
    //
}
