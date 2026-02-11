jQuery(function ($) {
  function getState() {
    return {
      type: $("#car_type").val() || "",
      month: $("#car_month").val() || "",
      size: $("#car_size").val() || "64",
      label: $('input[name="label"]').is(":checked") ? "1" : "",
      category: $("#car_category").val() || "",
      list: $('input[name="list"]').is(":checked") ? "1" : "",
      class: $("#car_class").val() || "",
    };
  }

  function refresh() {
    const data = getState();

    $.post(CAR_ADMIN.ajaxUrl, {
      action: "car_admin_preview",
      nonce: CAR_ADMIN.nonce,
      ...data,
    }).done(function (res) {
      if (!res || !res.success) return;

      $("#car_shortcode_output").val(res.data.shortcode || "");
      $("#car_preview").html(res.data.html || "");
    });
  }

  // initial
  refresh();

  // live changes
  $(document).on("change keyup", ".car-field", function () {
    refresh();
  });

  $("#car_copy_shortcode").on("click", function (e) {
    e.preventDefault();
    const el = document.getElementById("car_shortcode_output");
    if (!el) return;
    el.select();
    el.setSelectionRange(0, 99999);
    document.execCommand("copy");
  });
});
