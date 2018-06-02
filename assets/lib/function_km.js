$(document).ready(function(){
    var root_url = $("#root_url").val();
    var url_page_new = root_url + 'takmoph2014/page_news/';
    var data_page_news = {a:1};
    $.post(url_page_new,data_page_news,
        function(success){
            alert("1234");
            $('.import_box_news').html(success);
        }
    );
});


