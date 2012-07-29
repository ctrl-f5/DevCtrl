function CtrlLib() {
    var ctrl = this;

    ctrl.forms = function () {
        var ctrlForms = this;

        ctrlForms.isValid = function (form) {
            var isValid = true;
            form.find('input.required, select.required, textarea.required').each(function () {
                if ($(this).val()) {
                    $(this).closest('.control-group').removeClass('error');
                } else {
                    $(this).closest('.control-group').addClass('error');
                    isValid = false;
                }
            });
            return isValid;
        };

        return ctrlForms;
    };
}

var Ctrl = new CtrlLib();