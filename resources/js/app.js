import "./bootstrap"
import Swal from "sweetalert2"

// -----------------Show TshirtImage-----------------

document.addEventListener("DOMContentLoaded", function () {
    const quantityInputs = document.querySelectorAll(".quantity-input")

    quantityInputs.forEach(function (quantityInput) {
        const decrementBtn = quantityInput.querySelector('[data-action="decrement"]')
        const incrementBtn = quantityInput.querySelector('[data-action="increment"]')
        const quantityField = quantityInput.querySelector(".quantity")

        decrementBtn.addEventListener("click", function () {
            const currentValue = parseInt(quantityField.value)
            if (currentValue > 1) {
                quantityField.value = currentValue - 1
            }
        })

        incrementBtn.addEventListener("click", function () {
            const currentValue = parseInt(quantityField.value)
            if (currentValue < 99) {
                quantityField.value = currentValue + 1
            }
        })
    })
})

// Change the color of the tshirt
const colorOptions = document.querySelectorAll(".color-option")
const selectedColor = document.getElementById("selectedColor")
colorOptions.forEach((option) => {
    option.addEventListener("click", function () {
        colorOptions.forEach((otherOption) => otherOption.classList.remove("active"))
        this.classList.add("active")
        selectedColor.textContent = this.textContent.trim()
        var colorHex = this.getAttribute("data-color")
        document.getElementById("tshirt").src = "/storage/tshirt_base/" + colorHex + ".jpg"
    })
})

// -----------------Delete TshirtImage-----------------

document.addEventListener("DOMContentLoaded", function () {
    const deleteForms = document.querySelectorAll("[id^='deleteForm_']");
    if (deleteForms) {
        deleteForms.forEach(function (deleteForm) {
            deleteForm.addEventListener("submit", function (event) {
                event.preventDefault();

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        event.target.submit();
                    }
                });
            });
        });
    }
});


// -------------------Dashboard-------------------

if (window.location.pathname === "/dashboard") {
    document.addEventListener("DOMContentLoaded", function () {
        // Bargraph
        var ctxB = document.getElementById("barChart").getContext("2d")
        var myBarChart = new Chart(ctxB, {
            type: "bar",
            data: {
                labels: [
                    "Janeiro",
                    "Fevereiro",
                    "Março",
                    "Abril",
                    "Maio",
                    "Junho",
                    "Julho",
                    "Agosto",
                    "Setembro",
                    "Outubro",
                    "Novembro",
                    "Dezembro",
                ],
                datasets: [
                    {
                        label: "Number of orders",
                        data: [12, 19, 3, 5, 2, 3, 32, 12, 19, 3, 5, 2],
                        backgroundColor: ["rgb(42,107,229,0.5)"],
                        borderColor: ["rgb(42,107,229)"],
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: "Orders per month",
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                        },
                    },
                },
            },
        })

        // Piechart
        var ctxP = document.getElementById("pieChart").getContext("2d")
        var myPieChart = new Chart(ctxP, {
            type: "pie",
            data: {
                labels: ["Eletrônicos", "Roupas", "Livros", "Brinquedos", "Outros"],
                datasets: [
                    {
                        data: [300, 50, 100, 40, 120],
                        backgroundColor: [
                            "rgb(42,107,229,0.5)",
                            "rgba(145,60,76,0.5)",
                            "rgba(42,229,67,0.5)",
                            "rgba(229,204,42,0.5)",
                            "rgba(229,42,42,0.5)",
                        ],
                        hoverBackgroundColor: [
                            "rgb(42,107,229,0.9)",
                            "rgba(145,60,76,0.9)",
                            "rgba(42,229,67,0.9)",
                            "rgba(229,204,42,0.9)",
                            "rgba(229,42,42,0.9)",
                        ],
                    },
                ],
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: "Categories sold",
                    },
                },
                responsive: true,
            },
        })
    })
}
