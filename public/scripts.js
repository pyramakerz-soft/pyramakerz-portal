let currentStep = 1;

// Ensure all hidden sections are hidden on page load
window.onload = () => {
    const popup = document.getElementById("popup");
    popup.classList.add("hidden");
    popup.style.display = "none";

    const courseTrack = document.getElementById("course-track");
    courseTrack.style.display = "none";

    updateNavigationButtons();
};

// Function to navigate to the next step
function nextStep() {
    const currentFormStep = document.getElementById(`step-${currentStep}`);
    const nextFormStep = document.getElementById(`step-${currentStep + 1}`);

    if (nextFormStep) {
        currentFormStep.classList.remove("active");
        nextFormStep.classList.add("active");
        currentStep++;
    }

    updateNavigationButtons();
}

// Function to navigate to the previous step
function prevStep() {
    const currentFormStep = document.getElementById(`step-${currentStep}`);
    const prevFormStep = document.getElementById(`step-${currentStep - 1}`);

    if (prevFormStep) {
        currentFormStep.classList.remove("active");
        prevFormStep.classList.add("active");
        currentStep--;
    }

    updateNavigationButtons();
}

// Update navigation button visibility
function updateNavigationButtons() {
    const backButton = document.querySelector(".back-btn");
    const nextButton = document.querySelector(".next-btn");
    const submitButton = document.querySelector(".submit-btn");

    // Show Back button only if not on the first step
    backButton.style.display = currentStep > 1 ? "inline-block" : "none";

    // Show Next button only for steps before the last
    nextButton.style.display = currentStep < 5 ? "inline-block" : "none";

    // Show Submit button only for the last step
    submitButton.style.display = currentStep === 5 ? "inline-block" : "none";

    // Hide the course track if not on Step 4
    const courseTrack = document.getElementById("course-track");
    if (courseTrack && currentStep !== 4) {
        courseTrack.style.display = "none";
    }
}

// Show course track on "No" button click
function showCourseTrack() {
    const questionSection = document.getElementById("step-4");
    questionSection.classList.remove("active"); // Hide question section

    const courseTrack = document.getElementById("course-track");
    courseTrack.style.display = "block"; // Show the course track
    courseTrack.scrollIntoView({ behavior: "smooth" }); // Smooth scroll

    // Hide the next button
    const nextButton = document.querySelector(".next-btn");
    nextButton.style.display = "none";

    // Show the back button
    const backButton = document.querySelector(".back-btn");
    backButton.style.display = "inline-block";
}

// Show programming languages for "Yes" button click
function showProgrammingLanguages() {
    nextStep(); // Proceed to the programming languages step
}

// Toggle multi-select button active state
function toggleSelection(button, value, event) {
    // Prevent the default form submission behavior
    event.preventDefault();

    button.classList.toggle("active");

    const selectedLanguagesContainer = document.getElementById(
        "selected-programming-languages"
    );
    const existingInput = document.querySelector(
        `input[name="prog[]"][value="${value}"]`
    );

    if (button.classList.contains("active")) {
        // If the button is active, add a hidden input for this programming language
        if (!existingInput) {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "prog[]";
            input.value = value;
            selectedLanguagesContainer.appendChild(input);
        }
    } else {
        // If the button is not active, remove the corresponding hidden input
        if (existingInput) {
            selectedLanguagesContainer.removeChild(existingInput);
        }
    }
}

function handleSubmit(event) {
    event.preventDefault(); // Prevent default form submission behavior

    // Show the popup
    const popup = document.getElementById("popup");
    popup.classList.add("show");
    popup.style.display = "flex";

    // Collect all form data, including hidden inputs for prog[]
    const form = document.getElementById("registration-form");
    const formData = new FormData(form);

    // Debugging: Log the data being submitted
    console.log("Submitting form data...");
    for (let [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
    }

    // Submit the form data to the Laravel route using Fetch API
    fetch(form.action, {
        method: form.method,
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]')
                .value, // Include CSRF token
        },
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            console.log("Form submission successful:", data);
            // You can also handle success messages or further actions here
        })
        .catch((error) => {
            console.error("Form submission error:", error);
        });
}

// Add Submit button event listener
document
    .getElementById("registration-form")
    .addEventListener("submit", handleSubmit);

// Add Submit button event listener
document
    .getElementById("registration-form")
    .addEventListener("submit", handleSubmit);

// Function to close the popup
function closePopup() {
    const popup = document.getElementById("popup");
    popup.classList.remove("show");
    popup.style.display = "none";
}
