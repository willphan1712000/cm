$(document).ready(function(){
    $notification = $(".notification");
    $deleteBtn = $(".file__list--ele .delete");
    $deleteBtn.on("click", e => {
        e.preventDefault;
        if(confirm("Are you sure to delete this file or folder?")) {
            var path = $(e.currentTarget).find("input").attr("name");
            $.ajax({
                url: "data/deleteFolder.php",
                method: "POST",
                data: {
                    path: path
                },
                dataType: "html",
                success: function(e) {
                    if (e !== "") {
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
                    $notification.html('<i style="color: red" class="fa-solid fa-ban"></i><p>There is a problem with the connection to server</p><i class="fa-solid fa-xmark"></i>');
                    $(".notification i").eq(1).on("click",()=>{
                        $notification.removeClass("push");
                    })
                }
            })
        }
    })
})