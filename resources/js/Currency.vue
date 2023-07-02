<template>
    <text-input
        :value="val"
        type="text"
        id="currency"
        @input="onInput"
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
        // #,##0.00 ¤
        const config = {
            alias: 'currency',
            groupSeparator: this.groupSeparator,
            digits: this.digits,
        }

        if (this.digits > 0) {
            config.radixPoint = this.radixPoint;
        }

        console.log(this.meta);

        Inputmask(config).mask('#currency');
    },
    data() {
        return {
            val: this.meta.formatted_no_symbol
        }
    },
    computed: {
        /**
         * Returns the symbol for the currency input.
         * @returns {string}
         */
        symbol() {
            return this.meta.symbol
        },
        append() {
            return this.meta.append
        },
        radixPoint() {
            return this.meta.radix_point
        },
        groupSeparator() {
            return this.meta.group_separator
        },
        digits() {
            return this.meta.digits
        },
    },
    methods: {
        onInput(val) {
            this.update(val)
        },
    }
};
</script>
