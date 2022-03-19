const proofInputs = document.querySelectorAll('.proofAjaxClass');
console.log(proofInputs)
const uploadProofFile = function (e) {
    e.preventDefault();

    const proofAjaxForm = document.querySelector('#proofAjaxForm-' + this.id);
    const data = new FormData(proofAjaxForm);

    axios.post(proofAjaxForm.action, data)
        .then(res => console.log(res))
        .catch(err => console.log(err));
}

if (proofInputs.length > 0) {
    proofInputs.forEach(proofInput => proofInput.addEventListener('change', uploadProofFile));
}
