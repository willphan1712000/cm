$(document).ready(function() {
    // Toggle side navigation
    $(".side-nav--mobile .dropdownicon").on("click", ()=>{
        $(".side-nav--mobile .side-nav__btn").slideToggle('fast');
    })
})