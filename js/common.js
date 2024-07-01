window.addEventListener("load", function () {
  var signup_form = document.getElementById("signup-form");
  signup_form.addEventListener("submit", function (event) {
    var XHR = new XMLHttpRequest();
    var form_data = new FormData(signup_form);

    XHR.open("POST", "api/signup_submit.php");

    XHR.addEventListener("load", function (event) {
      document.getElementById("loading").style.display = "none";

      if (XHR.status === 200) {

        var response = JSON.parse(XHR.responseText);
        if (response.success) {
          alert(response.message);
          window.location.href = "index.php";
        } else {
          alert(response.message);
        }
      } else {
        alert("Something Went wrong!");
      }
    });

    XHR.addEventListener("error", on_error);
    XHR.send(form_data);

    document.getElementById("loading").style.display = "block";
    event.preventDefault();
  });

  var login_form = document.getElementById("login-form");
  login_form.addEventListener("submit", function (event) {

    var XHR = new XMLHttpRequest();
    var form_data = new FormData(login_form);

    XHR.open("POST", "api/login_submit.php");

    XHR.addEventListener("load", function (event) {
      document.getElementById("loading").style.display = "none";

      if (XHR.status === 200) {

        console.log("Response: " + XHR.response);
        console.log("Response Text: " + XHR.responseText);

        var response = JSON.parse(XHR.responseText);
        if (response.success) {
          alert(response.message);
          window.location.href = "index.php";
        } else {
          alert(response.message);
        }
      } else {
        alert("Something Went wrong!");
      }
    });

    XHR.addEventListener("error", on_error);

    XHR.send(form_data);

    document.getElementById("loading").style.display = "block";
    event.preventDefault();
  });
});

var on_error = function (event) {
  document.getElementById("loading").style.display = "none";
  alert("Connection to server could not be established!");
};
