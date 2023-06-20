<template>
    <div style="display: flex;">
        <text-input
            id="currency"
            type="text"
            v-model="result.val"
        />
        <select-input
            :options="[
                { value: 'EUR', label: '€'},
                { value: 'USD', label: '$'}
                ]"
            v-model="result.iso">
        </select-input>
        {{ result }}
    </div>
</template>

<script>
import Inputmask from "inputmask";

export default {
    mixins: [Fieldtype],
    mounted() {
        Inputmask(
            {
                alias: "currency",
                groupSeparator: ",",
                radixPoint: ",",
            }
        ).mask('#currency');
    },
    data() {
        return {
            result: this.value ?? {},
            val: this.value?.val,
            iso: this.value?.iso,
            symbol: this.value?.symbol,
        }
    },
    computed: {
        inputType() {
        }
    },
    watch: {
        result(result) {
            this.update(result)
        }
    }
};
</script>
