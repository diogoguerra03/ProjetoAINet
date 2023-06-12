import "./bootstrap"

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

const colorOptions = document.querySelectorAll(".color-option")
const selectedColor = document.getElementById("selectedColor")
const tshirtImage = document.getElementById("tshirtImage")

colorOptions.forEach((option) => {
    option.addEventListener("click", function () {
        colorOptions.forEach((otherOption) => otherOption.classList.remove("active"))
        this.classList.add("active")
        selectedColor.textContent = this.textContent.trim()

        // Send the selected color to the server
        const colorCode = this.dataset.color
        const url = `/change-color?colorCode=${encodeURIComponent(colorCode)}`

        // Make an AJAX request to the server
        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                tshirtImage.src = data.colorUrl
                tshirtImage.setAttribute('data-color-url', data.colorUrl);
            })
            .catch((error) => {
                console.error("Error:", error)
            })
    })
})

//bargraph
console.log("Hello from dashboard.js!")
var ctxB = document.getElementById("barChart").getContext("2d")
var myBarChart = new Chart(ctxB, {
    type: "bar",
    data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [
            {
                label: "# of Votes",
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    "rgba(255, 99, 132, 0.2)",
                    "rgba(54, 162, 235, 0.2)",
                    "rgba(255, 206, 86, 0.2)",
                    "rgba(75, 192, 192, 0.2)",
                    "rgba(153, 102, 255, 0.2)",
                    "rgba(255, 159, 64, 0.2)",
                ],
                borderColor: [
                    "rgba(255,99,132,1)",
                    "rgba(54, 162, 235, 1)",
                    "rgba(255, 206, 86, 1)",
                    "rgba(75, 192, 192, 1)",
                    "rgba(153, 102, 255, 1)",
                    "rgba(255, 159, 64, 1)",
                ],
                borderWidth: 1,
            },
        ],
    },
    options: {
        scales: {
            yAxes: [
                {
                    ticks: {
                        beginAtZero: true,
                    },
                },
            ],
        },
    },
})
