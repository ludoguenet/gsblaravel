const proofInputs = document.querySelectorAll('.proofAjaxClass');

const uploadProofFile = function (e) {
    e.preventDefault();

    const proofAjaxForm = document.querySelector('#proofAjaxForm-' + this.id);
    const data = new FormData(proofAjaxForm);

    axios.post(proofAjaxForm.action, data)
        .then(res => {
            proofAjaxForm.innerHTML = `<a href="${res.data.download_route}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </a>`;
        })
        .catch(err => console.log(err));
}

if (proofInputs.length > 0) {
    proofInputs.forEach(proofInput => proofInput.addEventListener('change', uploadProofFile));
}
