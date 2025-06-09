document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('mainForm');
  const pwd  = document.getElementById('inputPassword');
  const conf = document.getElementById('inputConfirm');

  form.addEventListener('submit', e => {
    e.preventDefault();
    e.stopPropagation();

    // HTML5 checks
    if (!form.checkValidity()) {
      form.classList.add('was-validated');
      return;
    }

    // Confirm password match
    if (pwd.value !== conf.value) {
      conf.classList.add('is-invalid');
      return;
    } else {
      conf.classList.remove('is-invalid');
    }

    // send to PHP
    fetch('submitForm.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        email: form.email.value,
        password: form.password.value,
        confirm: form.confirm.value,
        terms: form.terms.checked
      })
    })
    .then(r => r.json())
    .then(json => {
      if (json.success) {
        alert('Registered successfully!');
        form.reset();
        form.classList.remove('was-validated');
      } else {
        // show server-side error
        const fld = json.field;
        const msg = json.msg || json.error;
        const el  = document.querySelector(`[name="${fld}"]`);
        if (el) {
          el.classList.add('is-invalid');
          el.nextElementSibling.textContent = msg;
        } else {
          alert(msg);
        }
      }
    })
    .catch(() => alert('Network error'));
  });

  // clear match error on input
  conf.addEventListener('input', () => {
    if (conf.value === pwd.value) {
      conf.classList.remove('is-invalid');
    }
  });
});