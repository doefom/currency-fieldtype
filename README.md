# Currency Fieldtype

Currency Fieldtype is a Statamic addon that lets you handle any currency with ease.

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
- the radix point (for `'$1,234.56` the radix point would be `.`)
- the number of decimal digits (for `'$1,234.56` the number of digits would be `2`)

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
