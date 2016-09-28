(function( $ ) {

    'use strict';
$(document).ready(function() {
    var rsFields = [];
    var template = '<p class="mes-um-rs-row">\
        <label class="um-admin-half">\
        </label>\
        <span class="um-admin-half">\
            <span class="mes-um-admin-yesno">\
                <span class="btn pos-0"></span>\
                <span class="yes" data-value="1">Yes</span>\
                <span class="no" data-value="0">No</span>\
                <input type="hidden" name="_um_search_fields_mes_rs[]" value="" />\
            </span>\
        </span>\
        <div class="um-admin-clear"></div>\
    </p>';

    var $template = $(template);
    var $wrapper = $('#mes-um-rs-rows');
    var selector = 'select[name="_um_search_fields[]"]';

    var isDefined = function (value) {
        return typeof value !== "undefined";
    };

    var loadRSFields = function (init) {
        $wrapper.empty();

        if (isDefined(mes_um_rs_obj)) {
            var srchFields = mes_um_rs_obj.srchFields;
            if (init && isDefined(mes_um_rs_obj.rsFields)) {
                rsFields = mes_um_rs_obj.rsFields;
            }
        }

        var fields = {};
        $(selector + ' option:selected').each(function () {
            var $this = $(this);
            if ($this.val() == '0' || fields[$this.val()]) return;
            if (srchFields && isDefined(srchFields[$this.val()]) && srchFields[$this.val()].type != "number")
                return;

            fields[$this.val()] = 1;
            var $clone = $template.clone();
            $('label', $clone).text($this.text());
            if ($.inArray($this.val(), rsFields) != -1) {
                $('span.btn', $clone).toggleClass('pos-0 pos-1');
                $('input', $clone).val($this.val()).data('field', $this.val());
            }
            else {
                $('input', $clone).val('').data('field', $this.val());
            }
            $wrapper.append($clone);
        });

        for (var i = 0; i < rsFields.length;) {
            if (!fields[rsFields[i]]) {
                rsFields.splice(i, 1);
            }
            else {
                i++;
            }
        }
    };

    $(document).on('change', selector, function () {
        loadRSFields();
    });

    $(document).on('click', '.mes-um-rs-row .mes-um-admin-yesno span.btn', function (e) {
        e.stopImmediatePropagation();
        var $this = $(this);
        var $input = $this.parent().find('input[type=hidden]');
        if ($input.val() == '') {
            var update_val = $input.data('field');
            $this.animate({'left': '48px'}, 200).toggleClass('pos-0 pos-1');
            $input.val(update_val);
            rsFields.push(update_val);
        }
        else {
            var update_val = '';
            $this.animate({'left': '0'}, 200).toggleClass('pos-0 pos-1');
            $input.val(update_val);

            var i = 0;
            for (; i < rsFields.length; i++) {
                if (rsFields[i] == $input.data('field')) {
                    break;
                }
            }
            rsFields.splice(i, 1);
        }
        return false;

    });
    loadRSFields(true);

    $(document).on('click', '.um-admin-clone-remove', function () {
        loadRSFields();
    });

});//ready
})( jQuery );
