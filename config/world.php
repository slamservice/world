<?php

return [
	/*
	|--------------------------------------------------------------------------
	| Allowed countries to be loaded
	| Leave it empty to load all countries else include the country iso2
	| value in the allowed_countries array
	|--------------------------------------------------------------------------
	*/
	'allowed_countries' => [],

	/*
	|--------------------------------------------------------------------------
	| Disallowed countries to not be loaded
	| Leave it empty to allow all countries to be loaded else include the
	| country iso2 value in the disallowed_countries array
	|--------------------------------------------------------------------------
	*/
	'disallowed_countries' => [],

    /*
	|--------------------------------------------------------------------------
	| Supported country code.
	|--------------------------------------------------------------------------
	*/
	'accepted_country_code' => [
		'AD',
		'AR',
		'AS',
		'AT',
		'AU',
		'AX',
		'AZ',
		'BD',
		'BE',
		'BG',
		'BM',
		'BR',
		'BY',
		'CA',
		'CH',
		'CL',
		'CO',
        'CR',
		'CY',
		'CZ',
		'DE',
		'DK',
		'DO',
		'DZ',
		'EE',
		'ES',
		'FI',
		'FM',
		'FO',
		'FR',
		'GB',
		'GF',
		'GG',
		'GL',
        'GP',
		'GT',
		'GU',
		'HR',
		'HU',
		'IE',
		'IM',
		'IN',
		'IS',
		'IT',
		'JE',
		'JP',
		'KR',
		'LI',
		'LK',
		'LT',
		'LU',
        'LV',
		'MC',
		'MD',
		'MH',
		'MK',
		'MP',
		'MQ',
		'MT',
		'MW',
		'MX',
		'MY',
		'NC',
		'NL',
		'NO',
		'NZ',
		'PE',
		'PH',
        'PK',
		'PL',
		'PM',
		'PR',
		'PT',
		'PW',
		'RE',
		'RO',
		'RS',
		'RU',
		'SE',
		'SG',
		'SI',
		'SJ',
		'SK',
		'SM',
		'TH',
        'TR',
		'UA',
		'US',
		'UY',
		'VA',
		'VI',
		'WF',
		'YT',
		'ZA',
	],

	/*
	|--------------------------------------------------------------------------
	| Supported locales.
	|--------------------------------------------------------------------------
	*/
	'accepted_locales' => [
		'ar',
		'bn',
		'br',
		'de',
		'en',
		'es',
		'fr',
		'it',
		'ja',
		'kr',
		'nl',
		'pl',
		'pt',
		'ro',
		'ru',
		'tr',
		'zh',
	],
	/*
	|--------------------------------------------------------------------------
	| Enabled modules.
	| The cities module depends on the states module.
	|--------------------------------------------------------------------------
	*/
	'modules' => [
		'states' => true,
		'cities' => true,
		'timezones' => true,
		'currencies' => true,
		'languages' => true,
	],
	/*
	|--------------------------------------------------------------------------
	| Routes.
	|--------------------------------------------------------------------------
	*/
	'routes' => true,
	/*
	|--------------------------------------------------------------------------
	| Migrations.
	|--------------------------------------------------------------------------
	*/
	'migrations' => [
		'countries' => [
			'table_name' => 'worldcountries',
			'optional_fields' => [
				'phone_code' => [
					'required' => true,
					'type' => 'string',
					'length' => 5,
				],
				'iso3' => [
					'required' => true,
					'type' => 'string',
					'length' => 3,
				],
				'native' => [
					'required' => false,
					'type' => 'string',
				],
				'region' => [
					'required' => true,
					'type' => 'string',
				],
				'subregion' => [
					'required' => true,
					'type' => 'string',
				],
				'latitude' => [
					'required' => false,
					'type' => 'string',
				],
				'longitude' => [
					'required' => false,
					'type' => 'string',
				],
				'emoji' => [
					'required' => false,
					'type' => 'string',
				],
				'emojiU' => [
					'required' => false,
					'type' => 'string',
				],
			],
		],
		'states' => [
			'table_name' => 'worldstates',
			'optional_fields' => [
				'country_code' => [
					'required' => true,
					'type' => 'string',
					'length' => 3,
				],
				'state_code' => [
					'required' => false,
					'type' => 'string',
					'length' => 6,
				],
				'latitude' => [
					'required' => false,
					'type' => 'string',
				],
				'longitude' => [
					'required' => false,
					'type' => 'string',
				],
			],
		],
		'cities' => [
			'table_name' => 'worldcities',
			'optional_fields' => [
				'country_code' => [
					'required' => true,
					'type' => 'string',
					'length' => 3,
				],
				'state_code' => [
					'required' => false,
					'type' => 'string',
					'length' => 6,
				],
				'latitude' => [
					'required' => false,
					'type' => 'string',
				],
				'longitude' => [
					'required' => false,
					'type' => 'string',
				],
                'zipcode' => [
					'required' => false,
					'type' => 'string',
				],
                'state' => [
					'required' => false,
					'type' => 'string',
				],
                'province' => [
					'required' => false,
					'type' => 'string',
				],
                'province_code' => [
					'required' => false,
					'type' => 'string',
				],
                'community' => [
					'required' => false,
					'type' => 'string',
				],
                'community_code' => [
					'required' => false,
					'type' => 'string',
				],
			],
		],
		'timezones' => [
			'table_name' => 'worldtimezones',
		],
		'currencies' => [
			'table_name' => 'worldcurrencies',
		],
		'languages' => [
			'table_name' => 'worldlanguages',
		],
	],
];
