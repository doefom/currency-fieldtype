<template>
    <text-input
        v-model="val"
        type="text"
        id="currency"
        @input="onInput"
        :append="append ? symbol : false"
        :prepend="prepend ? symbol : false"
    />
</template>

<script>
import Inputmask from "inputmask";

export default {
    mixins: [Fieldtype],
    mounted() {
        Inputmask({
            alias: "currency",
            groupSeparator: this.groupSeparator,
            radixPoint: this.radixPoint
        }).mask('#currency');
    },
    data() {
        return {
            val: this.value?.value
        }
    },
    computed: {
        /**
         * Returns the symbol for the currency input.
         * If no symbol is provided in the value, it uses the default symbol from the currencies.
         * @returns {string}
         */
        symbol() {
            return " " + (this.value?.symbol ?? this.meta.currencies[this.config.iso].symbol)
        },
        append() {
            return this.config.symbol_position === 'append'
        },
        prepend() {
            return this.config.symbol_position === 'prepend'
        },
        groupSeparator() {
            return this.config.group_separator
        },
        radixPoint() {
            return this.config.radix_point
        },
    },
    methods: {
        onInput(val) {
            this.update({
                value: val, // TODO: Save value as float. Note: parseFloat won't work on european number formats.
                iso: this.config.iso,
                symbol: this.symbol,
                group_separator: this.groupSeparator,
                radix_point: this.radixPoint
            });
        },
    }
};
</script>
