$(document).ready(function() {
    // Copy Distribution
    var isChecked = false;
    var option = document.querySelectorAll(".dist__box--list .check");
    var selectSite = '<i style="color: orange" class="fa-solid fa-circle-exclamation"></i><p>Please select site(s)</p><i class="fa-solid fa-xmark"></i>';
    var serverError = '<i style="color: red" class="fa-solid fa-ban"></i><p>There is a problem connecting to the server</p><i class="fa-solid fa-xmark"></i>';
    $(".dist .all").on("click", e => {
        e.preventDefault();
        if(isChecked === false) {
            isChecked = true;
         } else {
            isChecked = false;
         }
         for (let i = 0; i < option.length; i++) {
            option[i].checked = isChecked;
         }
    })
    $(".dist .commit").on("click", e => {
        e.preventDefault();
        let data = {};
        for (let i = 0; i < option.length; i++) {
            if(option[i].checked) {
                data[i] = option[i].value;
            }
        }
         if(Object.keys(data).length === 0) {
            $notification.addClass("push");
            $notification.html(selectSite);
            $(".notification i").eq(1).on("click",()=>{
                $notification.removeClass("push");
            })
         } else {
             $.ajax({
                url: "data/dist.php",
                method: "POST",
                data: {
                    product: product,
                    data: JSON.stringify(data)
                },
                beforeSend: function() {
                    $notification.addClass("push");
                    $notification.html('<div class="spinner"></div><p>Distributing root files...<p>');
                },
                success: function(e) {
                    if(e !== "") {
                        $notification.empty();
                        $notification.html('<i style="color: orange" class="fa-solid fa-circle-exclamation"></i><p>'+e+'</p><i class="fa-solid fa-xmark"></i>');
                    } else {
                        $notification.empty();
                        $notification.html('<i style="color: green" class="fa-solid fa-circle-check"></i><p>Copied.</p><i class="fa-solid fa-xmark"></i>');
                        setTimeout(()=>{
                            location.reload()
                        }, 1500);
                    }
                    $(".notification i").eq(1).on("click",()=>{
                        $notification.removeClass("push");
                    })
                },
                error: function() {
                    $notification.empty();
                    $notification.html(serverError);
                    $(".notification i").eq(1).on("click",()=>{
                        $notification.removeClass("push");
                    })
                }
             })
         }
    })
    // Delete Distribution
    $(".dist .delete").on("click", e =>{
        e.preventDefault();
        let data = {};
        let count = 0;
        $input = $(".dist .deletePath");
        var path = $input.val();
        if(path === "") {
            $input.css("border", "solid 2px red");
        } else {
            $input.css("border", "solid 1px gray");
            for (let i = 0; i < option.length; i++) {
                if(option[i].checked) {
                    data[i] = option[i].value;
                    count++;
                }
            }
            if(count === 0) {
                $notification.addClass("push");
                $notification.html(selectSite);
                $(".notification i").eq(1).on("click",()=>{
                    $notification.removeClass("push");
                })
             } else {
                 $.ajax({
                     url: "data/distDelete.php",
                     method: "POST",
                     data: {
                         path: path,
                         data: JSON.stringify(data)
                     },
                     dataType: "html",
                     success: function(e) {
                         $notification.addClass("push");
                         if(e !== "") {
                             $notification.html('<i style="color: red" class="fa-solid fa-ban"></i><p>'+e+'</p><i class="fa-solid fa-xmark"></i>');
                        } else {
                            $notification.html('<i style="color: green" class="fa-solid fa-circle-check"></i><p>Deleted successfully.</p><i class="fa-solid fa-xmark"></i>');
                            setTimeout(()=>{
                                location.reload()
                            }, 1500);
                        }
                        $(".notification i").eq(1).on("click",()=>{
                            $notification.removeClass("push");
                        })
                     },
                     error: function() {
                         $notification.addClass("push");
                         $notification.html(serverError);
                         $(".notification i").eq(1).on("click",()=>{
                             $notification.removeClass("push");
                         })
                     }
                 })
             }
        }
    })

    // Send notification
    $(".dist .send").on("click", ()=>{
        let data = {};
        let count = 0;
        for (let i = 0; i < option.length; i++) {
            if(option[i].checked) {
                data[i] = option[i].value;
                count++;
            }
        }
        if(count === 0) {
            $notification.addClass("push");
            $notification.html(selectSite);
            $(".notification i").eq(1).on("click",()=>{
                $notification.removeClass("push");
            })
        } else {
            $.ajax({
                url: "data/notifySend.php",
                method: "POST",
                data: {
                    product: product,
                    data: JSON.stringify(data)
                },
                dataType: "html",
                success: function(e) {
                    $notification.addClass("push");
                    if(e !== "") {
                        $notification.html('<i style="color: orange" class="fa-solid fa-circle-exclamation"></i><p>'+e+'</p><i class="fa-solid fa-xmark"></i>');
                    } else {
                        $notification.html('<i style="color: green" class="fa-solid fa-circle-check"></i><p>Notification has been sent.</p><i class="fa-solid fa-xmark"></i>');
                    }
                    $(".notification i").eq(1).on("click",()=>{
                        $notification.removeClass("push");
                    })
                    setInterval(()=>{
                        $notification.removeClass("push");
                    }, 1000);
                },
                error: function(){
                    $notification.addClass("push");
                    $notification.html(serverError);
                    $(".notification i").eq(1).on("click",()=>{
                        $notification.removeClass("push");
                    })
                }
            })
        }
    })

    /// Database Distribution
    $(".dist .db").on("click", e =>{
        e.preventDefault();
        var query = $(".dist .query").val();
        let data = {};
        let count = 0;
        $input = $(".dist .query");
        var path = $input.val();
        if(path === "") {
            $input.css("border", "solid 2px red");
        } else {
            $input.css("border", "solid 1px gray");
            for (let i = 0; i < option.length; i++) {
                if(option[i].checked) {
                    data[i] = option[i].value;
                    count++;
                }
            }
            if(count === 0) {
                $notification.addClass("push");
                $notification.html(selectSite);
                $(".notification i").eq(1).on("click",()=>{
                    $notification.removeClass("push");
                })
             } else {
                 $.ajax({
                     url: "data/distdb.php",
                     method: "POST",
                     data: {
                        product: product,
                        query: query,
                        data: JSON.stringify(data)
                         
                     },
                     dataType: "html",
                     success: function(e) {
                         $notification.addClass("push");
                         if(e !== "") {
                             $notification.html('<i style="color: red" class="fa-solid fa-ban"></i><p>'+e+'</p><i class="fa-solid fa-xmark"></i>');
                        } else {
                            $notification.html('<i style="color: green" class="fa-solid fa-circle-check"></i><p>Query has been executed</p><i class="fa-solid fa-xmark"></i>');
                        }
                        $(".notification i").eq(1).on("click",()=>{
                            $notification.removeClass("push");
                        })
                     },
                     error: function() {
                         $notification.addClass("push");
                         $notification.html('<i style="color: red" class="fa-solid fa-ban"></i><p>query syntax error</p><i class="fa-solid fa-xmark"></i>');
                         $(".notification i").eq(1).on("click",()=>{
                             $notification.removeClass("push");
                         })
                     }
                 })
             }
        }
    })
})



// function uploadFileTv(src, techName) {
//     let data = {
//         "techName": techName,
//         "jpg": src
//     }
//     let post = JSON.stringify(data);
//     let xhr = new XMLHttpRequest();
//     xhr.onload = function() {
//         location.reload();
//     }
//     xhr.open("POST", "/admin/data/tvupload.php");
//     xhr.upload.addEventListener("progress", ({loaded, total}) => {
//         let fileLoaded = Math.floor((loaded/total)*100);
//         bar.value = fileLoaded; 
//         if (loaded == total) {
//             bar.style.display = "none";
//             progressLabel.innerHTML = `<p>Loading...</p></br>`;
//         } else {
//             progressLabel.innerHTML = `<p>Please wait</p></br>
//                                 <p>${fileLoaded} %</p></br>`;
//         }
//     })
//     xhr.setRequestHeader("Content-type",  "application/json");
//     xhr.send(post);
// }