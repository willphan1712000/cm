$(document).ready(function() {
    $textarea = $("#textarea");
    $notification = $(".notification");
    $commit = $("#form-textarea .commit");

    $(".file__list--ele .open").on("click", e => {
        e.preventDefault();
        $commit.prop("disabled", true);
        $commit.css({"background-color":"gray", "cursor":"default"});
        const path = $(e.currentTarget).find("input").attr("name");
        const name = $(e.currentTarget).siblings("p").html();
        $.ajax({
            url: "data/open.php",
            method: "POST",
            data: {
                path: path
            },
            dataType: "html",
            success: function(data) {
                $textarea.val(data);
                $("#form-textarea .name-open").attr("name", path);
                $("#form-textarea .name-open").val(name);
            }
        })
    })
    $textarea.on("keyup",()=>{
        $commit.prop("disabled", false);
        $commit.css({"background-color":"#000", "cursor":"pointer"});
        $commit.on("click", e =>{
            e.preventDefault();
            $.ajax({
                url: "data/commit.php",
                method: "POST",
                data: {
                    path: $("#form-textarea .name-open").attr("name"),
                    content: $textarea.val()
                },
                success: function() {
                    $notification.addClass("push");
                    $notification.html('<i style="color: green" class="fa-solid fa-circle-check"></i><p>The file content has been changed.</p><i class="fa-solid fa-xmark"></i>');
                    $(".notification i").eq(1).on("click",()=>{
                        $notification.removeClass("push");
                    })
                    setInterval(()=>{
                        $notification.removeClass("push");
                    }, 1000);
                },
                error: function(){
                    $notification.addClass("push");
                    $notification.html('<i style="color: red" class="fa-solid fa-ban"></i><p>There is a problem connecting to the server</p><i class="fa-solid fa-xmark"></i>');
                    $(".notification i").eq(1).on("click",()=>{
                        $notification.removeClass("push");
                    })
                }
            })
        })
    })
})
