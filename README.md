# Currency Fieldtype

> Currency Fieldtype is a Statamic addon that provides a "Currency" fieldtype.

## Features

This addon provides a "Currency" fieldtype that lets you choose one out of more than 160 currencies and is especially
suitable for fields like `price` or `account_balance` in any of your blueprints. In the background it also brings you
useful information like:

- the value as a formatted string (`1.234,56 €`)
- the value as a string (`1.234,56`)
- the raw value as a float (`1234.56`)
- the ISO code for the selected currency (`EUR`)
- the symbol for the selected currency (`€`)
- whether the symbol is appended or prepended to the input string (`true`/`false`)
- the group separator (for `1.234,56 €` the group separator would be `.`)
- the radix point (for `1.234,56 €` the radix point would be `,`)

On top of that it implements a mask on the input field to make sure the input is properly formatted as configured in the
field at any time.

## How to Install

You can search for this addon in the `Tools > Addons` section of the Statamic control panel and click **install**, or
run the following command from your project root:

``` bash
composer require doefom/currency-fieldtype
```

## How to Use

### Field Configuration

You can add the fieldtype to your blueprints like you would any other fieldtype that is already part of Statamic. It
then lets you configure a few things:

| Configuration Option    | Description                                                                                                                                | Default |
|-------------------------|--------------------------------------------------------------------------------------------------------------------------------------------|---------|
| Currency                | Select which currency you want to use for the field.                                                                                       | `'EUR'` |
| Prepend Currency Symbol | Choose if the currency symbol should be _prepended_ or _appended_ to the input value. By default the symbol is appended.                   | `false` |
| Radix Point             | Select between `,` and `.` for the radix point. If you choose one as the radix point, the other will automatically be the group separator. | `','`   |

### Usage in Antlers Templates

The following values are available when using the field in an Antlers template:

```markdown
value: '1.234,56'
formatted: '1.234,56 €'
raw: 1234.56
iso: EUR
symbol: €
prepend: false
radix_point: ','
group_separator: .
```

And you may use it like so:

```text
{{ currency_field_handle:value }}           => '1.234,56'
{{ currency_field_handle:formatted }}       => '1.234,56 €'
{{ currency_field_handle:raw }}             => 1234.56
{{ currency_field_handle:iso }}             => 'EUR'
{{ currency_field_handle:symbol }}          => '€'
{{ currency_field_handle:prepend }}         => false
{{ currency_field_handle:radix_point }}     => ','
{{ currency_field_handle:group_separator }} => '.'
```

## Caveats

If you add the currency field to a blueprint in a specific configuration, then save a value to an entry with it and then
later change the field configuration in the blueprint, you might run into issues with the formatting of the already
saved values.

To fix this you will have to type something in the field (it listens for an input event) and then save the entry again
to have the correct data stored in the entry after the field configuration change.
