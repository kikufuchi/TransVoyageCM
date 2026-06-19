// Version jQuery
$(document).ready(function () {

    (function checkPassword() {
        let $password = $('#password');
        let $confirmPassword = $('#confirm_password');
        let $passwordError = $('#passwordError');
        let $submitBtn = $('#submitBtn');
        let $strengthBar = $('#strengthBar');

        function checkPasswordMatch() {
            if ($confirmPassword.val() != '') {
                if ($password.val() !== $confirmPassword.val()) {
                    $passwordError.show();
                    $submitBtn.prop('disabled', true);
                } else {
                    $passwordError.hide();
                    $submitBtn.prop('disabled', false);
                }
            }
        }

        function checkPasswordStrength() {
            const val = $password.val();
            let strength = 0;

            if (val.length >= 4) strength += 25;
            if (val.length >= 6) strength += 50;
            if (val.length >= 8) strength += 75;
            if (val.length >= 10) strength += 100;

            $strengthBar.css('width', strength + '%');

            if (strength < 50) $strengthBar.css('backgroundColor', '#dc3545');
            else if (strength <= 75 && strength >= 50) $strengthBar.css('backgroundColor', '#ffc107');
            else $strengthBar.css('backgroundColor', '#28a745');
        }

        $password.on('keyup', function () {
            checkPasswordStrength();
        });

        $confirmPassword.on('keyup', checkPasswordMatch);
    })();

    (function ManageMail() {
       
    })();
});