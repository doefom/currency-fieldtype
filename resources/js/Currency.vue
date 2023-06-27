<template>
    <text-input
        :value="value"
        type="text"
        id="currency"
        @input="update"
        :append="append ? this.symbol : false"
        :prepend="!append ? this.symbol : false"
    />
</template>

<script>
import Inputmask from "inputmask";

export default {
    mixins: [Fieldtype],
    mounted() {
        // Add input mask for currency fieldtype.
        const config = {
            alias: "currency",
            groupSeparator: this.groupSeparator,
            digits: this.digits,
        }

        if (this.digits > 0) {
            config.radixPoint = this.radixPoint;
        }

        Inputmask(config).mask('#currency');
    },
    computed: {
        iso() {
            return this.config.iso;
        },
        /**
         * Returns the symbol for the currency input.
         * @returns {string}
         */
        symbol() {
            return this.meta.currencies[this.iso].symbol
        },
        append() {
            return this.meta.currencies[this.iso].append
        },
        radixPoint() {
            return this.meta.currencies[this.iso].radix_point
        },
        groupSeparator() {
            return this.meta.currencies[this.iso].group_separator
        },
        digits() {
            return this.meta.currencies[this.iso].digits
        },
    },
};
</script>
