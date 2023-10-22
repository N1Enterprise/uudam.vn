<script>
    let RELATED_POST_ALLOWED_COUNTRY_BADGE = {
        id: null,
        name: null,
        parseFromObject: function(obj) {
            this.id = obj?.id;
            this.name = obj?.name;

            return this;
        },
        render: function() {
            return $(`<button type="button" title="{{ __('Remove') }}" class="Related_Post_Badge_Selected btn btn-sm btn-outline-brand btn-primary btn-right-icon mr-3 mb-3">`)
                .attr('data-id', this.id)
                .attr('data-name', this.name)
                .append($(`<span class="bonus-content">`).text(`${this.name} - ${this.id}`))
                .append($('<i class="la la-close">'));
        }
    }

    $(document).ready(function () {
        $('select.Related_Post_Selector').on('loaded.bs.select', function() {
            $(this).trigger('changed.bs.select');
        });

        $('select.Related_Post_Selector').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            let $this = $(this);
            let optionHolder = $(`.Related_Post_Allowed_Holder`);
            let relatedPosts = [];

            optionHolder.find('.Related_Post_Holder_Content').html('');

            $.each($this.val(), function(i, id) {
                let obj = {
                    id: $this.find(`option[value="${id}"]`).first().val(),
                    name: $this.find(`option[value="${id}"]`).first().attr('data-post-name'),
                }

                relatedPosts.push(obj);
            });

            if ($.isEmptyObject(relatedPosts)) {
                optionHolder.find('.Related_Post_Holder_Content').html('');
                optionHolder.addClass('d-none');
            } else {
                optionHolder.removeClass('d-none');

                relatedPosts.map(function(obj) {
                    generateRelatedPostBadge(obj, optionHolder);
                });
            }
        });

        function generateRelatedPostBadge(obj, holderSelector) {
            if ($.isEmptyObject(obj)) {
                return;
            }

            $(holderSelector).find('.Related_Post_Holder_Content').append(RELATED_POST_ALLOWED_COUNTRY_BADGE.parseFromObject(obj).render());
        }
    });

    $(document).on('click', '.Related_Post_Badge_Selected', function() {
        const obj = {
            id: $(this).data('id'),
            name: $(this).data('name'),
        }

        const selector = $(`select.Related_Post_Selector`);

        selector.find(`option[value="${obj.id}"]`).prop('selected', false);
        selector.trigger('changed.bs.select').selectpicker('render');
    });
</script>
