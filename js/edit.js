$(document).ready(function(){
    $notification = $(".notification");
    $(".file__list--ele .edit").on("click", e => {
        e.preventDefault;
        $(e.currentTarget).prev().toggle();
        $(e.currentTarget).prev().focus();
        $(e.currentTarget).prev().prev().toggle();
        $(e.currentTarget).prev().val($(e.currentTarget).prev().prev().html())
    })
    $(".file__list--ele .edit__box").on("keyup", function(e) {
        if(!$(this).val()) {
            $(e.currentTarget).next().show();
            $(e.currentTarget).next().next().hide();
        } else {
            $(e.currentTarget).next().hide();
            $(e.currentTarget).next().next().show();
        }
    })
    $(".file__list--ele .acceptEdit").click(e => {
        e.preventDefault();
        var path = $(e.currentTarget).find("input").attr("name");
        var change = $(e.currentTarget).prev().prev().val();
        $.ajax({
            url: "data/edit.php",
            method: "POST",
            data: {
                path: path,
                change: change
            },
            dataType: "html",
            success: function(e) {
                if(e !== "") {
                    $notification.addClass("push");
                    $notification.html('<i style="color: red" class="fa-solid fa-ban"></i><p>'+e+'</p><i class="fa-solid fa-xmark"></i>');
                    $(".notification i").eq(1).on("click",()=>{
                        $notification.removeClass("push");
                    })
                } else {
                    location.reload();
                }
            },
            error: function() {
                $notification.addClass("push");
                $notification.html('<i style="color: red" class="fa-solid fa-ban"></i><p>There is a problem connecting to the server</p><i class="fa-solid fa-xmark"></i>');
                $(".notification i").eq(1).on("click",()=>{
                    $notification.removeClass("push");
                })
            }
        })
    })
})