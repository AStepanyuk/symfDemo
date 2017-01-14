
function initAjaxLikes() {

    var likeBtns = $('.btn-add-like');
    console.log(likeBtns);

    function ajaxLike(url, btn) {
        $.post(url, {}, function (response) {
            btn.innerText = response;
        });
    }
  

    likeBtns.click(function (event) {
        event.preventDefault();
        var href = this.getAttribute("href");
        ajaxLike(href, this);

    });
}

$(initAjaxLikes);