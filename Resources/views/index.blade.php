<x-layouts.admin>
    <x-slot name="title">
        {{ trans('seven::general.bulk_messaging') }} | {{ trans('seven::general.name') }}
    </x-slot>

    <x-slot name="content">
        <p>{{ trans('seven::general.bulk_messaging_description') }}</p>

        <x-form.container>
            <x-form id="seven_msg" method="POST" route="seven.submit">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head
                            description="{{ trans('seven::general.contact_filters_description') }}"
                            title="{{ trans('seven::general.contact_filters') }}"
                        />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.checkbox
                            checked="{{(bool)request('seven_filter_contact_disabled')}}"
                            name="seven_filter_contact_disabled"
                            :options="['1' => trans('seven::general.include_disabled_entries')]"
                            not-required
                        />

                        <x-form.group.select
                            name='seven_filter_contact_type'
                            label="{{ trans('seven::general.contact_filters_limit_to_type') }}"
                            :options="$contactTypes"
                            not-required
                        />
                    </x-slot>
                </x-form.section>

                <x-form.group.radio
                    :checked="request('seven_msg_type', 'sms')"
                    input-group-class="grid grid-cols-2 gap-2 sm:grid-cols-2"
                    label="{{ trans('seven::general.message_type') }}"
                    name="seven_msg_type"
                    :options="[
                        'sms' => trans('seven::general.sms'),
                        'voice' => trans('seven::general.voice'),
                    ]"
                />

                <x-form.group.textarea
                    label="{{ trans('seven::general.text') }}"
                    name="seven_text"
                    required
                    v-bind:maxlength="maxTextLength"
                    value="{{ request('seven_text') }}"
                />

                <x-form.group.text
                    icon="envelope"
                    label="{{ trans('seven::general.from') }}"
                    maxlength="16"
                    name="seven_from"
                    not-required
                    placeholder="{{ trans('seven::general.from_explained') }}"
                    value="{{ request('seven_from') }}"
                />

                <template v-if='isSMS'>
                    <x-form.group.date
                        allow-input="true"
                        alt-format="{{company_date_format() . ' h:i:S'}}"
                        alt-input="true"
                        date-format="Y-m-d h:i:S"
                        enable-seconds="true"
                        enable-time="true"
                        icon="calendar_today"
                        label="{{ trans('seven::general.delay') }}"
                        min-date="new Date"
                        name="seven_delay"
                        not-required
                        title="{{trans('seven::general.delay')}}"
                        value="{{ request('seven_delay') }}"
                        wrap="true"
                    />

                    <x-form.group.text
                        icon="signal"
                        label="{{ trans('seven::general.label') }}"
                        maxlength="100"
                        name="seven_label"
                        placeholder="{{ trans('seven::general.label_explained') }}"
                        value="{{ request('seven_label') }}"
                        not-required
                    />

                    <x-form.group.text
                        icon="reply"
                        label="{{ trans('seven::general.foreign_id') }}"
                        maxlength="64"
                        name="seven_foreign_id"
                        placeholder="{{ trans('seven::general.foreign_id_explained') }}"
                        value="{{ request('seven_foreign_id') }}"
                        not-required
                    />

                    <x-form.group.checkbox
                        checked="{{(bool)request('seven_performance_tracking')}}"
                        name="seven_performance_tracking"
                        label="{{ trans('seven::general.performance_tracking') }}"
                        :options="['1' => trans('seven::general.performance_tracking_explained')]"
                        not-required
                    />

                    <x-form.group.checkbox
                        checked="{{(bool)request('seven_no_reload')}}"
                        name="seven_no_reload"
                        label="{{ trans('seven::general.no_reload') }}"
                        :options="['1' => trans('seven::general.no_reload_explained')]"
                        not-required
                    />

                    <x-form.group.checkbox
                        checked="{{(bool)request('seven_flash')}}"
                        name="seven_flash"
                        label="{{ trans('seven::general.flash') }}"
                        :options="['1' => trans('seven::general.flash_explained')]"
                        not-required
                    />
                </template>
                <div v-else class='form-group col-md-12 margin-top'>
                    <x-form.group.checkbox
                        checked="{{(bool)request('seven_xml')}}"
                        name="seven_xml"
                        label="{{ trans('seven::general.xml') }}"
                        :options="['1' => trans('seven::general.xml_explained')]"
                        not-required
                    />
                </div>

                <x-form.group.checkbox
                    checked="{{(bool)request('seven_debug')}}"
                    name="seven_debug"
                    label="{{ trans('seven::general.debug') }}"
                    :options="['1' => trans('seven::general.debug_explained')]"
                    not-required
                />

                <x-form.section>
                    <x-slot name="foot">
                        <x-button
                            class="bg-green hover:bg-green-700 text-white px-6 py-1.5 text-base rounded-lg disabled:bg-green-100"
                            override="class"
                            type="submit"
                        >
                            <x-button.loading>{{ trans('general.confirm') }}</x-button.loading>
                        </x-button>
                    </x-slot>
                </x-form.section>

                <x-form.input.hidden
                    name="seven_api_key"
                    value="{{ $settings['api_key'] ?? '' }}"
                />
            </x-form>
        </x-form.container>
    </x-slot>

    @push('scripts_start')
        <script
            src='{{ asset('modules/Seven/Resources/assets/js/seven.min.js?v='. module_version('seven')) }}'
        ></script>
    @endpush
</x-layouts.admin>
