<script>
    // @class Modules\System\Enum\BonusAwardingTypeEnum
    const BONUS_AWARDING_TYPE_ENUM = {
        AUTOMATIC: 1,
        MANUAL: 2
    };

    // @class Modules\System\Enum\BonusAwardingConditionTypeEnum
    const BONUS_AWARDING_CONDITION_TYPE_ENUM = {
        DEPOSIT: 'deposit',
        SIGNUP: 'signup',
        NONE: 'none'
    };

    var BONUS = {
        is_finished: (() => {
            return !! ( + $(`input[name='is_bonus_finished']`).val() );
        })(),
        is_expired: (() => {
            return !! ( + $(`input[name='is_bonus_expired']`).val() );
        })(),
        is_view_mode: (() => {
            return !! ( + $(`input[name='is_bonus_view_mode']`).val() );
        })(),
    };

    var STEP_CONTROL = {
        active_step: (() => {
            return + ( $(`input[name='active_step']`).val() );
        })(),
        first_step: (() => {
            return + ( $('[role=wizardstep] a[data-toggle=wizardtab]:first').attr('data-wizard-step') );
        })(),
        last_step: (() => {
            return + ( $('[role=wizardstep] a[data-toggle=wizardtab]:last').attr('data-wizard-step') );
        })(),

        init: () => {
            STEP_CONTROL.triggerActiveStep();
        },

        triggerActiveStep: () => {
            const unLockedSteps = $('[role=wizardstep] a[data-toggle=wizardtab][data-wizard-locked="false"]');

            if (unLockedSteps.filter('.is-invalid').length) {
                STEP_CONTROL.activeStep(unLockedSteps.filter('.is-invalid').first());
            }

            if (! isEmpty(STEP_CONTROL.active_step)) {
                if (BONUS.STEP_CONTROL === -1 && !BONUS.is_finished) {
                    console.log({
                        cond: 'BONUS.active_step === -1 && !BONUS.is_finished',
                        val: STEP_CONTROL.active_step === -1 && !BONUS.is_finished
                    });
                    return;
                }

                if (STEP_CONTROL.isValidStepNumber(STEP_CONTROL.active_step)) {
                    STEP_CONTROL.activeStep(STEP_CONTROL.findWizardStepByNumber(STEP_CONTROL.active_step));
                }
            }
        },
        activeStep: (stepElement) => {
            $('[role=wizardstep] a[data-toggle=wizardtab]').attr('data-kwizard-state', 'pending');
            $('[role=wizardpane]').removeClass('active show');

            $(stepElement).attr('data-kwizard-state', 'current');
            $($(stepElement).attr('href')).addClass('active show');

            $(`
                input[name="awarding[type]"]:checked,
                input[name="awarding[multiple_instance]"],
                select[name="awarding[condition][type]"],
                input[name="wagering_requirement[status]"],
                input[name="liability[limit_bonus][status]"]
            `).trigger('change');

            // console.log(

            // );
            $(`input[name="awarding[type]"]:checked`).trigger('change')

            const nextStep = STEP_CONTROL.isValidStepNumber(STEP_CONTROL.active_step + 1)
                ? STEP_CONTROL.active_step + 1
                : null;

            $('input[name=next_step]').val(nextStep);

            STEP_CONTROL.renderStepButtons();
        },
        isValidStepNumber: (stepNumber) => {
            return stepNumber >= STEP_CONTROL.first_step && stepNumber <= STEP_CONTROL.last_step;
        },
        findWizardStepByNumber: (stepNumber) => {
            return $(`[role='wizardstep'] a[data-toggle='wizardtab'][data-wizard-step='${stepNumber}']`);
        },
        renderStepButtons: () => {
            $('button[data-wizard-action="previous"]').addClass('d-none');
            $('button[data-wizard-action="next"]').addClass('d-none');
            $('button[data-wizard-action="submit"]').addClass('d-none');

            if (STEP_CONTROL.active_step == STEP_CONTROL.first_step) {
                $('button[data-wizard-action="next"]').removeClass('d-none');
            } else if (STEP_CONTROL.active_step == STEP_CONTROL.last_step) {
                $('button[data-wizard-action="previous"]').removeClass('d-none');
                if (! BONUS.is_expired && ! BONUS.is_view_mode) {
                    $('button[data-wizard-action="submit"]').removeClass('d-none');
                }
            } else {
                $('button[data-wizard-action="next"]').removeClass('d-none');
                $('button[data-wizard-action="previous"]').removeClass('d-none');
            }

            $('button[data-wizard-action="cancel"]').removeClass('d-none');
        },
    };

    var FORM_AWARDING = {
        init: () => {
            FORM_AWARDING.onChangeAwardingType();
            FORM_AWARDING.onChangeAwardinMultipleInstance();
            FORM_AWARDING.onChangeAwardingCondition();
            FORM_AWARDING.onChangeBonusAwardType();
        },
        onChangeAwardingType: () => {
            $(`input[name='awarding[type]']`).on('change', function() {
                const awardingType  = $(this).val();
                const conditionType = $('#awarding_condition_type_select').val();

                FORM.showElement(
                    $(`#awarding_condition_type_${conditionType}`)
                );

                if (awardingType == BONUS_AWARDING_TYPE_ENUM.AUTOMATIC) {
                    FORM.hideElement(
                        $(`input[name="awarding[condition][${conditionType}][distribution_type]"][value=2]`).parent().parent()
                    );
                    FORM.hideElement(
                        $('input[name="awarding[bonus_award][type]"][value="any"]')
                            .parent()
                    );
                } else if (awardingType == BONUS_AWARDING_TYPE_ENUM.MANUAL) {
                    FORM.showElement(
                        $(`input[name="awarding[condition][${conditionType}][distribution_type]"][value=2]`).parent().parent()
                    )
                    FORM.showElement(
                        $('input[name="awarding[bonus_award][type]"][value="any"]')
                            .parent()
                    );
                }

                if(! $(`input[name="awarding[condition][${conditionType}][distribution_type]"]:checked:not(':disabled')`).length) {
                    $('.awarding_condition_distribution_type_btn:not(:disabled)')
                        .first()
                        .trigger('click')
                        .trigger('change');
                } else {
                    $(`input[name="awarding[condition][${conditionType}][distribution_type]"]:checked`).trigger('change');
                }

                if (! $('input[name="awarding[bonus_award][type]"]:checked:visible').length) {
                    $('input[name="awarding[bonus_award][type]"]:visible')
                        .first()
                        .trigger('click')
                        .trigger('change')
                } else {
                    $('input[name="awarding[bonus_award][type]"]:checked').trigger('change');
                }
            });
        },
        onChangeAwardinMultipleInstance: () => {
            $('input[name="awarding[multiple_instance]"]').on('change', function() {
                if($(this).is(':checked')) {
                    FORM.showElement(`[data-section-reference='multiple_instance']`);
                    return;
                }

                FORM.hideElement(`[data-section-reference='multiple_instance']`);
            });
        },
        onChangeAwardingCondition: () => {
            $('select[name="awarding[condition][type]"]').on('change', function() {
                const awardingConditionType = $(this).val();
                const elementId = $(this).attr('id');
                const awardingType = $('input[name="awarding[type]"]:checked').val();

                FORM.hideElement('.awarding_condition_type_section');
                FORM.showElement(`#awarding_condition_type_${awardingConditionType}`);

                $(`input.awarding_condition_distribution_type_btn[data-condition-type=${awardingConditionType}]:checked`).trigger('change');
                $(`[data-label-reference="#${elementId}"]`).val($(this).find('option:selected').text());

                if (awardingConditionType == 'signup' || awardingConditionType == 'none') {
                    FORM.hideElement($('input[name="awarding[bonus_award][type]"][value="percent"]').parent())

                } else if (awardingConditionType == BONUS_AWARDING_CONDITION_TYPE_ENUM.DEPOSIT) {
                    if (awardingType == BONUS_AWARDING_TYPE_ENUM.AUTOMATIC) {
                        FORM.hideElement(
                            $(`input[name="awarding[condition][${awardingConditionType}][distribution_type]"][value=2]`)
                                .parent()
                                .parent()
                        );
                    } else {
                        FORM.showElement(
                            $(`input[name="awarding[condition][${awardingConditionType}][distribution_type]"][value=2]`)
                                .parent()
                                .parent()
                        );
                    }
                } else {
                    FORM.showElement(
                        $('input[name="awarding[bonus_award][type]"][value="percent"]').parent()
                    );
                }

                if (! $('input[name="awarding[bonus_award][type]"]:checked:visible').length) {
                    $('input[name="awarding[bonus_award][type]"]:visible')
                        .first()
                        .trigger('click')
                        .trigger('change');
                } else {
                    $('input[name="awarding[bonus_award][type]"]:checked').trigger('change');
                }
            });
        },
        onChangeBonusAwardType: () => {
            $('input[name="awarding[bonus_award][type]"]').on('change', function() {
                const bonusAwardType = $(this).val();
                const awardingConditionType = $('#awarding_condition_type_select').val();

                FORM.hideElement(`[data-section-reference='awarding_bonus_award_type']`);
                FORM.showElement(`[data-section-reference='awarding_bonus_award_type'][data-bonus-award-type="${bonusAwardType}"]`);

                let awardingBonusAwardDistributionTypeBtn = `input.awarding_bonus_award_distribution_type_btn[data-bonus-award-type=${bonusAwardType}]`;

                FORM.hideElement(
                    $(awardingBonusAwardDistributionTypeBtn)
                        .parent()
                        .parent()
                );

                if ([BONUS_AWARDING_CONDITION_TYPE_ENUM.DEPOSIT].includes(awardingConditionType)) {
                    FORM.showElement(
                        $(`${awardingBonusAwardDistributionTypeBtn}[value!=3]`)
                            .parent()
                            .parent()
                    );
                } else {
                    FORM.showElement(
                        $(`${awardingBonusAwardDistributionTypeBtn}[value=3]`)
                            .parent()
                            .parent()
                    );
                }

                if (! $(`${awardingBonusAwardDistributionTypeBtn}:checked:visible`).length) {
                    $(`${awardingBonusAwardDistributionTypeBtn}:visible`)
                        .first()
                        .trigger('click')
                        .trigger('change');
                } else {
                    $(`${awardingBonusAwardDistributionTypeBtn}:checked`)
                        .trigger('change');
                }
            });
        }
    };

    var FORM_WAGERING_REQUIREMENT = {
        init: () => {
            FORM_WAGERING_REQUIREMENT.onChangeStatus();
        },
        onChangeStatus: () => {
            $('input[name="wagering_requirement[status]"]').on('change', function() {
                if ($(this).is(':checked')) {
                    FORM.showElement('#wagering_requirement_active_section')

                    if ($('select[name="awarding[condition][type]"]').val() == BONUS_AWARDING_CONDITION_TYPE_ENUM.DEPOSIT) {
                        FORM.showElement('#bonusEngineSection');
                    } else {
                        FORM.hideElement('#bonusEngineSection');
                    }

                    return;
                }

                FORM.hideElement('#wagering_requirement_active_section');
            });
        },
    };

    var FORM_LIABILITY = {
        init: () => {
            FORM_LIABILITY.onChangeLimitBonusStatus();
        },
        onChangeLimitBonusStatus: () => {
            $('input[name="liability[limit_bonus][status]"]').on('change', function() {
                if ($(this).is(':checked')) {
                    FORM.showElement('#liability_limit_bonus_active_section');
                    return;
                }

                FORM.hideElement('#liability_limit_bonus_active_section');
            });
        },
    };

    var FORM = {
        init: () => {
            FORM.onSubmit();
            FORM.onPrevious();
            FORM.onNext();
        },
        onSubmit: () => {
            $('button[data-wizard-action="submit"]').on('click', function(e) {
                e.preventDefault();

                if (BONUS.is_expired || BONUS.is_view_mode) {
                    return;
                }

                FORM.formAppend($('form#form_update_bonus'), `submit_form`, true);

                $('form#form_update_bonus').first().submit();
            });
        },

        onPrevious: () => {
            $('button[data-wizard-action="previous"]').on('click', function() {
                $('input[name=next_step]').val(STEP_CONTROL.active_step - 1);
                FORM.triggerSubmit();
            });
        },

        onNext: () => {
            $('button[data-wizard-action="next"]').on('click', function() {
                $('input[name=next_step]').val(STEP_CONTROL.active_step + 1);
                FORM.triggerSubmit();
            });
        },

        formAppend: (form, name, value) => {
            $(form).append($(`<input type="hidden" name="${name}">`).val(value));
        },

        triggerSubmit: () => {
            if (BONUS.is_expired || BONUS.is_view_mode) {
                const stepNumber = $('input[name=next_step]').val();

                STEP_CONTROL.activeStep(STEP_CONTROL.findWizardStepByNumber(stepNumber));

                return;
            }

            $('form#form_update_bonus').first().submit();
        },

        showElement: (element, enableInput = true) => {
            if (enableInput) {
                let elementId = $(element).attr('id');
                $(element).find(':input').prop('disabled', false);

                $(`[data-parent-section="#${elementId}"]`).find(':input').prop('disabled', false);
            }

            $(element).hasClass('tab-pane') ? $(element).addClass('active show') : $(element).removeClass('d-none');
        },

        hideElement: (element, disableInput = true) => {
            if (disableInput) {
                let elementId = $(element).attr('id');
                $(element).find(':input').prop('disabled', true);
                $(`[data-parent-section="#${elementId}"]`).find(':input').prop('disabled', true);
            }

            $(element).hasClass('tab-pane') ? $(element).removeClass('active show') : $(element).addClass('d-none');
        }
    };

    FORM_LIABILITY.init();
    FORM_WAGERING_REQUIREMENT.init();
    FORM_AWARDING.init();
    STEP_CONTROL.init();
    FORM.init();
</script>
