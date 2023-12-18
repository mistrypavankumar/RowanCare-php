$(document).ready(function () {
  var checkedGenders = [];
  var checkedSpecialization = [];

  function fetchData() {
    if (checkedGenders.length > 0 || checkedSpecialization.length > 0) {
      $("#seachedItems").show();
      $("#beforeSearchItems").hide();

      $.ajax({
        url: "../RowanCare-php/providers/search-doctors.php",
        method: "POST",
        data: {
          GET_DOCTORS: 1,
          GENDERS: JSON.stringify(checkedGenders),
          SPECIALIZATIONS: JSON.stringify(checkedSpecialization),
        },
        success: function (response) {
          $("#searchDataRow").html(response);
        },
        error: function (xhr, status, error) {
          console.log("Error: " + error);
          $("#seachedItems").html("<p>Error occurred while fetching data.</p>");
        },
      });
    } else {
      $("#beforeSearchItems").show();
      $("#seachedItems").hide();
    }
  }

  $(
    "#genderMale, #genderFemale, #Cardiology, #Neurology, #Pediatrics, #Orthopedics, #Dentist"
  ).change(function () {
    var value = $(this).val();
    var checkedArray = $(this).is("#genderMale, #genderFemale")
      ? checkedGenders
      : checkedSpecialization;

    if ($(this).is(":checked")) {
      checkedArray.push(value);
    } else {
      var index = checkedArray.indexOf(value);
      if (index > -1) {
        checkedArray.splice(index, 1);
      }
    }
    fetchData();
  });
});
