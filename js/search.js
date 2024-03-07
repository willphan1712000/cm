// ================ Portfolio ======================
$(document).ready(function() {
    function search(product) {
        $.ajax({
            url: "data/search.php",
            method: "POST",
            data: {
                searchReq: product
            },
            dataType: "JSON",
            // beforeSend: function() {
            //     $(".search."+product+" .search__result table").html('<div class="spinner"></div>');
            //     $(".search."+product+" s.search__result table").css("display", "flex");
            // },
            success: function(list) {
                let display, name;
                switch(product) {
                    case "p":
                        name = "Portfolio"
                        break
                    case "vtv":
                        name = "VTV"
                        display = "none"
                        break
                    case "htv":
                        name = "HTV"
                        display = "none"
                        break
                    default:
                        break
                }
                $inputBox = $(".search."+product+" .search__box input");
                $resultBox = $(".search."+product+" .search__result table");
                $resultBox.parent().find(".spinner").remove();
                $resultBox.show();
                $resultBox.css("display","block");
                $resultBox.html('<tr><th>#</th><th>'+name+'</th><th>Username</th><th>Password</th><th style="display:'+display+'">Tech</th><th style="display:'+display+'">Mobile Photos</th><th>TV Photos</th><th>AIC Admin</th><th>Subscription</th></tr>');
                for(let i=0;i<list.length;i++) {
                    var sub;
                    if(list[i].sub === null) {
                        sub = "Not subscribed";
                    } else {
                        sub = dateType(list[i].sub);
                    }
                    $resultBox.append('<tr><th>'+list[i].order+'</th><th>'+list[i].name+'</th><th>'+list[i].username+'</th><th>'+list[i].password+'</th><th style="display:'+display+'">'+list[i].tech+'</th><th style="display:'+display+'">'+list[i].mobile+'</th><th>'+list[i].tv+'</th><th><a href = "https://'+list[i].name+'/aicadmin" target="_blank">Admin</a></th><th><input id="'+product+'" class="'+sub+'" placeholder="MM/DD/YYYY" name='+list[i].name+' type="text" disabled value="'+sub+'"><i class="fa-solid fa-pen sub-edit"></i><div class="sub-edit__btn"><i class="fa-solid fa-check sub-edit__btn--confirm"></i></i><i class="fa-solid fa-ban sub-edit__btn--cancel"></i></th></tr>');
                }
                subEdit(product)
                // SEARCH
                $inputBox.keyup(()=>{
                    let type = $inputBox.val();
                    let result = [];
                    if(type) {
                        result = list.filter(e => {
                            return e.name.toLowerCase().startsWith(type.toLowerCase());
                        })
                        result = result.map(e => {
                            var sub;
                            if(e.sub === null) {
                                sub = "Not subscribed";
                            } else {
                                sub = dateType(e.sub);
                            }
                            return e = '<tr><th>'+e.order+'</th><th>'+e.name+'</th><th>'+e.username+'</th><th>'+e.password+'</th><th>'+e.tech+'</th><th>'+e.mobile+'</th><th>'+e.tv+'</th><th><a href = "https://'+e.name+'/aicadmin" target="_blank">Admin</a></th><th><input class="'+sub+'" placeholder="MM/DD/YYYY" name='+e.name+' type="text" disabled value="'+sub+'"><i class="fa-solid fa-pen sub-edit"></i><div class="sub-edit__btn"><i class="fa-solid fa-check sub-edit__btn--confirm"></i></i><i class="fa-solid fa-ban sub-edit__btn--cancel"></i></th></tr>';
                        })
                        $resultBox.html('<tr><th>#</th><th>Portfolio</th><th>Username</th><th>Password</th><th>Tech</th><th>Mobile Photos</th><th>TV Photos</th><th>AIC Admin</th><th>Subscription</th></tr>');
                        $resultBox.append(result);
                        subEdit(product)
                    } else {
                        search(product)
                    }
                })
            }
        })
    }
    search("p");
    search("vtv");
    search("htv");




    function dateType(date) {
        const splitDate = date.split("-"); // YYYYMMDD
        return splitDate[1] + "/" + splitDate[2] + "/" + splitDate[0]
    }
    function dateTypeReverse(date) {
        const splitDate = date.split("/"); // MMDDYYY
        return splitDate[2] + "-" + splitDate[0] + "-" + splitDate[1]
    }
    function subEdit(product) {
        // EDIT Subscription
        $(".search."+product+" .sub-edit").click(e => {
            if($(e.currentTarget).prev().attr('disabled')) {
                $(e.currentTarget).prev().prop('disabled', false);
                $(e.currentTarget).prev().val("");
            } else {
                $(e.currentTarget).prev().prop('disabled', true);
                $(e.currentTarget).prev().val($(e.currentTarget).prev().attr("class"));
            }
            $(e.currentTarget).next().slideToggle("fast");
        })
        $(".search."+product+" .sub-edit__btn .sub-edit__btn--confirm").click(e => {
            let name = $(e.currentTarget).parent().prev().prev().attr("name"), date = $(e.currentTarget).parent().prev().prev().val();
            $.ajax({
                url: "/data/subscription.php",
                method: "POST",
                data: {
                    req: product,
                    name: name,
                    date: dateTypeReverse(date)
                },
                success: function() {
                    $(e.currentTarget).parent().prev().prev().removeAttr('class');
                    $(e.currentTarget).parent().prev().prev().addClass(date);
                    $(e.currentTarget).parent().prev().prev().val(date);
                    $(e.currentTarget).parent(".sub-edit__btn").slideToggle("fast");
                    $(e.currentTarget).parent().prev().prev().prop('disabled', true);
                },
                error: function() {
                    alert("Please type in a correct date format");
                }
            })
        })
        $(".search."+product+" .sub-edit__btn .sub-edit__btn--cancel").click(e => {
            let name = $(e.currentTarget).parent().prev().prev().attr("name"), date = 'Not subscribed';
            $.ajax({
                url: "/data/subscription.php",
                method: "POST",
                data: {
                    req: product,
                    name: name,
                    date: date
                },
                success: function() {
                    $(e.currentTarget).parent().prev().prev().removeAttr('class');
                    $(e.currentTarget).parent().prev().prev().addClass(date);
                    $(e.currentTarget).parent().prev().prev().val(date);
                    $(e.currentTarget).parent(".sub-edit__btn").slideToggle("fast");
                    $(e.currentTarget).parent().prev().prev().prop('disabled', true);
                },
                error: function() {
                    alert("Error when canceling subscription");
                }
            })
        })
    }
})