const chk1 = document.getElementById("chk1");
const chk2 = document.getElementById("chk2");
const chk3 = document.getElementById("chk3");
const chk4 = document.getElementById("chk4");

chk2.addEventListener("change", function () {
  if (chk2.checked) {
    chk4.checked = false;
  }
});

chk4.addEventListener("change", function () {
  if (chk4.checked) {
    chk2.checked = false;
  }
});

$(document).on("change", ".country-select", function () {
  var selectedCountryId = $(this).val();
  var cityContainer = $(this)
    .closest("[data-repeater-item]")
    .find(".city-container");

  $.ajax({
    url: "/admin/dashboard/get-cities",
    method: "GET",
    data: { country_id: selectedCountryId },
    success: function (response) {
      cityContainer.empty();
      $.each(response, function (key, city) {
        var cityWrapper = $(
          '<div class="row city-wrapper" data-repeater-item></div>'
        );
        cityWrapper.append(
          '<div class="mb-3 col-lg-2"><input class="form-control city-input" type="text" value="' +
            city.name_ar +
            '" name="city_name[]" readonly></div>'
        );
        cityWrapper.append(
          '<div class="mb-3 col-lg-2"><input class="form-control price-input" type="text" ' +
            (city.shipping_price ? 'value="' + city.shipping_price + '"' : "") +
            ' placeholder="السعر" name="price[' +
            city.id +
            ']""></div>'
        );

        cityContainer.append(cityWrapper);
      });
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
});
