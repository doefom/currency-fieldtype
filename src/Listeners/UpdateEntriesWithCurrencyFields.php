<?php

namespace Doefom\CurrencyFieldtype\Listeners;

use Doefom\CurrencyFieldtype\Fieldtypes\CurrencyFieldtype;
use Statamic\Events\BlueprintSaved;
use Statamic\Facades\Entry;
use Statamic\Fields\Field;
use Statamic\Support\Arr;

class UpdateEntriesWithCurrencyFields
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BlueprintSaved $event): void
    {
        $blueprint = $event->blueprint;
        $currencyItems = $this->getCurrencyItems($blueprint);

        if ($currencyItems->count() === 0) {
            return;
        }

        $entries = Entry::query()->where('blueprint', $blueprint->handle())->get();
        foreach ($entries as $entry) {
            $this->updateCurrencyFields($entry, $currencyItems);
            $entry->saveQuietly();
        }
    }

    private function getCurrencyItems($blueprint)
    {
        return collect($blueprint->fields()->items())
            ->filter(fn($item) => Arr::get($item, 'field.type') === 'currency');
    }

    private function updateCurrencyFields($entry, $currencyItems)
    {
        foreach ($currencyItems as $item) {
            $handle = Arr::get($item, 'handle');
            $config = Arr::get($item, 'field', []);

            // Create a Field object with the necessary configuration
            $field = new Field($handle, $config);

            // Use the Field object to create the CurrencyFieldtype
            $fieldtype = (new CurrencyFieldtype)->setField($field);

            // Process the value
            $newValue = $fieldtype->process(Arr::get($entry->get($handle), 'value'));

            $entry->set($handle, $newValue);
        }
    }

}
