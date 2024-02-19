var feeCheckbox = document.getElementById("feeFree");
var feeInput = document.getElementById("fee");

feeCheckbox.addEventListener("change", function() {
    if (this.checked) {
        feeInput.setAttribute("disabled", "disabled");
        feeInput.removeAttribute("required");
    } else {
        feeInput.removeAttribute("disabled");
        feeInput.setAttribute("required", "required");
    }
});