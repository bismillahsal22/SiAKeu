$(document).ready(function () {
    $(".select2").select2(); // Initialize select2 plugin for better UI

    // Event listener for when the student name is changed
    $("#nama").on("change", function () {
        let studentId = $(this).val();

        if (studentId) {
            $.ajax({
                url: "{{ route('fetch.student.details') }}",
                type: "GET",
                dataType: "json",
                data: {
                    studentId: studentId,
                },
                success: function (data) {
                    if (data) {
                        // Auto-fill fields based on student data
                        $("#nisn").val(studentId); // Assuming nisn is same as studentId for example
                        // You might want to map the returned data to other fields if necessary
                        // For example, if you have nisn or other details, populate them here
                    } else {
                        // Handle case when data is not found
                        $("#nisn").val("");
                        // Clear other fields if necessary
                    }
                },
                error: function () {
                    // Handle errors
                    $("#nisn").val("");
                    // Clear other fields if necessary
                },
            });
        } else {
            // Clear fields if no studentId is selected
            $("#nisn").val("");
        }
    });
});
