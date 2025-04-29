(function() {
  'use strict';

  window.addEventListener('load', function() {
    var form = document.getElementById('messageComposerForm');

    form.addEventListener('submit', function(event) {
      var emailField = form.querySelector('[name="email"]');
      var subjectField = form.querySelector('[name="subject"]');
      var bodyField = form.querySelector('[name="body"]');

      var valid = true;

      var emailValue = emailField.value.trim();
      var subjectValue = subjectField.value.trim();
      var bodyValue = bodyField.value.trim();

      var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; 

      
      if (emailValue === "") {
        emailField.setCustomValidity("Az e-mail cím nem lehet üres.");
        valid = false;
      } else if (emailValue.length > 230) {
        emailField.setCustomValidity("Az e-mail cím maximum 230 karakter lehet.");
        valid = false;
      } else if (!emailPattern.test(emailValue)) {
        emailField.setCustomValidity("Nem megfelelő formátum.");
        valid = false;
      } else {
        emailField.setCustomValidity("");
      }

      if (subjectValue === "") {
        subjectField.setCustomValidity("A tárgy mező nem lehet üres.");
        valid = false;
      } else if (subjectValue.length > 400) {
        subjectField.setCustomValidity("A tárgy maximum 400 karakter lehet.");
        valid = false;
      } else {
        subjectField.setCustomValidity("");
      }

      if (bodyValue === "") {
        bodyField.setCustomValidity("Az üzenet mező nem lehet üres.");
        valid = false;
      } else if (bodyValue.length > 7000) {
        bodyField.setCustomValidity("Az üzenet maximum 7000 karakter lehet.");
        valid = false;
      } else {
        bodyField.setCustomValidity("");
      }

      //prevent sending if error detected
      if (!form.checkValidity() || !valid) {
        event.preventDefault();
        event.stopPropagation();
      }

      form.classList.add('was-validated');

    }, false);

  }, false);

})();
