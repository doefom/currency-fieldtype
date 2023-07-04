# Currency Fieldtype

Currency Fieldtype is a Statamic addon that lets you handle any currency with ease. Well, not any, but many at least.
168 to be precise. See which [currencies we currently support](#supported-currencies).

## Features

The addon makes sure you always got the right format depending on the locale and currency that's being used. While you
can safely ignore the addon when using it, it still provides useful information in the background in case you need it.
Here's the information you'll get:

- the value as a float (`1234.56`)
- the value as a formatted string (`'$1,234.56'`)
- the value as a formatted string without the symbol (`'1,234.56'`)
- the ISO code for the selected currency (`'USD'`)
- the symbol for the selected currency (`'$'`)
- whether the symbol is appended or prepended to the number (`true`/`false`)
- the group separator (for `'$1,234.56'` the group separator would be `,`)
- the radix point (for `'$1,234.56'` the radix point would be `.`)
- the number of decimal digits (for `'$1,234.56'` the number of digits would be `2`)

### Input Mask

The fieldtype implements a mask on the input field for each individual currency which provides a very smooth experience
when handling financial data or currencies.

## How to Install

You can search for this addon in the `Tools > Addons` section of the Statamic control panel and click **install**, or
run the following command from your project root:

``` bash
composer require doefom/currency-fieldtype
```

## How to Use

### Field Configuration

You can add the fieldtype to your blueprints like you would any other fieldtype that is already part of Statamic. For
configuration, everything you need to do is select which currency you would like to use, and you're good to go.

| Configuration Option | Description                                 | Default |
|----------------------|---------------------------------------------|---------|
| Currency             | The currency you want to use for the field. | `'USD'` |

### Usage in Antlers Templates

To give you all the flexibility and information you need the fieldtype supports augmentation so many more values are
available than just the plain value. Let's say we have a blueprint that uses the currency fieldtype with the field
handle `price`. After saving a value to an entry, this is what your data would look like:

```markdown
price: 1234.56
```

When using the field in an Antlers template, you got the following information at hand:

```text
{{ price:value }}                => 1234.56
{{ price:formatted }}            => '$1,234.56'
{{ price:formatted_no_symbols }} => '1,234.56'
{{ price:iso }}                  => 'USD'
{{ price:symbol }}               => '$'
{{ price:append }}               => false
{{ price:group_separator }}      => ','
{{ price:radix_point }}          => '.'
{{ price:digits }}               => 2
```

Same is true when using the Statamic API or in any other situation where the retrieved data is augmented.

## Caveats

### Changing the currency fieldtype's configuration after using it

If you've configured your currency fieldtype to use a specific currency, then save a bunch of entries with it and then
change its configuration, in most cases this won't cause any problems. The data will just be converted to the newly
configured currency. However, some currency conversion might cause issues and this is especially the case, when the
currency you convert into has fewer decimal digits than the one you started with.

For example:
Let's say we have an entry with a price (the field uses the Currency Fieldtype) of `1234.56`. In `USD` (US Dollar) this
will be displayed as `$1,234.56`. If you then convert to `JPY` (Japanese Yen) which has `0` decimal digits, you'll get a
wrong result of `¥1,235`. That's just something to keep in mind in case you'd need to reconfigure the field.

## Supported Currencies

```text
"AFA" => "Afghan Afghani",
"ALL" => "Albanian Lek",
"DZD" => "Algerian Dinar",
"AOA" => "Angolan Kwanza",
"ARS" => "Argentine Peso",
"AMD" => "Armenian Dram",
"AWG" => "Aruban Florin",
"AUD" => "Australian Dollar",
"AZN" => "Azerbaijani Manat",
"BSD" => "Bahamian Dollar",
"BHD" => "Bahraini Dinar",
"BDT" => "Bangladeshi Taka",
"BBD" => "Barbadian Dollar",
"BYR" => "Belarusian Ruble",
"BEF" => "Belgian Franc",
"BZD" => "Belize Dollar",
"BMD" => "Bermudan Dollar",
"BTN" => "Bhutanese Ngultrum",
"BTC" => "Bitcoin",
"BOB" => "Bolivian Boliviano",
"BAM" => "Bosnia-Herzegovina Convertible Mark",
"BWP" => "Botswanan Pula",
"BRL" => "Brazilian Real",
"GBP" => "British Pound Sterling",
"BND" => "Brunei Dollar",
"BGN" => "Bulgarian Lev",
"BIF" => "Burundian Franc",
"KHR" => "Cambodian Riel",
"CAD" => "Canadian Dollar",
"CVE" => "Cape Verdean Escudo",
"KYD" => "Cayman Islands Dollar",
"XOF" => "CFA Franc BCEAO",
"XAF" => "CFA Franc BEAC",
"XPF" => "CFP Franc",
"CLP" => "Chilean Peso",
"CLF" => "Chilean Unit of Account",
"CNY" => "Chinese Yuan",
"COP" => "Colombian Peso",
"KMF" => "Comorian Franc",
"CDF" => "Congolese Franc",
"CRC" => "Costa Rican Colón",
"HRK" => "Croatian Kuna",
"CUC" => "Cuban Convertible Peso",
"CZK" => "Czech Republic Koruna",
"DKK" => "Danish Krone",
"DJF" => "Djiboutian Franc",
"DOP" => "Dominican Peso",
"XCD" => "East Caribbean Dollar",
"EGP" => "Egyptian Pound",
"ERN" => "Eritrean Nakfa",
"EEK" => "Estonian Kroon",
"ETB" => "Ethiopian Birr",
"EUR" => "Euro",
"FKP" => "Falkland Islands Pound",
"FJD" => "Fijian Dollar",
"GMD" => "Gambian Dalasi",
"GEL" => "Georgian Lari",
"DEM" => "German Mark",
"GHS" => "Ghanaian Cedi",
"GIP" => "Gibraltar Pound",
"GRD" => "Greek Drachma",
"GTQ" => "Guatemalan Quetzal",
"GNF" => "Guinean Franc",
"GYD" => "Guyanaese Dollar",
"HTG" => "Haitian Gourde",
"HNL" => "Honduran Lempira",
"HKD" => "Hong Kong Dollar",
"HUF" => "Hungarian Forint",
"ISK" => "Icelandic Króna",
"INR" => "Indian Rupee",
"IDR" => "Indonesian Rupiah",
"IRR" => "Iranian Rial",
"IQD" => "Iraqi Dinar",
"ILS" => "Israeli New Sheqel",
"ITL" => "Italian Lira",
"JMD" => "Jamaican Dollar",
"JPY" => "Japanese Yen",
"JOD" => "Jordanian Dinar",
"KZT" => "Kazakhstani Tenge",
"KES" => "Kenyan Shilling",
"KWD" => "Kuwaiti Dinar",
"KGS" => "Kyrgystani Som",
"LAK" => "Laotian Kip",
"LVL" => "Latvian Lats",
"LBP" => "Lebanese Pound",
"LSL" => "Lesotho Loti",
"LRD" => "Liberian Dollar",
"LYD" => "Libyan Dinar",
"LTC" => "Litecoin",
"LTL" => "Lithuanian Litas",
"MOP" => "Macanese Pataca",
"MKD" => "Macedonian Denar",
"MGA" => "Malagasy Ariary",
"MWK" => "Malawian Kwacha",
"MYR" => "Malaysian Ringgit",
"MVR" => "Maldivian Rufiyaa",
"MRO" => "Mauritanian Ouguiya",
"MUR" => "Mauritian Rupee",
"MXN" => "Mexican Peso",
"MDL" => "Moldovan Leu",
"MNT" => "Mongolian Tugrik",
"MAD" => "Moroccan Dirham",
"MZM" => "Mozambican Metical",
"MMK" => "Myanmar Kyat",
"NAD" => "Namibian Dollar",
"NPR" => "Nepalese Rupee",
"ANG" => "Netherlands Antillean Guilder",
"TWD" => "New Taiwan Dollar",
"NZD" => "New Zealand Dollar",
"NIO" => "Nicaraguan Córdoba",
"NGN" => "Nigerian Naira",
"KPW" => "North Korean Won",
"NOK" => "Norwegian Krone",
"OMR" => "Omani Rial",
"PKR" => "Pakistani Rupee",
"PAB" => "Panamanian Balboa",
"PGK" => "Papua New Guinean Kina",
"PYG" => "Paraguayan Guarani",
"PEN" => "Peruvian Nuevo Sol",
"PHP" => "Philippine Peso",
"PLN" => "Polish Zloty",
"QAR" => "Qatari Rial",
"RON" => "Romanian Leu",
"RUB" => "Russian Ruble",
"RWF" => "Rwandan Franc",
"SVC" => "Salvadoran Colón",
"WST" => "Samoan Tala",
"STD" => "São Tomé and Príncipe Dobra",
"SAR" => "Saudi Riyal",
"RSD" => "Serbian Dinar",
"SCR" => "Seychellois Rupee",
"SLL" => "Sierra Leonean Leone",
"SGD" => "Singapore Dollar",
"SKK" => "Slovak Koruna",
"SBD" => "Solomon Islands Dollar",
"SOS" => "Somali Shilling",
"ZAR" => "South African Rand",
"KRW" => "South Korean Won",
"SSP" => "South Sudanese Pound",
"XDR" => "Special Drawing Rights",
"LKR" => "Sri Lankan Rupee",
"SHP" => "St. Helena Pound",
"SDG" => "Sudanese Pound",
"SRD" => "Surinamese Dollar",
"SZL" => "Swazi Lilangeni",
"SEK" => "Swedish Krona",
"CHF" => "Swiss Franc",
"SYP" => "Syrian Pound",
"TJS" => "Tajikistani Somoni",
"TZS" => "Tanzanian Shilling",
"THB" => "Thai Baht",
"TOP" => "Tongan Pa'anga",
"TTD" => "Trinidad & Tobago Dollar",
"TND" => "Tunisian Dinar",
"TRY" => "Turkish Lira",
"TMT" => "Turkmenistani Manat",
"UGX" => "Ugandan Shilling",
"UAH" => "Ukrainian Hryvnia",
"AED" => "United Arab Emirates Dirham",
"UYU" => "Uruguayan Peso",
"USD" => "US Dollar",
"UZS" => "Uzbekistan Som",
"VUV" => "Vanuatu Vatu",
"VEF" => "Venezuelan BolÃvar",
"VND" => "Vietnamese Dong",
"YER" => "Yemeni Rial",
"ZMK" => "Zambian Kwacha",
"ZWL" => "Zimbabwean dollar"
```

Your currency is missing? Feel free to submit a [GitHub issue](https://github.com/doefom/currency-fieldtype/issues),
we're happy to add yours as well!

## Support

This addon is under active maintenance. If something doesn't go as planned, or you see an opportunity to improve, just
open up a [GitHub issue,](https://github.com/doefom/currency-fieldtype/issues) and we'll do our best to take your
request into account.

## Attributions

### [heroicons](https://heroicons.com/)

Icons used in this package are from https://heroicons.com/.
