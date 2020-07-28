jQuery(document).ready(function(){

    // (base_url is a global value)

    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    /**
    *  Update the back url
    */
    $(".page-content").on("click",".view-product",function(e) {
        var back = $("#back").val();
        $.ajax({
            type: 'POST',
            url: '/products/setBackValue',
            data: {back: back,_token: CSRF_TOKEN},
            success: function(results) {
            },
            error: function(x,y,z) {
                console.log(z);
            }
        });
    });

    /**
    *  Update a category and its filters on (category) click
    */
    $(".filter-group").on("click",".category-display",function(e) {
        e.preventDefault;
        var category = $(this).val();
        $.ajax({
            type: 'POST',
            url:'/products/getProductsByCategory',
            data: {category: category,_token: CSRF_TOKEN},
            success: function(results) {
                $("#back").val(results.back);
                $(".page-title").html(results.displayName);
                $(".product-list").html('');
                $(".filters").html('');
                var paginate = results.paginate;
                $("#pagination").html(paginate);

                window.history.pushState(results.back, "Title", "/products?category=" + category);

                $.each(results.views,function(index,p) {
                    $(".product-list").append(p);
                });

                $("#"+category).parent().parent().find(".filters").html(results.filters);

           },
            error: function(x,y,z) {
                console.log(z);
            }
        });
    });

    /**
    *  Display all products on no-category click
    */
    $(".filter-group").on("click",".no-category",function(e) {
        e.preventDefault;
        $.ajax({
            type: 'POST',
            url:'/products/getProductsNoCategory',
            data: {_token: CSRF_TOKEN},
            success: function(results) {
                $("#back").val(results.back);
                $(".page-title").html('All Products');
                $(".product-list").html('');
                $(".filters").html('');
                var paginate = results.paginate;
                $("#pagination").html(paginate);

                $.each(results.views,function(index,p) {
                    $(".product-list").append(p);
                });
           },
            error: function(x,y,z) {
                console.log(z);
            }
        });
    });

    /**
    *  Update the filters for a category on (filter) click
    */
    $(".filter-group").on("click",".filter-option",function(e) {
        e.preventDefault;
        var t = $(this);

        var filters = [];

        var category = t.closest(".cat").find(".category-display").val();

        $("input:checkbox[class=filter-option]:checked").each(function (key,value) {
            filters.push($(this).val());
        });
        $.ajax({
            type: 'POST',
            dataType: 'json',
            cache: false,
            url:'/products/getProductsByFilter',
            data: {category: category,filters: filters,_token: CSRF_TOKEN},
            success: function(results) {
                $("#back").val(results.back);
                $(".page-title").html(results.displayName);
                $(".product-list").html('');
                var paginate = results.paginate;
                $("#pagination").html(paginate);

                window.history.pushState(results.back, "Title", "/products?category=" + category + "&filters= " + filters);

                $.each(results.views,function(index,p) {
                    $(".product-list").append(p);
                });
            },
            error: function(x,y,z) {
                console.log(z);
            }
        });
    });

    // Product Video Modal
    $('.video-modal-button').on("click",function(){
        var id = $(this).attr('href');
        var video = '//www.youtube.com/embed/' + id + '?autoplay=1';
        $('#video-modal-iframe').attr('src',video);
    });

    $('#videoModal').on('hide.bs.modal', function (e) {
       $('#video-modal-iframe').attr('src','');
    });

    // Back to top button
    var btn = $('#button');

    $(window).scroll(function() {
      if ($(window).scrollTop() > 300) {
        btn.addClass('show');
      } else {
        btn.removeClass('show');
      }
    });

    btn.on('click', function(e) {
      e.preventDefault();
      $('html, body').animate({scrollTop:0}, '300');
    });

    // Alt Navigation
    var height = $('.active-caption').height();
    var activeHeight = parseInt(height) + 60;
    $(".alt-nav-caption").css('height', activeHeight);

    $('.alt-nav-item').hover(function() {
        var active = '.' + $(this).data('hover');
        $(".caption-default").removeClass("active-caption");
        $(active).addClass("active-caption");

        var height = $('.active-caption').height();
        var activeHeight = parseInt(height) + 60;
        $(".alt-nav-caption").css('height', activeHeight);

    }, function() {
        var active = '.' + $(this).data('hover');
        $(".caption-default").addClass("active-caption");
        $(active).removeClass("active-caption");

        var height = $('.active-caption').height();
        var activeHeight = parseInt(height) + 60;
        $(".alt-nav-caption").css('height', activeHeight);
    });

    window.onresize = function(event) {
        var height = $('.active-caption').height();
        var activeHeight = parseInt(height) + 60;
        $(".alt-nav-caption").css('height', activeHeight);
    };


    // Product Image Gallery
        $('.thumb-js img').click(function() {
          var src = $(this).attr('src');
          $('.product-img').attr('src', src);
          $('.product-modal-image').attr('src', src);
        });

    // Multi Carousel
    $('.multi-item-carousel').carousel({
        interval: false
    });

	var requiredPart = $('.carousel-inner .item').length;

	$('.multi-item-carousel .item').each(function(){
		var next = $(this).next();
		if (!next.length) {
			next = $(this).siblings(':first');
		}

		next.children(':first-child').clone().appendTo($(this));

		if (requiredPart < 3) {
			jQuery('.multi-item-carousel .carousel-control').css('display','none');
		} else {
			if (next.next().length>0) {
				next.next().children(':first-child').clone().appendTo($(this));
			} else {
				$(this).siblings(':first').children(':first-child').clone().appendTo($(this));
			}
		}
	});


	// Product List Image - Same Heigh & Width
	var prodcutListImg = $('.product-item-img-wrap').width();
	$('.product-item-img-wrap').css({'height':prodcutListImg+'px'});

	window.onresize = function(event) {
		var prodcutListImg = $('.product-item-img-wrap').width();
		$('.product-item-img-wrap').css({'height':prodcutListImg+'px'});
	};

});

// YouTube Place Holder
document.addEventListener("DOMContentLoaded",
    function() {
        var div, n,
            v = document.getElementsByClassName("youtube-player");
        for (n = 0; n < v.length; n++) {
            div = document.createElement("div");
            div.setAttribute("data-id", v[n].dataset.id);
            div.innerHTML = labnolThumb(v[n].dataset.id);
            div.onclick = labnolIframe;
            v[n].appendChild(div);
        }
    });

function labnolThumb(id) {
    var thumb = '<img src="https://i.ytimg.com/vi/ID/hqdefault.jpg">',
        play = '<div class="play"></div>';
    return thumb.replace("ID", id) + play;
}

function labnolIframe() {
    var iframe = document.createElement("iframe");
    var embed = "https://www.youtube.com/embed/ID?autoplay=1&rel=0";
    iframe.setAttribute("src", embed.replace("ID", this.dataset.id));
    iframe.setAttribute("frameborder", "0");
    iframe.setAttribute("allowfullscreen", "1");
    this.parentNode.replaceChild(iframe, this);
}
