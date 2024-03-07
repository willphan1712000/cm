$(document).ready(function() {
    var option = document.querySelectorAll(".dist__box--list .check");
    var selectSite = '<div class="content"><i style="color: orange" class="fa-solid fa-circle-exclamation"></i><p>Please select site(s)</p><i class="fa-solid fa-xmark"></i></div>';
    var serverError = '<div class="content"><i style="color: red" class="fa-solid fa-ban"></i><p>There is a problem connecting to the server</p><i class="fa-solid fa-xmark"></i></div>';
    $input = $('.btn .sql input[name="sql"]');
    $import = $('.btn .sql button[name="import"]');
    var input = document.querySelector('.btn .sql input[name="sql"]');
    $('.btn .sql div').on("click", ()=>{
        $input.click();
    })
    var site = {}, queryArr = [];
    $input.on("change",() => {
        let file = input.files[0];
        let name = file.name;
        let b = file.size, kb = Math.floor(file.size/1024), mb = Math.floor(file.size/(1024*1024));
        let size;
        if(mb > 0) {
            size = mb + " MB";
        } else if (kb > 0 && mb === 0) {
            size = kb + " KB";
        } else {
            size = b + " B";
        }
        $('.btn .sql p').html(name + "<br>" + size);
        if(name.split('.')[1] !== 'sql') {
            $notification.addClass("push");
            $notification.html('<i style="color: red" class="fa-solid fa-ban"></i><p>Invaild file, it must be sql</p><i class="fa-solid fa-xmark"></i>');
            $(".notification i").eq(1).on("click",()=>{
                $notification.removeClass("push");
            })
            $import.css({
                "pointer-events": "none",
                "background-color": "#ccc"
            })
        } else {
            $notification.removeClass("push");
            $import.css({
                "pointer-events": "all",
                "background-color": "#000"
            })
            const reader = new FileReader();
            reader.readAsText(file);
            queryArr = [];
            reader.onload = function() {
                var sqlArr = reader.result.split('\n');
                for (let i = 0; i < sqlArr.length; i++) {
                    let firstTwo = sqlArr[i].split(' ').join('').substr(0, 2)
                    if(firstTwo !== '--' && firstTwo !== '/*' && firstTwo !== '//' && firstTwo !== '') {
                        queryArr.push(sqlArr[i]);                    
                    }
                }
            }
        }
    })
    $import.on("click", e => {
        e.preventDefault();
        for(const key in site) {
            delete site[key]
        }
        for (let i = 0; i < option.length; i++) {
            if(option[i].checked) {
                site[i] = option[i].value;
            }
        }
        if(Object.keys(site).length === 0) {
            $notification.addClass("push");
            $notification.html(selectSite);
            $(".notification i").eq(1).on("click",()=>{
                $notification.removeClass("push");
            })
        } else {
            if(confirm("The process will be comparing the uploaded database to the existing database. If there is any changes, it will be applied. Are you sure to proceed?") === true) {
            $notification.html('<div class="progress"><div id="progressBar"><span></span></div><label for="progressBar"></label></div>')
            $bar = $(".notification #progressBar span");
            $label = $(".notification label");
                $.ajax({
                    url: "data/defaultdb.php",
                    method: "POST",
                    data: {
                        product: product,
                        site: JSON.stringify(site),
                        queryArr: JSON.stringify(queryBreakDown(queryArr)),
                        db: JSON.stringify(databaseBreakDown(queryArr))
                    },
                    dataType: "json",
                    xhr: function() {
                        $notification.addClass("push");
                        var xhr = new window.XMLHttpRequest()
                        // xhr.onprogress = function(e) {
                        //     // For downloads
                        //     if(e.lengthComputable) {
                        //         $bar.css("width", `${(e.loaded/e.total)*100}%`)
                        //     }    
                        // }
                        xhr.upload.onprogress = function(e) {
                            // For uploads
                            if(e.lengthComputable) {
                                $label.html('Uploading database...')
                                $bar.css("width", `${(e.loaded/e.total)*30}%`)
                            }
                        }
                        return xhr;
                    }
                }).done(function(e) {
                    $notification.css("flex-direction", "column")
                    $label.html('Applying database...')
                    $bar.css("width", '70%')
                    setTimeout(()=>{
                        $bar.css("width", '100%')
                        $label.html('<i style="color: green" class="fa-solid fa-circle-check"></i>')
                        $notification.append('<div class="content"><p>Database changed: '+e[0]+', Database unchanged: '+e[1]+'</p><i class="fa-solid fa-xmark close"></i></div>');
                        $(".notification .close").on("click",()=>{
                            $notification.removeClass("push");
                        })
                    },1500)
                }).fail(function() {
                    $notification.addClass("push");
                    $notification.html(serverError);
                    $(".notification i").eq(1).on("click",()=>{
                        $notification.removeClass("push");
                    })
                })
            }
        }
    })

    function databaseBreakDown(queryArr) {
        let result = {}; string = '', array = [];
        for(let i = 0; i < queryArr.length; i++) {
            last = queryArr[i].substr(-1,1)
            if(last !== ";") {
                string += queryArr[i];
            } else {
                string += queryArr[i];
                array.push(string)
                string = '';
            }
        }
        array.forEach(e => {
            if(e.search(/CREATE TABLE `/) === 0) {
                let ele = e.split('`')
                result[ele[1]] = []
                for(let i = 3; i < ele.length; i+=2) {
                    result[ele[1]].push(ele[i])
                }
            }
        })
        return result;
    }
    function queryBreakDown(queryArr) {
        let result = {}
        let j = -1, table = [];
        let array = []
        for(let i = 0; i < queryArr.length; i++) {
            if(queryArr[i].includes("CREATE TABLE ")) {
                array = [];
                table.push(queryArr[i])
                j++
            } else {
                if(queryArr[i] !== "COMMIT;") {
                    array.push(queryArr[i])
                    result[table[j]] = array
                }
            }
        }
        return result;
    }
})