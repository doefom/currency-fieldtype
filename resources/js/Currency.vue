<template>
    <div>
        <text-input
            id="currency"
            type="text"
            v-model="test"
        />
    </div>
</template>

<script>
import Inputmask from "inputmask";

export default {
    mixins: [Fieldtype],
    mounted() {
        Inputmask({ alias: "currency" }).mask('#currency');
    },
    data() {
        return {
            test: null,
        };
    },
    computed: {
        inputType() {
        }
    }
};
</script>
