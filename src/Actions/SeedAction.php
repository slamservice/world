<?php

namespace Nnjeim\World\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Nnjeim\World\Models;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SeedAction extends Seeder
{
    private array $countries = [
        'data' => [],
    ];

    private array $modules = [
        'states' => [
            'class' => Models\State::class,
            'data' => [],
            'enabled' => false,
        ],
        'cities' => [
            'class' => Models\City::class,
            'data' => [],
            'enabled' => false,
        ],
        'timezones' => [
            'class' => Models\Timezone::class,
            'enabled' => false,
        ],
        'currencies' => [
            'class' => Models\Currency::class,
            'data' => [],
            'enabled' => false,
        ],
        'languages' => [
            'class' => Models\Language::class,
            'data' => [],
            'enabled' => false,
        ],
    ];

    public function __construct()
    {
        // countries
        $this->initCountries();
        // init modules
        foreach (config('world.modules') as $module => $enabled) {
            if ($enabled) {
                $this->modules[$module]['enabled'] = true;
                $this->initModule($module);
            }
        }
    }

    public function run(): void
    {
        $this->command->getOutput()->block('Seeding start');

        $this->command->getOutput()->progressStart(count($this->countries['data']));

        // country schema
        $countryFields = Schema::getColumnListing(config('world.migrations.countries.table_name'));

        $this->forgetFields($countryFields, ['id']);

        foreach (array_chunk($this->countries['data'], 20) as $countryChunks) {

            foreach ($countryChunks as $countryArray) {

                $countryArray = array_map(fn ($field) => gettype($field) === 'string' ? trim($field) : $field, $countryArray);

                $country = Models\Country::create(Arr::only($countryArray, $countryFields));
                // states and cities
                if ($this->isModuleEnabled('states')) {
                    $this->seedStates($country, $countryArray);
                }
                // timezones
                if ($this->isModuleEnabled('timezones')) {
                    $this->seedTimezones($country, $countryArray);
                }
                // currencies
                if ($this->isModuleEnabled('currencies')) {
                    $this->seedCurrencies($country, $countryArray);
                }

                $this->command->getOutput()->progressAdvance();
            }
        }

        // languages
        if ($this->isModuleEnabled('languages')) {
            $this->seedLanguages();
        }

        $this->command->getOutput()->progressFinish();

        $this->command->getOutput()->block('Seeding end');
    }

    /**
     * @param  string  $module
     * @return void
     */
    private function initModule(string $module)
    {
        if (array_key_exists($module, $this->modules)) {
            // truncate module database table.
            Schema::disableForeignKeyConstraints();
            app($this->modules[$module]['class'])->truncate();
            Schema::enableForeignKeyConstraints();
            // import json data.
            $moduleSourcePath = __DIR__ . '/../../resources/json/' . $module . '.json';

            if (File::exists($moduleSourcePath)) {
                if ($module == 'cities') {
                    // $fileJson = '';
                    // ini_set('memory_limit', '1024M');
                    // foreach (config('world.accepted_country_code') as $country_code) {
                    //     $moduleSourcePath = __DIR__ . '/../../resources/json/data/' . $country_code . '/zipcodes.'. strtolower($country_code) .'.json';
                    //     $fileReadJson = File::get($moduleSourcePath);
                    //     $fileReadJson = str_replace("[","",$fileReadJson);
                    //     $fileReadJson = str_replace("]",",",$fileReadJson);
                    //     $fileJson .= $fileReadJson;
                    //     //dd($fileJson);
                    // }
                    // //dd($fileJson);
                    // $fileJson = '['.$fileJson.']';
                    // $fileJson = str_replace(",]","]",$fileJson);
                    // $this->modules[$module]['data'] = json_decode($fileJson, true);
                    // //dd($this->modules[$module]['data']);
                } else {
                    $this->modules[$module]['data'] = json_decode(File::get($moduleSourcePath), true);
                }
            }
        }
    }

    /**
     * @param  string  $module
     * @return bool
     */
    private function isModuleEnabled(string $module): bool
    {
        return $this->modules[$module]['enabled'];
    }

    /**
     * @return void
     */
    private function initCountries(): void
    {
        app(Models\Country::class)->truncate();

        $this->countries['data'] = json_decode(File::get(__DIR__ . '/../../resources/json/countries.json'), true);

        if (!empty(config('world.allowed_countries')))
            $this->countries['data'] = Arr::where($this->countries['data'], function ($value, $key) {
                return in_array($value['iso2'], config('world.allowed_countries'));
            });

        if (!empty(config('world.disallowed_countries')))
            $this->countries['data'] = Arr::where($this->countries['data'], function ($value, $key) {
                return !in_array($value['iso2'], config('world.disallowed_countries'));
            });
    }

    /**
     * @param  Models\Country  $country
     * @param array $countryArray
     */
    private function seedStates(Models\Country $country, array $countryArray): void
    {
        // country states and cities
        $countryStates = Arr::where($this->modules['states']['data'], fn ($state) => $state['country_id'] === $countryArray['id']);
        // state schema
        $stateFields = Schema::getColumnListing(config('world.migrations.states.table_name'));
        //$country_zipcode =  config('world.accepted_country_zipcode');


        $this->forgetFields($stateFields, ['id', 'country_id']);

        foreach (array_chunk($countryStates, 20) as $stateChunks) {

            foreach ($stateChunks as $stateArray) {

                $stateArray = array_map(fn ($field) => gettype($field) === 'string' ? trim($field) : $field, $stateArray);
                //dd($stateArray);
                $country_code = $stateArray['country_code'];
                if (in_array($country_code, config('world.accepted_country_zipcode'))) {

                } else {
                    $state = $country
                    ->states()
                    ->create(Arr::only($stateArray, $stateFields));
                }

                //dd($stateArray,$state);

                // state cities
                if ($this->isModuleEnabled('cities')) {
                    //dd($this->modules['cities']['data'][0]);
                    //$fileJson = '';
                    ini_set('memory_limit', '1024M');
                    //foreach (config('world.accepted_country_code') as $country_code) {

                    if (in_array($country_code, config('world.accepted_country_zipcode'))) {

                        $moduleSourcePath = __DIR__ . '/../../resources/json/data/' . $country_code . '/zipcodes.' . strtolower($country_code) . '.json';
                        if (File::exists($moduleSourcePath)) {
                            $this->modules['cities']['data'] = json_decode(File::get($moduleSourcePath), true);
                            foreach ($this->modules['cities']['data']  as $zipcodeplace) {
                                //$stateArray['id'] = $zipcodeplace['zipcode'];
                                $stateArray['name'] = $zipcodeplace['state'];
                                $stateArray['state_code'] = $zipcodeplace['state_code'];
                                $state = $country
                                ->states()
                                ->firstOrCreate(Arr::only($stateArray, $stateFields));
                                $stateCities[0] = $zipcodeplace;
                                $stateCities[0]['name'] = $zipcodeplace['place'];
                                // dd($stateCities);
                                // $stateCities = Arr::where(
                                //     $this->modules['cities']['data'],
                                //     fn ($city) => $city['country_id'] = $countryArray['id'] && $city['state_id'] = $stateArray['id']
                                // );
                                // foreach ($stateCities as $key => $value) {
                                //     dd($key, $value);
                                //     $stateCities[$key] = $stateCities[$key];
                                // }
                                //dd($stateCities[0]);
                                $this->seedCities($country, $state, $stateCities);
                            }
                        }
                    } else {
                        $moduleSourcePath = __DIR__ . '/../../resources/json/cities.json';
                        if (File::exists($moduleSourcePath)) {
                            $this->modules['cities']['data'] = json_decode(File::get($moduleSourcePath), true);

                            $stateArray = array_map(fn ($field) => gettype($field) === 'string' ? trim($field) : $field, $stateArray);
                            $stateCities = Arr::where(
                                $this->modules['cities']['data'],
                                fn ($city) => $city['country_id'] === $countryArray['id'] && $city['state_id'] === $stateArray['id']
                            );

                            $this->seedCities($country, $state, $stateCities);
                        }
                    }
                    //dd('stop');

                    //$fileReadJson = File::get($moduleSourcePath);
                    //$fileReadJson = str_replace("[","",$fileReadJson);
                    //$fileReadJson = str_replace("]",",",$fileReadJson);
                    //$fileJson .= $fileReadJson;
                    //dd($fileJson);
                    //}
                    //dd($fileJson);
                    //$fileJson = '['.$fileJson.']';
                    //$fileJson = str_replace(",]","]",$fileJson);


                }
            }
        }
    }

    /**
     * @param  Models\Country  $country
     * @param  Models\State  $state
     * @param  array  $cities
     */
    private function seedCities(Models\Country $country, Models\State $state, array $cities): void
    {
        // state schema
        $cityFields = Schema::getColumnListing(config('world.migrations.cities.table_name'));
        //dd($country);
        $this->forgetFields($cityFields, ['id', 'country_id', 'state_id']);

        foreach (array_chunk($cities, 20) as $cityChunks) {

            foreach ($cityChunks as $cityArray) {

                $cityArray = array_map(fn ($field) => gettype($field) === 'string' ? trim($field) : $field, $cityArray);
                //dd($cityArray);
                $country
                    ->cities()
                    ->create(
                        array_merge(
                            Arr::only($cityArray, $cityFields),
                            ['state_id' => $state->id]
                        )
                    );
            }
        }
    }

    /**
     * @param  Models\Country  $country
     * @param $countryArray
     * @return void
     */
    private function seedTimezones(Models\Country $country, $countryArray): void
    {
        foreach ($countryArray['timezones'] as $timezone) {
            $country
                ->timezones()
                ->create([
                    'name' => (string) $timezone['zoneName'],
                ]);
        }
    }

    private function seedCurrencies(Models\Country $country, array $countryArray): void
    {
        // currencies
        $exists = in_array($countryArray['currency'], array_keys($this->modules['currencies']['data']), true);
        $currency = $exists
            ? $this->modules['currencies']['data'][$countryArray['currency']]
            : [
                'name' => (string) $countryArray['currency'],
                'code' => (string) $countryArray['currency'],
                'symbol' => (string) $countryArray['currency_symbol'],
                'symbol_native' => (string) $countryArray['currency_symbol'],
                'decimal_digits' => 2,
            ];
        $country
            ->currency()
            ->create([
                'name' => (string) $currency['name'],
                'code' => (string) $currency['code'],
                'symbol' => (string) $currency['symbol'],
                'symbol_native' => (string) $currency['symbol_native'],
                'precision' => (int) $currency['decimal_digits'],
            ]);
    }

    /**
     * @return void
     */
    private function seedLanguages(): void
    {
        // languages
        foreach ($this->modules['languages']['data'] as $language) {
            Models\Language::create($language);
        }
    }

    /**
     * @param  array  $array
     * @param  array  $values
     * @return void
     */
    private function forgetFields(array &$array, array $values)
    {
        foreach ($values as $value) {
            if (($key = array_search($value, $array)) !== false) {
                unset($array[$key]);
            }
        }
    }
}
