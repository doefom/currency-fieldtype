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
        // Add input mask for currency fieldtype.
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
         * @returns {string}
         */
        symbol() {
            return this.meta.currencies[this.config.iso].symbol
        },
        append() {
            return this.config.symbol_position === 'append'
        },
        prepend() {
            return this.config.symbol_position === 'prepend'
        },
        groupSeparator() {
            return this.radixPoint === '.' ? ',' : '.';
        },
        radixPoint() {
            return this.config.radix_point
        },
    },
    methods: {
        onInput(val) {
            this.update({
                value: val,
                valueFormatted: val + ' ' + this.symbol,
                valueRaw: this.parseToRawValue(val),
                iso: this.config.iso,
                symbol: this.symbol,
                group_separator: this.groupSeparator,
                radix_point: this.radixPoint
            });
        },

        parseToRawValue(val) {
            // 1: Replace all group separators to only have left the radix point
            // 2: Replace all a comma with a dot.
            // If the number is already in US format, the dot will be replaced with a dot.
            // Else the number is in EU format and the comma (radix point) will be replaced with a dot.
            let usFormat = val.replaceAll(this.groupSeparator, '').replace(this.radixPoint, '.');
            return parseFloat(usFormat);
        },
    }
};
</script>
