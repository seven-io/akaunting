@extends('layouts.admin')

@section('title', trans('sms77::general.name'))

@section('content')
    <h1>{{ trans('sms77::general.bulk_messaging') }}</h1>

    {!! Form::open(['id' => 'sms77_msg', 'novalidate' => true, 'role' => 'form',]) !!}

    {{ Form::textareaGroup('sms77_text', trans('sms77::general.text'), null, null, [
        ':maxlength' => 'maxTextLength',
        'required' => 'required',
    ]) }}

    <div class='form-group' style='padding: 0 12px;'>
        <p>{{trans('sms77::general.message_type')}}</p>

        <div class='d-flex justify-content-between'>
            <div class='custom-control custom-radio'>
                <input
                        @change='form.errors.clear("sms77_msg_type");'
                        class='custom-control-input'
                        id='sms77_msg_type_sms'
                        name='sms77_msg_type'
                        type='radio'
                        v-model='form.sms77_msg_type'
                        value='sms'
                />
                <label class='custom-control-label' for='sms77_msg_type_sms'>
                    {{ trans('sms77::general.sms') }}</label>
            </div>

            <div class='custom-control custom-radio'>
                <input
                        @change='form.errors.clear("sms77_msg_type");'
                        class='custom-control-input'
                        id='sms77_msg_type_voice'
                        name='sms77_msg_type'
                        type='radio'
                        v-model='form.sms77_msg_type'
                        value='voice'
                />
                <label class='custom-control-label' for='sms77_msg_type_voice'>
                    {{ trans('sms77::general.voice') }}</label>
            </div>
        </div>
    </div>

    {{ Form::textGroup('sms77_from', trans('sms77::general.from'), 'envelope', [
        'maxlength' => 16,
        'placeholder' => trans('sms77::general.from_explained'),
    ]) }}

    <template v-if='isSMS'>
        <akaunting-date
                data-name="sms77_delay"
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
                title="{{trans('sms77::general.delay')}}"
                v-model="form.sms77_delay"
                value='{{request('sms77_delay')}}'
        ></akaunting-date>

        {{ Form::textGroup('sms77_label', trans('sms77::general.label'), 'signal', [
            'maxlength' => 100,
            'placeholder' => trans('sms77::general.label_explained'),
        ], request('sms77_label')) }}

        {{ Form::textGroup('sms77_foreign_id', trans('sms77::general.foreign_id'),
            'reply', [
                'maxlength' => 64,
                'placeholder' => trans('sms77::general.foreign_id_explained'),
            ], request('sms77_foreign_id'))
         }}
    </template>

    <div class='form-group col-md-12 margin-top'>
        <div class='custom-control custom-checkbox'>
            {{ Form::checkbox('sms77_debug', 1, request('sms77_debug', 0), [
                   'class' => 'custom-control-input',
                   'id' => 'sms77_debug',
               ]) }}

            <label class='custom-control-label' for='sms77_debug'>
                <strong>{{ trans('sms77::general.debug') }}</strong>
                <small>{{trans('sms77::general.debug_explained')}}</small>
            </label>
        </div>
    </div>

    <div v-if='!isSMS' class='form-group col-md-12 margin-top'>
        <div class='custom-control custom-checkbox'>
            {{ Form::checkbox('sms77_xml', 1, request('sms77_xml', 0), [
                   'class' => 'custom-control-input',
                   'id' => 'sms77_xml',
               ]) }}

            <label class='custom-control-label' for='sms77_xml'>
                <strong>{{ trans('sms77::general.xml') }}</strong>
                <small>{{trans('sms77::general.xml_explained')}}</small>
            </label>
        </div>
    </div>

    <div v-if='isSMS' class='form-group col-md-12 margin-top'>
        <div class='custom-control custom-checkbox'>
            {{ Form::checkbox('sms77_performance_tracking', 1, request('sms77_performance_tracking', 0), [
                   'class' => 'custom-control-input',
                   'id' => 'sms77_performance_tracking',
               ]) }}

            <label class='custom-control-label' for='sms77_performance_tracking'>
                <strong>{{ trans('sms77::general.performance_tracking') }}</strong>
                <small>{{trans('sms77::general.performance_tracking_explained')}}</small>
            </label>
        </div>
    </div>

    <div v-if='isSMS' class='form-group col-md-12 margin-top'>
        <div class='custom-control custom-checkbox'>
            {{ Form::checkbox('sms77_no_reload', 1, request('sms77_no_reload', 0), [
                   'class' => 'custom-control-input',
                   'id' => 'sms77_no_reload',
               ]) }}

            <label class='custom-control-label' for='sms77_no_reload'>
                <strong>{{ trans('sms77::general.no_reload') }}</strong>
                <small>{{trans('sms77::general.no_reload_explained')}}</small>
            </label>
        </div>
    </div>

    <div v-if='isSMS' class='form-group col-md-12 margin-top'>
        <div class='custom-control custom-checkbox'>
            {{ Form::checkbox('sms77_flash', 1, request('sms77_flash', 0), [
                   'class' => 'custom-control-input',
                   'id' => 'sms77_flash',
               ]) }}

            <label class='custom-control-label' for='sms77_flash'>
                <strong>{{ trans('sms77::general.flash') }}</strong>
                <small>{{trans('sms77::general.flash_explained')}}</small>
            </label>
        </div>
    </div>

    <input type='submit' value='{{ trans('general.confirm') }}' class='btn btn-success'/>

    {!! Form::hidden('sms77_api_key', $settings['api_key'] ?? '') !!}

    {!! Form::close() !!}
@endsection

@push('scripts_start')
    <script src='{{ asset('modules/Sms77/Resources/assets/js/sms77.min.js?v='
        . module_version('sms77')) }}'></script>
@endpush
