"use strict"

document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('form');
  form.addEventListener('submit', formSend);

  async function formSend(e) {
    e.preventDefault();
    let error = formValidate(form);

		let formData = new FormData(form);

		if (error === 0) {
			let response = await fetch('sendmail.php', {
				method: 'POST', 
				body: formData
			});
			if (response.ok){
				let result = await response.json();
				alert(result.message);
				// alert("Данные отправлены! С Вами свяжутся в ближайшее время :)");
				form.reset();
			} else {
				alert("Что-то пошло не так, попробуйте, пожалуйста, ещё раз");
			}
		} else {
			alert('Пожалуйста, заполните обязательные поля');
		}
	}
	function formValidate(form) {
    let error = 0;
    let formReq = document.querySelectorAll('._req');

    for (let index = 0; index < formReq.length; index++) {
      const input = formReq[index];
			formRemoveError(input);

			if (input.getAttribute("type") === "checkbox" && input.checked === false) {
				formAddError(input);
				error++;
			} else {
				if (input.value === '') {
					formAddError(input);
					error++;
				}
			}
		}
		return error;
	}
	function formAddError(input) {
    input.parentElement.classList.add('_error');
    input.classList.add('_error');
  }
  function formRemoveError(input) {
    input.parentElement.classList.remove('_error');
    input.classList.remove('_error');
  }
});