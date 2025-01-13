function showCitiesByCountry(selectedCountryId) {
  var cityCheckboxes = document.querySelectorAll(".city-checkbox");

  cityCheckboxes.forEach(function (checkbox) {
    var countryId = checkbox.getAttribute("data-country-id");
    if (selectedCountryId === "" || countryId !== selectedCountryId) {
      checkbox.parentElement.parentElement.style.display = "none";
    } else {
      checkbox.parentElement.parentElement.style.display = "block";
    }
  });
}

document.addEventListener("DOMContentLoaded", function () {
  var selectedCountryId = document.getElementById("country").value;
  showCitiesByCountry(selectedCountryId);
});

document.getElementById("country").addEventListener("change", function () {
  var selectedCountryId = this.value;
  showCitiesByCountry(selectedCountryId);
});
