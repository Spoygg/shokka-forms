(function ($) {
  const getSFVars = () => {
    return $.post({
      url: ShokkaForms.ajaxurl,
      data: {
        action: 'shokka_forms'
      }
    });
  };

  const getFormErrors = (nonce, sferr) => {
    return $.post({
      url: ShokkaForms.ajaxurl,
      data: {
        action: 'shokka_forms_get_errors',
        nonce: nonce,
        sferr: sferr
      }
    });
  };

  const displayFormErrors = () => {
    const params = new URLSearchParams(window.location.search);
    if (params.has('sferr') === false) {
      return;
    }

    const sferr = params.get('sferr');

    getSFVars().then(
      (response) => {
        getFormErrors(response.data.errorsNonce, sferr).then(
          (response) => {
            if (response.data.errors) {
              response.data.errors.forEach(
                (err) => {
                  $(`[name=${err.field}]`).parent().append(
                    `<span class="sf-error">${err.message}</span>`
                  );
                }
              );
            }
          }
        );
      }
    );
  };

  displayFormErrors();
})(jQuery);
