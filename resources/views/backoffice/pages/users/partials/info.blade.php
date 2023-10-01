<div class="k-portlet">
    <div class="k-portlet__head">
        <div class="k-portlet__head-label">
            <h3 class="k-portlet__head-title">{{ __('General Information') }}</h3>
            @if($user->is_test_user)
            <span  class="btn btn-label-success btn-sm btn-pill" >
                <span>{{ __('Test Account') }}</span>
            </span>
            @endif
        </div>
        @if(!isset($hideUpdate))
        <div class="k-portlet__head-toolbar">
            <div class="k-portlet__head-group">
                @can('users.update')
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-primary btn-pill" data-modal="#userInfoModal">
                        <i class="la la-pencil"></i>
                        <span>{{ __('Update') }}</span>
                    </button>
                </div>
                @endcan
            </div>
        </div>
        @endif
    </div>

    <div class="k-portlet__body">
        <div class="form-group row">
            <div class="col-lg-4">
                <label>{{ __('First Name') }}</label>
                <input type="text" class="form-control" disabled="disabled" value="{{ optional($user->userDetail)->first_name ?? 'N/A' }}">
            </div>
            <div class="col-lg-4">
                <label>{{ __('Middle Name') }}</label>
                <input type="text" class="form-control" disabled="disabled" value="{{ optional($user->userDetail)->middle_name ?? 'N/A' }}">
            </div>
            <div class="col-lg-4">
                <label class="">{{ __('Last Name') }}</label>
                <input type="text" class="form-control" disabled="disabled" value="{{ optional($user->userDetail)->last_name ?? 'N/A' }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-4">
                <label>{{ __('Phone Number') }}</label>
                <input  class="form-control" type="text" disabled="disabled" @can(['users.show-user-phone']) value="{{ $user->phone_number_beautify }}"  @else value="******" @endcan>
            </div>
            <div class="col-lg-4">
                <label>{{ __('Language') }}</label>
                <input type="text" class="form-control" disabled="disabled" value="{{ optional($user->userDetail)->language_name ?? 'N/A' }}">
            </div>
            <div class="col-lg-4">
                <label class="">{{ __('Birthday') }}</label>
                <input type="text" class="form-control" disabled="disabled" value="{{ optional($user->userDetail)->birthday }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-4">
                <label>{{ __('User Username') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-user"></i></span>
                    </div>
                    <input type="text" class="form-control" disabled="disabled" value="{{ $user->username }}">
                </div>
            </div>
            <div class="col-lg-4">
                <label>{{ __('Currency') }}</label>
                <input type="text" class="form-control" disabled="disabled" value="{{ $user->currency_code }}">
            </div>
            <div class="col-lg-4">
                <label class="">{{ __('User ID') }}</label>
                <input type="text" class="form-control" disabled="disabled" value="{{ $user->id }}">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-4">
                <label>{{ __('Email') }}</label>
                <input @can(['users.show-user-email'])  value="{{ $user->email }}" @else  value="******" @endcan  type="text" class="form-control" disabled="disabled">
            </div>
            <div class="col-lg-4">
                <label>{{ __('Status') }}</label>
                <input type="text" class="form-control" disabled="disabled" value="{{ $user->serialized_status_name }}">
            </div>
            <div class="col-lg-4">
                <label>{{ __('Signup Date') }}</label>
                <input type="text" class="form-control" disabled="disabled" value="{{ $user->created_at_localized }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-4">
                <label>{{ __('Country') }}</label>
                <input type="text" class="form-control" disabled="disabled" value="{{ optional(optional($user->userDetail)->country)->name ?? 'N/A' }}">
            </div>
            <div class="col-lg-4">
                <label>{{ __('Province') }}</label>
                @php
                    $userStateName = optional($user->userDetail)->state_name;
                    $userStateName = empty($userStateName) ? optional(optional($user->userDetail)->state)->name: $userStateName;
                @endphp
                <input type="text" class="form-control" disabled="disabled" value="{{ empty($userStateName) ? 'N/A': $userStateName }}">
            </div>
            <div class="col-lg-4">
                <label>{{ __('City') }}</label>
                @php
                    $userCityName = optional($user->userDetail)->city_name;
                    $userCityName = empty($userCityName) ? optional(optional($user->userDetail)->city)->name: $userCityName;
                @endphp
                <input type="text" class="form-control" disabled="disabled" value="{{ empty($userCityName) ? 'N/A': $userCityName }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-8">
                <label>{{ __('Address') }}</label>
                <input type="text" class="form-control" disabled="disabled" value="{{ optional($user->userDetail)->address ?? 'N/A' }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12">
                <label>{{ __('Signup URL') }}</label>
                <input type="text" class="form-control" disabled="disabled" value="{{ optional($user->userDetail)->signup_url }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-12">
                <label>{{ __('Payload') }}</label>
                <input type="text" class="form-control" disabled="disabled" value="{{ optional($user->userDetail)->payload }}">
            </div>
        </div>
    </div>
</div>
@can('users.update')
<div class="modal fade" id="userInfoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="userInfoForm" method="POST" action="{{ route('bo.web.users.update', $user->getKey()) }}">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Edit User Infomation') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>{{ __('First Name') }}</label>
                            <input type="text" class="form-control" value="{{ old('first_name', optional($user->userDetail)->first_name) }}" name="first_name">
                        </div>
                        <div class="col-lg-4">
                            <label>{{ __('Middle Name') }}</label>
                            <input type="text" class="form-control" value="{{ old('middle_name', optional($user->userDetail)->middle_name) }}" name="middle_name">
                        </div>
                        <div class="col-lg-4">
                            <label>{{ __('Last Name') }}</label>
                            <input type="text" class="form-control" value="{{ old('last_name', optional($user->userDetail)->last_name) }}" name="last_name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>{{ __('Phone Number') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend border-right-0" style="width: 35%!important">
                                    <select @if(!Gate::check('users.show-user-phone')) disabled @endif name="calling_code" id="callingCode" class="form-control selectpicker" data-live-search="true">
                                        <option default value="">{{ __('Prefix') }}</option>
                                    </select>
                                </div>
                                <input @if(Gate::check('users.show-user-phone')) type="text" value="{{ old('contact_number', $user->national_phone_number) }}" @else disabled type="password" value="******" @endif name="contact_number" class="form-control" >
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label>{{ __('Birthday') }}</label>
                            <div class="input-group">
                                <input
                                    autocomplete="off"
                                    type="datepicker"
                                    max="{{ now()->modify("-{$SITE_AGE_RESTRICTION} years")->format('Y-m-d') }}"
                                    class="form-control"
                                    name="birthday"
                                    value="{{ old('birthday', optional($user->userDetail)->birthday) }}"
                                >
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label>{{ __('Language') }}</label>
                            <select name="language" class="form-control">
                                <option value="">--{{ __('Select language') }}--</option>
                                @foreach ($LANGUAGES as $lang)
                                <option {{ old('language', optional($user->userDetail)->language) == data_get($lang, 'code') ? 'selected' : '' }} value="{{ data_get($lang, 'code') }}">{{ data_get($lang, 'name') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>{{ __('Country') }}</label>
                            <select name="country_id" selected-id="{{ old('country_id', optional($user->userDetail)->country_id) }}" class="form-control k_selectpicker" data-live-search="true" title="{{ __('Select Country') }}"  data-size="5">
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="state_name">{{ __('Province') }}</label>
                            <input type="text" name="state_name" class="form-control" value="{{ $userStateName }}">
                        </div>
                        <div class="col-lg-4">
                            <label for="city_name">{{ __('City') }}</label>
                            <input type="text" name="city_name" class="form-control" value="{{ $userCityName }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-8">
                            <label>{{ __('Address') }}</label>
                            <input type="text" class="form-control" name="address" value="{{ old('address', optional($user->userDetail)->address) }}">
                        </div>
                        <div class="col-lg-4">
                            <label>{{ __('Email') }} *</label>
                            <input @if(!Gate::check('users.show-user-email')) disabled type="password" value="******" @else  type="email" value="{{ old('email', $user->email) }}" @endif required class="form-control" name="email" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label for="post_code">{{ __('Postal Code') }}</label>
                            <input type="text" value="{{ old('post_code', optional($user->userDetail)->post_code) }}" name="post_code" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('js_pages')
<script src="{{ asset('backoffice/js/common/libphonenumber.min.js') }}" type="text/javascript"></script>
<script>
    function initCallingCountryCodes() {
        let phonesPrefix = $('#callingCode');

        phonesPrefix.html('').append($('<option value="">').text("{{__('Prefix')}}"));

        let userCallingCode = "{{ $user->country_code }}";
        let countries = libphonenumber.getCountries();
        let options = [];
        $.each(countries, function (i, country) {
            let callingCode = libphonenumber.getCountryCallingCode(country);
            let callingCodeWithPlusSign = '+' + callingCode;
            let option = null;

            if (options[callingCode] !== undefined) {
                option = $(options[callingCode]).attr('data-tokens', $(options[callingCode]).attr('data-tokens') + ',' + country);
            } else {
                option = $('<option>').attr('data-tokens', country).attr('value', callingCodeWithPlusSign).text(callingCodeWithPlusSign);
            }

            if (userCallingCode == callingCodeWithPlusSign) {
                option.prop('selected', true);
            }

            options[callingCode] = option;
        })

        phonesPrefix.append(options);
        phonesPrefix.selectpicker('refresh');
    }

    function initProvinces() {
        let phonesPrefix = $('#callingCode');
        let userCallingCode = "{{ $user->country_code }}";
        let countries = libphonenumber.getCountries();
        let options = [];
        $.each(countries, function (i, country) {
            let callingCode = libphonenumber.getCountryCallingCode(country);
            let callingCodeWithPlusSign = '+' + callingCode;
            let option = null;

            if (options[callingCode] !== undefined) {
                option =  $(options[callingCode]).attr('data-tokens', $(options[callingCode]).attr('data-tokens') + ',' + country);
            } else {
                option = $('<option>').attr('data-tokens', country).attr('value', callingCodeWithPlusSign).text(callingCodeWithPlusSign);
            }

            if(userCallingCode == callingCodeWithPlusSign) {
                option.prop('selected', true);
            }

            options[callingCode] = option;
        })

        phonesPrefix.append(options);
        phonesPrefix.selectpicker('refresh');
    }

    function initCountries() {
        $.ajax({
            url: "{!! route('system.api.countries') !!}",
            success: function(data) {
                let countrySelector = $('#userInfoModal select[name="country_id"]').html('');
                $.each(data, function(i ,country) {
                    let option = $('<option>').attr('value', country.id).text(country.name);
                    countrySelector.append(option);
                })

                countrySelector.selectpicker('refresh');

                if(!isEmpty($('#userInfoModal select[name="country_id"]').attr('selected-id'))) {
                    countrySelector.selectpicker('val', $('#userInfoModal select[name="country_id"]').attr('selected-id'));
                }
            }
        })
    }

    $(document).ready(function() {
        initCallingCountryCodes();

        $('#userInfoModal').on('shown.bs.modal', function() {
            initCountries();
        });

        $('form#userInfoForm').on('submit', function(e) {
            e.preventDefault();

            let phoneNumber = $('#callingCode').val() + $('input[name="contact_number"]').val();

            $(this).append($(`<input type="hidden" name="phone_number">`).val(phoneNumber))
            $(this)[0].submit();
        })
    })
</script>
@endpush
@endcan
