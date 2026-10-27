import CurrencyFieldtype from './Currency.vue';

Statamic.booting(() => {
    Statamic.$components.register('currency-fieldtype', CurrencyFieldtype);
});
