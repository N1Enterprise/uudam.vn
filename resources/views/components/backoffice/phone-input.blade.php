<div class="input-group">
    <div class="input-group-prepend border-right-0" style="width: 35%!important">
        <select name="{{ $phonePrefixName }}" {{ $requiredPrefix ? 'required' : '' }} data-size="5" class="form-control k_selectpicker" data-live-search="true">
            <option default value="">{{ __('Prefix') }}</option>
        </select>
    </div>
    <input type="text" placeholder="{{ $placeholder }}" data-original-title="{{ $placeholder }}" data-toggle="tooltip"  name="{{ $phoneInputName }}" {{ $required ? 'required' : '' }} class="{{ $class }}" value="{{ $value }}">
    <input type="hidden"  name="{{ $phoneBeautifyName }}" value="{{ phone(old($phoneBeautifyName, $phone)) }}">
</div>

@push('js_pages')
<script src="{{ asset('backoffice/js/common/libphonenumber.min.js') }}" type="text/javascript"></script>
<script>
    $("input[name='{{ $phoneInputName }}']").inputmask({
        'mask': '9999999999999',
        placeholder: '' // remove underscores from the input mask
    });

    $(document).ready(function() {
        initCallingCountryCodes();
    });

    function initCallingCountryCodes() {
        let phonesPrefix =  $("select[name='{{$phonePrefixName}}']");

        phonesPrefix.html('').append($('<option value="">').text("{{__('Prefix')}}"));

        let selectedCallingCode = "{{ old($phonePrefixName) }}";
        let phoneNumber = '{{ $phone }}';
        if (selectedCallingCode.trim().length == 0) {
            if (libphonenumber.isValidPhoneNumber(phoneNumber)) {
                let phoneNumberObj = libphonenumber.parsePhoneNumber(phoneNumber);
                selectedCallingCode = '+' + phoneNumberObj.countryCallingCode;
            }
        }

        let countries = libphonenumber.getCountries();
        let options = [];
        $.each(countries, function(i, country) {
            let callingCode = libphonenumber.getCountryCallingCode(country);
            let callingCodeWithPlusSign = '+' + callingCode;
            let option = null;
            if (options[callingCode] !== undefined) {
                option = $(options[callingCode]).attr('data-tokens', $(options[callingCode]).attr('data-tokens') + ',' + country)
            } else {
                option = $('<option>').attr('data-tokens', country).attr('value', callingCodeWithPlusSign).text(callingCodeWithPlusSign)
            }
            if (selectedCallingCode == callingCodeWithPlusSign) {
                option.prop('selected', true);
            }

            options[callingCode] = option;
        });

        phonesPrefix.append(options);
        phonesPrefix.selectpicker('refresh');
    }

    $("select[name='{{ $phonePrefixName }}'],input[name='{{ $phoneInputName }}'").on('change keyup', function(e) {
        updatePhoneInput();

    })
    function updatePhoneInput() {
        let phoneNumber = $("select[name='{{ $phonePrefixName }}']").val() + $('input[name="{{ $phoneInputName }}"]').val();
        $("[name='{{ $phoneBeautifyName }}'").val(phoneNumber);
    }
</script>
@endpush
