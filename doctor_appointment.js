document.addEventListener("DOMContentLoaded", function () {
    var editButtons = document.getElementsByClassName("editButton");

    // Attach click event listeners to edit buttons
    for (var i = 0; i < editButtons.length; i++) {
        editButtons[i].addEventListener("click", openEditModal);
    }

    // Get the edit modal
    var editModal = document.getElementById("editModal");

    // Get the <span> element that closes the edit modal
    var closeSpan = editModal.getElementsByClassName("close")[0];

    // Attach click event listener to close button
    closeSpan.addEventListener("click", closeEditModal);

    // Attach click event listener to window
    window.addEventListener("click", closeEditModalOutside);

    // Function to open the edit modal and pre-fill the form fields with existing values
    function openEditModal(event) {
        var appointmentId = event.target.getAttribute("data-appointment-id");
        var editForm = document.getElementById("editForm");
        var editAppointmentId = document.getElementById("editAppointmentId");
        var editPatient = document.getElementById("editPatient");
        var editDate = document.getElementById("editDate");
        var editTime = document.getElementById("editTime");

        // Set the appointment ID value in the hidden input field
        editAppointmentId.value = appointmentId;

        // Get the appointment details
        var patient = event.target.parentNode.parentNode.parentNode.childNodes[1].textContent;
        var date = event.target.parentNode.parentNode.parentNode.childNodes[5].textContent;
        var time = event.target.parentNode.parentNode.parentNode.childNodes[7].textContent;

        // Set the form fields with existing values
        editPatient.value = patient;
        editDate.value = date;
        editTime.value = time;

        // Show the edit modal
        editModal.style.display = "block";
    }

    // Function to close the edit modal
    function closeEditModal() {
        editModal.style.display = "none";
    }

    // Function to close the edit modal when clicked outside the modal
    function closeEditModalOutside(event) {
        if (event.target == editModal) {
            editModal.style.display = "none";
        }
    }
});


 // JavaScript for the modal
 $(document).ready(function() {
    $(".editBtn").click(function() {
        var appointmentId = $(this).data("id");
        $("#editAppointmentId").val(appointmentId);
        $("#editModal").css("display", "block");
    });

    $(".close").click(function() {
        $("#editModal").css("display", "none");
    });
});