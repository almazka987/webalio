jQuery(document).ready(function($){

    function updShortcodeIds(from, key) {
console.log('foo started from', from);
console.log('key', key);
console.log('getNeededRepeaterFields(key)', getNeededRepeaterFields(key));
        getNeededRepeaterFields(key).find('.acf-repeater').not('.-empty').find('.acf-row').not('.acf-clone').each(function (idx, row) {
            var regexpData = new RegExp('insert$');
            var shortcodeName = $(row).parents('.acf-field-repeater').eq(0).data('name');

            $(row).find('.acf-field').not('.acf-hidden').filter(function() {
                return regexpData.test($(this).data('name'))
            }).each(function (idx, el) {
console.log('works with', el);
                var $curInput = $(el).find('.acf-input');
                var shortcodeId = $(row).find('.acf-row-handle.order span').eq(0).text();

                if (! $curInput.data('shrtcd')) {
                    $curInput.data('shrtcd', shortcodeId);
                } else {
                    if(! $curInput.data('shrtcd') == shortcodeId) {
                        shortcodeId = $curInput.data('shrtcd');
                    }
                }

                var val = '[' + shortcodeName + ' id="' + shortcodeId + '"' + ']';

                $curInput.find('input').not('.hidden').val(val).css({
                    color: '#000',
                    borderColor: '#3415B0',
                    background: '#FFFF99',
                }).addClass('copypaste-field');
                if ($curInput.find('input').not('.hidden').size() && ! $curInput.find('.js-copy-to-clipboard').size()) {
                    $curInput.find('input').not('.hidden').after('<a class="btn-copy js-copy-to-clipboard" href="#"><i class="far fa-copy"></i></a>')
                }
            });
        });
    }

    function copyToClipboard(elem) {
        // create hidden text element, if it doesn't already exist
        var origSelectionStart, origSelectionEnd;

        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;

        // select the content
        var currentFocus = document.activeElement;
        target.focus();
        target.setSelectionRange(0, target.value.length);
        // copy the selection
        var succeed;
        try {
            succeed = document.execCommand("copy");
        } catch(e) {
            succeed = false;
        }

        // restore original focus
        if (currentFocus && typeof currentFocus.focus === "function") {
            currentFocus.focus();
        }

        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);

        return succeed;
    }

    function getNeededRepeaterFields(key) {
        key = (key) ? new RegExp(key) : new RegExp($('.acf-tab-group li.active a').data('key'));

        return $('.acf-field-tab').filter(function () {
            return key.test($(this).data('key'));
        }).next('.acf-field-repeater').filter(function () {
            return ! $(this).parents('.acf-field-repeater').size() && ! $(this).parents('.-empty').size();
        });
    }

	if ($('#acf-group_57380c1a6623c')) {
	    updShortcodeIds('prosto');

        setInterval(function() {
            var $t = getNeededRepeaterFields(),
                rowCount = $t.data("rowCount"),
                rowLength = $t.find("tbody").children().length;
            if (rowCount && rowCount !== rowLength) {
                $t.trigger("rowcountchanged").data("rowCount", rowLength);
            } else if (!rowCount) {
                $t.data("rowCount", rowLength);
            }
        }, 50);

        $('.acf-field-repeater').filter(function () {
            return ! $(this).parents('.acf-field-repeater').size() && ! $(this).parents('.-empty').size();
        }).bind('rowcountchanged', function(event){
console.log('row change event on', event.currentTarget);
            updShortcodeIds('rowcountchanged');
        });

        $('.acf-tab-button').bind('click', function (e) {
            updShortcodeIds('click tab', $(e.currentTarget).data('key'));
        });

        $(document).on('click', '.acf-row .js-copy-to-clipboard', function(event) {
            event.preventDefault();
            var link = event.currentTarget;

            $(link).stop();
            if (copyToClipboard(link.previousSibling)) {
                $(link).removeClass('js-copy-to-clipboard').find('.fa-copy').removeClass('fa-copy').addClass('fa-check');
                setTimeout( function() {
                    $(link).addClass('js-copy-to-clipboard').find('.fa-check').removeClass('fa-check').addClass('fa-copy');
                }, 1500 );
            }
        });
	}


}); /* document ready end */
