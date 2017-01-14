var btn = document.getElementById("testbtn");
console.log(btn);
btn.addEventListener("click", function () {
    alert("Hi!")
});

var likeBtns = document.getElementsByClassName('btn-add-like');
console.log(likeBtns);

function ajaxLike(url, btn) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            btn.innerText=this.responseText;

            // document.getElementById("demo").innerHTML = this.responseText;
        }else{
            console.log("status" + this.status);
        }
    };
    xhttp.open("POST", url, true);
    xhttp.send();
}
for (var i = 0; i < likeBtns.length; i++) {
    likeBtns[i].addEventListener("click", function (event) {
        event.preventDefault();
        var projId = this.getAttribute("data-id");
        var href = this.getAttribute("href");
        ajaxLike(href, this);
        // alert("Hi!" + href);

        /*
         * отправить лайк на бекэнд
         * показать сколько лайков
         */
    })
}