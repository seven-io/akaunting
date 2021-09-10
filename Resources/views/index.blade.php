@extends('layouts.admin')

@section('title', trans('sms77::general.name'))

@section('content')
    <h1>{{ trans('sms77::general.bulk_messaging') }}</h1>

    {!! Form::open(['id' => 'sms77_msg', 'novalidate' => true, 'role' => 'form',]) !!}

    {{ Form::textareaGroup('sms77_text', trans('sms77::general.text'), null, null, [
        ':maxlength' => 'maxTextLength',
        'required' => 'required',
    ]) }}

    {{trans('sms77::general.message_type')}}<br>

    <div class='custom-control custom-radio mb-2'>
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

    <div class='custom-control custom-radio mb-2'>
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

    {{ Form::textGroup('sms77_from', trans('sms77::general.from'), 'envelope', [
        'maxlength' => 16,
    ]) }}

    <input type='submit' value='{{ trans('general.confirm') }}' class='btn btn-success'/>

    {!! Form::hidden('sms77_api_key', $settings['api_key'] ?? '') !!}

    {!! Form::close() !!}
@endsection

@push('scripts_start')
    <script src='{{ asset('modules/Sms77/Resources/assets/js/sms77.min.js?v='
        . module_version('sms77')) }}'></script>
@endpush
