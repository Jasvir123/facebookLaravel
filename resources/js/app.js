import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// set input type number to zero on page load
document.addEventListener("DOMContentLoaded", function () {
    let numberInput = document.querySelector('input[type="number"]');
    if (numberInput != null && numberInput.value == 0) {
        numberInput.value = ""; // Set empty value
    }

    let contactNo = document.querySelector("#contactNo");
    const updateToZeroIfLess = (e) => {
        if (e.target.value < 0) {
            e.target.value = 0;
        }
    };
    if (contactNo != null) {
        contactNo.addEventListener("keydown", updateToZeroIfLess);
        contactNo.addEventListener("keyup", updateToZeroIfLess);
    }
});
