<template>
    <text-input
        :value="value"
        type="text"
        id="currency"
        @input="update"
        :append="!prepend ? this.symbol : false"
        :prepend="prepend ? this.symbol : false"
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
    computed: {
        /**
         * Returns the symbol for the currency input.
         * @returns {string}
         */
        symbol() {
            return this.meta.currencies[this.config.iso].symbol
        },
        prepend() {
            return this.config.prepend;
        },
        radixPoint() {
            return this.config.radix_point
        },
        groupSeparator() {
            return this.radixPoint === '.' ? ',' : '.';
        },
    },
};
</script>
