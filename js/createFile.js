$(document).ready(function(){
    $notification = $(".notification");
    $(".newFile .accept").on("click",() => {
        var file = $(".newFile input").val();
        if(file === '') {
            $notification.addClass("push");
            $notification.html('<i style="color: orange" class="fa-solid fa-circle-exclamation"></i><p>Please enter a file name or a folder path including the file</p><i class="fa-solid fa-xmark"></i>');
            $(".notification i").eq(1).on("click",()=>{
                $notification.removeClass("push");
            })
        } else {
            $.ajax({
                url: "data/createFile.php",
                method: "POST",
                data: {
                    product: product,
                    file: file
                },
                fileType: "html",
                success: function(e){
                    $notification.addClass("push");
                    if(e !== "") {
                        $notification.html('<i style="color: orange" class="fa-solid fa-circle-exclamation"></i><p>'+e+'</p><i class="fa-solid fa-xmark"></i>');
                        $(".notification i").eq(1).on("click",()=>{
                            $notification.removeClass("push");
                        })
                    } else {
                        $notification.html('<i style="color: green" class="fa-solid fa-circle-check"></i><p>The file has been created successfully. The page will refresh.</p><i class="fa-solid fa-xmark"></i>');
                        setInterval(()=>{
                            location.reload();
                        }, 1000);
                    }
                },
                error: function(){
                    $notification.addClass("push");
                    $notification.html('<i style="color: red" class="fa-solid fa-ban"></i><p>There is a problem for connection to the server</p><i class="fa-solid fa-xmark"></i>');
                    $(".notification i").eq(1).on("click",()=>{
                        $notification.removeClass("push");
                    })
                }
            })
        }
    })

    $(".createBtn").click(function(e) {
        $(".newFile").css("display", "flex");
        $(this).hide();
    })
    $(".newFile .cancel").click(function(e) {
        $(".createBtn").show();
        $(this).parent().hide();
    })
})