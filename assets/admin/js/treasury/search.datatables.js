$(document).ready(function () {
  $(document).on('input', '#aj_search', function () {
    let ajax_search_url = $('#aj_search').attr('data-search-url');
    let ajax_search_token = $('#aj_search').attr('data-search-token');
    let ajax_search_query = $('#aj_search').val();

    console.log(ajax_search_token);
    jQuery.ajax({
      url: ajax_search_url,
      type: 'post',
      dataType: 'html',
      data: {
        search: ajax_search_query, '_token': ajax_search_token, ajax_search_url: ajax_search_url
      },
      cash: false,
      success: function (data) {
        $('#data_show').html(data);
      },
      error: function () {

      }
    });
  });

  $(document).on('click', '#links ul.pagination li a', function (e) {
    e.preventDefault();
    let ajax_search_url = $(this).attr('href');
    let ajax_search_token = $('#aj_search').attr('data-search-token');
    let ajax_search_query = $('#aj_search').val();

    console.log(ajax_search_token);
    jQuery.ajax({
      url: ajax_search_url,
      type: 'post',
      dataType: 'html',
      data: {
        search: ajax_search_query, '_token': ajax_search_token
      },
      cash: false,
      success: function (data) {
        $('#data_show').html(data);
      },
      error: function () {
 
      }
    });
  });
  
});