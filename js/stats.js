$(document).ready(function() {
    const req = ['p', 'vtv', 'p_mimg', 'p_tvimg', 'vtv_tvimg', 'htv', 'htv_tvimg'];
    const object = [$("#p .count .count__text p"), $("#vtv .count .count__text p"), $("#p .mimg-count .count__text p"), $("#p .tvimg-count .count__text p"), $("#vtv .tvimg-count .count__text p"), $("#htv .count .count__text p"), $("#htv .tvimg-count .count__text p")];
    for(let i = 0; i < req.length; i++) {
        $.ajax({
            url: "/data/stats.php",
            method: "POST",
            data: {
                request: req[i]
            },
            dataType: 'json',
            success: function(e) {
                $(".search__result").css("display", "block")
                object[i].prev().remove()
                object[i].html(e)
            },
            error: function() {
                object[i].prev().remove()
                object[i].html('<i class="fa-solid fa-ban"></i> error')
            }
        })

    }
})