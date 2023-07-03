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
        console.log(this.value)
        console.log(this.meta)
        const config = {
            alias: 'currency',
            groupSeparator: this.groupSeparator,
            digits: this.digits,
        }

        if (this.digits > 0) {
            config.radixPoint = this.radixPoint;
        }

        Inputmask(config).mask('#currency');
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
            console.log(this.meta.append)
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
};
</script>
