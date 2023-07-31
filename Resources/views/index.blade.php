@extends('layouts.admin')

@section('title', trans('seven::general.name'))

@section('content')
    <h1>{{ trans('seven::general.bulk_messaging') }}</h1>

    {!! Form::open(['id' => 'seven_msg', 'novalidate' => true, 'role' => 'form',]) !!}

    <fieldset class='col-md-12'>
        <legend><h2>{{ trans('seven::general.contact_filters') }}</h2></legend>

        <div class='form-group col-md-12 margin-top'>
            <div class='custom-control custom-checkbox'>
                {{ Form::checkbox('seven_filter_contact_disabled', 1,
                    request('seven_filter_contact_disabled', 0), [
                       'class' => 'custom-control-input',
                       'id' => 'seven_filter_contact_disabled',
                   ]) }}

                <label class='custom-control-label' for='seven_filter_contact_disabled'>
                    <strong>{{ trans('seven::general.include_disabled_entries') }}</strong>
                </label>
            </div>
        </div>

        <div class='form-group'>
            <label class='form-control-label' for='seven_filter_contact_type'>
                {{ trans('seven::general.contact_filters_limit_to_type') }}</label>

            <select class='form-control' id='seven_filter_contact_type' name='seven_filter_contact_type'>
                <option value='' selected></option>
                @foreach ($contactTypes as $contactType)
                    <option value='{{$contactType}}'>{{$contactType}}</option>
                @endforeach
            </select>
        </div>
    </fieldset>

    {{ Form::textareaGroup('seven_text', trans('seven::general.text'), null, null, [
        ':maxlength' => 'maxTextLength',
        'required' => 'required',
        'value' => request('seven_text'),
    ]) }}

    <div class='col-md-12 form-group'>
        <p>{{trans('seven::general.message_type')}}</p>

        <div class='d-flex justify-content-between'>
            <div class='custom-control custom-radio'>
                <input
                        @change='form.errors.clear("seven_msg_type");'
                        class='custom-control-input'
                        id='seven_msg_type_sms'
                        name='seven_msg_type'
                        type='radio'
                        v-model='form.seven_msg_type'
                        value='sms'
                />
                <label class='custom-control-label' for='seven_msg_type_sms'>
                    {{ trans('seven::general.sms') }}</label>
            </div>

            <div class='custom-control custom-radio'>
                <input
                        @change='form.errors.clear("seven_msg_type");'
                        class='custom-control-input'
                        id='seven_msg_type_voice'
                        name='seven_msg_type'
                        type='radio'
                        v-model='form.seven_msg_type'
                        value='voice'
                />
                <label class='custom-control-label' for='seven_msg_type_voice'>
                    {{ trans('seven::general.voice') }}</label>
            </div>
        </div>
    </div>

    {{ Form::textGroup('seven_from', trans('seven::general.from'), 'envelope', [
        'maxlength' => 16,
        'placeholder' => trans('seven::general.from_explained'),
        'value' => request('seven_from'),
    ]) }}

    <template v-if='isSMS'>
        <akaunting-date
                data-name="seven_delay"
                :date-config="{
                        allowInput: true,
                        altFormat: '{{company_date_format() . ' h:i:S'}}',
                        altInput: true,
                        dateFormat: 'Y-m-d h:i:S',
                        enableSeconds: true,
                        enableTime: true,
                        wrap: true,
                        }"
                icon="fas fa-calendar"
                style='padding: 0 12px;'
                title="{{trans('seven::general.delay')}}"
                v-model="form.seven_delay"
                value='{{request('seven_delay')}}'
        ></akaunting-date>

        {{ Form::textGroup('seven_label', trans('seven::general.label'), 'signal', [
            'maxlength' => 100,
            'placeholder' => trans('seven::general.label_explained'),
            'value' => request('seven_label'),
        ], request('seven_label')) }}

        {{ Form::textGroup('seven_foreign_id', trans('seven::general.foreign_id'),
            'reply', [
                'maxlength' => 64,
                'placeholder' => trans('seven::general.foreign_id_explained'),
                'value' => request('seven_foreign_id'),
            ], request('seven_foreign_id'))
         }}

        <div class='form-group col-md-12 margin-top'>
            <div class='custom-control custom-checkbox'>
                {{ Form::checkbox('seven_performance_tracking', 1,
                    request('seven_performance_tracking', 0), [
                       'class' => 'custom-control-input',
                       'id' => 'seven_performance_tracking',
                   ]) }}

                <label class='custom-control-label' for='seven_performance_tracking'>
                    <strong>{{ trans('seven::general.performance_tracking') }}</strong>
                    <small>{{trans('seven::general.performance_tracking_explained')}}</small>
                </label>
            </div>
        </div>

        <div class='form-group col-md-12 margin-top'>
            <div class='custom-control custom-checkbox'>
                {{ Form::checkbox('seven_no_reload', 1, request('seven_no_reload', 0), [
                       'class' => 'custom-control-input',
                       'id' => 'seven_no_reload',
                   ]) }}

                <label class='custom-control-label' for='seven_no_reload'>
                    <strong>{{ trans('seven::general.no_reload') }}</strong>
                    <small>{{trans('seven::general.no_reload_explained')}}</small>
                </label>
            </div>
        </div>

        <div class='form-group col-md-12 margin-top'>
            <div class='custom-control custom-checkbox'>
                {{ Form::checkbox('seven_flash', 1, request('seven_flash', 0), [
                       'class' => 'custom-control-input',
                       'id' => 'seven_flash',
                   ]) }}

                <label class='custom-control-label' for='seven_flash'>
                    <strong>{{ trans('seven::general.flash') }}</strong>
                    <small>{{trans('seven::general.flash_explained')}}</small>
                </label>
            </div>
        </div>
    </template>
    <div v-else class='form-group col-md-12 margin-top'>
        <div class='custom-control custom-checkbox'>
            {{ Form::checkbox('seven_xml', 1, request('seven_xml', 0), [
                   'class' => 'custom-control-input',
                   'id' => 'seven_xml',
               ]) }}

            <label class='custom-control-label' for='seven_xml'>
                <strong>{{ trans('seven::general.xml') }}</strong>
                <small>{{trans('seven::general.xml_explained')}}</small>
            </label>
        </div>
    </div>

    <div class='form-group col-md-12 margin-top'>
        <div class='custom-control custom-checkbox'>
            {{ Form::checkbox('seven_debug', 1, request('seven_debug', 0), [
                   'class' => 'custom-control-input',
                   'id' => 'seven_debug',
               ]) }}

            <label class='custom-control-label' for='seven_debug'>
                <strong>{{ trans('seven::general.debug') }}</strong>
                <small>{{trans('seven::general.debug_explained')}}</small>
            </label>
        </div>
    </div>

    <input type='submit' value='{{ trans('general.confirm') }}' class='btn btn-success'/>

    {!! Form::hidden('seven_api_key', $settings['api_key'] ?? '') !!}

    {!! Form::close() !!}
@endsection

@push('scripts_start')
    <script src='{{ asset('modules/Seven/Resources/assets/js/seven.min.js?v='
        . module_version('seven')) }}'></script>
@endpush
