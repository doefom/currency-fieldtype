<template>
    <Input
        :model-value="value"
        :id="id"
        :append="append ? symbol : null"
        :prepend="!append ? symbol : null"
        type="text"
        @update:model-value="update"
    />
</template>

<script setup>
import { computed, onMounted } from 'vue';
import { Fieldtype } from '@statamic/cms';
import { injectPublishContext, Input } from '@statamic/cms/ui';
import Inputmask from 'inputmask';

const emit = defineEmits(Fieldtype.emits);
const props = defineProps(Fieldtype.props);
const { expose, update } = Fieldtype.use(emit, props);
defineExpose(expose);

const { values } = injectPublishContext();

const id = computed(() => 'currency-input-' + props.fieldId);
const append = computed(() => props.meta.append);
const radixPoint = computed(() => props.meta.radix_point);
const groupSeparator = computed(() => props.meta.group_separator);
const digits = computed(() => props.meta.digits);

const symbol = computed(() => {
    if (props.meta.dynamic_currency_field) {
        const selectedIso = values.value[props.meta.dynamic_currency_field];
        return props.meta.available_symbols[selectedIso];
    }
    return props.meta.symbol;
});

onMounted(() => {
    const config = {
        alias: 'currency',
        groupSeparator: groupSeparator.value,
        digits: digits.value,
    };

    if (digits.value > 0) {
        config.radixPoint = radixPoint.value;
    }

    Inputmask(config).mask(id.value);
});
</script>
