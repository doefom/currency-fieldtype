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

        Inputmask(config).mask('#currency');
    },
    data() {
        return {
            val: this.value.value
        }
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
            // TODO: Parse radix point from pattern and so on
            return this.meta.currencies[this.iso].radix_point
        },
        groupSeparator() {
            return this.meta.currencies[this.iso].group_separator
        },
        digits() {
            return this.meta.currencies[this.iso].digits
        },
    },
    methods: {
        onInput(val) {
            this.update(val)
        },
    }
};
</script>
