# Currency Fieldtype

Currency Fieldtype is a Statamic addon that lets you handle any currency with ease by utilizing an input mask. Well, not
any, but many at least. 25 of the world's most traded ones to be precise. See
which [currencies we currently support](#supported-currencies).

## Features

The addon makes sure you always get the right format depending on the locale and currency that's being used. While you
can safely ignore the addon when using it, it still provides useful information in the background in case you need it.
Here's the information you'll get:

- the value as a float (`1234.56`)
- the value as a formatted string (`'$1,234.56'`)
- the value as a formatted string without the symbol (`'1,234.56'`)
- the ISO code for the selected currency (`'USD'`)
- the numeric code for the selected currency (`'840'`)
- the symbol for the selected currency (`'$'`)
- whether the symbol is appended or prepended to the number (`true`/`false`)
- the group separator (for `'$1,234.56'` the group separator would be `,`)
- the radix point (for `'$1,234.56'` the radix point would be `.`)
- the number of decimal digits (for `'$1,234.56'` the number of digits would be `2`)
- whether the value is stored in sub-units (`true`/`false`)
- the sub-unit-factor for the selected currency (`100`)

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
configuration, you simply need to select which currency you would like to use, and you're good to go. In addition, you 
can enable sub-unit storage for the field's value.

| Configuration Option | Description                                      | Default |
|----------------------|--------------------------------------------------|---------|
| Currency             | The currency you want to use for the field.      | `'USD'` |
| Sub-Units            | Store value in the currency's smallest sub-unit. | `false` |
| Default Value        | Set a default value.                             | `null`  |

### Usage in Antlers Templates

To give you all the flexibility and information you need the fieldtype supports augmentation so many more values are
available than just the plain value. Let's say we have a blueprint that uses the currency fieldtype with the field
handle `price`. After saving a value to an entry, this is what your data would look like:

```markdown
price: 1234.56
```

When using the field in an Antlers template, you have access to the following information:

```text
{{ price:value }}                => 1234.56
{{ price:formatted }}            => '$1,234.56'
{{ price:formatted_no_symbol }}  => '1,234.56'
{{ price:iso }}                  => 'USD'
{{ price:numeric_code }}         => '840'
{{ price:symbol }}               => '$'
{{ price:append }}               => false
{{ price:group_separator }}      => ','
{{ price:radix_point }}          => '.'
{{ price:digits }}               => 2
{{ price:store_sub_units }}      => false
{{ price:sub_unit_factor }}      => 100
```

The same is true when using the Statamic API or in any other situation where the retrieved data is augmented. When using
sub-unit value storage, the `formatted` values will be in the primary unit, while `value` is returned directly, in sub-units. 
In the example above, with sub-unit storage enabled, the first three values would consist of the following:

```text
{{ price:value }}                => 123456
{{ price:formatted }}            => '$1,234.56'
{{ price:formatted_no_symbol }}  => '1,234.56'
...
```

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

### Exchange rates

If you change the currency in the field configuration we just use another format, that's it. We do not convert any
currency into another.

## Supported Currencies

```text
"USD" => ["name" => "US Dollar", "numeric_code" => "840"],
"EUR" => ["name" => "Euro", "numeric_code" => "978"],
"JPY" => ["name" => "Yen", "numeric_code" => "392", "sub_unit_factor" => 1],
"GBP" => ["name" => "Pound Sterling", "numeric_code" => "826"],
"AUD" => ["name" => "Australian Dollar", "numeric_code" => "036"],
"CAD" => ["name" => "Canadian Dollar", "numeric_code" => "124"],
"CHF" => ["name" => "Swiss Franc", "numeric_code" => "756"],
"CNY" => ["name" => "Yuan Renminbi", "numeric_code" => "156"],
"SEK" => ["name" => "Swedish Krona", "numeric_code" => "752"],
"MXN" => ["name" => "Mexican Peso", "numeric_code" => "484"],
"NZD" => ["name" => "New Zealand Dollar", "numeric_code" => "554"],
"SGD" => ["name" => "Singapore Dollar", "numeric_code" => "702"],
"HKD" => ["name" => "Hong Kong Dollar", "numeric_code" => "344"],
"NOK" => ["name" => "Norwegian Krone", "numeric_code" => "578"],
"KRW" => ["name" => "Won", "numeric_code" => "410"],
"TRY" => ["name" => "Turkish Lira", "numeric_code" => "949"],
"INR" => ["name" => "Indian Rupee", "numeric_code" => "356"],
"RUB" => ["name" => "Russian Ruble", "numeric_code" => "643"],
"BRL" => ["name" => "Brazilian Real", "numeric_code" => "986"],
"ZAR" => ["name" => "Rand", "numeric_code" => "710"],
"DKK" => ["name" => "Danish Krone", "numeric_code" => "208"],
"PLN" => ["name" => "Zloty", "numeric_code" => "985"],
"TWD" => ["name" => "New Taiwan Dollar", "numeric_code" => "901"],
"THB" => ["name" => "Baht", "numeric_code" => "764"],
"MYR" => ["name" => "Malaysian Ringgit", "numeric_code" => "458"],
```

Your currency is missing? Feel free to submit a [GitHub issue](https://github.com/doefom/currency-fieldtype/issues),
we're happy to add yours as well!

## Support

This addon is under active maintenance. If something doesn't go as planned, or you see an opportunity to improve, just
open up a [GitHub issue,](https://github.com/doefom/currency-fieldtype/issues) and we'll do our best to take your
request into account.
