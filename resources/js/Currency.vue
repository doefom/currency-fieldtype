<template>
    <text-input
        :value="value"
        @input="update"
        :id="id"
        :append="append ? this.symbol : false"
        :prepend="!append ? this.symbol : false"
        type="text"
    />
</template>

<script>
import Inputmask from "inputmask";
    
export default {
    mixins: [Fieldtype],
    mounted() {
        // Add input mask for currency fieldtype.
        const config = {
            alias: 'currency',
            groupSeparator: this.groupSeparator,
            digits: this.digits,
        }

        // Is the currency has at least one radix point, add the radix point to the input mask configuration.
        if (this.digits > 0) {
            config.radixPoint = this.radixPoint;
        }

        // Apply the input mask to the currency field.
        Inputmask(config).mask(this.id);
    },
    computed: {
        /**
         * The id of the input field.
         * @returns {string}
         */
        id() {
            return 'currency-input-' + this.fieldId;
        },
        /**
         * Returns the symbol for the currency input.
         * @returns {string}
         */
        symbol() {
            return this.meta.symbol
        },
        /**
         * Returns true if the currency symbol is appended to the input, false otherwise.
         * @returns {boolean}
         */
        append() {
            return this.meta.append
        },
        /**
         * The radix point symbol to use.
         * @returns {any}
         */
        radixPoint() {
            return this.meta.radix_point
        },
        /**
         * The group separator symbol to use.
         * @returns {string}
         */
        groupSeparator() {
            return this.meta.group_separator
        },
        /**
         * The number of decimal digits.
         * @returns {number}
         */
        digits() {
            return this.meta.digits
        },
    },
};
</script>
