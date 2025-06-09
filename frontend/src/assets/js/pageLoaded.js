$(document).ready(function () {
    // Handle registration form submission
    $(document).on('submit', '#registerForm', function (e) {
      e.preventDefault();
      const $form = $(this);
  
      // reset previous errors
      $form.find('.is-invalid').removeClass('is-invalid');
      $form.addClass('was-validated');
  
      // HTML5 validation
      if (this.checkValidity() === false) {
        return;
      }
  
      // password match check
      const pwd  = $('#regPassword').val();
      const conf = $('#regConfirm').val();
      if (pwd !== conf) {
        $('#regConfirm')
          .addClass('is-invalid')
          .next('.invalid-feedback')
          .text('Passwords do not match.');
        return;
      }
  
      // build payload
      const payload = {
        name:     $('#inputName').val().trim(),
        email:    $('#regEmail').val().trim(),
        password: pwd,
        confirm:  conf,
        terms:    $('#regTerms').is(':checked')
      };
  
      // AJAX POST
      $.ajax({
        url: '../../../backend/dao/forms/submitForm.php',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(payload),
        dataType: 'json',
        success(resp) {
          if (resp.success) {
            alert('Registered successfully!');
            $form[0].reset();
            $form.removeClass('was-validated');
          } else {
            // show the first server-side validation error
            const fld = resp.field;
            const msg = resp.msg || resp.error;
            const $el = $form.find(`[name="${fld}"]`);
            if ($el.length) {
              $el.addClass('is-invalid')
                 .next('.invalid-feedback')
                 .text(msg);
            } else {
              alert(msg);
            }
          }
        },
        error(xhr) {
          alert('Server error: ' + xhr.responseText);
        }
      });
    });
  });
  