<template>
    <div>
        <text-input
            :value="value"
            type="text"
            @input="updateDebounced"
        />
    </div>
</template>

<script>

export default {
    mixins: [Fieldtype],
    data() {
        return {};
    },
    computed: {
        inputType() {
        }
    }
};
</script>
