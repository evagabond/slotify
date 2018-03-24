// Show hide login or register form depending on user choice
$(document).ready(function() {
    
    $("#hideLogin").click(function() {
        $("#loginForm").hide();
        $("#registerForm").show();
    });

    $("#hideRegister").click(function() {
        $("#loginForm").show();
        $('#registerForm').hide();
    });
});