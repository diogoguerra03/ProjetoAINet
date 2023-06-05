import "./bootstrap";

document.addEventListener("DOMContentLoaded", function () {
    const quantityInputs = document.querySelectorAll(".quantity-input");

    quantityInputs.forEach(function (quantityInput) {
        const decrementBtn = quantityInput.querySelector(
            '[data-action="decrement"]'
        );
        const incrementBtn = quantityInput.querySelector(
            '[data-action="increment"]'
        );
        const quantityField = quantityInput.querySelector(".quantity");

        decrementBtn.addEventListener("click", function () {
            const currentValue = parseInt(quantityField.value);
            if (currentValue > 1) {
                quantityField.value = currentValue - 1;
            }
        });

        incrementBtn.addEventListener("click", function () {
            const currentValue = parseInt(quantityField.value);
            if (currentValue < 99) {
                quantityField.value = currentValue + 1;
            }
        });
    });
});

const colorOptions = document.querySelectorAll(".color-option");
const selectedColor = document.getElementById("selectedColor");
colorOptions.forEach((option) => {
    option.addEventListener("click", function () {
        colorOptions.forEach((otherOption) =>
            otherOption.classList.remove("active")
        );
        this.classList.add("active");
        selectedColor.textContent = this.textContent.trim();
    });
});
