# Currency Fieldtype

> Currency Fieldtype is a Statamic addon that provides a "Currency" fieldtype.

## Features

This addon provides a "Currency" fieldtype that lets you choose one of the most used currencies in the world and is
especially
suitable for fields like `price` or `account_balance` in any of your blueprints. In the background it also brings you
useful information like:

- the value as a string (`'1,234.56'`)
- the value as a formatted string (`'$1,234.56'`)
- the raw value as a float (`1234.56`)
- the ISO code for the selected currency (`'USD'`)
- the name of the selected currency (`'US Dollar'`)
- the symbol for the selected currency (`'$'`)
- whether the symbol is appended or prepended to the number (`true`/`false`)
- whether there is a space between the symbol and the number (`true`/`false`)
- the group separator (for `'$1,234.56'` the group separator would be `,`)
- the radix point (for `'$1,234.56` the radix point would be `.`)
- the number of digits (for `'$1,234.56` the number of digits would be `2`)

On top of that it implements a mask on the input field to make sure the input is properly formatted as configured in the
field at any time.

## Currently Supported Currencies

1. USD (US Dollar)
2. EUR (Euro)
3. JPY (Japanese Yen)
4. GBP (Sterling)
5. CNY (Renminbi)
6. AUD (Australian Dollar)
7. CAD (Canadian Dollar)
8. CHF (Swiss Franc)
9. HKD (Hong Kong Dollar)
10. SGD (Singapore Dollar)
11. SEK (Swedish Krona)
12. KRW (South Korean Won)
13. NOK (Norwegian Krone)
14. NZD (New Zealand Dollar)
15. MXN (Mexican Peso)
16. BRL (Brazilian Real)
17. DKK (Danish Krone)
18. PLN (Polish Złoty)
19. THB (Thai Baht)
20. CZK (Czech Koruna)
21. TRY (Turkish Lira)
22. RON (Romanian Leu)

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

| Configuration Option | Description                                          | Default |
|----------------------|------------------------------------------------------|---------|
| Currency             | Select which currency you want to use for the field. | `'EUR'` |

### Usage in Antlers Templates

The following values are available when using the field in an Antlers template:

```markdown
value: '1,234.56'
formatted: '$1,234.56'
raw: 1234.56
iso: USD
name: 'US Dollar'
symbol: $
append: false
space: false
radix_point: .
group_separator: ','
digits: 2
```

And you may use it like so:

```text
{{ currency_field_handle:value }}           => '1,234.56'
{{ currency_field_handle:formatted }}       => '$1,234.56'
{{ currency_field_handle:raw }}             => 1234.56
{{ currency_field_handle:iso }}             => 'USD'
{{ currency_field_handle:name }}            => 'US Dollar'
{{ currency_field_handle:symbol }}          => '$'
{{ currency_field_handle:append }}          => false
{{ currency_field_handle:space }}           => false
{{ currency_field_handle:group_separator }} => ','
{{ currency_field_handle:radix_point }}     => '.'
{{ currency_field_handle:digits }}          => 2
```

## Caveats

If you add the currency field to a blueprint in a specific configuration, then save a value to an entry with it and then
later change the field configuration in the blueprint, you might run into issues with the formatting of the already
saved values.

To fix this you will have to type something in the field (it listens for an input event) and then save the entry again
to have the correct data stored in the entry after the field configuration change.
